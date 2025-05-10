<?php
// Simple language selection logic
include "header_Before_login.php"; // Include the header file
$lang = "en"; // Default language is English
if (isset($_GET['lang']) && $_GET['lang'] == 'am') {
    $lang = "am"; // Switch to Amharic if 'lang=am' is in the URL
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang == "en" ? "Help | Tepi Health Insurance" : "እርዳታ | ተፒ ጤና መድን"; ?></title>
    <link rel="stylesheet" type="text/css" href="../CSS/about.css">
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
  <style>
    #aboutbody{
      margin-top:20px;
    }
  </style>
</head>

<body>
  <div class="para1" style="padding: 80px; background-color: aliceblue; margin-bottom: 50px;">
  
    <h1><?php echo $lang == "en" ? "How does the website work?" : "ድህረገፁ እንዴት እየሰራ ነው?"; ?></h1>
    <p><?php echo $lang == "en" ? "Posting on Health insurance is a simple process. All what you need to do is to Register and Create an Account to get started. Fill up the form to complete the registration. Then you can sign in to your account." : "በጤና መድን ላይ ማስተዋወቅ ቀላል ሂደት ነው። ለመጀመር መመዝገብ እና መለያ መፍጠር ብቻ ነው የሚፈልጉት። ቅጹን በሙሉ በማስተካከል ምዝገባውን ያቅርቡ። ከዚያ ወደ መለያዎ ማግኘት ይችላሉ።"; ?></p>

    <h1><?php echo $lang == "en" ? "How to access the Website?" : "ድህረገፁን እንዴት ማግኘት ይቻላል?"; ?></h1>
    <p><?php echo $lang == "en" ? "Authorized user first Login to the system by inserting your Username and Password. After authorized person entered into the system by inserting valid Username and Password, he/her can access the system according to his/her activity." : "በፈቃድ የተፈቀደ ተጠቃሚ አካውንቱን በመግባት የተጠቃሚ ስም እና የሚስጥር ቁጥር በመጨመር ወደ ስርዓቱ ይግባል። ከፈቀደ በኋላ፣ እውነተኛ የተጠቃሚ ስም እና የሚስጥር ቁጥር በማስገባት በአገልግሎቱ መሠረት የስራ አይነቱን ሊያገናኝ ይችላል።"; ?></p>

    <h1><?php echo $lang == "en" ? "I can't Register on the website?" : "በድህረ ገፁ ላይ መመዝገብ አልቻልኩም?"; ?></h1>
    <p><?php echo $lang == "en" ? "Make sure you have filled out all required fields on the registration page. Once the registration form is filled out and submitted, an email notification will be sent to your email account with a link to validate your account. Please access your email to validate your account." : "በምዝገባ ገጹ ላይ የሚፈለጉትን መረጃዎች በሙሉ እንደተሟሉ ያረጋግጡ። ከምዝገባው ቅጽ በሙሉ በማስገባት እና በመላክ በኋላ፣ መለያዎን ለማረጋገጥ ከሚያስችል አገናኝ ጋር ኢሜል ማስታወቂያ ወደ ኢሜል መለያዎ ይላካል። እባክዎን መለያዎን ለማረጋገጥ ኢሜሎን ያንኩ።"; ?></p>

    <h1><?php echo $lang == "en" ? "Who can access the Website?" : "ድህረገፁን ማግኘት የሚችሉ ማን ናቸው?"; ?></h1>
    <p>
        <li><?php echo $lang == "en" ? "Guest user of the Health Insurance can access the pages About us and Help" : "የጤና መድን እንግዳ ተጠቃሚ የስለ እኛ እና የእርዳታ ገጾችን ማግኘት ይችላል"; ?></li>
        <li><?php echo $lang == "en" ? "External user who wants to Customer our Hospital can verify their Certificate by registering Hospital Card Officer and Customer to be Customer in a given Agency." : "ውጪ ተጠቃሚ ሆኖ በሆስፒታሉ ውስጥ ደንበኛ ለመሆን የሚፈልጉ በሆስፒታሉ የካርድ ባለሙያና ደንበኛ በምዝገባ ማረጋገጫ ማድረግ ይችላሉ።"; ?></li>
        <li><?php echo $lang == "en" ? "Administrator" : "አስተዳዳሪ"; ?></li>
        <li><?php echo $lang == "en" ? "Hospital HI Officer" : "የሆስፒታል ጤና መድን ባለሙያ"; ?></li>
        <li><?php echo $lang == "en" ? "Kebele Manager" : "የቀበሌ አስተዳዳሪ"; ?></li>
        <li><?php echo $lang == "en" ? "Customer" : "ደንበኛ"; ?></li>
        <li><?php echo $lang == "en" ? "Health Insurance Manager" : "የጤና መድን አስተዳዳሪ"; ?></li>
    </p>

  </div>
</body>
</html>
