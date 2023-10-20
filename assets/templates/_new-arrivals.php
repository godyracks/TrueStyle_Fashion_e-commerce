<style>
    .add-to-cart-btn {
        background-color: #fff;
        border: none;
        font-size: 20px;
        height: 20px;
        margin: 0px;
        cursor: pointer;
        z-index: 1000;
    }

    .add-to-cart-btn:hover {
        background-color: #16a085;
        color: #fff;
    }
</style>

<section class="section new-arrival">
    <div class="title">
        <h1>NEW ARRIVALS</h1>
        <p>All the latest picked from designers of our store</p>
    </div>
    <div class="product-center">
        <?php
        $query = "SELECT products.*, (SELECT image_path FROM product_images WHERE product_id = products.id LIMIT 1) AS image_path
                  FROM products
                  ORDER BY products.id DESC
                  LIMIT 8";

        $select_product = mysqli_query($conn, $query) or die('Query failed');

        while ($product = mysqli_fetch_assoc($select_product)) {
            $second_image_query = "SELECT image_path FROM product_images WHERE product_id = {$product['id']} LIMIT 1 OFFSET 1";
            $second_image_result = mysqli_query($conn, $second_image_query);
            $second_image = mysqli_fetch_assoc($second_image_result);
            $second_image_path = isset($second_image['image_path']) ? $second_image['image_path'] : '';

            echo "<div class='product-item' data-second-image='$second_image_path'>";
            ?>
            <div class="overlay">
                <a href="../details/?id=<?php echo $product['id']; ?>" class="product-thumb">
                    <img src="../uploaded_img/<?php echo $product['image_path']; ?>" alt="" class="first-image" />
                    <img src="../uploaded_img/<?php echo $second_image_path; ?>" alt="" class="second-image" style="display: none;" />
                </a>
                <?php if (!empty($product['discount'])) { ?>
                    <span class="discount"><?php echo $product['discount']; ?>%</span>
                <?php } else { ?>
                    <span class="discount">0%</span>
                <?php } ?>
                <ul class="icons">
                <li>
                     <form method="post" action="../wishlist/add_to_wishlist.php">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="quantity" value="1"> <!-- You can adjust the quantity as needed -->
                        <button type="submit" name="add_to_wishlist" class="add-to-cart-btn"><i class="bx bx-heart" style="font-size: 20px;"></i></button>
                    </form></li>
                    <li><a href="../details/?id=<?php echo $product['id']; ?>"><i class='bx bx-dots-vertical-rounded bx-tada' ></i></a></li>
                    <li>
                        <form method="post" action="../cart/add-to-cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                            <input type="hidden" name="quantity" value="1"> <!-- You can adjust the quantity as needed -->
                            <button type="submit" name="add_to_cart" class="add-to-cart-btn"><i class="bx bx-cart" style="font-size: 20px;"></i></button>
                        </form>
                    </li>
                </ul>
            </div>
            <!-- Add product info here -->
            <div class="product-info">
                <span><?php echo $product['category']; ?></span>
                <a href="../details/?id=<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a>
                <h4>KES <?php echo $product['price']; ?></h4>
            </div>
            </div>
            <?php
        }
        ?>
    </div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const productItems = document.querySelectorAll(".product-item");

        productItems.forEach(function (productItem) {
            productItem.addEventListener("mouseenter", function () {
                const firstImage = productItem.querySelector(".first-image");
                const secondImage = productItem.querySelector(".second-image");

                firstImage.style.display = "none";
                secondImage.style.display = "block";
            });

            productItem.addEventListener("mouseleave", function () {
                const firstImage = productItem.querySelector(".first-image");
                const secondImage = productItem.querySelector(".second-image");

                firstImage.style.display = "block";
                secondImage.style.display = "none";
            });
        });
    });
</script>