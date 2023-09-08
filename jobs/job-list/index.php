<?php include_once('../jobs-templates/job-header.php'); // Include necessary templates ?>
<?php include_once('../jobs-templates/job-navbar.php'); // Include necessary templates ?>
<div class="container-xxl py-5">
    <div class="container">
        <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Latest Job Listings</h1>
        <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.3s">
            <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                <li class="nav-item">
                    <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active" data-bs-toggle="pill"
                        href="#tab-1">
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
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <?php
                    include_once('../../assets/setup/db.php');
                    // Fetch job data from the database
                    $sql = "SELECT * FROM jobs WHERE job_nature = 'Featured' ORDER BY job_id DESC";
                    $result = $conn->query($sql);
                    ?>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="job-item p-4 mb-4">
                                <div class="row g-4">
                                    <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                        <!-- <img class="flex-shrink-0 img-fluid border rounded" src="img/com-logo-1.jpg" alt="" -->
                                            <!-- style="width: 80px; height: 80px;"> -->
                                        <div class="text-start ps-4">
                                            <h5 class="mb-3">
                                                <?= $row['job_name'] ?>
                                            </h5>
                                            <span class="text-truncate me-3"><i
                                                    class="fa fa-map-marker-alt text-primary me-2"></i>
                                                <?= $row['job_location'] ?>
                                            </span>
                                            <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i>
                                                <?= $row['job_nature'] ?>
                                            </span>
                                            <span class="text-truncate me-0"><i
                                                    class="far fa-money-bill-alt text-primary me-2"></i>
                                                <?= $row['salary_range'] ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div
                                        class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                        <div class="d-flex mb-3">
                                            <a class="btn btn-light btn-square me-3" href=""><i
                                                    class="far fa-heart text-primary"></i></a>
                                                    <a class="btn btn-primary" href="../job_details/?id=<?= $row['job_id'] ?>">Apply Now</a>
                                        </div>
                                        <small class="text-truncate"><i
                                                class="far fa-calendar-alt text-primary me-2"></i>Deadline:
                                            <?= $row['deadline'] ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No jobs found.</p>
                    <?php endif; ?>
                    <?php
                    // Close the database connection
                    // $conn->close();
                    ?>

                    <a class="btn btn-primary py-3 px-5" href="">Browse More Jobs</a>
                </div>
                <div id="tab-2" class="tab-pane fade show p-0">
                    <?php
                   // include_once('../../assets/setup/db.php');
                    // Fetch job data from the database
                    $sql = "SELECT * FROM jobs WHERE job_nature = 'Full Time' ORDER BY job_id DESC";
                    $result = $conn->query($sql);
                    ?>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="job-item p-4 mb-4">
                                <div class="row g-4">
                                    <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                        <!-- <img class="flex-shrink-0 img-fluid border rounded" src="img/com-logo-1.jpg" alt="" -->
                                            <!-- style="width: 80px; height: 80px;"> -->
                                        <div class="text-start ps-4">
                                            <h5 class="mb-3">
                                                <?= $row['job_name'] ?>
                                            </h5>
                                            <span class="text-truncate me-3"><i
                                                    class="fa fa-map-marker-alt text-primary me-2"></i>
                                                <?= $row['job_location'] ?>
                                            </span>
                                            <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i>
                                                <?= $row['job_nature'] ?>
                                            </span>
                                            <span class="text-truncate me-0"><i
                                                    class="far fa-money-bill-alt text-primary me-2"></i>
                                                <?= $row['salary_range'] ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div
                                        class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                        <div class="d-flex mb-3">
                                            <a class="btn btn-light btn-square me-3" href=""><i
                                                    class="far fa-heart text-primary"></i></a>
                                                    <a class="btn btn-primary" href="../job_details/?id=<?= $row['job_id'] ?>">Apply Now</a>
                                        </div>
                                        <small class="text-truncate"><i
                                                class="far fa-calendar-alt text-primary me-2"></i>Deadline:
                                            <?= $row['deadline'] ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No jobs found.</p>
                    <?php endif; ?>
                    <?php
                    // Close the database connection
                    //$conn->close();
                    ?>
                    <a class="btn btn-primary py-3 px-5" href="">Browse More Jobs</a>
                </div>
                <div id="tab-3" class="tab-pane fade show p-0">
                    <?php
                    //include_once('../../assets/setup/db.php');
                    // Fetch job data from the database
                    $sql = "SELECT * FROM jobs WHERE job_nature = 'Part Time' ORDER BY job_id DESC";
                    $result = $conn->query($sql);
                    ?>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="job-item p-4 mb-4">
                                <div class="row g-4">
                                    <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                        <!-- <img class="flex-shrink-0 img-fluid border rounded" src="img/com-logo-1.jpg" alt="" -->
                                            <!-- style="width: 80px; height: 80px;"> -->
                                        <div class="text-start ps-4">
                                            <h5 class="mb-3">
                                                <?= $row['job_name'] ?>
                                            </h5>
                                            <span class="text-truncate me-3"><i
                                                    class="fa fa-map-marker-alt text-primary me-2"></i>
                                                <?= $row['job_location'] ?>
                                            </span>
                                            <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i>
                                                <?= $row['job_nature'] ?>
                                            </span>
                                            <span class="text-truncate me-0"><i
                                                    class="far fa-money-bill-alt text-primary me-2"></i>
                                                <?= $row['salary_range'] ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div
                                        class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                        <div class="d-flex mb-3">
                                            <a class="btn btn-light btn-square me-3" href=""><i
                                                    class="far fa-heart text-primary"></i></a>
                                                    <a class="btn btn-primary" href="../job_details/?id=<?= $row['job_id'] ?>">Apply Now</a>
                                        </div>
                                        <small class="text-truncate"><i
                                                class="far fa-calendar-alt text-primary me-2"></i>Deadline:
                                            <?= $row['deadline'] ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No jobs found.</p>
                    <?php endif; ?>
                    <?php
                    // Close the database connection
                    //$conn->close();
                    ?>
                    <a class="btn btn-primary py-3 px-5" href="">Browse More Jobs</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once('../jobs-templates/job-footer.php'); ?>