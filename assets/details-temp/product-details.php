

<?php
// Check if there is a cart message in the session
if (isset($_SESSION['cart_message'])) {
    // Display the cart message
    $cart_message = $_SESSION['cart_message'];
    echo '<p>' . $cart_message . '</p>';

    // Clear the cart message from the session
    unset($_SESSION['cart_message']);
}
// Assuming you have a database connection established ($conn)

// Retrieve the product ID from the URL parameter
$productID = isset($_GET['id']) ? $_GET['id'] : null;

// Query to fetch the specific product based on the ID
$query = "SELECT * FROM products WHERE id = $productID";
$select_product = mysqli_query($conn, $query) or die('Query failed');

// Check if the product exists
if (mysqli_num_rows($select_product) > 0) {
    $product = mysqli_fetch_assoc($select_product);

   // Retrieve the product category
   $productCategory = $product['category'];



// Query to fetch related products of the same category, excluding the current product
$queryRelated = "SELECT id, name, image, category, price FROM products WHERE category = ? AND id != ? LIMIT 4";

   $select_related_products = mysqli_prepare($conn, $queryRelated);
   mysqli_stmt_bind_param($select_related_products, "si", $productCategory, $productID);
   mysqli_stmt_execute($select_related_products);
   $result_related = mysqli_stmt_get_result($select_related_products);
    

?>

<section class="section product-detail">
    <div class="details container">
        <div class="left image-container">
            <div class="main">
                <img src="../uploaded_img/<?php echo $product['image']; ?>" id="zoom" alt="" />
            </div>
        </div>
        <div class="right">
            <span><?php echo $product['category']; ?></span>
            <h1><?php echo $product['name']; ?></h1>
            <div class="price">KES <?php echo $product['price']; ?></div>
            <form>
                <div>
                    <select>
                        <option value="Select Size" selected disabled>Select Size</option>
                        <option value="1">32</option>
                        <option value="2">42</option>
                        <option value="3">52</option>
                        <option value="4">62</option>
                    </select>
                    <span><i class="bx bx-chevron-down"></i></span>
                </div>
            </form>
            <form class="form" method="POST" action="../cart/add-to-cart.php">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <input type="text" name="quantity" placeholder="1" value="1" hidden/>
                <button type="submit" class="addCart" name="add_to_cart">Add To Cart</button>
            </form>
            <h3>Product Details</h3>
            <p><?php echo $product['description']; ?></p>
        </div>
    </div>
</section>


<!-- Related products section -->
<section class="section featured">
    <div class="top container">
        <h1>Related Products</h1>
        <a href="#" class="view-more">View more</a>
    </div>
    <div class="product-center container">
    <?php
        if (mysqli_num_rows($result_related) === 0) {
            echo '<p>No related products are available.</p>';
        } else {
    while ($related_product = mysqli_fetch_assoc($result_related)) {
        echo '<div class="product-item">';
        echo '<div class="overlay">';
        echo '<a href="../details/?id=' . $related_product['id'] . '" class="product-thumb">';
        echo '<img src="../uploaded_img/' . $related_product['image'] . '" alt="" />';
        echo '</a>';
        echo '</div>';
        echo '<div class="product-info">';
        echo '<span>' . $related_product['category'] . '</span>';
        echo '<a href="../details/?id=' . $related_product['id'] . '">' . $related_product['name'] . '</a>';
        echo '<h4>KES ' . $related_product['price'] . '</h4>';
        echo '</div>';
        echo '<ul class="icons">';
        echo '<li><i class="bx bx-heart"></i></li>';
        echo '<li><i class="bx bx-search"></i></li>';
        echo '<li><form method="post" action="../cart/add-to-cart.php">
            <input type="hidden" name="product_id" value="'.$related_product['id'].'">
            <input type="hidden" name="quantity" value="1"> <!-- You can adjust the quantity as needed -->
            <button type="submit" name="add_to_cart" class="add-to-cart-btn"><i class="bx bx-cart" style="font-size: 20px;"></i></button>
        </form></li>';
        echo '</ul>';
        echo '</div>';
    }
}
        ?>
    </div>
</section>



<?php
} else {
    echo "Product not found.";
}
?>

