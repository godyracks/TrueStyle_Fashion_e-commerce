<?php
//ob_start();
session_start();

$host = 'localhost';
$username = 'root';
$password = '@godygaro66';
$database = 'truestyle';

// Create a connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check the connection
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

//echo 'Connected successfully';

// ... Rest of your code ...

// Close the connection
//mysqli_close($conn);

?>
