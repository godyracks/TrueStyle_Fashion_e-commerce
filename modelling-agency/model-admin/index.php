<?php
// Your database connection code here
 include_once('../../assets/setup/db.php');
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



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Model Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        form {
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
            form {
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    <h1>Add Model Data</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="images">Images (Upload multiple):</label>
        <input type="file" id="images" name="images[]" accept="image/*" multiple required class="file-input">

        <label for="caption">Caption:</label>
        <textarea id="caption" name="caption" required></textarea>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
