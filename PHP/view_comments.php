<?php
// Start the session
session_start();
// Check if the user is logged in
if (!isset($_SESSION["Username"]) || $_SESSION["Role"] !== "HealthInsuranceManager") {
    header("Location: login.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Complaints | Tepi Health Insurance</title>
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- For Font Awesome Icons -->
    <style>
        /* Body and Background Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('images/bg14.jpg'); /* Ensure this path is correct */
            background-size: cover;
            background-position: center;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative; /* Added to position the icon */
        }

        /* Back to Home Icon */
        .back-to-home {
            position: absolute;
            top: 20px;
            right: 20px;
            text-decoration: none;
            color: #fff;
            background: #007bff; /* Blue background */
            border-radius: 8px; /* Rounded corners */
            padding: 10px 15px; /* Padding around the text and icon */
            display: flex;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background 0.3s, transform 0.3s;
        }

        .back-to-home:hover {
            background: #0056b3; /* Darker blue on hover */
            transform: scale(1.1); /* Slightly enlarge on hover */
        }

        .back-to-home i {
            margin-right: 8px; /* Space between icon and text */
            font-size: 18px;
        }

        .back-to-home span {
            font-size: 14px;
            font-weight: 500; /* Slightly bold text */
        }

        /* Container Styling */
        .container {
            background: rgba(255, 255, 255, 0.9); /* Slightly transparent background */
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            padding: 30px;
            max-width: 600px;
            width: 100%;
        }

        /* Headings */
        h2 {
            text-align: center;
            color: #444;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Comments Section */
        .comments-section {
            margin-top: 20px;
        }

        .comment {
            background-color: #f1f1f1;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .comment h4 {
            margin: 0 0 10px;
            color: #333;
            font-size: 18px;
        }

        .comment p {
            color: #555;
            margin-bottom: 8px;
        }

        .comment small {
            color: #999;
        }

        /* Status Messages */
        .status-message {
            text-align: center;
            font-size: 16px;
            padding: 10px;
            border-radius: 6px;
        }

        .status-message.error {
            color: #d9534f; /* Red for errors */
            background-color: #f2dede;
        }

        .status-message.success {
            color: #5bc0de; /* Green for success */
            background-color: #dff0d8;
        }
    </style>
</head>
<body>

<a href="healthInsuranceManager.php" class="back-to-home"><i class="fas fa-home"></i><span>Back to Home</span></a> <!-- Redirect to PHP file -->

<div class="container">
    <h2>User Complaints</h2>

    <?php
    // Enable error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Database connection
    $servername = "localhost";
    $username = "root"; // your database username
    $password = ""; // your database password
    $dbname = "final_project"; // your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("<p class='status-message error'>Connection failed: " . $conn->connect_error . "</p>");
    }

    // Fetch comments
    $sql = "SELECT customer_name, comment, date_posted FROM comments ORDER BY date_posted DESC";
    $result = $conn->query($sql);

    // Debugging: Check if there are multiple results
    if ($result === FALSE) {
        echo "<p class='status-message error'>SQL Error: " . $conn->error . "</p>";
    } elseif ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='comment'>";
            echo "<h4>" . htmlspecialchars($row["customer_name"]) . "</h4>";
            echo "<p>" . htmlspecialchars($row["comment"]) . "</p>";
            echo "<small>Posted on " . htmlspecialchars($row["date_posted"]) . "</small>";
            echo "</div>";
        }
    } else {
        echo "<p>No comments found.</p>";
    }

    // Close connection
    $conn->close();
    ?>
</div>

</body>
</html>
