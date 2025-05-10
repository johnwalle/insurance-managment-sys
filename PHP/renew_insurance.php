<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final_project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user_id parameter is passed in the URL
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Calculate the new insurance expiry date (e.g., extend by 1 year)
    $new_expiry_date = date('Y-m-d H:i:s', strtotime('+1 year'));

    // Update the user's insurance expiry date in the database
    $sql = "UPDATE users SET insurance_expiry = '$new_expiry_date' WHERE UserId = $user_id";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Insurance successfully renewed! New expiry date: $new_expiry_date</p>";
        echo "<a href='insurancerenew.php'>Go back to the user list</a>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Invalid request. No user ID provided.";
}

$conn->close();
?>
