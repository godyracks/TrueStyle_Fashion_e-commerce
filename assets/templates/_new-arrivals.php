<section class="section new-arrival">
  <div class="title">
    <h1>NEW ARRIVALS</h1>
    <p>All the latest picked from designers of our store</p>
  </div>
  <div class="product-center">
    <?php
    $query = "SELECT * FROM products ORDER BY id DESC LIMIT 8";
    $select_product = mysqli_query($conn, $query) or die('Query failed');
    
    while ($product = mysqli_fetch_assoc($select_product)) {
    ?>
    <div class="product-item">
      <div class="overlay">
        <a href="../details" class="product-thumb">
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
