<?php
ob_start(); // Start output buffering
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

// Check if the job_id parameter is set in the URL
if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];

    // Fetch job details from the guest_jobs table
    $sql_select_job = "SELECT * FROM guest_jobs WHERE job_id = $job_id";
    $result = $conn->query($sql_select_job);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check if the "Approve Job" button is clicked
        if (isset($_POST['approve_job'])) {
            // Perform the job approval process, for example, transferring the job to the jobs table
            // You can write the SQL query and execute it here to move the job details to the jobs table

            // Example SQL query to insert the job into the jobs table
            $sql_approve_job = "INSERT INTO jobs (job_name, job_category, job_location, job_description, job_responsibility, job_qualifications, vacancy_number, job_nature, deadline, salary_range, company_name, posted_date, job_poster_email) 
                                VALUES (
                                    '" . $row['job_name'] . "',
                                    '" . $row['job_category'] . "',
                                    '" . $row['job_location'] . "',
                                    '" . $row['job_description'] . "',
                                    '" . $row['job_responsibility'] . "',
                                    '" . $row['job_qualifications'] . "',
                                    '" . $row['vacancy_number'] . "',
                                    '" . $row['job_nature'] . "',
                                    '" . $row['deadline'] . "',
                                    '" . $row['salary_range'] . "',
                                    '" . $row['company_name'] . "',
                                    '" . $row['posted_date'] . "',
                                    '" . $row['job_poster_email'] . "'
                                )";

            if ($conn->query($sql_approve_job) === TRUE) {
                // Job approved and transferred successfully

                // Delete the job entry from the guest_jobs table
                $sql_delete_job = "DELETE FROM guest_jobs WHERE job_id = $job_id";
                if ($conn->query($sql_delete_job) === TRUE) {
                    echo "Job approved successfully!"; //and the entry was deleted from guest_jobs.
                } else {
                    echo "Error deleting job entry from guest_jobs: " . $conn->error;
                }
            } else {
                echo "Error approving job: " . $conn->error;
            }
        }
    } else {
        // Job not found in guest_jobs table, show an error message
        echo "Job not found in guest_jobs table.";
    }
} else {
    // If job_id is not provided in the URL, show an error message or redirect to the admin dashboard
    header("Location: ../jobs_admin/");
    exit();
}

// Place the 'echo' statement here or anywhere after header redirection
ob_end_flush(); // Flush the output buffer
?>
<style>
    /* Base styles for larger screens */


.job-approval {
    max-width: 1000px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
}

h1 {
    text-align: center;
}

h2 {
    font-size: 24px;
    margin-top: 20px;
}

.job-details {
    margin-top: 20px;
    border: 1px solid #ccc;
    padding: 20px;
    border-radius: 8px;
}

.job-details h1 {
    font-size: 20px;
}

.job-details p {
    margin: 10px 0;
}

form {
    text-align: center;
}

form input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
}

/* Media query for screens less than 768px */
@media (max-width: 768px) {
    .job-approval {
        padding: 10px;
    }

    h2 {
        font-size: 20px;
    }

    .job-details {
        padding: 10px;
    }

    .job-details h1 {
        font-size: 18px;
    }

    .job-details p {
        font-size: 14px;
        margin: 8px 0;
    }
}

</style>
<br />
<br />
<br />
<br />
<br />
<!-- Display job details and provide an "Approve" button -->
<div class="job-details">
    <h1>Job Details</h1>
    <p>Job Name: <?php echo $row['job_name']; ?></p>
    <p>Job Category: <?php echo $row['job_category']; ?></p>
    <!-- Display other job details here -->

    <!-- Approve Job Button -->
    <form action="" method="post">
        <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">
        <input type="submit" name="approve_job" value="Approve Job">
    </form>
</div>
