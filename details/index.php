<?php include_once('../assets/product-page-temp/product-header.php') ?>

<?php 

  if(isset($_POST['add_to_cart'])){

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($select_cart) > 0){
    $message[] = 'product already added to cart!';
    }else{
    mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
    $message[] = 'product added to cart!';
    }

};

?>
<?php include_once('../assets/details-temp/product-details.php') ?>
<?php include_once('../assets/details-temp/related.php') ?>
<?php include_once('../assets/cart-temp/cart-footer.php') ?>