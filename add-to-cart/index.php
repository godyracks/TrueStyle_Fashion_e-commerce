<?php
//session_start();

// Assuming you have a database connection established ($conn)
include_once('../assets/setup/db.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = $_GET['id'];

    // Retrieve the product details from the database (modify as needed)
    $query = "SELECT * FROM products WHERE id = $productId";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        // Initialize the cart in the session if not already done
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Add the product to the cart
        $_SESSION['cart'][] = $product;

        // Redirect to the cart page
        header("Location: ../cart/");
        exit();
    }
}

// If no valid product ID was provided, redirect to the products page
header("Location: ../products/?page=" . $_GET['page']);
exit();
?>
