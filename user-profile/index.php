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
$query_user = "SELECT * FROM user_info WHERE email = '$user_id'";
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

// Retrieve user's orders
$query_orders = "SELECT * FROM orders WHERE email = '$user_id'";
$result_orders = mysqli_query($conn, $query_orders);
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

.icon-image img {
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

.active {
    border: 4px solid #16a085;
}

/* Section title styles */
.section-title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

/* Table styles */
.order-table {
    width: 100%;
    border-collapse: collapse;
    display: block;
}

.order-table th,
.order-table td {
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

    .left-column,
    .right-column {
        width: 100%;
    }

    /* Add responsive styles for your profile cards and other elements here */
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
    background-color: #68c3a3;
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
    border-top: 1px solid #ccc;
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
        <div class="profile-card" id="order-history-card">
            <div class="icon-image"><img src="../images/history.png" /></div>
            <div class="profile-info">
                <div class="profile-name">Order History</div>
                <div class="profile-title">Track, Return, or buy items again</div>
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
        <div class="section-title" id="section-title">Order History</div>
        <div class="order-table">
            <table>
                <thead>
                    <tr class="table-heading">
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop through user's orders
                    while ($row = mysqli_fetch_assoc($result_orders)) {
                        // Retrieve order details, you may need to adjust the SQL query
                        $order_id = $row['id'];
                        $query_order_details = "SELECT * FROM orders WHERE id = $order_id";
                        $result_order_details = mysqli_query($conn, $query_order_details);

                        // Loop through products in the order
                        while ($product = mysqli_fetch_assoc($result_order_details)) {
                            // Display the order row
                            echo '<tr class="order-row">';
                            echo '<td>' . $row['order_time'] . '</td>';
                            echo '<td>Pending</td>'; // You can fetch order status from the database
                            echo '<td>KES ' . number_format($row['total_price'], 2) . '</td>';
                            echo '<td><span class="expand-button bx bxs-chevron-down"></span></td>';
                            echo '</tr>';

                            // Display the order details with product information
                            echo '<tr class="order-details">';
                            echo '<td colspan="5">';
                            echo '<div class="order-images">';
                            // Add images of orders here
                            echo '<img src="../images/product-1.jpg" alt="Order 1">';
                            echo '<img src="../images/product-2.jpg" alt="Order 2">';
                            // Add more images if needed
                            echo '</div>';
                            echo '<div class="order-details-info">';
                            // Product Name
                            echo '<div><strong>Product Names:</strong> ' . $product['total_products'] . '</div>';
                            // Product Price
                            echo '<div><strong>Total Price:</strong> KES ' . number_format($product['total_price'], 2) . '</div>';
                            // Product Quantity
                            echo '<div><strong>Delivery Address:</strong> ' . $product['address'] . '</div>';
                            // Additional order details here
                            echo '</div>';
                            // Buttons for Track Order and Return
                            echo '<div class="order-buttons">';
                            echo '<button class="track-order-button">Track Order</button>';
                            echo '<button class="return-button">Return</button>';
                            echo '</div>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="login-security" id="login-security" style="display: none;">
            <!-- Login & Security content here -->
            <!-- Add your form or security settings here -->
        </div>

    </div>
</div>
<script>
    const orderRows = document.querySelectorAll('.order-row');
    const orderDetails = document.querySelectorAll('.order-details');

    orderRows.forEach((row, index) => {
        const expandButton = row.querySelector('.expand-button');

        expandButton.addEventListener('click', () => {
            // Toggle the visibility of the order details section
            if (orderDetails[index].style.display === 'none' || orderDetails[index].style.display === '') {
                orderDetails[index].style.display = 'block';
                expandButton.classList.remove('bxs-chevron-down');
                expandButton.classList.add('bxs-chevron-up');
            } else {
                orderDetails[index].style.display = 'none';
                expandButton.classList.remove('bxs-chevron-up');
                expandButton.classList.add('bxs-chevron-down');
            }
        });
    });

    const orderHistoryCard = document.getElementById('order-history-card');
    const loginCard = document.getElementById('login-security-card');
    const orderTable = document.querySelector('.order-table');

    orderHistoryCard.addEventListener('click', () => {
        // Show order history and set it as active
        orderHistoryCard.classList.add('active');
        loginCard.classList.remove('active');
        orderTable.style.display = 'block';
        document.querySelector('.section-title').textContent = 'Order History';
    });

    loginCard.addEventListener('click', () => {
        // Show login & security card and set it as active
        loginCard.classList.add('active');
        orderHistoryCard.classList.remove('active');
        orderTable.style.display = 'none';
        document.querySelector('.section-title').textContent = 'Change your Login Information';
    });
</script>

<?php
include_once('../assets/cart-temp/cart-footer.php');
?>
