<!-- Header start -->
<?php
session_start();
include_once('../../assets/setup/db.php');
$user_id = $_SESSION['SESSION_EMAIL'];

if (!isset($user_id)) {
    header('location:../../login');
    exit();
}
 include_once('../jobs-templates/job-header.php'); 
 ?>
<!-- Header end -->

<!-- navbar start -->
<?php include_once('../jobs-templates/job-navbar.php'); ?>
<!--  navbar end-->



<!-- job_detail.php -->
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// Load Composer's autoloader
require '../../vendor/autoload.php';

// Check if a job ID parameter is provided in the URL
if (isset($_GET['id'])) {
    $job_id = $_GET['id'];
  

    // Fetch job data from the database based on the job ID
    $sql = "SELECT * FROM jobs WHERE job_id = '$job_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Decode the JSON data for responsibility and qualification
        $responsibility = json_decode($row['job_responsibility'], true);
        $qualifications = json_decode($row['job_qualifications'], true);

        // Set the job name from the fetched row
            $jobName = $row['job_name'];   

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          
            // Get form data
            $name = $_POST['full_name'];
            $email = $_POST['email'];
            $cvFile = $_FILES['cv']['tmp_name'];
            $cvFileName = $_FILES['cv']['name'];
            $coverLetter = $_POST['cover_letter'];
            $jobId = $_POST['job_id'];
            $jobName = $_POST['job_name'];

           // Get the applicant's full name from the form
            $applicantFullName = $_POST['full_name'];

            // Query to retrieve job poster's email
            $query = "SELECT job_poster_email FROM jobs WHERE job_id = $jobId";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $jobPosterEmail = $row['job_poster_email'];

                // Create a new PHPMailer instance
                $mail = new PHPMailer;

                // Set up SMTP settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;  // Enable verbose debug output
                $mail->Debugoutput = function ($str, $level) {
                    // Print the debug message to the browser's console
                    error_log("$level: $str");
                };
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'godfreymatagaro@gmail.com'; // SMTP username
                $mail->Password = 'mdnpxflcotixeabh'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                 // Recipients// email content
                 $mail->setFrom('godfreymatagaro@gmail.com', 'Mailer');
                $mail->addAddress($jobPosterEmail);  // Job poster's email
                $mail->addAttachment($cvFile, $cvFileName);  // Attach CV
                $mail->Subject = "Job Application for Job Position: $jobName";
                $mail->Body = "Name: $name\nEmail: $email\nCover Letter:\n$coverLetter";

                // Send the email
                if ($mail->send()) {
                       // Output JavaScript code to show overlay with message and redirect after a delay
    echo '<div id="overlay">';
    echo '  <div class="overlay-content">';
    echo '    <p class="success-message">Application sent successfully!</p>';
    echo '    <div class="spinner"></div>';
    echo '  </div>';
    echo '</div>';
                               
            }     
                } else {
                    echo '<div id="overlay">';
                    echo '  <div class="overlay-content">';
                    echo '    <p class="error-message">An Error Occured! Check your Internet.</p>';
                    echo '    <div class="spinner"></div>';
                    echo '  </div>';
                    echo '</div>';
                   
                }
                    // Output JavaScript code to refresh the page or display a message
                    echo '<script>';
                    echo 'setTimeout(function() {';
                        echo '  window.location.href = "../job-list/";'; // Redirect to another page
                    echo '}, 3000);'; // Refresh after 3 seconds
                    echo '</script>';
        }
    }
}
?>
<style>
    #overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #16a085;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.overlay-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
}

.success-message {
    color: green;
    font-weight: bold;
    font-size: 18px;
}
.error-message {
    color: red;
    font-weight: bold;
    font-size: 18px;
}

.spinner {
    border: 4px solid rgba(0, 0, 0, 0.1);
    border-left: 4px solid #3498db;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    animation: spin 2s linear infinite;
    margin-top: 20px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

</style>

        <!-- Job Detail Content -->
        <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container">
            <div class="row gy-5 gx-4">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center mb-5">
                            <!-- <img class="flex-shrink-0 img-fluid border rounded" src="img/com-logo-2.jpg" alt="" style="width: 80px; height: 80px;"> -->
                            <div class="text-start ps-4">
                                <h3 class="mb-3"><?php echo $row['job_name'] ?></h3>
                                <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i><?= $row['job_location'] ?></span>
                                <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i><?= $row['job_nature'] ?></span>
                                <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i><?= $row['salary_range'] ?></span>
                            </div>
                        </div>
                <div class="mb-5">
                <h4 class="mb-3">Job Description</h4>
                            <p><?= $row['job_description'] ?></p>
                    <!-- Display Responsibility List -->
                    <h4 class="mb-3">Responsibility</h4>
                    <ul class="list-unstyled">
                        <?php foreach ($responsibility as $item): ?>
                            <li><i class="fa fa-angle-right text-primary me-2"></i><?= $item ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="">
                    <!-- Display Qualifications List -->
                    <h4 class="mb-4">Qualifications</h4>
                    <ul class="list-unstyled">
                        <?php foreach ($qualifications as $item): ?>
                            <li><i class="fa fa-angle-right text-primary me-2"></i><?= $item ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
           
                <div class="">
    <h4 class="mb-4">Apply For The Job</h4>
    <form method="post" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-md-6">
                <input type="text" class="form-control" name="full_name" placeholder="Full Name" required>
            </div>
            <div class="col-md-6">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <!-- <div class="col-md-6">
                <input type="tel" class="form-control" name="phone" placeholder="Phone Number" required>
            </div> -->
            <!-- <div class="col-md-6">
                <input type="text" class="form-control" name="id_number" placeholder="National ID/Passport Number" required>
            </div> -->
            <!-- <div class="col-md-6">
                <input type="text" class="form-control" name="education" placeholder="Highest Education Level" required>
            </div> -->
            <!-- <div class="col-md-6">
                <input type="text" class="form-control" name="institution" placeholder="Institution" required>
            </div> -->
            <!-- <div class="col-md-6">
                <input type="text" class="form-control" name="year_completed" placeholder="Year Completed" required>
            </div> -->
            <!-- <div class="col-md-12">
                <textarea class="form-control" name="work_experience" rows="5" placeholder="Work Experience" required></textarea>
            </div> -->
            <!-- <div class="col-md-6">
                <input type="text" class="form-control" name="skills" placeholder="Skills" required>
            </div> -->
            <!-- <div class="col-md-6">
                <input type="text" class="form-control" name="languages" placeholder="Languages" required>
            </div> -->
            <!-- <div class="col-md-12">
                <input type="text" class="form-control" name="references" placeholder="References" required>
            </div> -->
            <div class="col-md-12">
                <textarea class="form-control" name="cover_letter" rows="5" placeholder="Cover Letter" required></textarea>
            </div>
            
            <div class="col-md-12">
            <input type="hidden" name="job_id" value="<?= $job_id ?>">
            </div>
            <div class="col-md-12">
            <input type="hidden" name="job_name" value="<?= $jobName ?>">
            </div>
           
            <div class="col-md-12">
              <label>Upload your CV (PDF Format)</label>
                <input type="file" class="form-control" name="cv" accept=".pdf" required>
            </div>
            <div class="col-md-12">
                <button class="btn btn-primary w-100" type="submit" name="submit">Apply Now</button>
            </div>
        </div>
    </form>
</div>
<?php
 
            ?>
 </div>
            <div class="col-lg-4">
                        <div class="bg-light rounded p-5 mb-4 wow slideInUp" data-wow-delay="0.1s">
                            <h4 class="mb-4">Job Summary</h4>
                            <p><i class="fa fa-angle-right text-primary me-2"></i>Published On: <?php echo $row['posted_date'] ?></p>
                            <p><i class="fa fa-angle-right text-primary me-2"></i>Vacancy: <?php echo $row['vacancy_number'] ?></p>
                            <p><i class="fa fa-angle-right text-primary me-2"></i>Job Nature: <?php echo $row['job_nature'] ?></p>
                            <p><i class="fa fa-angle-right text-primary me-2"></i>Salary: <?php echo $row['salary_range'] ?></p>
                            <p><i class="fa fa-angle-right text-primary me-2"></i>Location: <?php echo $row['job_location'] ?></p>
                            <p class="m-0"><i class="fa fa-angle-right text-primary me-2"></i>Deadline: <?php echo $row['deadline'] ?></p>
                        </div>
                        <div class="bg-light rounded p-5 mb-4 wow slideInUp" data-wow-delay="0.1s">
    <h4 class="mb-4">Job Poster</h4>
    <img src="../../images/driver.jpg" alt="Job Poster Image" class="img-fluid">
</div>

                        <div class="bg-light rounded p-5 wow slideInUp" data-wow-delay="0.1s">
                            <h4 class="mb-4">Company Detail</h4>
                            <p class="m-0">Company Name: <?php echo $row['company_name'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Job Detail End -->



 <!-- Footer Start -->
 <?php include_once('../jobs-templates/job-footer.php'); ?>
        <!-- Footer End -->