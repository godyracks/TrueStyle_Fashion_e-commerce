<?php
include_once('../assets/product-page-temp/product-header.php');
include_once('../assets/setup/db.php');
// Check if the user is logged in
$user_id = isset($_SESSION['SESSION_EMAIL']) ? $_SESSION['SESSION_EMAIL'] : null;
$product_name = [];

if (!isset($user_id)) {
    // If user is not logged in, retrieve guest cart items
    $session_id = session_id();
    $select_guest_cart = mysqli_query($conn, "SELECT guest_cart.*, products.name AS product_name, products.price AS product_price FROM `guest_cart` 
        JOIN `products` ON guest_cart.product_id = products.id WHERE guest_cart.session_id = '$session_id'") or die('query failed');
    $grand_total = 0;
    $product_name = [];

    if (mysqli_num_rows($select_guest_cart) > 0) {
        while ($fetch_guest_cart = mysqli_fetch_assoc($select_guest_cart)) {
            $sub_total = (float)$fetch_guest_cart['product_price'] * (int)$fetch_guest_cart['quantity'];
            $grand_total += $sub_total;
            $product_name[] = $fetch_guest_cart['product_name'] . ' (' . $fetch_guest_cart['quantity'] . ')';
        }
    }
} else {
    // If user is logged in, retrieve cart items
    $select_cart = mysqli_query($conn, "SELECT cart.*, products.name AS product_name, products.price AS product_price FROM `cart` 
        JOIN `products` ON cart.product_id = products.id WHERE cart.user_id = '$user_id'") or die('query failed');
    $grand_total = 0;
    $product_name = [];

    if (mysqli_num_rows($select_cart) > 0) {
        while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
            $sub_total = (float)$fetch_cart['product_price'] * (int)$fetch_cart['quantity'];
            $grand_total += $sub_total;
            $product_name[] = $fetch_cart['product_name'] . ' (' . $fetch_cart['quantity'] . ')';
        }
    }
}

if (isset($_POST['order_btn'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];
    $payment_method = $_POST['payment-method'];

    $total_products = implode(', ', $product_name);

    $numeric_total_price = (float)str_replace(',', '', $grand_total);

    // Insert order details into the orders table
    $insert_order_query = mysqli_prepare($conn, "INSERT INTO `orders` (name, email, address, city, zip, payment_method, total_products, total_price) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

if ($insert_order_query === false) {
    echo "Error preparing insert query: " . mysqli_error($conn);
} else {
    mysqli_stmt_bind_param($insert_order_query, "sssssssd", $name, $email, $address, $city, $zip, $payment_method, $total_products, $grand_total);

    mysqli_stmt_execute($insert_order_query);
    if ($insert_order_query) {
        // Order insertion successful, you can perform further actions here
        // For example, send order confirmation email, clear the user's cart, etc.
        //echo "Order placed successfully!";
        // Store the phone number, total products, and order number in the session
        $_SESSION['phone_number'] = $phone_number;
        $_SESSION['total_products'] = $total_products;
        $_SESSION['orderNo'] = $orderNo;
        $_SESSION['grand_total'] = $grand_total;

        // Redirect to payments.php
        header("Location: ../payments/");
        exit;
    } else {
        echo "Error inserting order details: " . mysqli_error($conn);
    }

    mysqli_stmt_close($insert_order_query);
}
}
?>
    <style>

.container4 {
   max-width: 800px;
   margin: 0 auto;
   padding: 20px;
   background-color: #fff;
   box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

h1 {
   font-size: 24px;
   margin-bottom: 20px;
}

h2 {
   font-size: 18px;
   margin-bottom: 10px;
}

/* Order summary */
.order-summary {
   background-color: #f9f9f9;
   padding: 20px;
   border-radius: 5px;
}

.order-item {
   display: flex;
   margin-bottom: 10px;
}

.order-item img {
   max-width: 80px;
   margin-right: 10px;
}

.total {
   text-align: right;
   margin-top: 10px;
   font-weight: bold;
}

/* Checkout form */
.checkout-form {
   background-color: #f9f9f9;
   padding: 20px;
   border-radius: 5px;
}

.form-group {
   margin-bottom: 15px;
}

label {
   font-weight: bold;
}

input[type="text"],
input[type="email"],
input[type="radio"] {
   width: 100%;
   padding: 10px;
   border: 1px solid #ccc;
   border-radius: 5px;
   font-size: 16px;
}

input[type="radio"] {
   margin-right: 5px;
}

.checkout-button {
   background-color: #007BFF;
   color: #fff;
   padding: 10px 20px;
   border: none;
   border-radius: 5px;
   font-size: 18px;
   cursor: pointer;
}

/* Responsive styles */
@media (max-width: 768px) {
   .container {
       padding: 10px;
   }
   h1 {
       font-size: 20px;
       margin-bottom: 15px;
   }
   h2 {
       font-size: 16px;
       margin-bottom: 8px;
   }
}


    </style>

    <div class="container4">
        <h1>Checkout</h1>
        <div class="order-summary">
            <h2>Order Summary</h2>
            <!-- Display order items here -->
            <?php
// Loop through each product in the $product_name array and display its details
foreach ($product_name as $product) {
    // Split the product name and quantity from the formatted string
    list($productName, $quantity) = explode(' (', $product);
    $quantity = rtrim($quantity, ')'); // Remove the closing parenthesis

    // Fetch additional product details (e.g., price and image) from your database based on $productName
    // Modify the query to join the product_images table to fetch the image_path
    $query = mysqli_query($conn, "SELECT p.price, pi.image_path 
        FROM products p 
        JOIN product_images pi ON p.id = pi.product_id
        WHERE p.name = '$productName'");
    $productData = mysqli_fetch_assoc($query);
    $price = $productData['price'];
    $imagePath = $productData['image_path'];

    // Calculate subtotal for this product
    $subtotal = (float)$price * (int)$quantity;
    $subtotals[] = $subtotal; // Store subtotal in the array
?>

<div class="order-item">
    <img src="../uploaded_img/<?php echo $imagePath; ?>" alt="<?php echo $productName; ?>">
    <div class="product-details">
        <h3><?php echo $productName; ?></h3>
        <p>Price: KSh <?php echo $price; ?></p>
        <p>Quantity: <?php echo $quantity; ?></p>
        <p>Subtotal: KSh <?php echo number_format($subtotal, 2); ?></p>
    </div>
</div>
<?php
}
?>
<div class="total">
    <?php
    $grandTotal = array_sum($subtotals);
    echo "Grand Total: KSh " . number_format($grandTotal, 2);
    ?>
</div>
</div>
        <div class="checkout-form">
            <h2>Shipping Information</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" required>
                </div>
                <div class="form-group">
                    <label for="zip">ZIP Code:</label>
                    <input type="text" id="zip" name="zip" required>
                </div>
                <!-- Payment method options -->
                <h2>Payment Method</h2>
                <div class="form-group">
                    <input type="radio" id="credit-card" name="payment-method" value="credit-card" required>
                    <label for="credit-card">Credit Card</label>
                </div>
                <div class="form-group">
                    <input type="radio" id="paypal" name="payment-method" value="paypal" required>
                    <label for="paypal">PayPal</label>
                </div>
                <!-- Additional payment fields (e.g., credit card info) -->
                <!-- Include JavaScript to show/hide payment fields based on selected method -->
                <div id="credit-card-fields" class="hidden">
                    <!-- Credit card fields go here -->
                </div>
                <div id="paypal-fields" class="hidden">
                    <!-- PayPal fields go here -->
                </div>
                <div class="form-group">
                    <button type="submit" class="checkout-button" name="order_btn">Place Order</button>
                </div>
            </form>
        </div>
    </div>
    <script src="script.js">
        // JavaScript to handle payment method selection and show/hide payment fields
document.addEventListener("DOMContentLoaded", function () {
    const paymentMethodRadio = document.querySelectorAll('input[name="payment-method"]');
    const creditCardFields = document.getElementById('credit-card-fields');
    const paypalFields = document.getElementById('paypal-fields');

    paymentMethodRadio.forEach(function (radio) {
        radio.addEventListener("change", function () {
            if (radio.value === "credit-card") {
                creditCardFields.classList.remove("hidden");
                paypalFields.classList.add("hidden");
            } else if (radio.value === "paypal") {
                creditCardFields.classList.add("hidden");
                paypalFields.classList.remove("hidden");
            }
        });
    });
});

    </script> <!-- Include JavaScript for payment method handling -->
<?php include_once('../assets/cart-temp/cart-footer.php') ?>
