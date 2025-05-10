<?php 
ob_start();  // Start output buffering
// Include header file
include 'header_Before_login.php'; 
$lang = "en"; // Default language is English
if (isset($_GET['lang']) && $_GET['lang'] == 'am') {
    $lang = "am"; // Switch to Amharic if 'lang=am' is in the URL
}
// Language switching logic
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'am'])) {
    $lang = $_GET['lang'];
    setcookie('lang', $lang, time() + (86400 * 30), '/'); // Cookie expires in 30 days
    $_COOKIE['lang'] = $lang; // Update the current request with the new language
} elseif (isset($_COOKIE['lang'])) {
    $lang = $_COOKIE['lang'];
} else {
    $lang = 'en'; // Default language
}

// Define translations
$translations = [
    'en' => [
        'quote' => 'Your Health, Our Priority – Protecting Lives, Empowering Futures.',
        'about_us' => 'About Us',
        'about_desc' => 'CBHI Tepi is a community-based health insurance initiative dedicated to providing affordable and accessible health insurance coverage to the people of Tepi. Our mission is to improve the health and well-being of our community by offering comprehensive health insurance plans tailored to meet local needs.',
        'about_button' => 'Click for more',
        'packages' => 'Packages',
        'packages_desc' => 'Health insurance packages provide individuals and families with essential financial protection and access to quality healthcare services. These packages are designed to offer a range of coverage options to cater to different needs and budgets. Whether you\'re seeking basic coverage for routine check-ups and preventive care or comprehensive protection for unexpected medical expenses, health insurance packages are tailored to provide peace of mind and ensure that you receive the necessary medical care when you need it most.',
        'providers' => 'Health Insurance Providers',
        'providers_desc' => 'Health care providers play a vital role in the healthcare ecosystem by offering a wide range of services, including preventive care, diagnostics, surgeries, rehabilitation, and ongoing medical management. They may specialize in specific fields such as primary care, cardiology, pediatrics.',
    ],
    'am' => [
        'quote' => 'ጤናዎት፣ እኛን በተጠቃላሊ ነው። – ሕይወትን እኰንደገና መታገስ፣ ሁሉንም አብሮአት መስበር።',
        'about_us' => 'ስለእኛ',
        'about_desc' => 'CBHI Tepi ከተማዪቱ ጤና መድኃኒት ተሳትፎ የሚሰጥ ሙሉ ጤና መድኃኒት በተሞላ እና በማዕከል ያለ ድርጅት ነው። ተፈጻሚ ሕግ ሁኔታዎቻችንን ለአሳየኝ እና ሙሉ ሕጉን በማሳሰባት ሕይወታችንን የምንገናኛቸውን እኛ ሁሉንም ይማረክ።',
        'about_button' => 'ተጨማሪ መረጃ',
        'packages' => 'ፓኬጆቻችን',
        'packages_desc' => 'ጤና መድኃኒት ፓኬጆች ለግለሰቦችና ለቤተሰቦች ከበለጠ ተገቢ ጉዳዮችን እና የተለያዩ ተመን ግምት ማከማቻ እና በሥነ ጥበብ ጤና ስርዓቶች ይሰጡ። የሕብረተሰቡን ቅርጸታቸው ለመከታተል እና የተለያዩ ሀምሌሞችን ማድረግ እና ስርአተ ስምትን በትክክል የማንኛውም ሰው ማግኘትን በማከታተል ምንም ያልተሰጠ የሚሆንን ምርት የመድኃኒት ተለዋዋጭ ይሆናሉ።',
        'providers' => 'እኛን አቅራቢዎች',
        'providers_desc' => 'ሕግ አቅራቢዎች በጤና በስራ በማስከበር እና በተቃም ትርፍ በሚሰጡ ምርጥ ባለበት ማሳሰብ።',
    ],
];

// Select the appropriate translations based on the user's language
$selected_translations = $translations[$lang];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/home.css">
    <link rel="icon" type="image/x-icon" href="./Images/logooo.png">
    <title> Tepi Health Insurance </title>
    <style>
        #indexbody{
            max-width:100%;
            padding: 0;
            margin: 0;
            overflow-x: hidden;
        }
        #quote1 {
            font-size: 40px; /* Decreased font size */
        }
    </style>
</head>
<body id="indexbody" style="max-width:100%;">
    <div class="slideshow-container" style="background-color: blue;">
        <div class="mySlides fade" style="margin-top:70px;">
            <img src="./Images/minstry.jpg" style="width: 1200px; height: 312px;">
        </div>
        <div class="mySlides fade" style="margin-top:70px;">
            <img src="./Images/abebe.JPG" style="width: 1200px; height: 312px;">
        </div>
        <div class="mySlides fade" style="margin-top:70px;">
            <img src="./Images/86.JPG" style="width: 1200px; height: 312px;">
        </div>
        <div class="mySlides fade" style="margin-top:70px;">
            <img src="./Images/16.png" style="width: 1200px; height: 312px;">
        </div>
    </div>

    <br>

    <div style="text-align:center">
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>

    <!-- Quote -->
    <div class="quote1">
        <h3 id="quote1"><?= htmlspecialchars($selected_translations['quote']) ?></h3>
    </div>

    <!-- About Us Section -->
    <section class="container1" id="about_in_home">
        <div class="image1">
            <img id="about_img" src="./Images/design.jpg">
        </div>
        <div class="text1">
            <span id="aboutus"><?= htmlspecialchars($selected_translations['about_us']) ?></span>
            <div class="textbox1">
                <p id="para1"><?= htmlspecialchars($selected_translations['about_desc']) ?></p>
                <a href="./PHP/about.php"><button id="aboutbttn" style="margin-right:100px;"><?= htmlspecialchars($selected_translations['about_button']) ?></button></a>
            </div>
        </div>
    </section>

    <div class="container2">
        <section id="pkgsection">
            <div class="text2">
                <h2 id="packages"><?= htmlspecialchars($selected_translations['packages']) ?></h2>
                <div id="packageimage">
                    <img id="package_img" src="./Images/87.jpg" style="margin-top:50px;">
                </div>
                <div class="textbox2">
                    <p id="para2"><?= htmlspecialchars($selected_translations['packages_desc']) ?></p>
                </div>
            </div>
        </section>
    </div>

    <section id="provider-section">
        <div class="container3">
            <div class="text3">
                <h2 id="providers"><center><?= htmlspecialchars($selected_translations['providers']) ?></center></h2><br><br>
                <div id="providerimage">
                    <img id="provider_img" src="./Images/minstry.jpg">
                    <img id="provider_img" src="./Images/who.jpg">
                    <br>
                </div>
                <div class="textbox3">
                    <p id="para3"><?= htmlspecialchars($selected_translations['providers_desc']) ?></p>
                </div>
            </div>
        </div>
    </section>

    <br><br>

    <?php include "footer.php"; include "cookie_banner.php"; ?>

    <script src="./JS/home.js"></script>
</body>
</html>
