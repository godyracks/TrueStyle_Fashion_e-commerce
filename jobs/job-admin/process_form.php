<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Establish a database connection (replace with your credentials)
include_once '../../assets/setup/db.php';

// Function to sanitize input data
function sanitizeInput($data){
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}

// Handle different actions based on the request method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        // Sanitize and retrieve form data
        $job_name = sanitizeInput($_POST['job_name']);
        $job_detail = sanitizeInput($_POST['job_detail']);
        $job_category = sanitizeInput($_POST['job_category']);
        $job_location = sanitizeInput($_POST['job_location']);
        $job_description = sanitizeInput($_POST['job_description']);
        $job_responsibility_list = sanitizeInput($_POST['job_responsibility']);
        $job_qualifications_list = sanitizeInput($_POST['job_qualifications']);
        // Convert semicolon-separated lists to arrays
        $job_responsibility = explode(';', $job_responsibility_list);
        $job_qualifications = explode(';', $job_qualifications_list);
        // Convert arrays to JSON strings
        $job_responsibility_json = json_encode($job_responsibility);
        $job_qualifications_json = json_encode($job_qualifications);

        $vacancy_number = sanitizeInput($_POST['vacancy_number']);
        $job_time = sanitizeInput($_POST['job_time']);
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        $deadline = sanitizeInput($_POST['deadline']);
        $min_salary = sanitizeInput($_POST['min_salary']);
        $max_salary = sanitizeInput($_POST['max_salary']);
        $company_name = sanitizeInput($_POST['company_name']);
        $posted_date = sanitizeInput($_POST['posted_date']);

        // Prepare and execute SQL query
        $sql = "INSERT INTO jobs (job_name, job_detail, job_category, job_location, job_description, job_responsibility, job_qualifications, vacancy_number, job_time, is_featured, deadline, min_salary, max_salary, company_name, posted_date)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssissiissdss", $job_name, $job_detail, $job_category, $job_location, $job_description, $job_responsibility_json, $job_qualifications_json, $vacancy_number, $job_time, $is_featured, $deadline, $min_salary, $max_salary, $company_name, $posted_date);

        if ($stmt->execute()) {
            echo "Job record inserted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'edit') {
        // Sanitize and retrieve form data
        $job_id = sanitizeInput($_POST['job_id']);
        $updated_job_name = sanitizeInput($_POST['job_name']);
        $updated_job_detail = sanitizeInput($_POST['job_detail']);
        // ... (sanitize and retrieve other form data)

        // Process and update database (similar to previous logic)
        // ...
    }
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET['action'])) {
        $action = $_GET['action'];

        if ($action === 'retrieve') {
            if (isset($_GET['job_id'])) {
                $job_id = $_GET['job_id'];
                // Retrieve job data based on job_id
                $retrieve_sql = "SELECT * FROM jobs WHERE job_id = ?";
                $retrieve_stmt = $conn->prepare($retrieve_sql);
                $retrieve_stmt->bind_param("i", $job_id);

                $retrieve_stmt->execute();
                $result = $retrieve_stmt->get_result();
                $job_data = $result->fetch_assoc();
                // Convert JSON-encoded strings back to arrays
                $job_responsibility = explode(';', $job_data['job_responsibility']);
                $job_qualifications = explode(';', $job_data['job_qualifications']);
                // ...
            }
        } elseif ($action === 'delete') {
            // ...
        }
    }
}



$conn->close();
?>
