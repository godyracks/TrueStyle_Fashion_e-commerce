<?php
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

?>

<style>
    /* Base styles for larger screens */


.admin-dashboard {
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
    margin-top: 20px;
    font-size: 24px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ccc;
}

th, td {
    padding: 10px;
    text-align: left;
}

th {
    background-color: #007bff;
    color: #fff;
}

.approve {
    text-decoration: none;
    color: #007bff;
}

/* Media query for screens less than 768px */
@media (max-width: 768px) {
    .admin-dashboard {
        padding: 10px;
    }

    h2 {
        font-size: 20px;
    }

    table {
        font-size: 14px;
    }

    th, td {
        padding: 8px;
    }
}

</style>
<br />
<br />
<br />
<br />
<br />

<!-- Admin Dashboard Content -->
<div class="admin-dashboard">
    <h1>Welcome, Admin!</h1>

    <!-- Job Listing Section -->
    <h2>Job Listings</h2>
    
    <!-- Display a table of jobs from guest_jobs table -->
    <table>
        <thead>
            <tr>
                <th>Job Name</th>
                <th>Job Category</th>
                <th>Job Location</th>
                <th>Posted Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch job listings from the guest_jobs table
            $sql = "SELECT * FROM guest_jobs";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['job_name'] . "</td>";
                    echo "<td>" . $row['job_category'] . "</td>";
                    echo "<td>" . $row['job_location'] . "</td>";
                    echo "<td>" . $row['posted_date'] . "</td>";
                    echo "<td><a class='approve' href='approve_job.php?job_id=" . $row['job_id'] . "'>Approve</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No jobs found in guest_jobs table.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
// Include the footer or any necessary scripts
 include_once('../assets/cart-temp/cart-footer.php'); 
?>
