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

// Handle form submission
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    
    // Assuming you are using session to store logged-in username
    session_start();
    $username = $_SESSION['Username']; // Adjust this as necessary

    // Validate passwords
    if ($newPassword !== $confirmPassword) {
        $message = "New passwords do not match.";
    } else {
        // Check if current password is correct
        $stmt = $conn->prepare("SELECT Password FROM registered_user WHERE Username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows === 0) {
            $message = "User not found.";
        } else {
            $stmt->bind_result($hashedPassword);
            $stmt->fetch();
            $stmt->close();

            if (!password_verify($currentPassword, $hashedPassword)) {
                $message = "Current password is incorrect.";
            } else {
                // Hash new password and update in database
                $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

                $stmt = $conn->prepare("UPDATE registered_user SET Password = ? WHERE Username = ?");
                $stmt->bind_param("ss", $newHashedPassword, $username);
                
                if ($stmt->execute()) {
                    $message = "Password changed successfully.";
                    $stmt->close();
                    $conn->close();
                    // Redirect to login page after successful password change
                    header("Location: login.php");
                    exit(); // Ensure no further code is executed after redirection
                } else {
                    $message = "Failed to change password: " . $stmt->error;
                }
            }
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
    <title>Change Password | Gondar Health Insurance</title>
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            height: 100vh;
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

        /* Form Elements */
        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        /* Status Messages */
        .status-message {
            text-align: center;
            font-size: 16px;
            padding: 10px;
            border-radius: 6px;
            margin-top: 20px;
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

<a href="profilepage.php" class="back-to-home"><i class="fas fa-home"></i><span>Back to Home</span></a>

<div class="container">
    <h2>Change Password</h2>

    <form action="" method="post">
        <label for="current_password">Current Password</label>
        <input type="password" id="current_password" name="current_password" required>

        <label for="new_password">New Password</label>
        <input type="password" id="new_password" name="new_password" required>

        <label for="confirm_password">Confirm New Password</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit" class="btn">Change Password</button>
    </form>
    
    <?php if ($message): ?>
        <p class="status-message <?= strpos($message, 'success') !== false ? 'success' : 'error'; ?>"><?= htmlspecialchars($message); ?></p>
    <?php endif; ?>
</div>

</body>
</html>
