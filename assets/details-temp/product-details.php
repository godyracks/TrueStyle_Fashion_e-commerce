<?php
// Assuming you have a database connection established ($conn)

// Retrieve the product ID from the URL parameter
$productID = isset($_GET['id']) ? $_GET['id'] : null;

// Query to fetch the specific product based on the ID
$query = "SELECT * FROM products WHERE id = $productID";
$select_product = mysqli_query($conn, $query) or die('Query failed');

// Check if the product exists
if (mysqli_num_rows($select_product) > 0) {
    $product = mysqli_fetch_assoc($select_product);
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
            <form class="form" method="POST" action="../cart/">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <input type="text" name="quantity" placeholder="1" value="1" />
                <button type="submit" class="addCart" name="add_to_cart">Add To Cart</button>
            </form>
            <h3>Product Details</h3>
            <p><?php echo $product['description']; ?></p>
        </div>
    </div>
</section>

<?php
} else {
    echo "Product not found.";
}
?>
