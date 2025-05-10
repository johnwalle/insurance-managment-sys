<?php
// Start session to access logged-in user's information
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final_project";


// Redirect to login if the user is not logged in or not an user
if (!isset($_SESSION["Username"]) || $_SESSION["Role"] !== "User") {
    header("Location: login.php");
    exit();
}


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$error = '';
$success = '';

// Check if the form is submitted
if (isset($_POST['send']) && isset($_POST['username'], $_POST['message'])) {
    $username = trim($_POST['username']);
    $message = trim($_POST['message']);

    // $target_dir = "C:/xampp/htdocs/insurance-managment-sys/recieptimage/"; // Directory to store images
    // $image=$_FILES["image"]["name"];
    // $target_file = $target_dir.$_FILES["image"]["name"];
    // $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // $allowed_types = ["jpg", "jpeg", "png", "gif"];

    // // Check if the file is an image
    // $check =getimagesize($_FILES["image"]["tmp_name"]);
    // if ($check === false) {
    //     echo "File is not an image.";
    //     exit;
    // }

    // // Validate file type
    // if (!in_array($imageFileType, $allowed_types)) {
    //     echo "Only JPG, JPEG, PNG & GIF files are allowed.";
    //     exit;
    // }
    //    $users= $_SESSION["Username"];
    //    if(!empty($image) ){
    //     move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    //    }
    
    // Validate input
    if (empty($username) || empty($message)) {
        $error = "Username and message are required.";
    } else {
        // Prepare and execute the insert query
        $sql = "INSERT INTO messages (username, message,sent_at) VALUES (?,?,NOW())";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param('ss', $username, $message);
        if ($stmt->execute()) {
            $success = "Message sent successfully!";
            echo '<script>window.onload = function() { setTimeout(function() { document.getElementById("username").value = ""; document.getElementById("message").value = ""; }, 1000); }; </script>';
        } else {
            $error = "Failed to send message: " . $conn->error;
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Payment Request</title>
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
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
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

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        label {
            font-size: 16px;
            color: #444;
            margin-bottom: 5px;
        }

        input[type="text"], textarea {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
        }

        button {
            background-color: #007bff; /* Blue background */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #0056b3; /* Darker blue on hover */
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

<a href="profilePage.php" class="back-to-home"><i class="fas fa-home"></i><span>Back to Home</span></a> <!-- Redirect to PHP file -->

<div class="container">
    <h2>Send Payment Request Message</h2>

    <form method="post" action="requestpaymentmanager.php">
        <label for="username">Enter Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="message">Enter Payment Request Message:</label>
        <textarea id="message" name="message" rows="5" required></textarea>
        <input type="file" name="image">

        <button type="submit" name="send">Send Request</button>
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <?php if ($error): ?>
            <p class='status-message error'><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class='status-message success'><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>


