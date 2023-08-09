<!-- Latest Products -->
<section class="section featured">
  <div class="top container">
    <h1>Latest Products</h1>
    <a href="#" class="view-more">View more</a>
  </div>
  <div class="product-center container">
    <?php
    $query = "SELECT * FROM products ORDER BY id DESC LIMIT 4"; // Adjust the query to fetch latest products
    $select_product = mysqli_query($conn, $query) or die('Query failed');
    
    while ($product = mysqli_fetch_assoc($select_product)) {
    ?>
    <div class="product-item">
      <div class="overlay">
      <a href="../details/?id=<?php echo $product['id']; ?>" class="product-thumb">
          <img src="../uploaded_img/<?php echo $product['image']; ?>" alt="" /> <!-- Update image path -->
        </a>
        <?php if (!empty($product['discount'])) { ?>
          <span class="discount"><?php echo $product['discount']; ?>%</span>
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
    <?php } ?>
  </div>
</section>
