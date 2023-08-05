<?php
include_once('../assets/product-page-temp/product-header.php');

// Check if the user is logged in
if (!isset($_SESSION['SESSION_EMAIL'])) {
   // Redirect the user to the login page or display an error message
   header("Location:../login");
   exit();
}

// Check if the user is an admin
if ($_SESSION['SESSION_EMAIL'] !== 'godfreymatagaro@gmail.com') {
   // Redirect the normal user to a different page or display an error message
   header("Location: ../access_denied");
   exit();
}

$user_id = $_SESSION['SESSION_NAME'];

if(isset($_POST['add_product'])){
   $p_name = $_POST['p_name'];
   $p_category = $_POST['p_category'];
   $p_description = $_POST['p_description'];
   $p_price = $_POST['p_price'];
   $p_image = $_FILES['p_image']['name'];
   $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   $p_image_folder = '../uploaded_img/'.$p_image;

   $insert_query = mysqli_prepare($conn, "INSERT INTO `products` (name, category, description, price, image) VALUES (?, ?, ?, ?, ?)");
   mysqli_stmt_bind_param($insert_query, "sssis", $p_name, $p_category, $p_description, $p_price, $p_image);
   mysqli_stmt_execute($insert_query);


   if($insert_query){
      move_uploaded_file($p_image_tmp_name, $p_image_folder);
      $message[] = 'product added successfully';
   }else{
      $message[] = 'could not add the product';
   }
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_query = mysqli_query($conn, "DELETE FROM `products` WHERE id = $delete_id ") or die('query failed');
   if($delete_query){
      header('location:../admin/');
      $message[] = 'product has been deleted';
   }else{
      header('location:../admin/');
      $message[] = 'product could not be deleted';
   }
}

if(isset($_POST['update_product'])){
   $update_p_id = $_POST['update_p_id'];
   $update_p_name = $_POST['update_p_name'];
   $update_p_category = $_POST['update_p_category'];
   $update_p_description = $_POST['update_p_description'];
   $update_p_price = $_POST['update_p_price'];
   $update_p_image = $_FILES['update_p_image']['name'];
   $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
   $update_p_image_folder = 'uploaded_img/'.$update_p_image;

   $update_query = mysqli_query($conn, "UPDATE `products` SET name = '$update_p_name', category = '$update_p_category', description = '$update_p_description', price = '$update_p_price', image = '$update_p_image' WHERE id = '$update_p_id'");

   if($update_query){
      move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
      $message[] = 'product updated successfully';
      header('location:../admin/');
   }else{
      $message[] = 'product could not be updated';
      header('location:../admin/');
   }
}

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   }
}

?>

<h1>ADMIN PANEL</h1>
<div class="container">

<section>

<form action="" method="post" class="add-product-form" enctype="multipart/form-data">
   <h3>add a new product</h3>
   <input type="text" name="p_category" placeholder="CATEGORY e.g MEN'S WEAR, LADIES'S WEAR, UNISEX " class="box" required>
   <input type="text" name="p_name" placeholder="enter the product name e.g denim shirts, " class="box" required>
   <input type="text" name="p_description" placeholder="enter the product brief description" class="box" required>
   <input type="number" name="p_price" min="0" placeholder="enter the product price" class="box" required>
   <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
   <input type="submit" value="add the product" name="add_product" class="btn">
</form>

</section>

<section class="display-product-cards">

   <div class="card-container">

      <?php
         
         $select_products = mysqli_query($conn, "SELECT * FROM `products`");
         if(mysqli_num_rows($select_products) > 0){
            while($row = mysqli_fetch_assoc($select_products)){
      ?>

      <div class="card">
         <img src="../uploaded_img/<?php echo $row['image']; ?>" height="100" alt="">
         <h4><?php echo $row['name']; ?></h4>
         <p>KES <?php echo $row['price']; ?>/-</p>
         <div class="card-actions">
            <a href="../admin/?delete=<?php echo $row['id']; ?>" class="delete-btn" > <i class="fas fa-trash"></i> delete </a>
            <a href="../admin/?edit=<?php echo $row['id']; ?>" class="option-btn"> <i class="fas fa-edit"></i> update </a>
         </div>
      </div>

      <?php
         }    
         }else{
            echo "<div class='empty'>no product added</div>";
         }
      ?>

   </div>

</section>

<section class="edit-form-container">

   <?php
   
   if(isset($_GET['edit'])){
      $edit_id = $_GET['edit'];
      $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = $edit_id");
      if(mysqli_num_rows($edit_query) > 0){
         while($fetch_edit = mysqli_fetch_assoc($edit_query)){
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <img src="uploaded_img/<?php echo $fetch_edit['image']; ?>" height="200" alt="">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">
      <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['name']; ?>">
      <input type="text" class="box" required name="update_p_category" value="<?php echo $fetch_edit['category']; ?>">
      <input type="text" class="box" required name="update_p_description" value="<?php echo $fetch_edit['description']; ?>">
      <input type="number" min="0" class="box" required name="update_p_price" value="<?php echo $fetch_edit['price']; ?>">
      <input type="file" class="box" required name="update_p_image" accept="image/png, image/jpg, image/jpeg">
      <input type="submit" value="update the product" name="update_product" class="btn">
      <input type="reset" value="cancel" id="close-edit" class="option-btn">
   </form>

   <?php
            }
         }
         echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
      }
   ?>

</section>

   </div>

   <?php include_once('../assets/cart-temp/cart-footer.php'); ?>
