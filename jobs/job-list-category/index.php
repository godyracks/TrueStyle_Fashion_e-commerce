<?php include_once('../jobs-templates/job-header.php'); // Include necessary templates ?>
<?php include_once('../jobs-templates/job-navbar.php'); // Include necessary templates ?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and other necessary files
include_once('../../assets/setup/db.php');


// Check if category parameter is set
if (isset($_GET['category'])) {
    $category = $_GET['category'];

      
?>

        <!-- Container for Job Listings -->
        <div class="container-xxl py-5">
            <div class="container">
                <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Categorical Listing</h1>
                <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.3s">
                    <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                        <li class="nav-item">
                            <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active" data-bs-toggle="pill" href="#tab-1">
                                <h6 class="mt-n1 mb-0">Featured</h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="d-flex align-items-center text-start mx-3 pb-3" data-bs-toggle="pill" href="#tab-2">
                                <h6 class="mt-n1 mb-0">Full Time</h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="d-flex align-items-center text-start mx-3 me-0 pb-3" data-bs-toggle="pill" href="#tab-3">
                                <h6 class="mt-n1 mb-0">Part Time</h6>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Featured Jobs -->
                        <div id="tab-1" class="tab-pane fade show p-0 active">
                        <?php
                  $sqlFeatured = "SELECT * FROM jobs WHERE job_category = '$category' AND job_nature = 'Featured' ORDER BY job_id DESC";
                    $resultFeatured = $conn->query($sqlFeatured);

                    while ($row = $resultFeatured->fetch_assoc()):
                               ?> 
                                <div class="job-item p-4 mb-4">
            <div class="row g-4">
                <div class="col-sm-12 col-md-8 d-flex align-items-center">
                    <!-- <img class="flex-shrink-0 img-fluid border rounded" src="img/com-logo-1.jpg" alt="" style="width: 80px; height: 80px;"> -->
                    <div class="text-start ps-4">
                        <h5 class="mb-3"><?= $row['job_name'] ?></h5>
                        <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i><?= $row['job_location'] ?></span>
                        <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i><?= $row['job_nature'] ?></span>
                        <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i><?= $row['salary_range'] ?></span>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                    <div class="d-flex mb-3">
                        <a class="btn btn-light btn-square me-3" href=""><i class="far fa-heart text-primary"></i></a>
                        <a class="btn btn-primary" href="../job_details/?id=<?= $row['job_id'] ?>">Apply Now</a>
                    </div>
                    <small class="text-truncate"><i class="far fa-calendar-alt text-primary me-2"></i>Date Line: <?= $row['deadline'] ?></small>
                </div>
            </div>
        </div> <?php
    endwhile;
    ?>
                        </div>
                        
                        <!-- Full Time Jobs -->
                        <div id="tab-2" class="tab-pane fade show p-0">
                        <?php
                          $sqlFullTime = "SELECT * FROM jobs WHERE job_category = '$category' AND job_nature = 'Full Time' ORDER BY job_id DESC";
                        $resultFullTime = $conn->query($sqlFullTime);
    
                        while ($row = $resultFullTime->fetch_assoc()):
                            ?>
                                <div class="job-item p-4 mb-4">
                                            <div class="row g-4">
                                                <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                                    <!-- <img class="flex-shrink-0 img-fluid border rounded" src="img/com-logo-1.jpg" alt="" style="width: 80px; height: 80px;"> -->
                                                    <div class="text-start ps-4">
                                                        <h5 class="mb-3"><?=  $row['job_name'] ?></h5>
                                                        <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i><?=  $row['job_location'] ?></span>
                                                        <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i><?=  $row['job_nature'] ?></span>
                                                        <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i><?=  $row['salary_range'] ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                                    <div class="d-flex mb-3">
                                                        <a class="btn btn-light btn-square me-3" href=""><i class="far fa-heart text-primary"></i></a>
                                                        <a class="btn btn-primary" href="../job_details/?id=<?= $row['job_id'] ?>">Apply Now</a>
                                                    </div>
                                                    <small class="text-truncate"><i class="far fa-calendar-alt text-primary me-2"></i>Deadline: <?=  $row['deadline'] ?></small>
                                                </div>
                                            </div>
                                        </div><?php
                                    endwhile;
                                    ?>
                        </div>
                        
                        <!-- Part Time Jobs -->
                        <div id="tab-3" class="tab-pane fade show p-0">
                        <?php
                         $sqlPartTime = "SELECT * FROM jobs WHERE job_category = '$category' AND job_nature = 'Part Time' ORDER BY job_id DESC";
                        $resultPartTime = $conn->query($sqlPartTime);
    
                        while ($row = $resultPartTime->fetch_assoc()): ?>
                                <div class="job-item p-4 mb-4">
                                            <div class="row g-4">
                                                <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                                    <!-- <img class="flex-shrink-0 img-fluid border rounded" src="img/com-logo-1.jpg" alt="" style="width: 80px; height: 80px;"> -->
                                                    <div class="text-start ps-4">
                                                        <h5 class="mb-3"><?= $row['job_name'] ?></h5>
                                                        <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i><?=  $row['job_location'] ?></span>
                                                        <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i><?=  $row['job_nature'] ?></span>
                                                        <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i><?=  $row['salary_range'] ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                                    <div class="d-flex mb-3">
                                                        <a class="btn btn-light btn-square me-3" href=""><i class="far fa-heart text-primary"></i></a>
                                                        <a class="btn btn-primary" href="../job_details/?id=<?= $row['job_id'] ?>">Apply Now</a>
                                                    </div>
                                                    <small class="text-truncate"><i class="far fa-calendar-alt text-primary me-2"></i>Deadline: <?=  $row['deadline'] ?></small>
                                                </div>
                                            </div>
                                        </div><?php
                                    endwhile;
                                    ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
// Include footer template
include_once('../jobs-templates/job-footer.php');
} else {
    echo "<p>Category parameter missing.</p>";
}
?>