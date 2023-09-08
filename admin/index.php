<?php



include_once('../assets/product-page-temp/product-header.php');

// Check if the user is logged in
if (!isset($_SESSION['SESSION_EMAIL'])) {
   // Redirect the user to the login page or display an error message
   header("Location:../login");
   exit();
}

// Check if the user is an admin
if ($_SESSION['SESSION_EMAIL'] !== 'godfreymatagaro@gmail.com' && $_SESSION['SESSION_EMAIL'] !== 'gmatagaro4@gmail.com' && $_SESSION['SESSION_EMAIL'] !== 'another1@gmail.com') {
   // Redirect the normal user to a different page or display an error message
   header("Location: ../access_denied");
   exit();
}

$user_id = $_SESSION['SESSION_NAME'];

if(isset($_POST['add_product'])){
   $p_name = $_POST['p_name'];
   $p_category = $_POST['p_category'];
   $p_description = $_POST['p_description'];
    // Sanitize the HTML content (You might need to use a proper HTML sanitizer library)
    $p_description = htmlspecialchars($p_description);
   $p_price = $_POST['p_price'];
   $p_discount = $_POST['p_discount'];
   $p_image = $_FILES['p_image']['name'];
   $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   $p_image_folder = '../uploaded_img/'.$p_image;
   $p_featured = isset($_POST['p_featured']) ? 1 : 0;

   $insert_query = mysqli_prepare($conn, "INSERT INTO `products` (name, category, description, price, discount, image, featured) VALUES (?, ?, ?, ?, ?, ?, ?)");
   mysqli_stmt_bind_param($insert_query, "sssiisi", $p_name, $p_category, $p_description, $p_price, $p_discount, $p_image, $p_featured);
  
   mysqli_stmt_execute($insert_query);


   if($insert_query){
      header('location:../admin/');
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

if (isset($_POST['update_product'])) {
   $update_p_id = $_POST['update_p_id'];
   $update_p_name = $_POST['update_p_name'];
   $update_p_price = $_POST['update_p_price'];
   $update_p_description = $_POST['update_p_description'];

   // Sanitize the input
   $update_p_name = mysqli_real_escape_string($conn, $update_p_name);
   $update_p_price = mysqli_real_escape_string($conn, $update_p_price);
   $update_p_description = mysqli_real_escape_string($conn, $update_p_description);

   // Prepare the update statement
   $update_query = $conn->prepare("UPDATE products SET name=?, price=?, description=? WHERE id=?");
   $update_query->bind_param("sssi", $update_p_name, $update_p_price, $update_p_description, $update_p_id);

   // Execute the update statement
   if ($update_query->execute()) {
      $message[] = 'Product updated successfully';
   } else {
      $message[] = 'Product could not be updated: ' . $update_query->error;
   }
}


if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="bx bx-x" onclick="this.parentElement.style.display = `none`;"></i> </div>';
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
   <div id="editor" name="p_description" required></div>
   <input type="number" name="p_price" min="0" placeholder="enter the product price" class="box" required>
   <input type="number" name="p_discount" min="0" placeholder="enter the product discount (optional)" class="box" >
   <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
   <input type="checkbox" name="p_featured" value="1"> Featured

   <input type="submit" value="add the product" name="add_product" class="btn">
</form>

</section>



<section class="display-product-cards">

   <div class="card-container">

   <?php
         $limit = 3; // Number of products to display per page
         $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number

         $offset = ($page - 1) * $limit; // Offset for pagination

         $select_products = mysqli_query($conn, "SELECT * FROM `products` ORDER BY id DESC LIMIT $offset, $limit");
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
            <?php
               // Pagination logic
               $total_products = mysqli_query($conn, "SELECT COUNT(*) as total FROM `products`");
               $total_products = mysqli_fetch_assoc($total_products)['total'];
               $total_pages = ceil($total_products / $limit);

               if ($total_pages > 1) {
                  echo '<div class="pagination">';
                  for ($i = 1; $i <= $total_pages; $i++) {
                     echo '<a href="../admin/?page=' . $i . '">' . $i . '</a>';
                  }
                  echo '</div>';
               }
            ?>
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
<?php
// Your database connection code here
 //include_once('../../assets/setup/db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $caption = $_POST["caption"];

    // Check if files were uploaded
    if (isset($_FILES["images"]) && is_array($_FILES["images"]["name"])) {
        $imageErrors = array();

        // Loop through each uploaded file
        for ($i = 0; $i < count($_FILES["images"]["name"]); $i++) {
            $imageFileName = $_FILES["images"]["name"][$i];
            $imageTmpName = $_FILES["images"]["tmp_name"][$i];
            $imageFileType = strtolower(pathinfo($imageFileName, PATHINFO_EXTENSION));

            // Generate a unique filename to avoid overwriting
            $uniqueFilename = uniqid() . "." . $imageFileType;
            $targetPath = "../model_img_uploads/" . $uniqueFilename;

            // Check if the file is an image
            $validExtensions = array("jpg", "jpeg", "png", "gif");
            if (!in_array($imageFileType, $validExtensions)) {
                $imageErrors[] = "File '{$imageFileName}' is not a valid image.";
            } elseif (move_uploaded_file($imageTmpName, $targetPath)) {
                // File was successfully uploaded, you can now insert its information into the database
                $sql = "INSERT INTO models (name, image, caption) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $name, $uniqueFilename, $caption);
$stmt->execute();
            } else {
                $imageErrors[] = "Error uploading file '{$imageFileName}'";
            }
        }

        if (empty($imageErrors)) {
            // All images were uploaded successfully
            echo "All images uploaded successfully!";
        } else {
            // Handle any errors related to image uploads
            foreach ($imageErrors as $error) {
                echo $error . "<br>";
            }
        }
    } else {
        echo "No files were uploaded.";
    }
}
?>

    <style>
       

       model-form {
            background-color: #fff;
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        input[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
         model-form{
                max-width: 90%;
            }
        }
    </style>

    <h1>Add Model Data</h1>
    <form action="" method="POST" enctype="multipart/form-data" class="model-form">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="images">Images (Upload multiple):</label>
        <input type="file" id="images" name="images[]" accept="image/*" multiple required class="file-input">

        <label for="caption">Caption:</label>
        <textarea id="caption" name="caption" required></textarea>

        <input type="submit" value="Submit">
    </form>

</div>
  


   
   <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

<script>
    ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => {
      console.error(error);
    });
        // Close the edit form when cancel button is clicked
        document.querySelector('#close-edit').onclick = () =>{
            document.querySelector('.edit-form-container').style.display = 'none';
            window.location.href = '../admin';
         };

         document.addEventListener('DOMContentLoaded', function() {
    const icon = document.querySelector('.bx-x');
    icon.addEventListener('click', function() {
      window.location.href = '../admin';
    });
  });

   </script>

   <?php include_once('../assets/cart-temp/cart-footer.php'); ?> 