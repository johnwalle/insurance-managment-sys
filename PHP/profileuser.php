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
$loggedInUsername = $_SESSION['Username']; // Adjust this as necessary

// Fetch user information
$userInfo = [];
if ($loggedInUsername) {
    $stmt = $conn->prepare("SELECT Username, FirstName, LastName, Email, Phone, BirthDate, Gender, SubCity, Kebele, HomeNo FROM Users WHERE Username = ?");
    $stmt->bind_param("s", $loggedInUsername);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userInfo['Username'], $userInfo['FirstName'], $userInfo['LastName'], $userInfo['Email'], $userInfo['Phone'], $userInfo['BirthDate'], $userInfo['Gender'], $userInfo['SubCity'], $userInfo['Kebele'], $userInfo['HomeNo']);
        $stmt->fetch();
    } else {
        $userInfo['Error'] = "User not found.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="<?php echo $lang == 'en' ? 'en' : 'am'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang == "en" ? "User Profile | Tepi Health Insurance" : "የተጠቃሚ መገለጫ | ተፒ የጤና መድን"; ?></title>
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* General Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-image: url('images/bg14.jpg');
            background-size: cover;
            background-position: center;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            position: relative;
        }

        /* Back to Home Icon */
        .back-to-home {
            position: absolute;
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

        /* Profile Image */
        .profile-image {
            width: 120px;
            height: 120px;
            background: #007bff;
            border-radius: 50%;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            animation: bounce 2s infinite;
        }

        .profile-image i {
            font-size: 60px;
            color: #fff;
        }

        /* Headings */
        h2 {
            color: #444;
            font-size: 28px;
            margin-bottom: 20px;
        }

        /* Profile Information */
        .profile-info {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            font-size: 18px;
            color: #666;
            width: 100%;
            max-width: 600px;
        }

        .profile-info-left,
        .profile-info-right {
            display: flex;
            flex-direction: column;
            gap: 20px;
            flex: 1;
        }

        .profile-info i {
            margin-right: 15px;
            color: #007bff;
            animation: fadeIn 1.5s ease-in-out infinite alternate;
        }

        .profile-item {
            display: flex;
            align-items: center;
            padding: 10px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .profile-item:hover {
            transform: translateY(-5px);
        }

        /* Status Messages */
        .status-message {
            text-align: center;
            font-size: 16px;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Animations */
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-30px);
            }
            60% {
                transform: translateY(-15px);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0.4;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>

<a href="profilepage.php" class="back-to-home">
    <i class="fas fa-home"></i>
    <span><?php echo $lang == "en" ? "Back to Home" : "ወደ መነሻ ተመለስ"; ?></span>
</a>

<div class="profile-image">
    <i class="fas fa-user"></i>
</div>

<?php if (isset($userInfo['Error'])): ?>
    <p class="status-message"><?= htmlspecialchars($userInfo['Error']); ?></p>
<?php else: ?>
    <h2><?php echo $lang == "en" ? "User Profile" : "የተጠቃሚ መገለጫ"; ?></h2>

    <div class="profile-info">
        <div class="profile-info-left">
            <div class="profile-item">
                <i class="fas fa-user"></i>
                <span><?php echo $lang == "en" ? "Username: " : "የተጠቃሚ ስም፡ "; ?><?= htmlspecialchars($userInfo['Username'] ?? ''); ?></span>
            </div>
            <div class="profile-item">
                <i class="fas fa-id-badge"></i>
                <span><?php echo $lang == "en" ? "First Name: " : "ስም፡ "; ?><?= htmlspecialchars($userInfo['FirstName'] ?? ''); ?></span>
            </div>
            <div class="profile-item">
                <i class="fas fa-id-badge"></i>
                <span><?php echo $lang == "en" ? "Last Name: " : "የአባት ስም፡ "; ?><?= htmlspecialchars($userInfo['LastName'] ?? ''); ?></span>
            </div>
            <div class="profile-item">
                <i class="fas fa-envelope"></i>
                <span><?php echo $lang == "en" ? "Email: " : "ኢሜይል፡ "; ?><?= htmlspecialchars($userInfo['Email'] ?? ''); ?></span>
            </div>
            <div class="profile-item">
                <i class="fas fa-phone"></i>
                <span><?php echo $lang == "en" ? "Phone Number: " : "ስልክ ቁጥር፡ "; ?><?= htmlspecialchars($userInfo['Phone'] ?? ''); ?></span>
            </div>
        </div>
        <div class="profile-info-right">
            <div class="profile-item">
                <i class="fas fa-city"></i>
                <span><?php echo $lang == "en" ? "Sub City: " : "ክ/ከተማ፡ "; ?><?= htmlspecialchars($userInfo['SubCity'] ?? ''); ?></span>
            </div>
            <div class="profile-item">
                <i class="fas fa-map-marker-alt"></i>
                <span><?php echo $lang == "en" ? "Kebele: " : "ቀበሌ፡ "; ?><?= htmlspecialchars($userInfo['Kebele'] ?? ''); ?></span>
            </div>
            <div class="profile-item">
                <i class="fas fa-home"></i>
                <span><?php echo $lang == "en" ? "Home Number: " : "የቤት ቁጥር፡ "; ?><?= htmlspecialchars($userInfo['HomeNo'] ?? ''); ?></span>
            </div>
            <div class="profile-item">
                <i class="fas fa-birthday-cake"></i>
                <span><?php echo $lang == "en" ? "Date of Birth: " : "የትውልድ ቀን፡ "; ?><?= htmlspecialchars($userInfo['BirthDate'] ?? ''); ?></span>
            </div>
            <div class="profile-item">
                <i class="fas fa-venus-mars"></i>
                <span><?php echo $lang == "en" ? "Gender: " : "ፆታ፡ "; ?><?= htmlspecialchars($userInfo['Gender'] ?? ''); ?></span>
            </div>
        </div>
    </div>
<?php endif; ?>

</body>

</html>
