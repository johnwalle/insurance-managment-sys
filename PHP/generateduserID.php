<?php
// Database connection settings

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final_project";

session_start();

// Redirect to login if the user is not logged in or not an admin
if (!isset($_SESSION["Username"]) || $_SESSION["Role"] !== "User") {
    header("Location: login.php");
    exit();
}
include "header_Before_login.php"; // Include the header file
$lang = "en"; // Default language is English
if (isset($_GET['lang']) && $_GET['lang'] == 'am') {
    $lang = "am"; // Switch to Amharic if 'lang=am' is in the URL
}
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'am'])) {
    $lang = $_GET['lang'];
    setcookie('lang', $lang, time() + (86400 * 30), '/'); // Cookie expires in 30 days
    $_COOKIE['lang'] = $lang; // Update the current request with the new language
} elseif (isset($_COOKIE['lang'])) {
    $lang = $_COOKIE['lang'];
} else {
    $lang = 'en'; // Default language
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$idCardData = null;
$error = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted username
    $submittedUsername = $_POST['username'];

    // Fetch the user's ID card data from the database
    $sql = "SELECT Username, FirstName, LastName, Gender, Kebele, Phone, QR_Code_URL FROM users WHERE Username = ? AND ID_Generated = 1";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param('s', $submittedUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the ID card data
        $idCardData = $result->fetch_assoc();
    } else {
        $error = "No ID card has been generated for this username.";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang == 'en' ? 'Your ID Card | Tepi Health Insurance' : 'የእርስዎ መታወቂያ ካርድ | ተፒ ጤና መድህን'; ?></title>
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
        <a href="profilePage.php" class="button">
            <i class="fas fa-home"></i>
            <?php echo $lang == 'en' ? 'Back to Home' : 'ወደ መነሻ ይመለሱ'; ?>
        </a>
    </div>

    <div class="form-container">
        <form method="post" action="">
            <input type="text" name="username" placeholder="<?php echo $lang == 'en' ? 'Enter Username' : 'የተጠቃሚ ስም ያስገቡ'; ?>" required>
            <button type="submit"><?php echo $lang == 'en' ? 'View ID Card' : 'መታወቂያ ካርድ ይመልከቱ'; ?></button>
        </form>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </div>

    <?php if ($idCardData): ?>
        <div class="card">
            <div class="text-content">
                <h2><?php echo $lang == 'en' ? 'Tepi Health Insurance ID Card' : 'የተፒ ጤና መድህን መታወቂያ ካርድ'; ?></h2>
                <p><strong><?php echo $lang == 'en' ? 'Username:' : 'የተጠቃሚ ስም:'; ?></strong> <?php echo htmlspecialchars($idCardData['Username']); ?></p>
                <p><strong><?php echo $lang == 'en' ? 'First Name:' : 'የመጀመሪያ ስም:'; ?></strong> <?php echo htmlspecialchars($idCardData['FirstName']); ?></p>
                <p><strong><?php echo $lang == 'en' ? 'Last Name:' : 'የአባት ስም:'; ?></strong> <?php echo htmlspecialchars($idCardData['LastName']); ?></p>
                <p><strong><?php echo $lang == 'en' ? 'Gender:' : 'ፆታ:'; ?></strong> <?php echo htmlspecialchars($idCardData['Gender']); ?></p>
                <p><strong><?php echo $lang == 'en' ? 'Kebele:' : 'ቀበሌ:'; ?></strong> <?php echo htmlspecialchars($idCardData['Kebele']); ?></p>
                <p><strong><?php echo $lang == 'en' ? 'Phone Number:' : 'የስልክ ቁጥር:'; ?></strong> <?php echo htmlspecialchars($idCardData['Phone']); ?></p>
            </div>
            <img src="<?php echo htmlspecialchars($idCardData['QR_Code_URL']); ?>" alt="QR Code" class="qr-code">
        </div>
        <div class="print-btn">
            <button onclick="window.print()"><i class="fas fa-print"></i> <?php echo $lang == 'en' ? 'Print' : 'አትም'; ?></button>
        </div>
    <?php endif; ?>

</body>
</html>