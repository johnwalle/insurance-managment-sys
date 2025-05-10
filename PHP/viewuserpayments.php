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
    die("<p class='status-message error'>Connection failed: " . $conn->connect_error . "</p>");
}

// Fetch users with UserType = 'User'
$users = [];
$sql = "SELECT UserId, username, paid_status 
        FROM users 
        WHERE UserType = 'User'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    $errorMessage = "No users found.";
}

// Handle status update
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];
    
    if ($action === 'mark_paid') {
        $updateSql = "UPDATE users SET paid_status = 'paid' WHERE UserId = ?";
    } elseif ($action === 'mark_unpaid') {
        $updateSql = "UPDATE users SET paid_status = 'unpaid' WHERE UserId = ?";
    }
    
    if (isset($updateSql)) {
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $errorMessage = "Failed to update status.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Management | Tepi Health Insurance</title>
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- For Font Awesome Icons -->
    <style>
        /* Body and Background Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('../Images/bg14.jpg'); /* Ensure this path is correct */
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
            max-width: 900px;
            width: 100%;
        }

        /* Headings */
        h2 {
            text-align: center;
            color: #444;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Table Styling */
        .user-list {
            width: 100%;
            border-collapse: collapse;
        }

        .user-list th, .user-list td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .user-list th {
            background-color: #007bff;
            color: white;
            text-transform: uppercase;
            font-size: 14px;
        }

        .user-list td {
            background-color: #f9f9f9;
            font-size: 14px;
        }

        .user-list td a {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 12px;
            transition: background-color 0.3s;
        }

        .user-list td a:hover {
            background-color: #0056b3;
        }

        /* Status Messages */
        .status-message {
            text-align: center;
            font-size: 16px;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
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

<a href="hospitalOfficier.php" class="back-to-home"><i class="fas fa-home"></i><span>Back to Home</span></a> <!-- Redirect to PHP file -->

<div class="container">
    <h2>Payment Management</h2>

    <?php if (isset($errorMessage)): ?>
        <p class='status-message error'><?= htmlspecialchars($errorMessage); ?></p>
    <?php else: ?>
        <table class="user-list">
            <thead>
                <tr>
                    <th><i class="fas fa-user"></i> Username</th>
                    <th><i class="fas fa-credit-card"></i> Payment Status</th>
                    <th><i class="fas fa-edit"></i> Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['username']); ?></td>   
                    <td>
                        <?php 
                        if($user['paid_status'] == ""){
                            echo 'Not set';
                        }
                        else{
                            echo $user['paid_status'];
                        }
                         ?></td>
                    <td>
                        <?php if ($user['paid_status'] === 'paid'): ?>
                            <a href="?action=mark_unpaid&id=<?= htmlspecialchars($user['UserId']); ?>" class="update-btn">Mark as Unpaid</a>
                        <?php else: ?>
                            <a href="?action=mark_paid&id=<?= htmlspecialchars($user['UserId']); ?>" class="update-btn">Mark as Paid</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
