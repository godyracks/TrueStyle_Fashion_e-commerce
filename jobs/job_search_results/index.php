

<?php
// job_search_results.php
include_once('../jobs-templates/job-header.php'); 
include_once('../jobs-templates/job-navbar.php');

// Connect to your database (replace with your database connection code)
include('../../assets/setup/db.php');

// Retrieve form data
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";
$category = isset($_GET['category']) ? $_GET['category'] : "";
$location = isset($_GET['location']) ? $_GET['location'] : "";

// Build the SQL query based on the form inputs
$sql = "SELECT * FROM jobs WHERE 1";

if (!empty($keyword)) {
    $sql .= " AND (job_name LIKE '%$keyword%' OR job_description LIKE '%$keyword%')";
}

if (!empty($category) && $category !== "Category") {
    $sql .= " AND job_category = '$category'";
}

if (!empty($location) && $location !== "Location") {
    $sql .= " AND job_location = '$location'";
}

// Execute the query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo'<br />';
        echo'<br />';
        echo'<br />';
        echo '<div class="job-item p-4 mb-4">';
        echo '<div class="row g-4">';
        echo '<div class="col-sm-12 col-md-8 d-flex align-items-center">';
        // You can uncomment the image tag if you have a job logo image
        // echo '<img class="flex-shrink-0 img-fluid border rounded" src="img/com-logo-1.jpg" alt="" style="width: 80px; height: 80px;">';
        echo '<div class="text-start ps-4">';
        echo '<h5 class="mb-3">' . $row['job_name'] . '</h5>';
        echo '<span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>' . $row['job_location'] . '</span>';
        echo '<span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i>' . $row['job_nature'] . '</span>';
        echo '<span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>' . $row['salary_range'] . '</span>';
        echo '</div>';
        echo '</div>';
        echo '<div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">';
        echo '<div class="d-flex mb-3">';
        echo '<a class="btn btn-light btn-square me-3" href=""><i class="far fa-heart text-primary"></i></a>';
        echo '<a class="btn btn-primary" href="../job_details/?id=' . $row['job_id'] . '">Apply Now</a>';
        echo '</div>';
        echo '<small class="text-truncate"><i class="far fa-calendar-alt text-primary me-2"></i>Deadline: ' . $row['deadline'] . '</small>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo'<br />';
    echo'<br />';
    echo'<br />';
    echo '<p>No results found</p>';
    echo '<p>Sorry, no jobs matching your criteria were found.</p>';
    echo '<a href="javascript:history.go(-1)" class="btn btn-primary">Go Back</a>';
}
include_once('../jobs-templates/job-footer.php'); 
//$conn->close()
?>
