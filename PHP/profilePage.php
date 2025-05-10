<?php
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION["Username"]) || $_SESSION["Role"] !== "User") {
    header("Location: login.php");
    exit();
}
    include "../header_Before_login.php"; // Include the header file
    
    // Default language is English
    $lang = "en"; 
    
    // Check if 'lang' parameter is set in the URL and switch to Amharic if needed
    if (isset($_GET['lang']) && $_GET['lang'] == 'am') {
        $lang = "am"; // Switch to Amharic if 'lang=am' is in the URL
    }
    
    // Check for language switch in the URL and save it in a cookie
    if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'am'])) {
        $lang = $_GET['lang'];
        setcookie('lang', $lang, time() + (86400 * 30), '/'); // Cookie expires in 30 days
        $_COOKIE['lang'] = $lang; // Update the current request with the new language
    } 
    // Check if there is already a language saved in the cookie
    elseif (isset($_COOKIE['lang'])) {
        $lang = $_COOKIE['lang'];
    } else {
        $lang = 'en'; // Default to English if no cookie or URL parameter
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


// Get current time
$current_time = date('h:i A'); // 12-hour format with AM/PM
?> 
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang == "en" ? "Health Insurance User | Tepi Health Insurance" : "የጤና መድህን ተጠቃሚ | ተፒ ጤና መድህን"; ?></title>
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <link rel="stylesheet" href="../CSS/After_login.css">
    <link rel="stylesheet" href="../CSS/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 <!-- For Font Awesome Icons -->

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            background-image: url('../Images/bg14.jpg'); /* Background image for body */
            background-size: cover;
            background-position: center;
        }

        #side-menu {
            width: 250px;
            background-color: #007bff;
            color: white;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh; /* Full viewport height */
            overflow-y: auto; /* Enable vertical scrolling */
            display: flex;
            flex-direction: column;
            justify-content: flex-start; /* Align items to the top */
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
            margin-top: auto; /* Pushes these links to the bottom */
        }

        #content {
            margin-left: 250px; /* Ensures content starts after the menu */
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
                <img src="../Images/user.png" alt="Logo">
                <div class="site-name"><?php echo $lang == "en" ? "User" : "ተጠቃሚ"; ?></div>
            </div>

            <ul class="nav">
                <li><a href="./profileuser.php"><?php echo $lang == "en" ? "Profile Information" : "የመገለጫ መረጃ"; ?></a></li>
                <li><a href="./generateduserID.php"><?php echo $lang == "en" ? "View My Certificate ID" : "የማረጋገጫ መታወቂያ አይዲ ይመልከቱ"; ?></a></li>
                <li><a href="comment_form.php" class="action"><?php echo $lang == "en" ? "Complain" : "ቅሬታ አቅርብ"; ?></a></li>
                <li><a href="./update_info.php"><?php echo $lang == "en" ? "Update Information" : "መረጃን አዘምን"; ?></a></li>
                <li><a href="./change_password.php"><?php echo $lang == "en" ? "Change Password" : "የይለፍ ቃል ቀይር"; ?></a></li>
                <li><a href="./paymentuser.php"><?php echo $lang == "en" ? "Payment Methods" : "የክፍያ ዘዴዎች"; ?></a></li>
                <li><a href="./requestpaymentmanager.php"><?php echo $lang == "en" ? "Request Payment" : "ክፍያ እንዲደርስዎ ይጠይቁ"; ?></a></li>
                <li><a href="./sendreciept.php"><?php echo $lang == "en" ? "Send Receipt" : "ደረሰኝ ላክ"; ?></a></li>
                <li><a href="./helpuser.php"><?php echo $lang == "en" ? "Help" : "እርዳታ"; ?></a></li>
            </ul>
        </div>
    </div>

    <div id="content">
        <div class="top-right-buttons">
            <a href="./logout.php" class="button"><i class="fas fa-sign-out-alt"></i><?php echo $lang == "en" ? "Logout" : "ውጣ"; ?></a>          
        </div>

        <div>
        <h1 id="Greeting"><?php echo $lang == "en" ? "Welcome to Health Insurance User's Page" : "እንኳን ወደ የጤና መድህን ተጠቃሚ ገፅ በደህና መጡ"; ?></h1>
        <h2 id="username-display">
                <?php echo $greeting . ", " . htmlspecialchars($_SESSION["Username"]); ?>
            </h2>
        </div>
    </div>
</body>
</html>

