<?php
session_start();
include "db_conn.php";

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $status = mysqli_real_escape_string($conn, $_POST["status"]);

    // Validate input
    if (empty($username) || empty($status)) {
        http_response_code(400);
        echo "Invalid input";
        exit();
    }

    // Update query
    $sql = "UPDATE registered_user SET Status = ? WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $status, $username);

    if ($stmt->execute()) {
        echo "Status updated successfully";
    } else {
        http_response_code(500);
        echo "Error updating status: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo "Invalid request method";
}
?>
