

<?php
//session_start();
// Check if there is a cart message in the session
if (isset($_SESSION['cart_message'])) {
    echo $_SESSION['cart_message'];
    unset($_SESSION['cart_message']);
    unset($_SESSION['cart_message_class']);
}
// Assuming you have a database connection established ($conn)
$itemsPerPage = 8;
$currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($currentPage - 1) * $itemsPerPage;

// Query to fetch limited products with LIMIT and OFFSET
$query = "SELECT * FROM products LIMIT $offset, $itemsPerPage";
$select_product = mysqli_query($conn, $query) or die('Query failed');
?>

<section class="section all-products" id="products">
    <div class="top container">
        <h1>All Products</h1>
        <form>
            <select>
                <option value="1">Default Sorting</option>
                <option value="2">Sort By Price</option>
                <option value="3">Sort By Popularity</option>
                <option value="4">Sort By Sale</option>
                <option value="5">Sort By Rating</option>
            </select>
            <span><i class="bx bx-chevron-down"></i></span>
        </form>
    </div>
    <div class="product-center container">
        <?php
        if (mysqli_num_rows($select_product) > 0) {
            while ($product = mysqli_fetch_assoc($select_product)) {
        ?>
                <div class="product-item">
                    <div class="overlay">
                        <a href="../details/?id=<?php echo $product['id']; ?>" class="product-thumb">
                            <img src="../uploaded_img/<?php echo $product['image']; ?>" alt="" />
                        </a>
                        <?php if (!empty($product['discount'])) { ?>
                                <span class="discount"><?php echo $product['discount']; ?>%</span>
                            <?php } else { ?>
                                <span class="discount" >0%</span>
                         <?php } ?>
                    </div>
                    <div class="product-info">
                        <span><?php echo $product['category']; ?></span>
                        <a href="../details/?id=<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a>
                        <h4>KES <?php echo $product['price']; ?></h4>
                    </div>
                    <ul class="icons">
                        <li><i class="bx bx-heart"></i></li>
                        <li><i class="bx bx-search"></i></li>
                                            <li><form method="post" action="../cart/add-to-cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="quantity" value="1"> <!-- You can adjust the quantity as needed -->
                        <button type="submit" name="add_to_cart" class="add-to-cart-btn"><i class="bx bx-cart" style="font-size: 10px;"></i></button>
                    </form></li>

                    </ul>
                </div>
        <?php
            }
        } else {
            echo "No products found.";
        }
        ?>
    </div>
</section>

<section class="pagination">
    <div class="container">
        <?php
        // Calculate total number of pages
        $totalPagesQuery = "SELECT COUNT(*) AS total FROM products";
        $totalPagesResult = mysqli_query($conn, $totalPagesQuery);
        $totalProducts = mysqli_fetch_assoc($totalPagesResult)['total'];
        $totalPages = ceil($totalProducts / $itemsPerPage);

        // Display pagination links
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a href='../product/?page=$i'>$i</a> ";
        }

        // Display next page link
        if ($currentPage < $totalPages) {
            echo "<a href='../product/?page=" . ($currentPage + 1) . "'><i class='bx bx-right-arrow-alt'></i></a>";
        }
        ?>
    </div>
</section>
