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



if ($conn->connect_error) {
    die("<p class='status-message error'>Connection failed: " . $conn->connect_error . "</p>");
}

// Initialize variables
$errorMessage = '';
$successMessage = '';

// Fetch user data
if (isset($_GET['id'])) {
    $userID = intval($_GET['id']);
    $sql = "SELECT * FROM Users WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
    } else {
        $errorMessage = "User not found.";
    }
} 
 if (isset($_POST['update'])) {
    // Update user data
    $userID = intval($_POST['id']);
    $username = $_POST['username'];
    $firstName = $_POST['FirstName'];
    $lastName = $_POST['LastName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['Phone'];
    $subCity = $_POST['subcity'];
    $kebele = $_POST['kebele'];
    $homeNo = $_POST['home'];
    $dateOfBirth = $_POST['BirthDate'];
    $gender = $_POST['gender'];

    $sql = "UPDATE Users SET Username = ?, FirstName = ?, LastName = ?, Email = ?, Phone = ?, SubCity = ?, Kebele = ?, HomeNo = ?, BirthDate = ?, Gender = ? WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssssssi', $username, $firstName, $lastName, $email, $phoneNumber, $subCity, $kebele, $homeNo, $dateOfBirth, $gender, $userID);

    if ($stmt->execute()) {
        $successMessage = "User updated successfully.";
    } else {
        $errorMessage = "Failed to update user.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang == "en" ? "Update User | Tepi Health Insurance" : "የተጠቃሚን መረጃ ያዘምኑ | ተፒ ጤና መድን"; ?></title>
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
            color: #333;
        }

        h2 {
            color: #444;
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-group button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .status-message {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .status-message.success {
            background-color: #d4edda;
            color: #155724;
        }

        .status-message.error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .back-to-home {
            position: fixed;
            top: 20px;
            right: 20px;
            text-decoration: none;
            color: #fff;
            background: #007bff;
            border-radius: 50px;
            padding: 10px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transition: background 0.3s, transform 0.3s;
        }

        .back-to-home:hover {
            background: #0056b3;
            transform: scale(1.1);
        }

        .back-to-home i {
            margin-right: 8px;
            font-size: 18px;
        }

        .back-to-home span {
            font-size: 14px;
            font-weight: 500;
        }

        .confirmation-box {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            z-index: 1000;
        }

        .confirmation-box.active {
            display: block;
        }

        .confirmation-box h3 {
            margin-top: 0;
        }

        .confirmation-box .buttons {
            text-align: right;
        }

        .confirmation-box .buttons button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
            transition: background-color 0.3s;
        }

        .confirmation-box .buttons button:hover {
            background-color: #0056b3;
        }

        .confirmation-box .buttons .cancel-btn {
            background-color: #6c757d;
        }

        .confirmation-box .buttons .cancel-btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang == "en" ? "Update User | Tepi Health Insurance" : "የተጠቃሚን መረጃ ያዘምኑ | ተፒ ጤና መድን"; ?></title>
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
            color: #333;
        }

        h2 {
            color: #444;
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-group button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .status-message {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .status-message.success {
            background-color: #d4edda;
            color: #155724;
        }

        .status-message.error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .back-to-home {
            position: fixed;
            top: 20px;
            right: 20px;
            text-decoration: none;
            color: #fff;
            background: #007bff;
            border-radius: 50px;
            padding: 10px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transition: background 0.3s, transform 0.3s;
        }

        .back-to-home:hover {
            background: #0056b3;
            transform: scale(1.1);
        }

        .back-to-home i {
            margin-right: 8px;
            font-size: 18px;
        }

        .back-to-home span {
            font-size: 14px;
            font-weight: 500;
        }

        .confirmation-box {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            z-index: 1000;
        }

        .confirmation-box.active {
            display: block;
        }

        .confirmation-box h3 {
            margin-top: 0;
        }

        .confirmation-box .buttons {
            text-align: right;
        }

        .confirmation-box .buttons button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
            transition: background-color 0.3s;
        }

        .confirmation-box .buttons button:hover {
            background-color: #0056b3;
        }

        .confirmation-box .buttons .cancel-btn {
            background-color: #6c757d;
        }

        .confirmation-box .buttons .cancel-btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<!-- Back to Home button -->
<a href="healthInsuranceManager.php" class="back-to-home"><i class="fas fa-home"></i><span><?php echo $lang == "en" ? "Back to Home" : "ወደ መነሻ ገፅ ተመልስ"; ?></span></a>

<div class="form-container">
    <h2><?php echo $lang == "en" ? "Update User" : "የተጠቃሚን መረጃ ያዘምኑ"; ?></h2>

    <?php if ($errorMessage): ?>
        <p class="status-message error"><?= htmlspecialchars($lang == "en" ? $errorMessage : "ይቅርታ፣ ስህተት ተከስቷል።"); ?></p>
    <?php endif; ?>

    <?php if ($successMessage): ?>
        <p class="status-message success"><?= htmlspecialchars($lang == "en" ? $successMessage : "ማስተካከያው ተሳክቷል።"); ?></p>
    <?php endif; ?>

    <?php if (isset($user)): ?>
        <form id="updateForm" action="update_user.php" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($user['UserID']); ?>">

            <div class="form-group">
                <label for="username"><?php echo $lang == "en" ? "Username" : "የተጠቃሚ ስም"; ?></label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['Username']); ?>" required>
            </div>

            <div class="form-group">
                <label for="first_name"><?php echo $lang == "en" ? "First Name" : "የመጀመሪያ ስም"; ?></label>
                <input type="text" id="FirstName" name="FirstName" value="<?= htmlspecialchars($user['FirstName']); ?>" required>
            </div>

            <div class="form-group">
                <label for="last_name"><?php echo $lang == "en" ? "Last Name" : "የአባት ስም"; ?></label>
                <input type="text" id="LastName" name="LastName" value="<?= htmlspecialchars($user['LastName']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email"><?php echo $lang == "en" ? "Email" : "ኢሜይል"; ?></label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['Email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="phone_number"><?php echo $lang == "en" ? "Phone Number" : "የስልክ ቁጥር"; ?></label>
                <input type="text" id="Phone" name="Phone" value="<?= htmlspecialchars($user['Phone']); ?>" required>
            </div>

            <div class="form-group">
                <label for="sub_city"><?php echo $lang == "en" ? "Sub City" : "ክፍለ ከተማ"; ?></label>
                <input type="text" id="subcity" name="subcity" value="<?= htmlspecialchars($user['SubCity']); ?>" required>
            </div>

            <div class="form-group">
                <label for="kebele"><?php echo $lang == "en" ? "Kebele" : "ቀበሌ"; ?></label>
                <input type="text" id="kebele" name="kebele" value="<?= htmlspecialchars($user['Kebele']); ?>" required>
            </div>

            <div class="form-group">
                <label for="home_no"><?php echo $lang == "en" ? "Home No" : "የቤት ቁጥር"; ?></label>
                <input type="text" id="home" name="home" value="<?= htmlspecialchars($user['HomeNo']); ?>" required>
            </div>

            <div class="form-group">
                <label for="date_of_birth"><?php echo $lang == "en" ? "Date of Birth" : "የትውልድ ቀን"; ?></label>
                <input type="date" id="BirthDate" name="BirthDate" value="<?= htmlspecialchars($user['BirthDate']); ?>" required>
            </div>

            <div class="form-group">
                <label for="gender"><?php echo $lang == "en" ? "Gender" : "ፆታ"; ?></label>
                <select id="gender" name="gender" required>
                    <option value="Male" <?= ($user['Gender'] == 'Male') ? 'selected' : ''; ?>>
                        <?php echo $lang == "en" ? "Male" : "ወንድ"; ?>
                    </option>
                    <option value="Female" <?= ($user['Gender'] == 'Female') ? 'selected' : ''; ?>>
                        <?php echo $lang == "en" ? "Female" : "ሴት"; ?>
                    </option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit" name="update" onclick="showConfirmation()"><?php echo $lang == "en" ? "Update" : "አዘምን"; ?></button>
            </div>
        </form>
    <?php endif; ?>
</div>

<!-- Confirmation Box -->
<div id="confirmationBox" class="confirmation-box">
    <h3><?php echo $lang == "en" ? "Are you sure you want to update this user?" : "ይህንን ተጠቃሚ ማዘመን"?> </h3>

    <div class="buttons">
        <button id="confirmUpdate">Yes, Update</button>
        <button class="cancel-btn" onclick="hideConfirmation()">Cancel</button>
    </div>
</div>

<script>
    function showConfirmation() {
        document.getElementById('confirmationBox').classList.add('active');
    }

    function hideConfirmation() {
        document.getElementById('confirmationBox').classList.remove('active');
    }

    document.getElementById('confirmUpdate').onclick = function() {
        document.getElementById('updateForm').submit();
    }
</script>

</body>
</html>
