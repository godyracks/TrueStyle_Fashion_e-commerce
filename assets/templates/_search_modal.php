<?php
include_once('../assets/setup/db.php'); // Include your database connection

if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];
    
    // Modify the query to use the LIKE operator with wildcards
    $searchSQL = "SELECT name FROM products WHERE name LIKE '%$searchQuery%' LIMIT 5"; // Limit results to 5 suggestions
    
    $result = mysqli_query($conn, $searchSQL);
    
    $suggestions = array();
    
    // Fetch and store suggestions in an array
    while ($row = mysqli_fetch_assoc($result)) {
        $suggestions[] = $row['name'];
    }
    
    // Return suggestions as JSON
    echo json_encode($suggestions);
}
?>





<style>
      /* Styles for the search modal */
.search-modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
  z-index: 9999;
  /* border: 2px solid #16a085; */
}

.search-modal-content {
    margin-top: 100px;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
  margin: 0 auto;
  /* border: 2px solid #16a085; */
}

.search-icon {
  font-size: 24px;
  margin-right: 10px;
}

.search-input {
    border: 2px solid #16a085;
  border-bottom: 2px solid black; /* White bottom border */
  border-radius: 10px;
  background-color: transparent;
  color: #16a085 ;
  font-size: 18px;
  padding: 10px;
  width: 200px;
  outline: none;
}

.close-icon {
  font-size: 24px;
  cursor: pointer;
  margin-left: 10px;
}

    </style>

<div class="search-modal" id="searchModal">
  <div class="search-modal-content">
    <form method="GET" action="">
      <div class="search-input-container">
      <button type="submit"> <i class="bx bx-search search-icon"></i></button>
        <input type="text" class="search-input" name="query" id="searchInput" placeholder="Search...">
      </div>
    </form>
    <div id="suggestionList" class="suggestion-list"></div>
    <i class="bx bx-x close-icon" id="closeSearchModal"></i>
  </div>
</div>


<script>
  const searchModal = document.getElementById('searchModal');
  const searchIcon = document.querySelector('.bx-search');
  const closeSearchModal = document.getElementById('closeSearchModal');
  const suggestionList = document.getElementById('suggestionList');

  // Function to show the search modal
  function openSearchModal() {
    searchModal.style.display = 'block';
  }

  // Function to hide the search modal
  function closeSearchModalFunction() {
    searchModal.style.display = 'none';
  }

  // Function to fetch and display suggestions
function fetchSuggestions() {
  const query = searchInput.value;

  // Check if the query is empty
  if (query.trim() === '') {
    suggestionList.innerHTML = ''; // Clear the suggestion list if the query is empty
    return;
  }

  // Make an AJAX request to fetch suggestions
  // Replace 'suggest.php' with the actual server-side script for suggestions
  fetch(`/truestylev1/product/?query=${query}`)

    .then(response => response.json())
    .then(data => {
      // Display suggestions in the suggestion list
      suggestionList.innerHTML = '';

      if (data.length > 0) {
        data.forEach(suggestion => {
          const suggestionItem = document.createElement('div');
          suggestionItem.textContent = suggestion;
          suggestionItem.classList.add('suggestion-item');
          suggestionItem.addEventListener('click', () => {
            // Set the selected suggestion as the input value when clicked
            searchInput.value = suggestion;
            suggestionList.innerHTML = ''; // Clear the suggestion list
          });
          suggestionList.appendChild(suggestionItem);
        });
      } else {
        suggestionList.innerHTML = '<div class="no-suggestions">No suggestions found</div>';
      }
    });
}


  // Event listeners
  searchInput.addEventListener('input', fetchSuggestions);
  searchIcon.addEventListener('click', openSearchModal);
  closeSearchModal.addEventListener('click', closeSearchModalFunction);
</script>