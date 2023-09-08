<?php
// Include your database connection code here
 include_once('../../assets/setup/db.php');

// Query to fetch model data from the database
$sql = "SELECT name, image, caption FROM models";
$result = $conn->query($sql);

// Check if there are any rows in the result set
if (mysqli_num_rows($result) > 0) {
    // Start the portfolio section
    echo '<section class="portfolioheader">
      <h1>portfolio</h1>  <a href="../models/#models-contact"><button class="contact-us">Contact Us</button></a>
    </section>
    <section class="portfolio">
      <div class="row">';

    // Loop through the fetched data and generate HTML for each model
    while ($row = $result->fetch_assoc()) { 
        $name = $row['name'];
        $image = $row['image'];
        $caption = $row['caption'];

        // Generate a random image URL from the list of images for this model
        $imageUrls = explode(',', $image); // Assuming multiple image URLs are stored as comma-separated values
        $randomImageUrl = $imageUrls[array_rand($imageUrls)];

        // Generate HTML for each model using the random image
        echo '<div class="portfoliocol">
                <a class="modelpage" href="../model-details/?name=' . $name . '">
                  <img src="../../model_img_uploads/' . $randomImageUrl . '" alt="' . $name . '" />
                  <div class="layer">
                    <h3>' . $name . '</h3>
                  </div>
                  <div class="eye-icon">
                    <a href="../model-details/?name=' . $name . '"></i></a>
                  </div>
                </a>
              </div>';
    }

    // End the portfolio section
    echo '</div>
    </section>';
} else {
    // Handle the case where no models are found
    echo 'No models found in the database.';
}
?>
