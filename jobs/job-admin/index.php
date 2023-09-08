<?php
include_once('../../assets/setup/db.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $jobName = $_POST['job_name'];
    $jobCategory = $_POST['job_category'];
    $jobLocation = $_POST['job_location'];
    $jobDescription = $_POST['job_description'];

    // Get job responsibility key-value pairs
    $responsibilityKeys = $_POST['responsibility_key'];
    $responsibilityValues = $_POST['responsibility_value'];
    $jobResponsibility = array();
    for ($i = 0; $i < count($responsibilityKeys); $i++) {
        $key = $responsibilityKeys[$i];
        $value = $responsibilityValues[$i];
        $jobResponsibility[$key] = $value;
    }
    $jobResponsibilityJSON = json_encode($jobResponsibility);

    // Get job qualifications key-value pairs
    $qualificationKeys = $_POST['qualification_key'];
    $qualificationValues = $_POST['qualification_value'];
    $jobQualifications = array();
    for ($i = 0; $i < count($qualificationKeys); $i++) {
        $key = $qualificationKeys[$i];
        $value = $qualificationValues[$i];
        $jobQualifications[$key] = $value;
    }
    $jobQualificationsJSON = json_encode($jobQualifications);

    $vacancyNumber = $_POST['vacancy_number'];
    $jobNature = $_POST['job_nature'];
    $deadline = $_POST['deadline'];
    $salaryRange = $_POST['salary_range'];
    $companyName = $_POST['company_name'];
    $postedDate = $_POST['posted_date'];

    // Prepare and execute the SQL query
    $sql = "INSERT INTO jobs (job_name, job_category, job_location, job_description, job_responsibility, job_qualifications, vacancy_number, job_nature, deadline, salary_range, company_name, posted_date) VALUES ('$jobName', '$jobCategory', '$jobLocation', '$jobDescription', '$jobResponsibilityJSON', '$jobQualificationsJSON', '$vacancyNumber', '$jobNature', '$deadline', '$salaryRange', '$companyName', '$postedDate')";

    if ($conn->query($sql) === TRUE) {
        echo "New job created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn;
    }

    // Close the database connection
    $conn->close();
}


?>

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
    
    <label for="job_time">Job Nature:</label>
    <input type="text" id="job_nature" name="job_nature"><br>
    
    <label for="deadline">Deadline:</label>
    <input type="date" id="deadline" name="deadline"><br>
    
    <label for="salary_range">Salary Range:</label>
    <input type="text" id="salary_range" name="salary_range"><br>
    
    <label for="company_name">Company Name:</label>
    <input type="text" id="company_name" name="company_name" required><br>
    
    <label for="posted_date">Posted Date:</label>
    <input type="date" id="posted_date" name="posted_date" required><br>
    
    <input type="submit" value="Create Job">
</form>
