<?php
include_once('../assets/product-page-temp/product-header.php');

$user_id = $_SESSION['SESSION_EMAIL'];

if (!isset($user_id)) {
    header('location:../login');
    exit();
}


$select_cart = mysqli_query($conn, "SELECT cart.*, products.name AS product_name, products.price AS product_price FROM `cart` 
                                    JOIN `products` ON cart.product_id = products.id 
                                    WHERE cart.user_id = '$user_id'");
$grand_total = 0;
$product_name = [];

if (mysqli_num_rows($select_cart) > 0) {
    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
        $sub_total = (float)$fetch_cart['product_price'] * (int)$fetch_cart['quantity'];
        $grand_total += $sub_total;
        $product_name[] = $fetch_cart['product_name'] . ' (' . $fetch_cart['quantity'] . ')';
    }
}

if (isset($_POST['order_btn'])) {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $method = $_POST['method'];
    $flat = $_POST['flat'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $county = $_POST['county'];
    $pin_code = $_POST['pin_code'];

    $total_product = implode(', ', $product_name);
    $detail_query = mysqli_prepare($conn, "INSERT INTO `orders` (name, number, email, method, flat, street, city, county, pin_code, total_products, total_price, order_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");

    mysqli_stmt_bind_param($detail_query, "ssssssssssd", $name, $number, $email, $method, $flat, $street, $city, $county, $pin_code, $total_product, $grand_total);
    mysqli_stmt_execute($detail_query);

    if ($detail_query) {
        echo "
        <div class='modal-overlay'>
            <div class='modal-dialog'>
                <div class='message-container'>
                    <h3>Thank you for shopping!</h3>
                    <div class='order-detail'>
                        <span>".$total_product."</span>
                        <span class='total'> total: KES ".$grand_total."/- </span>
                    </div>
                    <div class='customer-details'>
                        <p>your name: <span>".$name."</span></p>
                        <p>your number: <span>".$number."</span></p>
                        <p>your email: <span>".$email."</span></p>
                        <p>your address: <span>".$flat.", ".$street.", ".$city.", ".$county.", ".$pin_code."</span></p>
                        <p>your payment mode: <span>".$method."</span></p>
                        <p>(*pay when product arrives*)</p>
                    </div>
                    <a href='../user-profile' class='btn'>Track Order</a>
                    <a href='../product' class='btn'>Continue Shopping</a>
                </div>
            </div>
        </div>";

     
        // Check if the order details were inserted successfully
        if (mysqli_stmt_affected_rows($detail_query) > 0) {
            // Delete cart items for the user
            $delete_query = mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'");
            if (!$delete_query) {
                echo "Error deleting cart items: " . mysqli_error($conn);
            }
        } else {
            echo "Error inserting order details: " . mysqli_error($conn);
        }

        mysqli_stmt_close($detail_query);
    }
}
?>

<div class="container4">
    <section class="checkout-form">
        <?php if (!empty($product_name)): ?>
            <h1 class="heading">complete your order</h1>
            <form action="" method="post">
                <!-- Display order details -->
                <div class="display-order">
                    <?php foreach ($product_name as $product): ?>
                        <label><?= $product; ?></label>
                    <?php endforeach; ?>
                    <label class="grand-total"> grand total : KES <?= $grand_total; ?>/- </label>
                </div>

                <!-- Customer details form -->
                <div class="flex">
                <div class="inputBox">
                        <label>Your name</label>
                        <input type="text" placeholder="enter your name" name="name" required>
                    </div>
                    <div class="inputBox">
                        <label>Your number</label>
                        <input type="number" placeholder="enter your number" name="number" required>
                    </div>
                    <div class="inputBox">
                        <label>Your email</label>
                        <input type="email" placeholder="enter your email" name="email" required>
                    </div>
                    <div class="inputBox">
                        <label>Payment Method</label>
                        <select name="method">
                            <option value="cash on delivery" selected>Cash On Delivery</option>
                            <option value="m-pesa">M-PESA</option>
                            <option value="visa">VISA</option>
                        </select>
                    </div>
                    <div class="inputBox">
                        <label>Sreet 1</label>
                        <input type="text" placeholder="e.g. flat no." name="flat" required>
                    </div>
                    <div class="inputBox">
                        <label>Street 2</label>
                        <input type="text" placeholder="e.g. University Way" name="street" required>
                    </div>
                    <div class="inputBox">
                        <label>City or Town</label>
                        <input type="text" placeholder="e.g. Nairobi" name="city" required>
                    </div>
                    <div class="inputBox">
                        <label>County</label>
                        <input type="text" placeholder="e.g. Nairobi" name="county" required>
                    </div>
                    <div class="inputBox">
                        <label>Pin Code</label>
                        <input type="text" placeholder="e.g. 123456" name="pin_code" required>
                    </div>
                </div>
                <input type="submit" value="order now" name="order_btn" class="btn">
            </form>
        <?php else: ?>
            <div class='display-order'><p>Your cart is empty!</p></div>
        <?php endif; ?>
    </section>
</div>

<?php include_once('../assets/cart-temp/cart-footer.php') ?>
