

<?php include_once('../assets/product-page-temp/product-header.php') ?>
<?php
        $user_id = $_SESSION['SESSION_EMAIL'];

        if(!isset($user_id)){
            header('location:../login');
        };
        // Dump the $user_id variable
    //var_dump($user_id);
    
// Handle Add to Cart Logic
if (isset($_POST['add_to_cart'])) {
    $productID = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Retrieve product details from the database based on product ID
    $query = "SELECT * FROM products WHERE id = $productID";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);

        // Insert the product into the cart table
        $insert_query = "INSERT INTO cart (user_id, name, price, image, quantity) VALUES ('$user_id', '{$product['name']}', '{$product['price']}', '{$product['image']}', '$quantity')";
        mysqli_query($conn, $insert_query) or die('Query failed');

        // Redirect to the cart page
        header('Location: index.php');
        exit();
    } else {
        $message = 'Product not found.';
    }
}

    if(isset($_POST['update_cart'])){
        $update_quantity = $_POST['cart_quantity'];
        $update_id = $_POST['cart_id'];
        mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_quantity' WHERE id = '$update_id'") or die('query failed');
        $message[] = 'cart quantity updated successfully!';
     }

     if(isset($_GET['remove'])){
        $remove_id = $_GET['remove'];
        mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
        header('location:index.php');
     }

?>
<?php include_once('../assets/cart-temp/cart-items.php') ?>
<?php include_once('../assets/cart-temp/latest.php') ?>
<?php include_once('../assets/cart-temp/cart-footer.php') ?>