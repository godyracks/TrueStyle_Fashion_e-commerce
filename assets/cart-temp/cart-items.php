<div class="container cart">
  <table>
    <tr>
      <th>Product</th>
      <th>Quantity</th>
      <th>Subtotal</th>
    </tr>
    <?php
    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    $grand_total = 0;

    if (mysqli_num_rows($cart_query) > 0) {
      while ($fetch_cart = mysqli_fetch_assoc($cart_query)) {
        $sub_total = (float)$fetch_cart['price'] * (int)$fetch_cart['quantity'];

        $grand_total += $sub_total;
    ?>
        <tr>
          <td>
            <div class="cart-info">
              <img src="../uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="" />
              <div>
                <p><?php echo $fetch_cart['name']; ?></p>
                <span>Price: KES <?php echo $fetch_cart['price']; ?>/-</span> <br />
                <a href="../cart/index.php?remove=<?php echo $fetch_cart['id']; ?>" class="delete-btn" onclick="return confirm('Remove item from cart?');">Remove</a>
              </div>
            </div>
          </td>
          <td>
            <form action="" method="post">
              <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
              <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
              <input type="submit" name="update_cart" value="Update" class="option-btn">
            </form>
          </td>
          <td>KES <?php echo $sub_total; ?>/-</td>
        </tr>
    <?php
      }
    } else {
      echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">No items added</td></tr>';
    }
    ?>
  </table>
  <div class="total-price">
    <table>
      <tr>
        <td>Grand Total</td>
        <td>KES <?php echo $grand_total; ?>/-</td>
      </tr>
    </table>
    <?php
    // Enable the "proceed to checkout" button only if there are items in the cart
    $checkoutButtonClass = ($grand_total > 0) ? '' : 'disabled';
    ?>
    <a href="#" class="btn <?php echo $checkoutButtonClass; ?>">Proceed to Checkout</a>
  </div>
</div>
