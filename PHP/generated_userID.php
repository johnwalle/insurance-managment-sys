<?php
// Start session and include database connection
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final_project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$userData = null;
$error = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted username
    $submittedUsername = $_POST['username'];

    // Fetch user data based on username
    $sql = "SELECT id, Username, First_Name, Last_Name, Gender, Kebele, Phone_Number FROM registered_user WHERE Username = ? AND UserType = 'User'";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param('s', $submittedUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user data
        $userData = $result->fetch_assoc();
        $userId = $userData['id'];

        // Generate QR code URL dynamically
        $dataForQRCode = "Username: {$userData['Username']}\nName: {$userData['First_Name']} {$userData['Last_Name']}\nGender: {$userData['Gender']}\nKebele: {$userData['Kebele']}\nPhone: {$userData['Phone_Number']}";
        $encodedData = urlencode($dataForQRCode);
        $qrCodeURL = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=$encodedData";

        // Save the generated QR code URL to the database
        $updateSQL = "UPDATE registered_user SET QR_Code_URL = ?, ID_Generated = 1 WHERE id = ?";
        $updateStmt = $conn->prepare($updateSQL);
        if ($updateStmt) {
            $updateStmt->bind_param('si', $qrCodeURL, $userId);
            $updateStmt->execute();
            $updateStmt->close();
        } else {
            die("Error preparing statement: " . $conn->error);
        }
    } else {
        $error = "No data found for the provided username.";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Certificate ID | Gondar Health Insurance</title>
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Your existing CSS here */
        body {
            display: flex;
            flex-direction: column;
            background-image: url('images/bg14.jpg'); /* Ensure this path is correct */
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
            position: relative;
        }
        .form-container {
            max-width: 500px;
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            text-align: center;
        }
        .form-container input {
            padding: 10px;
            font-size: 16px;
            margin-bottom: 10px;
            width: 80%;
            max-width: 300px;
        }
        .form-container button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
        .card {
            width: 500px;
            border: 2px solid #007bff;
            border-radius: 10px;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
            position: relative;
        }
        .card .text-content {
            max-width: 70%;
        }
        .card .text-content h2 {
            margin: 0;
            font-size: 20px;
            text-align: center;
            color: #007bff;
        }
        .card .text-content p {
            margin: 5px 0;
            font-size: 16px;
            color: #333;
        }
        .card .qr-code {
            width: 150px;
            height: 150px;
        }
        .print-btn {
            position: absolute;
            bottom: 10px;
            right: 10px;
        }
        .print-btn button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
        }
        .print-btn button .fa {
            margin-right: 8px;
        }
        .print-btn button:hover {
            background-color: #0056b3;
        }
        .top-right-buttons {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .top-right-buttons .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            margin-left: 10px;
            transition: background-color 0.3s;
        }
        .top-right-buttons .button:hover {
            background-color: #0056b3;
        }
        .top-right-buttons .fa {
            margin-right: 5px;
        }
        /* Print styles */
        @media print {
            body * {
                visibility: hidden;
            }
            .card, .card * {
                visibility: visible;
            }
            .card {
                position: absolute;
                top: 20px;
                left: 20px;
                width: calc(100% - 40px); /* Adjust the width for the print view */
                height: auto;
                box-shadow: none;
            }
            .print-btn {
                visibility: visible;
            }
        }
    </style>
</head>
<body>
    <div class="top-right-buttons">
        <a href="healthInsuranceManager.php" class="button"><i class="fas fa-home"></i>Back to Home</a>
 
    </div>

    <div class="form-container">
        <form method="post" action="">
            <input type="text" name="username" placeholder="Enter Username " required>
            <button type="submit">Generate Certificate Card</button>
        </form>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </div>

    <?php if ($userData): ?>
        <div class="card">
            <div class="text-content">
                <h2>Gondar Health Insurance ID Card</h2>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($userData['Username']); ?></p>
                <p><strong>First Name:</strong> <?php echo htmlspecialchars($userData['First_Name']); ?></p>
                <p><strong>Last Name:</strong> <?php echo htmlspecialchars($userData['Last_Name']); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($userData['Gender']); ?></p>
                <p><strong>Kebele:</strong> <?php echo htmlspecialchars($userData['Kebele']); ?></p>
                <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($userData['Phone_Number']); ?></p>
            </div>
            <img src="<?php echo $qrCodeURL; ?>" alt="QR Code" class="qr-code">
        </div>
        <div class="print-btn">
            <button onclick="window.print()"><i class="fas fa-print"></i> Print</button>
        </div>
    <?php endif; ?>
</body>
</html>
