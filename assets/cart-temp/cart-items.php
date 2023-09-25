<div class="container cart">
  <?php
  // Start or resume the session
 // session_start();
  
  include_once('../assets/setup/db.php');

  // Check if the user is logged in
  $user_id = isset($_SESSION['SESSION_EMAIL']) ? $_SESSION['SESSION_EMAIL'] : null;

  if (isset($_POST['update_update_btn'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];

    // Check if the user is logged in
    if ($user_id) {
      // User is logged in, update quantity in the user's cart
      $update_quantity_query = mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id' AND user_id = '$user_id'");
    } else {
      // User is not logged in, update quantity in the guest cart
      $session_id = session_id();
      $update_quantity_query = mysqli_query($conn, "UPDATE `guest_cart` SET quantity = '$update_value' WHERE guest_id = '$update_id' AND session_id = '$session_id'");
    }

    if ($update_quantity_query) {
      header('location:../cart/');
    }
  }

  // Initialize a flag to track if guest cart items were displayed
  $guest_cart_displayed = false;

  // Function to fetch the product image for a given product ID
  function fetchProductImage($conn, $productID)
  {
    $query = "SELECT image_path FROM product_images WHERE product_id = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $productID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
      return $row['image_path'];
    }
    return null; // Return null if no image is found
  }

  // Retrieve items from the user's cart if logged in
  $select_cart = mysqli_query($conn, "SELECT cart.*, products.price, products.name FROM `cart` JOIN `products` ON cart.product_id = products.id WHERE cart.user_id = '$user_id'") or die('query failed');
  $grand_total = 0;

  // Check if there are items in the user's cart
  if (mysqli_num_rows($select_cart) > 0) {
    echo '<table>
            <tr>
              <th>Product</th>
              <th>Quantity</th>
              <th>Subtotal</th>
              <th>Action</th>
            </tr>';
    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
      $product_image = fetchProductImage($conn, $fetch_cart['product_id']);
      $sub_total = (float)$fetch_cart['price'] * (int)$fetch_cart['quantity'];
      $grand_total += $sub_total;
      echo '<tr>
              <td>
                <div class="cart-info">
                  <img src="../uploaded_img/' . $product_image . '" alt="" />
                  <div>
                    <p>' . $fetch_cart['name'] . '</p>
                    <span>Price: KES ' . $fetch_cart['price'] . '/-</span> <br />
                    <a href="../cart/add-to-cart.php?remove=' . $fetch_cart['id'] . '" class="delete-btn" onclick="return confirm(\'Remove item from cart?\');">Remove</a>
                  </div>
                </div>
              </td>
              <td>
              <form action="" method="post">
                <input type="hidden" name="update_quantity_id" value="' . $fetch_cart['id'] . '">
                <select name="update_quantity">
                  <?php
                  // Generate options for quantities from 1 to 10
                  for ($i = 1; $i <= 10; $i++) {
                    $selected = ($i == $fetch_cart["quantity"]) ? "selected" : ';
                    echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                  }
                  ?>
                </select>
                <input type="submit" value="Update" name="update_update_btn" class="option-btn">
              </form>
            </td>
            
  
  
              <td>KES ' . $sub_total . '/-</td>
              <td>
                <a href="../cart/add-to-cart.php?remove=' . $fetch_cart['id'] . '" class="delete-btn" onclick="return confirm(\'Remove item from cart?\');">Remove</a>
              </td>
            </tr>';
    }
    echo '</table>';
  }

  // If the user is not logged in, retrieve and display items from the guest cart
  if (!$user_id) {
    $session_id = session_id(); // Get the guest session ID
    $select_guest_cart = mysqli_query($conn, "SELECT guest_cart.*, products.price, products.name, products.id as product_id FROM `guest_cart` JOIN `products` ON guest_cart.product_id = products.id WHERE guest_cart.session_id = '$session_id'") or die('query failed');

    if (mysqli_num_rows($select_guest_cart) > 0) {
      echo '<h2>Guest Cart Items</h2>';
      echo '<table>
              <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
              </tr>';
      while ($fetch_guest_cart = mysqli_fetch_assoc($select_guest_cart)) {
        $product_image = fetchProductImage($conn, $fetch_guest_cart['product_id']);
        $sub_total = (float)$fetch_guest_cart['price'] * (int)$fetch_guest_cart['quantity'];
        $grand_total += $sub_total;
        echo '<tr>
                <td>
                  <div class="cart-info">
                    <img src="../uploaded_img/' . $product_image . '" alt="" />
                    <div>
                      <p>' . $fetch_guest_cart['name'] . '</p>
                      <span>Price: KES ' . $fetch_guest_cart['price'] . '/-</span>
                      <a href="../cart/add-to-cart.php?remove=' . $fetch_guest_cart['guest_id'] . '" class="delete-btn" onclick="return confirm(\'Remove item from cart?\');">Remove</a>
                    </div>
                  </div>
                </td>
                <td>
                  <form action="../cart/add-to-cart.php" method="post">
                    <input type="hidden" name="update_quantity_id"  value="' . $fetch_guest_cart['product_id'] . '" >
                    <input type="number" name="update_quantity" min="1"  value="' . $fetch_guest_cart['quantity'] . '" >
                    <input type="submit" value="update" name="update_update_btn" class="option-btn">
                  </form>
                </td>
                <td>KES ' . $sub_total . '/-</td>
                <td>
     
                </td>
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