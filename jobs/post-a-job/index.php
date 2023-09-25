<?php
include_once('../jobs-templates/job-header.php');

// Include necessary files for database connection
include_once('../../assets/setup/db.php');

// Custom function to escape values
function escapeValue($conn, $value) {
    return mysqli_real_escape_string($conn, $value);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $jobName = escapeValue($conn, $_POST['job_name']);
    $jobCategory = escapeValue($conn, $_POST['job_category']);
    $jobLocation = escapeValue($conn, $_POST['job_location']);
    $jobDescription = escapeValue($conn, $_POST['job_description']);

    // Get and sanitize job responsibility key-value pairs
    $responsibilityKeys = array_map('trim', $_POST['responsibility_key']);
    $responsibilityValues = array_map('trim', $_POST['responsibility_value']);
    $jobResponsibility = array_combine($responsibilityKeys, $responsibilityValues);
    $jobResponsibilityJSON = json_encode($jobResponsibility);

    // Get and sanitize job qualifications key-value pairs
    $qualificationKeys = array_map('trim', $_POST['qualification_key']);
    $qualificationValues = array_map('trim', $_POST['qualification_value']);
    $jobQualifications = array_combine($qualificationKeys, $qualificationValues);
    $jobQualificationsJSON = json_encode($jobQualifications);

    $vacancyNumber = intval($_POST['vacancy_number']);
    $jobNature = escapeValue($conn, $_POST['job_nature']);
    $deadline = $_POST['deadline']; // Assuming date format is valid
    $salaryRange = escapeValue($conn, $_POST['salary_range']);
    $companyName = escapeValue($conn, $_POST['company_name']);
    $postedDate = $_POST['posted_date']; // Assuming date format is valid
    $jobPosterEmail = escapeValue($conn, $_POST['job_poster_email']);

    // Prepare and execute the SQL query using prepared statements
    $sql = "INSERT INTO guest_jobs (job_name, job_category, job_location, job_description, job_responsibility, job_qualifications, vacancy_number, job_nature, deadline, salary_range, company_name, posted_date, job_poster_email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssssssiisssss", $jobName, $jobCategory, $jobLocation, $jobDescription, $jobResponsibilityJSON, $jobQualificationsJSON, $vacancyNumber, $jobNature, $deadline, $salaryRange, $companyName, $postedDate, $jobPosterEmail);
        if ($stmt->execute()) {
            echo "New job created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}
?>

<style>
    /* Base styles for larger screens */
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
}

h1 {
    text-align: center;
}

form {
    max-width: 600px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
}

label {
    display: block;
    font-weight: bold;
}

input[type="text"],
input[type="number"],
textarea,
select,
input[type="date"],
input[type="email"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

select {
    font-size: 16px;
}

input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 10px 20px;
    cursor: pointer;
    font-size: 18px;
}

/* Media query for screens less than 768px */
@media (max-width: 768px) {
    form {
        padding: 10px;
    }

    input[type="text"],
    input[type="number"],
    textarea,
    select,
    input[type="date"],
    input[type="email"] {
        font-size: 14px;
    }

    input[type="submit"] {
        font-size: 16px;
    }
}

</style>



<h1>Create a New Job</h1>
<form action="" method="post">
    <label for="job_name">Job Name:</label>
    <input type="text" id="job_name" name="job_name" required><br>
    
    <label for="job_category">Job Category:</label>
    <input type="text" id="job_category" name="job_category"><br>
    
    <label for="job_location">Job Location:</label>
    <input type="text" id="job_location" name="job_location"><br>
    
    <label for="job_description">Job Description:</label>
    <textarea id="job_description" name="job_description"></textarea><br>
    
    <label for="job_responsibility">Job Responsibility:</label><br>
    <input type="text" name="responsibility_key[]" placeholder="Key 1">
    <input type="text" name="responsibility_value[]" placeholder="Value 1"><br>
    
    <input type="text" name="responsibility_key[]" placeholder="Key 2">
    <input type="text" name="responsibility_value[]" placeholder="Value 2"><br>
    
    <input type="text" name="responsibility_key[]" placeholder="Key 3">
    <input type="text" name="responsibility_value[]" placeholder="Value 3"><br>
    
    <label for="job_qualifications">Job Qualifications:</label><br>
    <input type="text" name="qualification_key[]" placeholder="Key 1">
    <input type="text" name="qualification_value[]" placeholder="Value 1"><br>
    
    <input type="text" name="qualification_key[]" placeholder="Key 2">
    <input type="text" name="qualification_value[]" placeholder="Value 2"><br>
    
    <input type="text" name="qualification_key[]" placeholder="Key 3">
    <input type="text" name="qualification_value[]" placeholder="Value 3"><br>
    
    <label for="vacancy_number">Vacancy Number:</label>
    <input type="number" id="vacancy_number" name="vacancy_number"><br>
    
     <label for="job_nature">Job Nature:</label>
    <select id="job_nature" name="job_nature" required>
        <option value="Full Time">Full Time</option>
        <option value="Part Time">Part Time</option>
        <option value="Featured">Featured</option>
    </select><br>
    
    <label for="deadline">Deadline:</label>
    <input type="date" id="deadline" name="deadline"><br>
    
    <label for="salary_range">Salary Range:</label>
    <input type="text" id="salary_range" name="salary_range"><br>
    
    <label for="company_name">Company Name:</label>
    <input type="text" id="company_name" name="company_name" required><br>
    
    <label for="posted_date">Posted Date:</label>
    <input type="date" id="posted_date" name="posted_date" required><br>
    
      <label for="job_poster_email">Job Poster Email:</label>
    <input type="email" id="job_poster_email" name="job_poster_email" required><br>
    
    <input type="submit" value="Create Job">
</form>



        <!-- Footer Start -->
     <?php
     include_once('../jobs-templates/job-footer.php'); 
     ?>
        
  <!-- Footer End -->  