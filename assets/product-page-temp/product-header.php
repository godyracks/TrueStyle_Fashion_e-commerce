
<?php include_once('../assets/setup/db.php') ?>
<?php
         // Fetch the cart count
            $cartCount = 0;
            if (isset($_SESSION['SESSION_EMAIL'])) {
                $userID = $_SESSION['SESSION_EMAIL'];
                $cartQuery = "SELECT COUNT(*) AS count FROM cart WHERE user_id = '$userID'";
                $cartResult = mysqli_query($conn, $cartQuery);
                $cartCount = mysqli_fetch_assoc($cartResult)['count'];
            }

            // Fetch the wishlist count
// $wishlistCount = 0;
// if (isset($_SESSION['SESSION_EMAIL'])) {
//     $userID = $_SESSION['SESSION_EMAIL'];
//     $wishlistQuery = "SELECT COUNT(*) AS count FROM wishlist WHERE user_id = '$userID'";
//     $wishlistResult = mysqli_query($conn, $wishlistQuery);
//     $wishlistCount = mysqli_fetch_assoc($wishlistResult)['count'];
// }

          ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Box icons -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"
    />
    <!-- Custom StyleSheet -->
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="custom.css" />
    <title>True Style</title>
  </head>

  <body>
    <!-- Navigation -->
    <div class="top-nav">
      <div class="container d-flex">
        <p>Order Online Or Call Us: +254 701 559 001</p>
        <ul class="d-flex">
          <li><a href="#">About Us</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </div>
    </div>
    <div class="navigation">
      <div class="nav-center container d-flex">
        <a href="../home" class="logo"><h1>True Style</h1></a>

        <ul class="nav-list d-flex">
          <li class="nav-item">
            <a href="../home" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="../product" class="nav-link">Shop</a>
          </li>
          <li class="nav-item">
            <a href="#terms" class="nav-link">Adverts</a>
          </li>
          <li class="nav-item">
            <a href="#about" class="nav-link">About</a>
          </li>
          <li class="nav-item">
            <a href="#contact" class="nav-link">Contact</a>
          </li>
          <li class="icons d-flex">
          <?php
       // session_start();
        if (isset($_SESSION['SESSION_EMAIL'])) {
          // User is logged in
          echo '<a href="/truestylev1/logout" class="icon">
            <i class="bx bx-log-out"></i>
          </a>';
        } else {
          // User is not logged in
          echo '<a href="/truestylev1/login" class="icon">
            <i class="bx bx-user"></i>
          </a>';
        }
        ?>
            <div class="icon">
              <i class="bx bx-search"></i>
            </div>
            <div class="icon">
              <i class="bx bx-heart"></i>
              <span class="d-flex">0</span>
            </div>
            <a href="../cart" class="icon">
              <i class="bx bx-cart"></i>
              <span class="d-flex"><?php echo $cartCount; ?></span>
            </a>
          </li>
        </ul>

        <div class="icons d-flex">
        <?php
       // session_start();
        if (isset($_SESSION['SESSION_EMAIL'])) {
          // User is logged in
          echo '<a href="/truestylev1/logout" class="icon">
            <i class="bx bx-log-out"></i>
          </a>';
        } else {
          // User is not logged in
          echo '<a href="/truestylev1/login" class="icon">
            <i class="bx bx-user"></i>
          </a>';
        }
        ?>
        <div class="icon">
          <i class="bx bx-search"></i>
        </div>
        <div class="icon">
          <i class="bx bx-heart"></i>
          <span class="d-flex">0</span>
        </div>
        <a href="/truestylev1/cart" class="icon">
          <i class="bx bx-cart"></i>
          <span class="d-flex"><?php echo $cartCount; ?></span>
        </a>
      </div>

        <div class="hamburger">
          <i class="bx bx-menu-alt-left"></i>
        </div>
      </div>
    </div>