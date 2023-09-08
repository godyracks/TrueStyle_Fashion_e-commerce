<div class="container cart">
  <?php

  // Check if the user is logged in
  $user_id = isset($_SESSION['SESSION_EMAIL']) ? $_SESSION['SESSION_EMAIL'] : null;

  if (isset($_POST['update_update_btn'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    $update_quantity_query = mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id'");
    if ($update_quantity_query) {
      header('location:../cart/');
    }
  }


  // Initialize a flag to track if guest cart items were displayed
  $guest_cart_displayed = false;

  // Retrieve items from the user's cart if logged in
  $select_cart = mysqli_query($conn, "SELECT cart.*, products.price, products.image, products.name FROM `cart` JOIN `products` ON cart.product_id = products.id WHERE cart.user_id = '$user_id'") or die('query failed');
  $grand_total = 0;

  // Check if there are items in the user's cart
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
  }

  // If the user is not logged in, retrieve and display items from the guest cart
  if (!$user_id) {
    $session_id = session_id(); // Get the guest session ID
    $select_guest_cart = mysqli_query($conn, "SELECT guest_cart.*, products.price, products.image, products.name FROM `guest_cart` JOIN `products` ON guest_cart.product_id = products.id WHERE guest_cart.session_id = '$session_id'") or die('query failed');

    if (mysqli_num_rows($select_guest_cart) > 0) {
      echo '<h2>Guest Cart Items</h2>';
      echo '<table>
              <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
              </tr>';
      while ($fetch_guest_cart = mysqli_fetch_assoc($select_guest_cart)) {
        $sub_total = (float)$fetch_guest_cart['price'] * (int)$fetch_guest_cart['quantity'];
        $grand_total += $sub_total;
        echo '<tr>
                <td>
                  <div class="cart-info">
                    <img src="../uploaded_img/' . $fetch_guest_cart['image'] . '" alt="" />
                    <div>
                      <p>' . $fetch_guest_cart['name'] . '</p>
                      <span>Price: KES ' . $fetch_guest_cart['price'] . '/-</span>
                      <!-- You can add a remove link here for guest cart items if needed -->
                    </div>
                  </div>
                </td>
                
               
                <td>' . $fetch_guest_cart['quantity'] . '</td>
                <td>KES ' . $sub_total . '/-</td>
              </tr>';
      }
      echo '</table>';
      $guest_cart_displayed = true; // Set the flag to true
    }
  }

  // If both carts are empty, display "Cart Not Found" message
  if (!$guest_cart_displayed && mysqli_num_rows($select_cart) === 0) {
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