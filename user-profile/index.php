<?php
include_once('../assets/product-page-temp/product-header.php');

$user_id = $_SESSION['SESSION_EMAIL'];

if (!isset($user_id)) {
    header('location:../login');
    exit();
}

// Retrieve user information
$query_user = "SELECT * FROM user_info WHERE email = '$user_id'";
$result_user = mysqli_query($conn, $query_user);

// Retrieve the most recent order for the user
$query_order = "SELECT * FROM orders WHERE email = '$user_id' ORDER BY order_time DESC LIMIT 1";
$result_order = mysqli_query($conn, $query_order);

if (mysqli_num_rows($result_user) > 0) {
    $user = mysqli_fetch_assoc($result_user);
    // Display the user information
    $name = $user['name'];
    $email = $user['email'];

    // Display the user information and order details in the profile section
    echo '
    <div class="profile-container">
      <div class="profile-card">
        <img src="../uploaded_img/gody.jpg" class="card-img-top" alt="User Avatar">
        <div class="card-body">
          <h5 class="card-title" id="user-name">' . $name . '</h5>
          <p class="card-text" id="user-email">' . $email . '</p>
        <a href="../jobs/job-list/" class="btn btn-primary">Job List</a>
          <a href="../logout" class="btn btn-secondary">Logout</a>
        </div>
      </div>
      <div class="profile-details">
        <div class="profile-section">
          <h5><i class="bx bx-shopping-bag"></i> Orders</h5>';

    if (mysqli_num_rows($result_order) > 0) {
        $order = mysqli_fetch_assoc($result_order);
        // Display the most recent order details
        $order_id = $order['order_id'];
        $order_time = date('M d, Y', strtotime($order['order_time']));
        $total_price = $order['total_price'];
        $total_products = $order['total_products'];

        echo '
          <p>Order ID: ' . $order_id . '</p>
          <p>Order Time: ' . $order_time . '</p>
          <p>Total Price: KES ' . $total_price . '</p>
          <p>Total Products: ' . $total_products . '</p>';
    } else {
        echo '<p>No orders placed yet.</p>';
    }

    echo '
        </div>

        <div class="profile-section">
          <h5><i class="bx bx-truck"></i> Deliveries</h5>
          <p>No deliveries scheduled.</p>
        </div>

        <div class="profile-section">
          <h5><i class="bx bx-time"></i> Order Status</h5>';

    // Retrieve pending orders for the user
    $query_pending = "SELECT * FROM orders WHERE email = '$user_id' AND status = 'pending'";
    $result_pending = mysqli_query($conn, $query_pending);

    if (mysqli_num_rows($result_pending) > 0) {
        echo '<ul>';
        while ($pending_order = mysqli_fetch_assoc($result_pending)) {
            echo '<li>Order ID: ' . $pending_order['order_id'] . '</li>';
            echo '<li>Status: ' . $pending_order['status'] . '</li>';
            // Display other pending order details as needed
        }
        echo '</ul>';
    } else {
        echo '<p>No Order Status Found..</p>';
    }

    echo '
        </div>

        <div class="profile-section">
          <h5><i class="bx bx-message"></i> Messages</h5>
          <p>No messages to display.</p>
        </div>
      </div>
    </div>';
} else {
    // If user info not found, display a message
    echo '
    <div class="profile-container">
      <div class="profile-card">
        <img src="../uploaded_img/gody.jpg" class="card-img-top" alt="User Avatar">
        <div class="card-body">
          <h5 class="card-title" id="user-name">John Doe</h5>
          <p class="card-text" id="user-email">johndoe@example.com</p>
          <a href="../edit_profile" class="btn btn-primary">Edit Profile</a>
          <a href="../logout" class="btn btn-secondary">Logout</a>
        </div>
      </div>
      <div class="profile-details">
        <div class="profile-section">
          <h5><i class="bx bx-shopping-bag"></i> Orders</h5>
          <p>No orders placed yet.</p>
        </div>

        <div class="profile-section">
          <h5><i class="bx bx-truck"></i> Deliveries</h5>
          <p>No deliveries scheduled.</p>
        </div>

        <div class="profile-section">
          <h5><i class="bx bx-time"></i> Pending Orders</h5>
          <p>No pending orders.</p>
        </div>

        <div class="profile-section">
          <h5><i class="bx bx-message"></i> Messages</h5>
          <p>No messages to display.</p>
        </div>
      </div>
    </div>';
}

include_once('../assets/cart-temp/cart-footer.php');
?>
