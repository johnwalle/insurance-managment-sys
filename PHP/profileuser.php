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

// Fetch user information
$userInfo = [];
if ($loggedInUsername) {
    $stmt = $conn->prepare("SELECT Username, First_Name, Last_Name, Email, Phone_Number, Sub_City, Kebele, Home_No, Date_Of_Birth, Gender FROM registered_user WHERE Username = ?");
    $stmt->bind_param("s", $loggedInUsername);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userInfo['Username'], $userInfo['First_Name'], $userInfo['Last_Name'], $userInfo['Email'], $userInfo['Phone_Number'], $userInfo['Sub_City'], $userInfo['Kebele'], $userInfo['Home_No'], $userInfo['Date_Of_Birth'], $userInfo['Gender']);
        $stmt->fetch();
    } else {
        $userInfo['Error'] = "User not found.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile | Gondar Health Insurance</title>
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

<a href="profilepage.php" class="back-to-home"><i class="fas fa-home"></i><span>Back to Home</span></a>

<div class="profile-image">
    <i class="fas fa-user"></i>
</div>

<?php if (isset($userInfo['Error'])): ?>
    <p class="status-message"><?= htmlspecialchars($userInfo['Error']); ?></p>
<?php else: ?>
    <h2>User Profile</h2>

    <div class="profile-info">
        <div class="profile-info-left">
            <div class="profile-item">
                <i class="fas fa-user"></i>
                <span>Username: <?= htmlspecialchars($userInfo['Username'] ?? ''); ?></span>
            </div>
            <div class="profile-item">
                <i class="fas fa-id-badge"></i>
                <span>First Name: <?= htmlspecialchars($userInfo['First_Name'] ?? ''); ?></span>
            </div>
            <div class="profile-item">
                <i class="fas fa-id-badge"></i>
                <span>Last Name: <?= htmlspecialchars($userInfo['Last_Name'] ?? ''); ?></span>
            </div>
            <div class="profile-item">
                <i class="fas fa-envelope"></i>
                <span>Email: <?= htmlspecialchars($userInfo['Email'] ?? ''); ?></span>
            </div>
            <div class="profile-item">
                <i class="fas fa-phone"></i>
                <span>Phone Number: <?= htmlspecialchars($userInfo['Phone_Number'] ?? ''); ?></span>
            </div>
        </div>
        <div class="profile-info-right">
            <div class="profile-item">
                <i class="fas fa-city"></i>
                <span>Sub City: <?= htmlspecialchars($userInfo['Sub_City'] ?? ''); ?></span>
            </div>
            <div class="profile-item">
                <i class="fas fa-map-marker-alt"></i>
                <span>Kebele: <?= htmlspecialchars($userInfo['Kebele'] ?? ''); ?></span>
            </div>
            <div class="profile-item">
                <i class="fas fa-home"></i>
                <span>Home Number: <?= htmlspecialchars($userInfo['Home_No'] ?? ''); ?></span>
            </div>
            <div class="profile-item">
                <i class="fas fa-birthday-cake"></i>
                <span>Date of Birth: <?= htmlspecialchars($userInfo['Date_Of_Birth'] ?? ''); ?></span>
            </div>
            <div class="profile-item">
                <i class="fas fa-venus-mars"></i>
                <span>Gender: <?= htmlspecialchars($userInfo['Gender'] ?? ''); ?></span>
            </div>
        </div>
    </div>
<?php endif; ?>

</body>
</html>
