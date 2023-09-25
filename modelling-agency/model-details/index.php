<?php
include_once('../../assets/setup/db.php');

if (isset($_GET['name'])) {
    $modelName = $_GET['name'];
// Query to fetch model data from the database for the selected model
$sql = "SELECT name, image, caption FROM models WHERE name = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $modelName);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the model was found
    if ($result->num_rows > 0) {
        // Fetch model details and start the HTML page
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $image = $row['image'];
        $caption = $row['caption'];

         // Fetch all images associated with the model
         $imageSql = "SELECT image FROM models WHERE name = ?";
         $imageStmt = $conn->prepare($imageSql);

        ?>
    <style>
     

      
        /* Container styles */
        .model-details {
            text-align: center;
            padding: 20px;
        }

        .container6 {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        /* Section Header */
        .section-model-header {
            width: 100%;
            margin-bottom: 30px;
        }

        .section-model-header h2 {
            font-size: 24px;
            color: #333;
        }

        /* Instagram Embed */
        .instagram-embed {
            width: 300px;
            height: 300px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Photo Slide */
        .photo-slide2 {
            width: 100%; /* Occupy full width on small screens */
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            margin-bottom: 20px; /* Add some space between sections */
        }

        .slider2-container {
            position: relative;
            overflow: hidden;
        }

        .slider2 {
            display: flex;
            transition: transform 0.5s ease;
        }

        .slider2 img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .prev-btn,
        .next-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: #333;
            color: #fff;
            border: none;
            padding: 5px 10px;
            font-size: 20px;
            cursor: pointer;
            z-index: 1;
        }

        .prev-btn {
            left: 10px;
        }

        .next-btn {
            right: 10px;
        }

        /* Model Name */
        .model-name {
            width: 100%; /* Occupy full width on small screens */
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }

        .model-name h1 {
            font-size: 36px;
            color: #333;
            margin-bottom: 10px;
        }

        /* Buttons */
        button {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin-top: 10px;
            cursor: pointer;
        }

        /* Instagram Embed styles */
.instagram-embed {
    width: 500px;
    height: 700px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}


        /* Style for the social media icons */
        .social-icons {
            display: flex;
            gap: 10px;
        }

        .social-icon {
            width: 30px;
            height: 30px;
            /* background-color: #3498db; */
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            text-decoration: none;
            color: #fff;
            font-size: 18px;
        }

        /* Style for the contact details */
        .contact-details p {
            margin: 5px 0;
        }




        /* Add some responsive styles */
        @media (max-width: 768px) {
            .container6 {
                flex-direction: column;
                align-items: center;
            }

            /* Adjust the width of specific elements for small screens */
            .instagram-embed,
            .photo-slide,
            .model-name {
                width: 100%;
            }
        }
    </style>
<?php   include_once('../model-templates/header.php'); ?>
    <section class="model-details">
        <div class="container6">
            <div class="section-model-header">
                <h2>Model Details</h2>
            </div>
  
            <div class="child1-container">
                <div class="photo-slide2">
                    <div class="slider2-container">
                        <div class="slider2">
                        <img src="../../model_img_uploads/<?php echo $image; ?>" alt="Photo 1">
                       
                        </div>
                        <button class="prev-btn">&#10094;</button>
                        <button class="next-btn">&#10095;</button>
                    </div>
                </div>
            </div>
            <div class="child1-container">
           <!-- Instagram Embed -->
                <div class="instagram-embed">
                    <!-- Social Media Icons -->
                    <div class="social-icons">
                        <a href="#" class="social-icon">
                            <img src="instagram.svg" alt="Instagram" width="30px;" height="30px;">
                        </a>
                        <a href="#" class="social-icon" >
                            <img src="x.svg" alt="Twitter" width="25px;" height="25px;">
                        </a>
                     
                    </div>

                    <!-- Contact Details -->
                    <div class="contact-details">
                        <p>Email: example@example.com</p>
                        <p>Phone: +123456789</p>
                    </div>
                </div>
</div>

            </div>
            <div class="child1-container">
            <div class="model-name">
                        <h1><?php echo $name; ?></h1>
                        <p><?php echo $caption; ?></p>
                        <button>About Model</button><br />
                        <button><a href="https://www.instagram.com/gody_racks/" style="color:white;">Visit Instagram</a></button>
                </div>
            </div>
        </div>
    </section>
    <script>
        const slider = document.querySelector(".slider2");
        const prevBtn = document.querySelector(".prev-btn");
        const nextBtn = document.querySelector(".next-btn");
        let currentIndex = 0;

        function showSlide(index) {
            if (index < 0) {
                currentIndex = slider.children.length - 1;
            } else if (index >= slider.children.length) {
                currentIndex = 0;
            }
            slider.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        prevBtn.addEventListener("click", () => {
            currentIndex--;
            showSlide(currentIndex);
        });

        nextBtn.addEventListener("click", () => {
            currentIndex++;
            showSlide(currentIndex);
        });

        // Initial display
        showSlide(currentIndex);
    </script>
  <?php include_once('../model-templates/footer.php');
      } else {
        // Handle the case where the model was not found
        echo "Model not found.";
    }
} else {
    // Handle the case where the database query failed
    echo "Database error.";
}
  
}

?>