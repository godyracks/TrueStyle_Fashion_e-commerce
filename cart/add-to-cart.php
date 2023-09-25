<?php
ob_start();
include_once('../assets/setup/db.php');

// Start or resume the session
//session_start();

// Check if the user is logged in
if (isset($_SESSION['SESSION_EMAIL'])) {
    $user_id = $_SESSION['SESSION_EMAIL'];
} else {
    $user_id = null; // User is not logged in
}

if (isset($_POST['add_to_cart'])) {
    $productID = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Retrieve product details from the database based on product ID
    $query = "SELECT * FROM products WHERE id = $productID";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);

        // Check if the user is logged in
        if ($user_id) {
            // Check if the product is already in the cart
            $check_query = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = $productID";
            $check_result = mysqli_query($conn, $check_query);

            if ($check_result && mysqli_num_rows($check_result) > 0) {
                // Product already exists in the cart, update the quantity
                $existing_cart_item = mysqli_fetch_assoc($check_result);
                $new_quantity = $existing_cart_item['quantity'] + $quantity;

                // Update the quantity in the cart table
                $update_query = "UPDATE cart SET quantity = $new_quantity WHERE user_id = '$user_id' AND product_id = $productID";
                mysqli_query($conn, $update_query) or die('Query failed');

                $_SESSION['cart_message'] = 'Product quantity updated in cart.';
                $_SESSION['cart_message_class'] = 'success';
            } else {
                // Insert the product into the cart table
                $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', $productID, $quantity)";
                mysqli_query($conn, $insert_query) or die('Query failed');

                $_SESSION['cart_message'] = 'Product added to cart.';
                $_SESSION['cart_message_class'] = 'success';
            }
        } else {
            // User is not logged in, insert into the guest cart
            $session_id = session_id(); // Use PHP's session_id() as a unique identifier

            // Check if the product is already in the guest cart
            $check_query = "SELECT * FROM guest_cart WHERE session_id = '$session_id' AND product_id = $productID";
            $check_result = mysqli_query($conn, $check_query);

            if ($check_result && mysqli_num_rows($check_result) > 0) {
                // Product already exists in the guest cart, update the quantity
                $existing_cart_item = mysqli_fetch_assoc($check_result);
                $new_quantity = $existing_cart_item['quantity'] + $quantity;

                // Update the quantity in the guest cart table
                $update_query = "UPDATE guest_cart SET quantity = $new_quantity WHERE session_id = '$session_id' AND product_id = $productID";
                mysqli_query($conn, $update_query) or die('Query failed');

                $_SESSION['cart_message'] = 'Product quantity updated in cart.';
                $_SESSION['cart_message_class'] = 'success';
            } else {
                // Insert the product into the guest cart table
                $insert_query = "INSERT INTO guest_cart (session_id, product_id, quantity) VALUES ('$session_id', $productID, $quantity)";
                mysqli_query($conn, $insert_query) or die('Query failed');

                $_SESSION['cart_message'] = 'Product added to cart.';
                $_SESSION['cart_message_class'] = 'success';
            }
        }

        // Redirect to the previous page (the product page)
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        $_SESSION['cart_message'] = 'Product not found.';
        $_SESSION['cart_message_class'] = 'error';
        // Redirect to the previous page (the product page)
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}

if (isset($_POST['update_update_btn'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    
    // Check if the user is logged in
    if ($user_id) {
        // Update quantity in the user's cart
        $update_quantity_query = mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id' AND user_id = '$user_id'");
    } else {
        // User is not logged in, update quantity in the guest cart
        $session_id = session_id();
        $update_quantity_query = mysqli_query($conn, "UPDATE `guest_cart` SET quantity = '$update_value' WHERE product_id = '$update_id' AND session_id = '$session_id'");
    }

    if ($update_quantity_query) {
      header('location:../cart/');
    }
}

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];

    // Check if the user is logged in
    if ($user_id) {
        // User is logged in, remove from the user's cart
        $remove_query = "DELETE FROM cart WHERE id = '$remove_id' AND user_id = '$user_id'";
    } else {
        // User is not logged in, remove from the guest cart
        $session_id = session_id(); // Use PHP's session_id() to identify the guest cart
        $remove_query = "DELETE FROM guest_cart WHERE guest_id = '$remove_id' AND session_id = '$session_id'";
    }

    mysqli_query($conn, $remove_query) or die('Query failed');
    $_SESSION['cart_message'] = 'Product removed from cart.';
    $_SESSION['cart_message_class'] = 'success';
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
?>