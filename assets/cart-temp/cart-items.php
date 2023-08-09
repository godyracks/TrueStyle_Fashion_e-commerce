<?php
    if (isset($_SESSION['cart_message'])) {
        echo $_SESSION['cart_message'];
        unset($_SESSION['cart_message']);
        unset($_SESSION['cart_message_class']);
    }
    ?>
<style>
  /* Add this CSS to style the cart message */
.cart-message {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    display: none;
    z-index: 9999;
    text-align: center;
    font-size: 16px;
    font-weight: bold;
    box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.2);
}

.cart-message.success {
    background-color: #4caf50;
}

.cart-message.error {
    background-color: #f44336;
}

.cart-message.show {
    display: block;
}

.cart-message .close-btn {
    position: absolute;
    top: 5px;
    right: 10px;
    cursor: pointer;
}

</style>


<div class="container cart">

  <?php
  

  if (isset($_POST['update_update_btn'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    $update_quantity_query = mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id'");
    if ($update_quantity_query) {
      header('location:../cart/');
    }
  }

  $select_cart = mysqli_query($conn, "SELECT cart.*, products.price, products.image, products.name FROM `cart` JOIN `products` ON cart.product_id = products.id WHERE cart.user_id = '$user_id'") or die('query failed');
  $grand_total = 0;

  if (mysqli_num_rows($select_cart) > 0) {
    echo '<table>
            <tr>
              <th>Product</th>
              <th>Quantity</th>
              <th>Subtotal</th>
            </tr>';
    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
      $sub_total = (float)$fetch_cart['price'] * (int)$fetch_cart['quantity'];
      $grand_total += $sub_total;
      echo '<tr>
              <td>
                <div class="cart-info">
                  <img src="../uploaded_img/' . $fetch_cart['image'] . '" alt="" />
                  <div>
                    <p>' . $fetch_cart['name'] . '</p>
                    <span>Price: KES ' . $fetch_cart['price'] . '/-</span> <br />
                    <a href="../cart/add-to-cart.php?remove=' . $fetch_cart['id'] . '" class="delete-btn" onclick="return confirm(\'Remove item from cart?\');">Remove</a>
                  </div>
                </div>
              </td>
              <td>
                <form action="" method="post">
                  <input type="hidden" name="update_quantity_id"  value="' . $fetch_cart['id'] . '" >
                  <input type="number" name="update_quantity" min="1"  value="' . $fetch_cart['quantity'] . '" >
                  <input type="submit" value="update" name="update_update_btn" class="option-btn">
                </form>
              </td>
              <td>KES ' . $sub_total . '/-</td>
            </tr>';
    }
    echo '</table>';
  } else {
    echo '<img src="../images/cart.jpg" alt="Cart Not Found" />
          <p style="color: orange; font-size: 20px;">Cart is empty. Start shopping now!</p>';
  }
  ?>
  <div class="total-price">
    <?php
    if ($grand_total > 0) {
      echo '<table>
              <tr>
                <td>Grand Total</td>
                <td>KES ' . $grand_total . '/-</td>
              </tr>
            </table>
            <a href="../checkout/" class="btn">Proceed to Checkout</a>';
    }
    ?>
  </div>
</div>
<!-- Cart message container outside of the cart container -->
<!-- <div class="cart-message <?php echo isset($_SESSION['cart_message_class']) ? $_SESSION['cart_message_class'] : ''; ?>" id="cartMessage">
    <span class="close-btn" onclick="closeCartMessage()"><i class="bx bx-x"></i></span>
 
</div> -->

<script>
    function closeCartMessage() {
        document.getElementById("cartMessage").classList.remove("show");
    }
</script>
