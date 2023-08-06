    <!-- Featured -->
  
    <section class="section new-arrival">
  <div class="title">
    <h1>Featured</h1>
    <p>All the latest picked from designer of our store</p>
  </div>
  <div class="product-center">
    <?php
    $query = "SELECT * FROM products WHERE featured = 1 ORDER BY id DESC LIMIT 4";
    $select_featured = mysqli_query($conn, $query) or die('Query failed');

    while ($product = mysqli_fetch_assoc($select_featured)) {
    ?>
    <div class="product-item">
      <div class="overlay">
        <a href="" class="product-thumb">
          <img src="../uploaded_img/<?php echo $product['image']; ?>" alt="" />
        </a>
        <?php if (!empty($product['discount'])) { ?>
          <span class="discount"><?php echo $product['discount']; ?>%</span>
        <?php } ?>
      </div>
      <div class="product-info">
        <span><?php echo $product['category']; ?></span>
        <a href=""><?php echo $product['name']; ?></a>
        <h4>KES <?php echo $product['price']; ?></h4>
      </div>
      <ul class="icons">
        <li><i class="bx bx-heart"></i></li>
        <li><i class="bx bx-search"></i></li>
        <li><i class="bx bx-cart"></i></li>
      </ul>
    </div>
    <?php } ?>
  </div>
</section>

