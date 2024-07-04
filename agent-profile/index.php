<?php
session_start();
$user_id = $_SESSION['SESSION_EMAIL'];

if (!isset($user_id)) {
    header('location:../login');
    exit();
}

include_once('../assets/setup/db.php');
include_once('../assets/product-page-temp/product-header.php');

// Retrieve user information
// $query_user = "SELECT * FROM user_info WHERE email = '$user_id'";
$query_user = "SELECT user_info.*, agent_activity.referral_code 
              FROM user_info 
              LEFT JOIN agent_activity 
              ON user_info.email = agent_activity.email
              WHERE user_info.email = '$user_id'";

$result_user = mysqli_query($conn, $query_user);

$userInitials = '';
$userFirstName = '';

if ($result_user->num_rows > 0) {
    $row = $result_user->fetch_assoc();
    $userName = $row['name']; // Retrieve the user's name from the database

    // Split the user's name into words
    $nameWords = explode(' ', $userName);

    // Get the first word as the first name
    $userFirstName = $nameWords[0];

    // Extract the initials from the first name and last name
    $userInitials = substr($userFirstName, 0, 1);
} else {
    echo "User information not found!";
}
?>

<style>
    /* Main container for the profile section */
.profile-container {
    display: flex;
}

/* Left column styles */
.left-column {
    width: 30%;
    padding: 20px;
    background-color: white;
}

/* Right column styles */
.right-column {
    width: 70%;
    padding: 20px;
}

/* Profile card styles */
.user-dtl {
    background-color: #fff;
    border-radius: 10px;
    margin-bottom: 10px;
    padding: 10px;
    display: flex;
    align-items: center;
}
.profile-card {
    background-color: #efeff0;
    border-radius: 10px;
    margin-bottom: 10px;
    padding: 10px;
    display: flex;
    align-items: center;
}

/* Initials styles */
.profile-initials {
    width: 50px;
    height: 50px;
    background-color: whitesmoke;
    color: #16a085;
    text-align: center;
    line-height: 50px;
    /* border-radius: 50%; */
    margin-right: 10px;
}
.icon-image {
    width: 50px;
    height: 50px;
    background-color: #16a085;
    color: #16a085;
    text-align: center;
    line-height: 50px;
    border-radius: 50%;
    margin-right: 10px;
}

.icon-image img{
    width: 40px;
    height: 40px;
}

/* Name and Title styles */
.profile-info {
    flex-grow: 1;
}

.profile-name {
    font-weight: bold;
}

.profile-title {
    color: #888;
}

.active{
    border: 4px solid #16a085;
}

/* Section title styles */
.section-title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

/* Table styles */

   .agent-details {
       display: none;
   }

.order-table {
    width: 100%;
    border-collapse: collapse;
    display: block;
}

.order-table th, .order-table td {
    /* border: 1px solid #ccc; */
    padding: 10px;
    text-align: left;
}

.order-table th {
    background-color: #fff;
    color: black;
    font-weight: bold;
}

/* Style for the expand/collapse button (chevron) */
.expand-button {
    cursor: pointer;
    display: inline-block;
    width: 20px;
    height: 20px;
    background-image: url('chevron-down.png'); /* Add your image URL */
    background-size: cover;
    transition: transform 0.3s;
}

.collapsed .expand-button {
    transform: rotate(0deg);
}

/* Additional styles for order images and summary */
.order-image {
    max-width: 100px;
    height: auto;
    margin: 5px;
}

/* You can add more styles for the Order Summary section here */

/* Media query for smaller screens */


@media (max-width: 768px) {
    /* Adjust the width of the columns and flex direction for smaller screens */
    .profile-container {
        flex-direction: column;
    }

    .left-column, .right-column {
        width: 100%;
    }

    /* Add responsive styles for your profile cards and other elements here */
}



/* Style for the expand/collapse button (chevron) */
.expand-button {
    cursor: pointer;
    display: inline-block;
    width: 20px;
    height: 20px;
    background-image: url('chevron-down.png'); /* Add your image URL */
    background-size: cover;
    transition: transform 0.3s;
}

.collapsed .expand-button {
    transform: rotate(0deg);
}

/* Style for the hidden order details row */
.order-details.collapsed {
    display: none;
  }
  .order-details {
    display: none;
}
  

/* Style for the table rows */
.order-row {
    cursor: pointer;
    background-color: #16a085;
}

.order-row:hover {
    background-color:#68c3a3;
}

/* Style for the order images */
.order-images img {
    max-width: 100px;
    height: auto;
    margin: 5px;
    flex-direction: row;
}

/* Style for the additional order details */
/* Style for the order summary section */
.order-details-info {
    border-top: 1px solid #ccc; /* Add a top border to separate orders */
    padding: 10px;
    flex-direction: row;
}

/* Style for merchandise details */
.order-details-info div:nth-child(1) {
    font-weight: bold;
    text-decoration: underline;
}

/* Style for shipping, tax, and total lines */
.order-details-info div {
    margin-bottom: 5px;
}

/* Style for the total amount */
.order-details-info .order-total {
    font-size: 18px;
    text-decoration: underline;
}

/* Style for the buttons */
.order-buttons {
    margin-top: 10px;
}

.order-buttons button {
    margin-right: 10px;
    padding: 5px 10px;
    background-color: #3498db;
    color: #fff;
    border: none;
    cursor: pointer;
}

.order-buttons button:hover {
    background-color: #207db5;
}

/* Style for the agent-details section */
.agent-details {
    display: none;
}

.agent-details h2 {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

/* Style for agent-activity sub-sections */
.agent-activity {
    border: 1px solid #ddd;
    padding: 15px;
    margin: 10px 0;
    background-color: #fff;
    border-radius: 5px;
}

.agent-activity h3 {
    font-size: 18px;
    margin-top: 0;
}


/* Media query for smaller screens */
@media (max-width: 768px) {
    /* Adjust the width of the columns and flex direction for smaller screens */
    .profile-container {
        flex-direction: column;
    }

    .left-column, .right-column {
        width: 100%;
        text-align: left; /* Align content to the left */
    }

    /* Add responsive styles for your profile cards and other elements here */
    .profile-card {
        text-align: left; /* Align profile cards to the left */
    }

    /* Align order rows to the left */
    .order-row {
        text-align: left;
    }
    .order-details {
        display: flex; /* Use flexbox to make the children appear in a row */
        flex-wrap: wrap; /* Wrap items onto the next line if the screen is too narrow */
        text-align: left; /* Align content to the left within the row */

        /* Style for the hidden order details row */
        display: none; /* Ensure that hidden details don't display on small screens */
    }

    .order-images {
        display: flex; /* Make the images appear in a row */
        align-items: center; /* Vertically center the images within the row */
    }

    .order-details-info div {
        flex: 1; /* Distribute available space evenly to create a horizontal layout */
        margin: 5px; /* Add spacing between items in the row */
    }

    .order-details-info .order-total {
        flex: 1; /* Stretch the total amount to fill the available space */
    }

    .order-buttons {
        flex: 1; /* Stretch the buttons to fill the available space */
    }

    .agent-activity {
        margin: 10px 0;
    }
}



/* Media query for smaller screens */
@media (max-width: 768px) {
    .order-table {
        overflow-x: auto;
    }
}

 </style>
 <br>
 <br>
 <br>
 <br>
 <div class="profile-container">
        <div class="left-column">
            <!-- card start -->
            <div class=" user-dtl">
            <div class="profile-initials"><?php echo $userInitials; ?></div>
                <div class="profile-info">
                <div class="profile-name"><?php echo $userFirstName; ?></div>
                    <div class="profile-title">Profile</div>
                </div>
                <div class="profile-logout"><a href="http://localhost/truestylev1/logout" class="icon">
            <i class="bx bx-log-out"></i>
          </a></div>
            </div>
            <!-- card end -->
            <!-- Add five more similar profile cards for different options -->
            <!-- card start -->
            
            <!-- card end -->
             <!-- card start -->
             <div class="profile-card"  id="agents-card">
                <div class="icon-image"><img src="../images/handshake.png" /></div>
                <div class="profile-info">
                    <div class="profile-name"> TrueStyle Agents</div>
                    <div class="profile-title">A truestyle agent details</div>
                </div>
            </div>
            <!-- card end -->
            <div class="profile-card" id="login-security-card">
            <div class="icon-image"><img src="../images/padlock-icon.png" /></div>
                <div class="profile-info">
                    <div class="profile-name">Login & Security</div>
                    <div class="profile-title">Edit Name and number & password</div>
                </div>
        </div>
        
        </div>
        <div class="right-column">
            <div class="section-title" id="section-title">Welcome Back!</div>
            

            <div class="agent-details" id="agent-details" style="display: none;">
    <!-- <h2>TrueStyle Agents</h2> -->
    <a href="./deposit/"><div class="agent-activity">
        <h3>Deposit <i class='bx bx-plus'></i><i class='bx bxs-coin-stack' ></i></h3>
        <!-- Add content related to deposits here -->
    </div></a>

    <a href="./withdrawal/"><div class="agent-activity">
    <h3>Withdraw </h3>
</div></a>


    <div class="agent-activity">
        <h3>Testimony</h3>
        <!-- Add content related to testimonies here -->
    </div>

    <div class="agent-activity">
        <h3>Transactions</h3>
        <!-- Add content related to transactions here -->
    </div>

    <div class="agent-activity">
        <h3>Investments</h3>
        <!-- Add content related to investments here -->
    </div>

    <div class="agent-activity">
        <h3>Total Earned</h3>
        <!-- Add content related to total earnings here -->
    </div>
    <div class="agent-activity">
    <h3>Referral Link</h3>
    <p>Your referral link: <span id="referral-link">http://localhost/truestylev1/agent-signup?referral_code=<?php echo $row['referral_code']; ?></span></p>
    <button id="copy-referral-link"><i class='bx bx-copy'></i></button>
</div>



    <div class="agent-activity">
        <h3>Referral List</h3>
        <!-- Add content related to the referral list and referral links here -->
    </div>
   

</div>


    <div class="login-security" id="login-security" style="display: none;">
        <!-- Login & Security content here -->
        <!-- Add your form or security settings here -->
    </div>
         
           
        </div>
      
    </div>
    <script>

const agentsCard = document.getElementById('agents-card');
const loginCard = document.getElementById('login-security-card');
const agentDetails = document.getElementById('agent-details');
const loginSecurity = document.getElementById('login-security');
const sectionTitle = document.getElementById('section-title');
const withdrawCard = document.getElementById('withdraw-card');

agentsCard.addEventListener('click', () => {
    agentsCard.classList.add('active');
    loginCard.classList.remove('active');
    agentDetails.style.display = 'block';
    loginSecurity.style.display = 'none';
    sectionTitle.innerText = 'TrueStyle Agents';
});

loginCard.addEventListener('click', () => {
    loginCard.classList.add('active');
    agentsCard.classList.remove('active');
    agentDetails.style.display = 'none';
    loginSecurity.style.display = 'block';
    sectionTitle.innerText = 'Change your Login Information';
});

withdrawCard.addEventListener('click', () => {
    window.location.href = 'withdrawal.php';
});






    </script>
    <script>
document.addEventListener('DOMContentLoaded', () => {
    const copyButton = document.getElementById('copy-referral-link');
    const referralLink = document.getElementById('referral-link');

    copyButton.addEventListener('click', () => {
        const range = document.createRange();
        range.selectNode(referralLink);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        document.execCommand('copy');
        window.getSelection().removeAllRanges();
        alert('Referral link copied!');
    });
});
</script>


<?php
include_once('../assets/cart-temp/cart-footer.php');
?>