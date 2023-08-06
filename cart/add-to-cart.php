<?php
//session_start();
include_once('../assets/setup/db.php'); // Include your database connection here

$user_id = $_SESSION['SESSION_EMAIL'];

if (!isset($user_id)) {
    header('location:../login');
    exit();
}

if (isset($_POST['add_to_cart'])) {
    $productID = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $product_id = $_POST['id'];

    // Check if the product is already in the cart
    $check_query = "SELECT * FROM cart WHERE user_id = '$user_id' AND id = '$product_id'";
    $check_result = mysqli_query($conn, $check_query);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        // Product already exists in the cart
        $message = 'Product already exists in the cart.';
        // You might want to handle this case appropriately
    } else {
        // Retrieve product details from the database based on product ID
        $query = "SELECT * FROM products WHERE id = $productID";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);

            // Insert the product into the cart table
            $insert_query = "INSERT INTO cart (user_id, name, price, image, quantity) VALUES ('$user_id', '{$product['name']}', '{$product['price']}', '{$product['image']}', '$quantity')";
            mysqli_query($conn, $insert_query) or die('Query failed');

            // Redirect to the cart page
            header('Location:../cart/');
            exit();
        } else {
            $message = 'Product not found.';
            // You might want to handle this case appropriately
        }
    }
}
?>
