<?php
// Database connection details
$servername = "localhost";   // This is the default address for your local server.
$username = "root";          // Default username for XAMPP MySQL.
$password = "";              // Default password is empty for XAMPP MySQL.
$dbname = "final_project";   // The name of the database you just created.

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
