<?php
// Simple language selection logic
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
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang == "en" ? "About Us | CBHI Tepi" : "ስለእኛ |ቴፒ ሲቢኤችአይ"; ?></title>
    <link rel="stylesheet" type="text/css" href="../CSS/about.css">
    <link rel="icon" type="image/x-icon" href="/Images/logooo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
    <style>
      #aboutbody {
        margin-top: 70px;
      }
    </style>
</head>
<body>
  <div id="aboutbody">
    <div class="hero-image">
      <img src="../Images/banner.png" alt="Hero Image" style="width:100%">
    </div>

    <div class="heading1">
      <h1><?php echo $lang == "en" ? "Empowering Lives through Quality Health Insurance" : "በጥራት ጤና መስጠት ሕይወቶችን ማስተካከል"; ?></h1>
    </div>

    <div class="para1" style="padding: 50px 50px;background-color: aliceblue;margin-bottom: 50px;">
      <h1><?php echo $lang == "en" ? "Overview" : "እትም"; ?></h1>
      <h4><?php echo $lang == "en" ? "Who Are We?" : "እኛ ማን ነን?"; ?></h4>
      <p><?php echo $lang == "en" ? "CBHI Tepi is a community-based health insurance initiative dedicated to providing affordable and accessible health insurance coverage to the people of Tepi. Our mission is to improve the health and well-being of our community by offering comprehensive health insurance plans tailored to meet local needs." : "ቢሲኤችአይ ተፒ በማህበረሰብ የተመሠረተ ጤና መስጠት እቅድ ነው፣ በተፒ ሕዝብ ለማህበረሰቡ ተመን እና ተመሳሳይ በሆነ ጤና መስጠት ማስተካከል። ማህበረሰብ ጤናን እና ተመንነትን ማሻሻል በማህበረሰቡ የተሟላ ጤና መስጠት እቅዶች እንደተስተናገደ እንደአንድ ዓላማ ተሰርቷል።"; ?></p>
      <h4><?php echo $lang == "en" ? "What We Do" : "ምን እንደምን እንሰራ?"; ?></h4>
      <p><?php echo $lang == "en" ? "We offer a range of health insurance products designed to cover medical expenses, including outpatient and inpatient care, emergency services, and essential medications. Our goal is to make healthcare accessible and affordable for everyone in the Tepi area." : "በጤና እቅዶች ምንም ሆነ ምን አብሮኝ ስራው ተመላላሽ ተስተናገደ፣ ተመን እና ተመሳሳይ ጤናን ማስተካከል።"; ?></p>
    </div>

    <div class="row" style="justify-content: center; display: flex; box-sizing: border-box; margin-left: auto;">
      <!-- Card Structure for Vision, Mission, and Values -->
      <div class="card" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); transition: 0.3s; width: 20%; border-radius: 5px; padding: 50px 50px; margin-left:30px; margin-bottom: 50px; background-color:#54544a;">
        <div class="container1">
          <h4 id="headings-of-card"><b><center><?php echo $lang == "en" ? "Our Vision" : "ዕላማችን"; ?></center></b></h4> 
        </div>

        <div class="column">
          <a href="#"><img src="../Images/blue_eye.png" alt="Vision Icon" style="width:100%"></a>
        </div>

        <div class="container1">
          <h4><b><center><?php echo $lang == "en" ? "To provide accessible and comprehensive health insurance coverage to the Tepi community" : "በቴፒ ማህበረሰብ ለማህበረሰቡ ተመሳሳይ ጤና መስጠት ተስተናገደ እንደ አንድ እምነት ነው"; ?></center></b></h4> 
        </div>
      </div>

      <div class="card" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); transition: 0.3s; width: 20%; border-radius: 5px; padding: 50px 50px; margin-left:30px; margin-bottom: 50px; background-color:#54544a;">
        <div class="container1">
          <h4 id="headings-of-card"><b><center><?php echo $lang == "en" ? "Our Mission" : "ተልዕኮች"; ?></center></b></h4> 
        </div>

        <div class="column">
          <a href="#"><img src="../Images/red-flag.png" alt="Mission Icon" style="width:100%"></a>
        </div>

        <div class="container1">
          <h4><b><center><?php echo $lang == "en" ? "To be the leading provider of health insurance in Tepi, ensuring quality and reliability" : "በተፒ ስለተለያዩ እቅዶች ተመሳሳይ ጤና መስጠት"; ?></center></b></h4> 
        </div>
      </div>
      
      <div class="card" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); transition: 0.3s; width: 20%; border-radius: 5px; padding: 50px 50px; margin-left:30px; margin-bottom: 50px; background-color:#54544a;">
        <div class="container1">
          <h4 id="headings-of-card"><b><center><?php echo $lang == "en" ? "Our Values" : "አንደኛ እቅዶች"; ?></center></b></h4> 
        </div>

        <div class="column">
          <a href="#"><img src="../Images/diamond1.png" alt="Values Icon" style="width:100%"></a>
        </div>

        <div class="container1">
          <h4><b><center><?php echo $lang == "en" ? "Integrity, Excellence, Compassion, and Community Focus" : "ተመንነት፣ ተመንነት፣ ተንኮልነት፣ እና ማህበረሰብ ያህል"; ?></center></b></h4> 
        </div>
      </div>
    </div>

    <!-- Statistics Section -->
    <div id="wrapper1">
      <div class="wrapper">
        <div class="container">
          <i class="fas fa-utensils"></i>
          <img src="../Images/wall-clock.png" class="icon">
          <span class="num" data-val="13">000</span>
          <span class="text"><?php echo $lang == "en" ? "Years of Experience" : "አመታት ተሞክሮ"; ?></span>
        </div>

        <div class="container">
          <i class="fas fa-smile-beam"></i>
          <img src="../Images/branch.png" class="icon">
          <span class="num" data-val="12">000</span>
          <span class="text"><?php echo $lang == "en" ? "Cover Sub cities" : "የምእመናን ምንጭ"; ?></span>
        </div>

        <div class="container">
          <i class="fas fa-list"></i>
          <img src="../Images/insurance.png" class="icon">
          <span class="num" data-val="5">000</span>
          <span class="text"><?php echo $lang == "en" ? "Coverage Plans" : "ተሳማሚ ስም"; ?></span>
        </div>

        <div class="container">
          <i class="fas fa-star"></i>
          <img src="../Images/handshake.png" class="icon">
          <span class="num" data-val="31000">31,000</span> <!-- Updated value -->
          <span class="text"><?php echo $lang == "en" ? "Satisfied Customers" : "ተደርሷ የሆኑ ተንኮልአለና"; ?></span>
        </div>
      </div>
    </div>
    
    <script src="../JS/about.js"></script>
  </div>  
</body>
</html>
