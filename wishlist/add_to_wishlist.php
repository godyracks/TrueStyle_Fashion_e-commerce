<?php
// Include your database connection here
include_once('../assets/setup/db.php');

// Start the session
//session_start();

// Get the user's email from the session
$user_email = $_SESSION['SESSION_EMAIL'];

if (!isset($user_email)) {
    header('location:../login');
    exit();
}

// Retrieve the user_id based on the email from the user_info table
$user_query = "SELECT id FROM user_info WHERE email = '$user_email'";
$user_result = mysqli_query($conn, $user_query);

if (!$user_result || mysqli_num_rows($user_result) == 0) {
    // Handle the case where the user is not found (you can redirect or display an error message)
    die('User not found.');
}

// Fetch the user_id
$user_row = mysqli_fetch_assoc($user_result);
$user_id = $user_row['id'];

if (isset($_POST['add_to_wishlist'])) {
    $productID = $_POST['product_id'];
    $product_id = $_POST['id'];

    // Retrieve product details from the database based on product ID
    $query = "SELECT * FROM products WHERE id = $productID";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);

        // Check if the product is already in the wishlist
        $check_query = "SELECT * FROM wishlist WHERE user_id = '$user_id' AND product_id = $productID";
        $check_result = mysqli_query($conn, $check_query);

        if ($check_result && mysqli_num_rows($check_result) > 0) {
            // Product already exists in the wishlist
            $_SESSION['wishlist_message'] = 'Product is already in your wishlist.';
            $_SESSION['wishlist_message_class'] = 'error'; // Set error class
        } else {
            // Insert the product into the wishlist table
            $insert_query = "INSERT INTO wishlist (user_id, product_id) VALUES ('$user_id', $productID)";
            mysqli_query($conn, $insert_query) or die('Query failed');
            $_SESSION['wishlist_message'] = 'Product added to wishlist.';
            $_SESSION['wishlist_message_class'] = 'success'; // Set success class
        }

        // Redirect to the previous page (the product page)
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        $_SESSION['wishlist_message'] = 'Product not found.';
        $_SESSION['wishlist_message_class'] = 'error'; // Set error class
        // Redirect to the previous page (the product page)
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    $remove_query = "DELETE FROM wishlist WHERE id = '$remove_id' AND user_id = '$user_id'";
    mysqli_query($conn, $remove_query) or die('query failed');
    $_SESSION['wishlist_message'] = 'Product removed from wishlist.';
    $_SESSION['wishlist_message_class'] = 'success'; // Set success class
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
?>
