<?php
session_start();
// Redirect to login if the user is not logged in or not an user

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
?>

<!DOCTYPE html>
<html lang="<?php echo $lang == 'en' ? 'en' : 'am'; ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang == "en" ? "Help | Tepi Health Insurance" : "እርዳታ | ተፒ የጤና መድን"; ?></title>
    <link rel="stylesheet" type="text/css" href="../CSS/about.css">
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('../Images/bg14.jpg');
            background-size: cover;
            background-position: center;
            color: #333;
        }

        .top-right-buttons {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1000;
        }

        .top-right-buttons .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .top-right-buttons .button:hover {
            background-color: #0056b3;
        }

        .top-right-buttons .fa {
            margin-right: 5px;
        }

        #aboutbody {
            padding: 20px;
            margin: 0;
        }

        .para1 {
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            margin: 20px 0;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin: 0 0 20px;
            text-align: center;
        }

        li {
            text-align: center;
            list-style: none;
        }
    </style>
</head>
<body>
    <div class="top-right-buttons">
        <a href="profilePage.php" class="button"><i class="fas fa-home"></i><?php echo $lang == "en" ? "Back to Home" : "ወደ መነሻ ተመለስ"; ?></a>
    </div>

    <div id="aboutbody">
        <div class="para1">
            <h1><?php echo $lang == "en" ? "How does the website work?" : "ድህረ ገጹ እንዴት ይሰራል?"; ?></h1>
            <p><?php echo $lang == "en" ? "Posting on Health insurance is a simple process..." : "በየጤና መድን ድህረ ገጽ ላይ መያዝ ቀላል ሂደት ነው። መጀመሪያ ለመጀመር ተመዝግበው መለያ መፍጠር አለብዎት። ቅጽን በማስተካከል እና በመላክ መመዝገብዎን ያጠናቅቁ። ከዚያ በኋላ ወደ መለያዎ መግባት ይችላሉ።"; ?></p>

            <h1><?php echo $lang == "en" ? "How to access the website?" : "ድህረ ገጹን እንዴት ማግኘት ይቻላል?"; ?></h1>
            <p><?php echo $lang == "en" ? "Authorized users first log in..." : "በተፈቃደ ተጠቃሚ መመዝገብ በመፍትሄ መግባት ያስፈልጋል። ትክክለኛ የተጠቃሚ ስም እና የመክፈቻ ቃል በማስገባት ውስጥ ሲገቡ በሚመለከተው ክስተት መሠረት መረጃ ማግኘት ይችላሉ።"; ?></p>

            <h1><?php echo $lang == "en" ? "I can't register on the website?" : "በድህረ ገጹ ላይ መመዝገብ አልቻልኩም?"; ?></h1>
            <p><?php echo $lang == "en" ? "Make sure you have filled out all required fields..." : "በመመዝገቢያ ቅጽ ላይ ሁሉንም የሚጠየቁ መስኮች ተሞልተው መሆኑን ያረጋግጡ። ከዚያ በኋላ ኢሜልዎን በመፈተሽ መለያዎን ለማረጋገጥ ሊንክ ያለው መልዕክት ይደርሳችኋል።"; ?></p>

            <h1><?php echo $lang == "en" ? "Who can access the website?" : "ድህረ ገጹን ማግኘት ለማን ይቻላል?"; ?></h1>
            <p>
                <li><?php echo $lang == "en" ? "Guest users of Health Insurance can access the pages About Us and Help." : "የጤና መድን እንግዳ ተጠቃሚዎች የ'ስለኛ' እና 'እርዳታ' ገጾችን ማየት ይችላሉ።"; ?></li>
                <li><?php echo $lang == "en" ? "External users who want to be customers..." : "ውጪ ተጠቃሚዎች እንደደንበኞች ለመመዝገብ የሆላ ካርድ መስጫ እና ደንበኛ በመመዝገብ ድህረ ገጹን ማግኘት ይችላሉ።"; ?></li>
                <li><?php echo $lang == "en" ? "Administrator" : "አስተዳዳሪ"; ?></li>
                <li><?php echo $lang == "en" ? "Hospital HI Officer" : "የሆስፒታል የጤና መድን ባለሙያ"; ?></li>
                <li><?php echo $lang == "en" ? "Kebele Manager" : "የቀበሌ አስተዳዳሪ"; ?></li>
                <li><?php echo $lang == "en" ? "Customer" : "ደንበኛ"; ?></li>
                <li><?php echo $lang == "en" ? "Health Insurance Manager" : "የጤና መድን አስተዳዳሪ"; ?></li>
            </p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
