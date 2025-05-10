<?php

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $lang == 'en' ? 'Explore our range of comprehensive health insurance packages tailored to meet your specific needs.' : 'ወደ ልዩ ፍላጎቶቻችሁ የተቀመጡ የጤና መስጠት ፓኬጆቻችንን ያስሱ።'; ?>">
    <title><?php echo $lang == "en" ? "Packages | Tepi Health Insurance" : "ፓኬጆች | ቴፒ የጤና መስጠት"; ?></title>
    <link rel="stylesheet" href="../CSS/packageStyles.css">
    <link rel="icon" type="image/x-icon" href="./Images/logooo.png">
</head>
<body>
<div class="main-content">
        <h1 id="mainTopic"><?php echo $lang == "en" ? "Packages" : "ፓኬጆች"; ?></h1>
        <p class="description">
         <?php echo $lang == "en" ? "Welcome to our Health Insurance Packages page! We offer a range of comprehensive health insurance packages tailored to meet your specific needs. Each package provides different levels of coverage to ensure that you have access to the necessary healthcare services and support. Our packages are designed to be flexible, affordable, and easy to understand." : "ወደ የጤና መስጠት ፓኬጆቻችን ገፅ እንኳን በደህና መጡ! ለተለያዩ ፍላጎቶቻችሁ የተስተካከሉ የጤና መስጠት ፓኬጆችን እናቀርባለን። እያንዳንዱ ፓኬጅ የተለያዩ የማስተካከያ ደረጃዎችን ይሰጣል፣ እንዲሁም ወደ አስፈላጊ የጤና አገልግሎቶች እና ድጋፍ መድረስን ያረጋግጣል። ፓኬጆቻችን ተስማሚ፣ ተመናጭ እና ቀላል እንዲሆኑ ተዘጋጅተዋል።";?>
            </p>
    </div>
    
    <hr>
    <div>
    <h2 class="pack-heading"><u><?php echo $lang == "en" ? "Health Insurance Plans Offered" : "የቀረቡ የጤና መስጠት እቅዶች"; ?></u>
    </h2>

        <div class="packages">
            <div class="pack">
            <h3 class="pack-sub-head"> <?php echo $lang == "en" ? "Monthly Package" : "ወርሃዊ ፓኬጅ"; ?>
            </h3>
            <ul>
                <li><?php echo $lang == "en" ? "Coverage for hospitalization expenses" : "የሆስፒታል ክፍያዎች ሽፋን"; ?></li>
                <li><?php echo $lang == "en" ? "Regular health check-ups" : "መደበኛ የጤና ምርመራዎች"; ?></li>
                <li><?php echo $lang == "en" ? "Prescription medication coverage" : "የሕክምና መድሀኒት ሽፋን"; ?></li>
                <li><?php echo $lang == "en" ? "Dental and vision coverage" : "የጥርስ እና የአይነት አገልግሎት ሽፋን"; ?></li>
                <li><?php echo $lang == "en" ? "Specialist consultations" : "የስፔሻሊስቶች አማካይነት"; ?></li>
            </ul>

            <p class="price"><?php echo $lang == "en" ? "30 birr/month" : "30 ብር/ወር"; ?></p>
            <center><a href="payment.php"><button class="pack-btn"><?php echo $lang == "en" ? "Get" : "ይውሰዱ"; ?></button></a></center>

            </div>
    
            <div class="pack">
            <h3 class="pack-sub-head">
                <?php echo $lang == "en" ? "Yearly Package" : "ዓመታዊ ፓኬጅ"; ?>
            </h3>
            <ul>
                <li><?php echo $lang == "en" ? "Coverage for hospitalization expenses" : "የሆስፒታል ክፍያዎች ሽፋን"; ?></li>
                <li><?php echo $lang == "en" ? "Regular health check-ups" : "መደበኛ የጤና ምርመራዎች"; ?></li>
                <li><?php echo $lang == "en" ? "Prescription medication coverage" : "የሕክምና መድሀኒት ሽፋን"; ?></li>
                <li><?php echo $lang == "en" ? "Dental and vision coverage" : "የጥርስ እና የአይነት አገልግሎት ሽፋን"; ?></li>
                <li><?php echo $lang == "en" ? "Specialist consultations" : "የስፔሻሊስቶች አማካይነት"; ?></li>
            </ul>
            <p class="price"><?php echo $lang == "en" ? "330 birr/year" : "330 ብር/ዓመት"; ?></p>
            <center><a href="payment.php"><button class="pack-btn"><?php echo $lang == "en" ? "Get" : "ይውሰዱ"; ?></button></a></center>

            </div>
        </div>
    </div>
<hr>
    <div class="ben-details">
    <h3 class="ben-sub-head">
        <?php echo $lang == "en" ? "Health Insurance Benefits" : "የጤና መስጠት ጥቅሞች"; ?>
    </h3>
    <div class="icons">
        <div class="ic">
            <p class="ic-des"><?php echo $lang == "en" ? "Medical Services Coverage" : "የሕክምና አገልግሎቶች ሽፋን"; ?></p>

                <img src="../Images/ic1_pkg.png" alt="Medical Services Coverage" class="ic-img">
            </div>
            <div class="ic">
            <p class="ic-des"><?php echo $lang == "en" ? "Prescription Drug Coverage" : "የመድሀኒት ሽፋን"; ?></p>

                <img src="../Images/ic2_pkg.png" alt="Prescription Drug Coverage" class="ic-img">
            </div>
            <div class="ic">
            <p class="ic-des"><?php echo $lang == "en" ? "Mental Health Services" : "የአእምሮ ጤና አገልግሎቶች"; ?></p>
                <img src="../Images/ic3_pkg.png" alt="Mental Health Services" class="ic-img">
            </div>
            <div class="ic">
            <p class="ic-des"><?php echo $lang == "en" ? "Laboratory and Diagnostic Tests" : "የላቦራቶሪ እና የምርመራ ሙከራዎች"; ?></p>
                <img src="../Images/ic4_pkg.png" alt="Laboratory and Diagnostic Tests" class="ic-img">
            </div>
            <div class="ic">
            <p class="ic-des"><?php echo $lang == "en" ? "Maternity and Childbirth Benefits" : "የእናትነት እና የልደት ጥቅሞች"; ?></p>
                <img src="../Images/ic5_pkg.png" alt="Maternity and Childbirth Benefits" class="ic-img">
            </div>
           
        </div>
    </div>

    <hr>

  
</body>
</html>