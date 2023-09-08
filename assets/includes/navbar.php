<?php //session_start();
$user_id = $_SESSION['SESSION_EMAIL'];
?>
  <style>
         /* Add this CSS to your existing stylesheet */
/* Style the shop container */
.product-container {
  position: relative;
  display: inline-block;
  border-radius: 6px;
}
/* Center-align the dropdown list */
.product-dropdown {
  display: none;
  position: absolute;
  background-color: white;
  min-width: 200px;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  z-index: 1;
  left: 0;
  top: 100%; /* Position it below the shop link */
  border-radius: 6px;
  
}

.product-dropdown a:nth-child(odd) {
  background-color: #f1f1f1; /* Set the background color for odd-numbered items (e.g., grey) */
  color: #000; /* Set the text color for odd-numbered items */
}

.product-dropdown a:nth-child(even) {
  background-color: #fff; /* Set the background color for even-numbered items (e.g., white) */
  color: #000; /* Set the text color for even-numbered items */
}
/* Display each item on a separate line */
.product-dropdown a {
  display: block; /* Make each item a block-level element */
  padding: 0px; /* Adjust padding as needed */
  text-decoration: none;
  color: #000; /* Text color for list items */
  transition: background-color 0.3s ease;
  border-radius: 6px;
  flex-direction: row;
  justify-content: center;
  align-items: center;
}

/* Style for list item hover effect */
.product-dropdown a:hover {
  background-color: #fff; /* Background color on hover */
}

/* Add this CSS to your existing stylesheet */
.product-dropdown a.active-option {
  background-color: #16a085; /* Set the background color for the active option */
  color: #fff;/* Set the text color for the active option */
}


/* Style the service container */
.service-container {
  position: relative;
  display: inline-block;
  
}
/* Center-align the dropdown list */
.service-dropdown {
  display: none;
  position: absolute;
  background-color:  #f1f1f1;
  min-width: 200px;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  z-index: 1;
  left: 0;
  top: 100%; /* Position it below the shop link */
  border-radius: 6px;
}
/* Display each item on a separate line */
.service-dropdown a {
  display: block; /* Make each item a block-level element */
  padding: 2px; /* Adjust padding as needed */
  text-decoration: none;
  color: #000; /* Text color for list items */
  transition: background-color 0.3s ease;
  border-radius: 6px;
}

.service-dropdown a:nth-child(odd) {
  background-color: #f1f1f1; /* Set the background color for odd-numbered items (e.g., grey) */
  color: #000; /* Set the text color for odd-numbered items */
}

.service-dropdown a:nth-child(even) {
  background-color: #fff; /* Set the background color for even-numbered items (e.g., white) */
  color: #000; /* Set the text color for even-numbered items */
}

/* Style for list item hover effect */
.service-dropdown a:hover {
  background-color: #fff; /* Background color on hover */
}

/* Add this CSS to your existing stylesheet */
.service-dropdown a.active-option {
  background-color: #16a085; /* Set the background color for the active option */
  color: #fff; /* Set the text color for the active option */
}
/* Style the arrows */
.desktop-arrow {
  display: inline; /* Display the desktop arrow by default */
  margin-left: 5px;
  transform: rotate(0deg); /* Pointing down */
  transition: transform 0.3s ease;
}

.mobile-arrow {
  display: none; /* Hide the mobile arrow by default */
  margin-left: 5px;
  transform: rotate(90deg); /* Pointing right */
  transition: transform 0.3s ease;
}

/* Dropdown for Mobile */
@media only screen and (max-width: 768px) {
  .service-container {
    display: block; /* Display the container as a block */
  }

  /* Hide the desktop arrow and mobile arrow on smaller screens */
  .desktop-arrow,
  .mobile-arrow {
    display: none;
  }
   /* Adjust the margin to position the mobile arrow correctly */
   .mobile-arrow {
    margin-left: 0; /* Remove the margin */
  }

   /* Show the service dropdown on mobile */
   .service-dropdown {
    display: block;
    position: static; /* Remove absolute positioning */
    top: auto; /* Reset top position */
    min-width: auto; /* Reset minimum width */
    box-shadow: none; /* Remove box-shadow */
    border-radius: 0; /* Remove border-radius */
    /* height: 20px; */
  }
   /* Style the service dropdown items on mobile */
   .service-dropdown a {
    padding: 0px 70px; /* Adjust padding as needed */
    text-align: left; /* Align text to the left */
  }
  .dropdown {
    position: static;
  }

  /* Remove the hover effect on mobile */
  .nav-item:hover .product-dropdown {
    display: none;
  }

  .nav-item:hover .service-dropdown {
    display: none;
  }

  /* Show the mobile arrow and hide the desktop arrow */
  .desktop-arrow {
    display: none;
  }

  .mobile-arrow {
    display: inline;
  }

  /* Adjust the margin to position the mobile arrow correctly */
  .mobile-arrow {
    margin-left: 10px;
  }
}


 </style>
<!-- Header -->
<header class="header" id="header">
  <!-- Top Nav -->
  <div class="top-nav">
    <div class="container d-flex">
      <p>Order Online Or Call Us: +254 701 559 001</p>
      <ul class="d-flex">
        <li><a href="#">About Us</a></li>
        <li><a href="#">FAQ</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </div>
  </div>

  <div class="navigation">
    <div class="nav-center container d-flex">
      <a href="/" class="logo">
        <h1>True Style</h1>
      </a>

      <ul class="nav-list d-flex">
        <li class="nav-item">
          <a href="https://truestyle.co.ke/home" class="nav-link">Home</a>
        </li>
           <li class="nav-item">
  <div class="product-container">
    <a href="#" class="nav-link" onclick="toggleProductDropdown()">Products
      <i class="bx bx-chevron-down desktop-arrow"></i>
      <i class="bx bx-chevron-right mobile-arrow"></i>
    </a>
    <div class="product-dropdown" id="productDropdown">
      <a href="../product_list/?name=T-Shirt">T-Shirts</a>
      <a href="../product_list/?name=Hoodie">Hoodies</a>
      <a href="../product_list/?name=Sweat Pants">Sweat Pants</a>
      <a href="../product_list/?name=Shirt">Shirts</a>
      <a href="../product_list/?name=Ankara">Ankara Outfits</a>
      <!-- Add more items as needed -->
    </div>
  </div>
</li>
       <li class="nav-item">
          <a href="http://localhost/truestylev1/product" class="nav-link">Shop</a>
        </li>
        <div class="service-container">
  <a href="#" class="nav-link" onclick="toggleServiceDropdown()">Services
    <i class="bx bx-chevron-down desktop-arrow"></i>
    <i class="bx bx-chevron-right mobile-arrow"></i>
  </a>
  <div class="service-dropdown" id="serviceDropdown">
    <a href="https://truestyle.co.ke/jobs/jobs-home">Jobs updates</a>
    <a href="#">Advertisements</a>
    <a href="https://truestyle.co.ke/modelling-agency">Modeling Agency</a>
    <a href="https://truestyle.co.ke/events">TS EVENTS</a>
    <a href="https://truestyle.co.ke/sacco">TS SACCO</a>
    <!-- Add more items as needed -->
  </div>
</div>
        
        <?php
        //error_reporting(E_ALL); ini_set('display_errors', 1);
        $adminEmails = array('godfreymatagaro@gmail.com', 'gmatagaro4@gmail.com', 'engmillie24@gmail.com');
        // Check if admin is logged in
        if (isset($_SESSION['SESSION_EMAIL']) && in_array($_SESSION['SESSION_EMAIL'], $adminEmails)) {
          echo '<li class="nav-item">
                  <a href="https://truestyle.co.ke/admin" class="nav-link"><i class="bx bx-shield"></i>Admin</a>
                </li>';
        } else {
          echo '<li class="nav-item">
                  <a href="https://truestyle.co.ke/user-profile" class="nav-link"><i class="bx bx-user"></i>My Profile</a>
                </li>';
        }

        ?>

        <li class="icons d-flex">
          <?php
// session_start();

// Check if the user is logged in
$user_id = isset($_SESSION['SESSION_EMAIL']) ? $_SESSION['SESSION_EMAIL'] : null;

// Initialize cart count
$cartCount = 0;

// If the user is not logged in, fetch the cart count from guest_cart using session_id()
if (!$user_id) {
  $session_id = session_id(); // Get the guest session ID
  $cartQueryGuest = "SELECT COUNT(*) AS count FROM guest_cart WHERE session_id = '$session_id'";
  $cartResultGuest = mysqli_query($conn, $cartQueryGuest);
  $cartCount = mysqli_fetch_assoc($cartResultGuest)['count'];
} else {
  // If the user is logged in, fetch the cart count from the cart table
  $cartQuery = "SELECT COUNT(*) AS count FROM cart WHERE user_id = '$user_id'";
  $cartResult = mysqli_query($conn, $cartQuery);
  $cartCount = mysqli_fetch_assoc($cartResult)['count'];
}

// Query to count the items in the wishlist for the user
$wishlistCountQuery = "SELECT COUNT(*) AS count FROM wishlist WHERE user_id = '$user_id'";
$wishlistCountResult = mysqli_query($conn, $wishlistCountQuery);
$wishlistCount = mysqli_fetch_assoc($wishlistCountResult)['count'];?>

   <?php
      // session_start();
        if (isset($_SESSION['SESSION_EMAIL'])) {
          // User is logged in
          echo '<a href="https://truestyle.co.ke/logout" class="icon">
            <i class="bx bx-log-out"></i>
          </a>';
        } else {
          // User is not logged in
          echo '<a href="https://truestyle.co.ke/login" class="icon">
            <i class="bx bx-user"></i>
          </a>';
        }
        ?>
          <div class="icon">
            <i class="bx bx-search"></i>
          </div>
         <a href="https://truestyle.co.ke/wishlist" class="icon">
              <div class="icon">
                <i class="bx bx-heart"></i>
                <span class="d-flex"><?php echo $wishlistCount; ?></span>
              </div>
            </a>

          <a href="https://truestyle.co.ke/cart" class="icon">
            <i class="bx bx-cart"></i>
            <span class="d-flex"><?php echo $cartCount; ?></span>
          </a>
        </li>
      </ul>

      <div class="icons d-flex">
        <?php
        // Check if user is logged in
        if (isset($_SESSION['SESSION_EMAIL'])) {
          // User is logged in
          echo '<a href="https://truestyle.co.ke/logout" class="icon">
                  <i class="bx bx-log-out"></i>
                </a>';
        } else {
          // User is not logged in
          echo '<a href="https://truestyle.co.ke/login" class="icon">
                  <i class="bx bx-user"></i>
                </a>';
        }
        ?>
        <div class="icon">
          <i class="bx bx-search"></i>
        </div>
        <a href="https://truestyle.co.ke/wishlist" class="icon">
        <div class="icon">
          <i class="bx bx-heart"></i>
          <span class="d-flex"><?php echo $wishlistCount; ?></span>
        </div>
        </a>
        <a href="https://truestyle.co.ke/cart" class="icon">
          <i class="bx bx-cart"></i>
          <span class="d-flex"><?php echo $cartCount; ?></span>
        </a>
      </div>

      <div class="hamburger">
        <i class="bx bx-menu-alt-left"></i>
      </div>
    </div>
  </div>
  
  <script>
function toggleProductDropdown() {
  var shopDropdown = document.getElementById("productDropdown");
  var desktopArrow = document.querySelector(".desktop-arrow");
  var mobileArrow = document.querySelector(".mobile-arrow");
  var options = shopDropdown.querySelectorAll("a");
  if (shopDropdown.style.display === "block") {
    shopDropdown.style.display = "none";
    desktopArrow.style.transform = "rotate(0deg)";
    mobileArrow.style.transform = "rotate(90deg)";
  } else {
    shopDropdown.style.display = "block";
    desktopArrow.style.transform = "rotate(180deg)";
    mobileArrow.style.transform = "rotate(90deg)";

    // Add the "active-option" class to the first option
    options[0].classList.add("active-option");

    // Remove the "active-option" class from other options
    for (var i = 1; i < options.length; i++) {
      options[i].classList.remove("active-option");
    }
  }
}


function toggleServiceDropdown() {
  var shopDropdown = document.getElementById("serviceDropdown");
  var desktopArrow = document.querySelector(".desktop-arrow");
  var mobileArrow = document.querySelector(".mobile-arrow");
  var options = shopDropdown.querySelectorAll("a");

  if (shopDropdown.style.display === "block") {
    shopDropdown.style.display = "none";
    desktopArrow.style.transform = "rotate(0deg)";
    mobileArrow.style.transform = "rotate(90deg)";
  } else {
    shopDropdown.style.display = "block";
    desktopArrow.style.transform = "rotate(180deg)";
    mobileArrow.style.transform = "rotate(90deg)";

    // Add the "active-option" class to the first option
    options[0].classList.add("active-option");

    // Remove the "active-option" class from other options
    for (var i = 1; i < options.length; i++) {
      options[i].classList.remove("active-option");
    }
  }
}


  </script>

