<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

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

    // Retrieve product details from the database based on product ID
    $query = "SELECT * FROM products WHERE id = $productID";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);

        // Check if the product is already in the cart
        $check_query = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = $productID";
        $check_result = mysqli_query($conn, $check_query);

        if ($check_result && mysqli_num_rows($check_result) > 0) {
            // Product already exists in the cart
            $_SESSION['cart_message'] = 'Product already exists in the cart.';
            $_SESSION['cart_message_class'] = 'error'; // Set error class
        } else {
            // Insert the product into the cart table
            $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', $productID, $quantity)";
            mysqli_query($conn, $insert_query) or die('Query failed');
            $_SESSION['cart_message'] = 'Product added to cart.';
            $_SESSION['cart_message_class'] = 'success'; // Set success class
        }

        // Redirect to the previous page (the product page)
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        $_SESSION['cart_message'] = 'Product not found.';
        $_SESSION['cart_message_class'] = 'error'; // Set error class
        // Redirect to the previous page (the product page)
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    $remove_query = "DELETE FROM cart WHERE id = '$remove_id' AND user_id = '$user_id'";
    mysqli_query($conn, $remove_query) or die('query failed');
    $_SESSION['cart_message'] = 'Product removed from cart.';
    $_SESSION['cart_message_class'] = 'success'; // Set success class
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
?>
