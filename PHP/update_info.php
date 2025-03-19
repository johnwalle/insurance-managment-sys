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

// Assuming you are using session to store logged-in username
session_start();
$loggedInUsername = $_SESSION['Username']; // Adjust this as necessary

// Fetch user information for the form
$userInfo = [];
if ($loggedInUsername) {
    $stmt = $conn->prepare("SELECT Username, FirstName, LastName, Email, Phone, SubCity, Kebele, HomeNo, BirthDate, Gender FROM Users WHERE Username = ?");
    $stmt->bind_param("s", $loggedInUsername);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userInfo['Username'], $userInfo['First_Name'], $userInfo['Last_Name'], $userInfo['Email'], $userInfo['Phone_Number'], $userInfo['Sub_City'], $userInfo['Kebele'], $userInfo['Home_No'], $userInfo['Date_Of_Birth'], $userInfo['Gender']);
        $stmt->fetch();
    }
    $stmt->close();
}

// Handle form submission
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $subCity = $_POST['sub_city'];
    $kebele = $_POST['kebele'];
    $homeNo = $_POST['home_no'];
    $dateOfBirth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    
    // Check if any changes have been made
    if ($firstName == $userInfo['First_Name'] &&
        $lastName == $userInfo['Last_Name'] &&
        $email == $userInfo['Email'] &&
        $phoneNumber == $userInfo['Phone_Number'] &&
        $subCity == $userInfo['Sub_City'] &&
        $kebele == $userInfo['Kebele'] &&
        $homeNo == $userInfo['Home_No'] &&
        $dateOfBirth == $userInfo['Date_Of_Birth'] &&
        $gender == $userInfo['Gender']) {
        $message = "No changes detected. Please update at least one field first.";
    } else {
        // Update user information in the database
        $stmt = $conn->prepare("UPDATE Users SET FirstName = ?, LastName = ?, Email = ?, Phone = ?, SubCity = ?, Kebele = ?, HomeNo = ?, BirthDate = ?, Gender = ? WHERE Username = ?");
        $stmt->bind_param("ssssssssss", $firstName, $lastName, $email, $phoneNumber, $subCity, $kebele, $homeNo, $dateOfBirth, $gender, $loggedInUsername);
        
        if ($stmt->execute()) {
            $message = "Information updated successfully.";
        } else {
            $message = "Failed to update information: " . $stmt->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Information | Gondar Health Insurance</title>
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
            overflow: hidden; /* Hide overflow on the body to prevent scrolling */
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
            padding: 20px;
            max-width: 500px;
            width: 100%;
            max-height: 80vh; /* Ensure container doesn't exceed viewport height */
            overflow-y: auto; /* Add vertical scrollbar if needed */
            position: relative; /* For positioning the icon */
            margin: 0 auto; /* Center horizontally */
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

        input, select {
            width: calc(100% - 20px);
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
            margin-bottom: 20px; /* Margin for status message at the top */
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

<a href="profilepage.php" class="back-to-home"><i class="fas fa-home"></i><span>Back to Home</span></a> <!-- Redirect to PHP file -->

<div class="container">
    <?php if ($message): ?>
        <p class="status-message <?= strpos($message, 'success') !== false ? 'success' : 'error'; ?>"><?= htmlspecialchars($message); ?></p>
    <?php endif; ?>
    
    <h2>Update Information</h2>

    <form action="" method="post">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($userInfo['Username'] ?? '') ?>" readonly>

        <label for="first_name">First Name</label>
        <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($userInfo['First_Name'] ?? '') ?>" required>

        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($userInfo['Last_Name'] ?? '') ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($userInfo['Email'] ?? '') ?>" required>

        <label for="phone_number">Phone Number</label>
        <input type="text" id="phone_number" name="phone_number" value="<?= htmlspecialchars($userInfo['Phone_Number'] ?? '') ?>" required>

        <label for="sub_city">Sub City</label>
        <input type="text" id="sub_city" name="sub_city" value="<?= htmlspecialchars($userInfo['Sub_City'] ?? '') ?>" required>

        <label for="kebele">Kebele</label>
        <input type="text" id="kebele" name="kebele" value="<?= htmlspecialchars($userInfo['Kebele'] ?? '') ?>" required>

        <label for="home_no">Home No</label>
        <input type="text" id="home_no" name="home_no" value="<?= htmlspecialchars($userInfo['Home_No'] ?? '') ?>" required>

        <label for="date_of_birth">Date of Birth</label>
        <input type="date" id="date_of_birth" name="date_of_birth" value="<?= htmlspecialchars($userInfo['Date_Of_Birth'] ?? '') ?>" required>

        <label for="gender">Gender</label>
        <select id="gender" name="gender" required>
            <option value="Male" <?= ($userInfo['Gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= ($userInfo['Gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
        </select>

        <button type="submit" class="btn">Update Information</button>
    </form>
</div>

</body>
</html>
