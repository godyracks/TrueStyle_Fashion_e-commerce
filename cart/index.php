<?php
include_once('../assets/product-page-temp/product-header.php');

// Start or resume the session
//session_start();

// Check if the user is logged in
$user_id = isset($_SESSION['SESSION_EMAIL']) ? $_SESSION['SESSION_EMAIL'] : null;

// Handle Add to Cart Logic
if (isset($_POST['add_to_cart'])) {
    $productID = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if the product is already in the cart
    $check_query = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = $productID";
    $check_result = mysqli_query($conn, $check_query);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        // Product already exists in the cart
        $message = 'Product already exists in the cart.';
    } else {
        // Retrieve product details from the database based on product ID
        $query = "SELECT * FROM products WHERE id = $productID";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);

            if ($user_id) {
                // Insert the product into the user's cart
                $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', $productID, $quantity)";
                mysqli_query($conn, $insert_query) or die('Query failed');
            } else {
                // User is not logged in, insert into the guest cart
                $session_id = session_id(); // Use PHP's session_id() as a unique identifier
                $insert_query = "INSERT INTO guest_cart (session_id, product_id, quantity) VALUES ('$session_id', $productID, $quantity)";
                mysqli_query($conn, $insert_query) or die('Query failed');
            }

            // Redirect to the cart page
            header('Location:../cart/');
            exit();
        } else {
            $message = 'Product not found.';
        }
    }
}

if (isset($_POST['update_cart'])) {
    $update_quantity = $_POST['cart_quantity'];
    $update_id = $_POST['cart_id'];

    if ($user_id) {
        // Update the cart quantity for the user
        mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_quantity' WHERE id = '$update_id' AND user_id = '$user_id'") or die('query failed');
    } else {
        // Update the cart quantity for the guest
        $session_id = session_id();
        mysqli_query($conn, "UPDATE `guest_cart` SET quantity = '$update_quantity' WHERE id = '$update_id' AND session_id = '$session_id'") or die('query failed');
    }

    $message[] = 'Cart quantity updated successfully!';
}

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];

    if ($user_id) {
        // Remove the item from the user's cart
        mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id' AND user_id = '$user_id'") or die('query failed');
    } else {
        // Remove the item from the guest cart
        $session_id = session_id();
        mysqli_query($conn, "DELETE FROM `guest_cart` WHERE id = '$remove_id' AND session_id = '$session_id'") or die('query failed');
    }

    header('location:../cart/');
}
?>

<?php include_once('../assets/cart-temp/cart-items.php') ?>
<?php include_once('../assets/cart-temp/latest.php') ?>
<?php include_once('../assets/cart-temp/cart-footer.php') ?>
