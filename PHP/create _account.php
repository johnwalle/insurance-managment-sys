<?php
session_start();

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
require_once "db_conn.php"; // Ensure your database connection is properly set here

// Redirect to login if the user is not logged in or not an admin
if (!isset($_SESSION["Username"]) || $_SESSION["Role"] !== "Admin") {
    header("Location: login.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $fname = $_POST['name'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $bday = $_POST['bday'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $sub_city = $_POST['sub_city'] ?? '';
    $kebele = $_POST['kebele'] ?? '';
    $homeno = $_POST['homeno'] ?? '';
    $usertype = $_POST['usertype'] ?? 'User'; 
    $uname = $_POST['uname'] ?? '';
    $password = $_POST['password'] ?? '';
    $re_password = $_POST['re_password'] ?? '';

    // Validate required fields
    if (empty($fname) || empty($lname) || empty($email) || empty($phone) || empty($bday) || empty($gender) || empty($uname) || empty($password) || empty($re_password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $re_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT * FROM Users WHERE Username = ?");
        $stmt->execute([$uname]);
        
        if ($stmt->rowCount() > 0) {
            $error = "Username already exists.";
        } else {
            // Securely hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $stmt = $conn->prepare("INSERT INTO Users (FirstName, LastName, Email, Phone, Birthday, Gender, SubCity, Kebele, HomeNo, UserType, Username, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $success = $stmt->execute([$fname, $lname, $email, $phone, $bday, $gender, $sub_city, $kebele, $homeno, $usertype, $uname, $hashed_password]);

            if ($success) {
                // Get user ID and start session
                $_SESSION['id'] = $conn->lastInsertId();
                header("Location: homeloggedin.php");  // Redirect after successful registration
                exit();
            } else {
                $error = "Failed to register. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang == "en" ? "Sign Up | Tepi Health Insurance" : "መመዝገብ | ተፒ የጤና መድን"; ?></title>
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <link rel="stylesheet" href="../CSS/registerStyles.css">
    <style>
          #wrapper__form {
            max-width: 700px;
            margin: 50px auto;
            background:rgba(248, 248, 248, 0.6);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="submit"] {
    background-color: #007bff;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

input[type="submit"]:active {
    background-color: #003366;
}

    </style>
</head>
<body>
    <div class="wrapper" id="wrapper__form">

        <!-- Error and success messages -->
        <?php if ($error): ?>
            <p id="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p id="success"><?php echo $lang == "en" ? "Registration successful! Redirecting..." : "መመዝገብ ተሳክቷል! በመላክ ላይ..."; ?></p>
        <?php endif; ?>

        <form action="register.php" method="POST">
        <h2><?php echo $lang == "en" ? "Registration" : "መመዝገብ"; ?></h2>

<div class="input-box">
    <label><?php echo $lang == "en" ? "Full Name" : "ሙሉ ስም"; ?></label>
    <div class="column">
        <input type="text" name="name" placeholder="<?php echo $lang == 'en' ? 'First Name' : 'አንደኛ ስም'; ?>" required>
        <input type="text" name="lname" placeholder="<?php echo $lang == 'en' ? 'Last Name' : 'የአባት ስም'; ?>" required>
    </div>
</div>

<div class="input-box">
    <label><?php echo $lang == "en" ? "Email" : "ኢሜይል"; ?></label>
    <input type="email" name="email" placeholder="<?php echo $lang == 'en' ? 'ex: myName@gmail.com' : 'ምሳሌ፡ myName@gmail.com'; ?>" required>
</div>

<div class="column">
    <div class="input-box">
        <label><?php echo $lang == "en" ? "Phone Number" : "ስልክ ቁጥር"; ?></label>
        <input type="text" name="phone" placeholder="<?php echo $lang == 'en' ? 'xxxxxxxxxx' : 'xxxxxxxxxx'; ?>" required>
    </div>
    <div class="input-box">
        <label><?php echo $lang == "en" ? "Date of Birth" : "የትውልድ ቀን"; ?></label>
        <input type="date" name="bday" required>
    </div>
</div>

<div class="gender-box">
    <h3><?php echo $lang == "en" ? "Gender" : "ፆታ"; ?></h3>
    <div class="gender-option">
        <label><input type="radio" name="gender" value="Male" checked> <?php echo $lang == "en" ? "Male" : "ወንድ"; ?></label>
        <label><input type="radio" name="gender" value="Female"> <?php echo $lang == "en" ? "Female" : "ሴት"; ?></label>
    </div>
</div>

<div class="input-box">
    <label><?php echo $lang == "en" ? "Address" : "አድራሻ"; ?></label>
    <div class="column">
        <input type="text" name="sub_city" placeholder="<?php echo $lang == 'en' ? 'Sub City' : 'ክፍለ ከተማ'; ?>" required>
        <input type="text" name="kebele" placeholder="<?php echo $lang == 'en' ? 'Kebele' : 'ቀበሌ'; ?>" required>
        <input type="text" name="homeno" placeholder="<?php echo $lang == 'en' ? 'Home No' : 'የቤት ቁጥር'; ?>" required>
    </div>
</div>

<div class="uType-box">
    <h3><?php echo $lang == "en" ? "User Type" : "የተጠቃሚ አይነት"; ?></h3>
    <div class="uType-option">
        <label><input type="radio" name="usertype" value="User" checked> <?php echo $lang == "en" ? "User" : "ተጠቃሚ"; ?></label>
        <label><input type="radio" name="usertype" value="Admin"> <?php echo $lang == "en" ? "Admin" : "አስተዳዳሪ"; ?></label>
        <label><input type="radio" name="usertype" value="KebeleManager"> <?php echo $lang == "en" ? "Kebele Manager" : "የቀበሌ አስተዳዳሪ"; ?></label>
        <label><input type="radio" name="usertype" value="HealthInsuranceManager"> <?php echo $lang == "en" ? "Health Insurance Manager" : "የጤና መድን አስተዳዳሪ"; ?></label>
        <label><input type="radio" name="usertype" value="Hiofficier"> <?php echo $lang == "en" ? "HI Officer" : "የጤና መድን ባለሙያ"; ?></label>
    </div>
</div>

<div class="input-box">
    <label><?php echo $lang == "en" ? "Username" : "የተጠቃሚ ስም"; ?></label>
    <input type="text" name="uname" placeholder="<?php echo $lang == 'en' ? 'Username' : 'የተጠቃሚ ስም'; ?>" required>
</div>

<div class="input-box">
    <label><?php echo $lang == "en" ? "Password" : "የይለፍ ቃል"; ?></label>
    <input type="password" name="password" placeholder="<?php echo $lang == 'en' ? 'Enter password' : 'የይለፍ ቃል ያስገቡ'; ?>" required>
</div>

<div class="input-box">
    <label><?php echo $lang == "en" ? "Confirm Password" : "የይለፍ ቃልን ያረጋግጡ"; ?></label>
    <input type="password" name="re_password" placeholder="<?php echo $lang == 'en' ? 'Re-enter password' : 'የይለፍ ቃልን ዳግመኛ ያስገቡ'; ?>" required>
</div>

<div class="check">
    <input type="checkbox" required>
    <?php echo $lang == "en" ? "I have read and agree to the" : "ህጉን አንብቤ ተስማምቻለሁ"; ?>
    <a href="terms.php"><?php echo $lang == "en" ? "Terms & Conditions" : "ውሎች እና መመሪያዎች"; ?></a>
</div>

<input type="submit" value="<?php echo $lang == 'en' ? 'Register' : 'ይመዝገቡ'; ?>">

<h4><?php echo $lang == "en" ? "Already have an account?" : "አስቀድሞ መለያ አለዎት?"; ?>
    <a href="login.php"><?php echo $lang == "en" ? "Log in" : "ይግቡ"; ?></a>
</h4>
        </form>
    </div>
</body>
</html>
