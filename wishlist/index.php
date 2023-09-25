<?php include_once('../assets/product-page-temp/product-header.php') ?>

<div class="container cart">
  <?php
 // session_start(); // Start the session

  $user_id = $_SESSION['SESSION_EMAIL'];

  if (!isset($user_id)) {
      header('location:../login');
      exit();
  }
  // Fetch wishlist items for the user
  $select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');

  if (mysqli_num_rows($select_wishlist) > 0) {
    echo '<table>
            <tr>
              <th>Product</th>
              <th>Action</th>
            </tr>';
    while ($fetch_wishlist = mysqli_fetch_assoc($select_wishlist)) {
      // Fetch product details based on product_id from wishlist
      $product_id = $fetch_wishlist['product_id'];
      $product_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$product_id'") or die('query failed');
      $product = mysqli_fetch_assoc($product_query);

      // Fetch the image path from the product_images table
      $image_query = mysqli_query($conn, "SELECT image_path FROM `product_images` WHERE product_id = '$product_id' LIMIT 1") or die('query failed');
      $image_row = mysqli_fetch_assoc($image_query);
      $image_path = $image_row['image_path'];

      echo '<tr>
              <td>
                <div class="wishlist-info">
                  <img src="../uploaded_img/' . $image_path . '" alt="" />
                  <div>
                    <p>' . $product['name'] . '</p>
                    <span>Price: KES ' . $product['price'] . '/-</span><br />
                    <a href="./add_to_wishlist.php?remove=' . $fetch_wishlist['id'] . '" class="delete-btn" onclick="return confirm(\'Remove item from wishlist?\');">Remove</a>
                  </div>
                </div>
              </td>
              <td>
                <form action="../cart/" method="post">
                  <input type="hidden" name="product_id" value="' . $product['id'] . '">
                  <input name="add_to_cart" type="submit" value="Add to Cart" class="option-btn">
                </form>
              </td>
            </tr>';
    }
    echo '</table>';
  } else {
    echo '<img src="../images/wishlist.png" alt="Wishlist Not Found" />
          <p style="color: green; font-size: 20px;">Your wishlist is empty. Start adding products!</p>';
  }
  ?>
</div>

<?php include_once('../assets/cart-temp/cart-footer.php') ?>
