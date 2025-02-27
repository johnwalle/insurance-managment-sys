<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["Username"])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

// Set timezone
date_default_timezone_set('Africa/Addis_Ababa');
// Get current hour
$current_hour = date('G'); // 24-hour format (0-23)

// Determine greeting based on time of day
if ($current_hour >= 5 && $current_hour < 12) {
    $greeting = "Good Morning";
} elseif ($current_hour >= 12 && $current_hour < 17) {
    $greeting = "Good Afternoon";
} else {
    $greeting = "Good Evening";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Insurance Manager| Gondar Health Insurance</title>
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <link rel="stylesheet" href="../CSS/After_login.css">
    <link rel="stylesheet" href="../CSS/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- For Font Awesome Icons -->

    <style>
        /* General Body Styling */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            background-image: url('../Images/bg14.jpg');
            background-size: cover;
            background-position: center;
        }

        /* Side Menu Styling */
        #side-menu {
            width: 250px;
            background-color: #007bff;
            color: white;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        #side-menu .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }

        #side-menu .logo img {
            width: 100px;
            height: auto;
        }

        #side-menu .site-name {
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
        }

        #side-menu .nav {
            list-style-type: none;
            padding: 0;
            flex-grow: 1;
        }

        #side-menu .nav li {
            margin: 6px 0;
        }

        #side-menu .nav li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            display: block;
            padding: 10px 15px;
            border-radius: 5px;
        }

        #side-menu .nav li a:hover {
            background-color: bisque;
            color: #007bff;
        }

        #side-menu .nav .bottom-links {
            margin-top: auto;
        }

        /* Content Styling */
        #content {
            margin-left: 250px;
            padding: 40px;
            width: calc(100% - 250px);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        #Greeting {
            font-size: 60px;
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            color: #007bff;
            animation: fadeIn 2s ease-in-out, bounce 2s infinite;
            margin-bottom: 20px;
            text-align: center;
        }

        #username-display {
            font-size: 24px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #ff5733;
            animation: usernameColorChange 3s infinite alternate;
        }

        .top-right-buttons {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
        }

        .top-right-buttons a {
            text-decoration: none;
        }

        .top-right-buttons .button {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .top-right-buttons .button i {
            margin-right: 8px;
            font-size: 18px;
        }

        .top-right-buttons .button:hover {
            background-color: bisque;
            color: #007bff;
            transform: scale(1.1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }

        @keyframes usernameColorChange {
            from {
                color: #ff5733;
            }
            to {
                color: #007bff;
            }
        }
    </style>
</head>

<body>
    <div id="side-menu">
        <div>
            <div class="logo">
                <img src="../Images/officier.png" alt="Officer Logo">
                <div class="site-name"> Health Insurance Manager </div>
            </div>

            <ul class="nav">
                <li><a href="./seeuserinformation.php">View Customer Information</a></li>
                <li><a href="./updateuserinformation.php">Update Customer Information</a></li>
                <li><a href="./generated_userID.php">Generate Certeficate ID </a></li>
                <li><a href="view_comments.php" class="action">see complain</a></li>
                <li><a href="./insurancerenew.php">Renew Insurance </a></li>
                <li><a href="./requestpaymentmanager.php">Request Payment</a></li>
            </ul>
        </div>
    </div>

    <div id="content">
        <div class="top-right-buttons">
            <a href="./logout.php" class="button"><i class="fas fa-sign-out-alt"></i>Logout</a>
            
        </div>

        <div>
            <h1 id="Greeting">Welcome to Health Insurance's Manager Page</h1>
            <h5 id="username-display">
                <?php echo $greeting . ", " . htmlspecialchars($_SESSION["Username"]); ?>
            </h5>
        </div>
    </div>
</body>
</html>
