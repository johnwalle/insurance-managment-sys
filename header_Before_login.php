<?php
session_start();

// Check if the language is set and store it in session
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Set the current language
$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en'; // Default to English if no language is selected

// Translation arrays
$translations = [
    'en' => [
        'home' => 'Home',
        'about' => 'About Us',
        'contact' => 'Contact Us',
        'packages' => 'Packages',
        'help' => 'Help',
        'greeting' => 'Hello, ',
        'signup' => 'Sign up',
        'login' => 'Login'
    ],
    'am' => [
        'home' => 'ማዕከል',
        'about' => 'ስለእኛ',
        'contact' => 'እኛን ያግኙ',
        'packages' => 'ፓኬጆች',
        'help' => 'እርዳታ',
        'greeting' => 'ሰላም, ',
        'signup' => 'ማስመዝገብ',
        'login' => 'ግባ'
    ]
];

// Use the translation array for the current language
$current_translation = $translations[$lang];
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="Images/logooo.png">
  <link rel="stylesheet" href="CSS/header_Before_login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    /* Your CSS remains unchanged */
    .header {
      position: fixed;
      top: 0;
      right: 0;
      left: 0;
      display: flex;
      align-items: center;
      justify-content: space-around;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.5);
      background-color: rgb(5, 61, 87);
      font-family: Arial, sans-serif;
      z-index: 1000;
    }

    .logo {
      display: flex;
      align-items: center;
      margin: 10px;
    }

    .logo .site-name {
      font-size: 22px;
      font-weight: bold;
      color: rgb(241, 241, 241);
      font-family: 'Play', sans-serif;
    }

    .logo img {
      width: 50px;
      object-fit: cover;
    }

    .middle-list {
      display: flex;
      justify-content: space-around;
      align-items: center;
    }

    .nav {
      list-style-type: none;
      padding: 0;
    }

    .nav li {
      float: left;
      margin-right: 10px;
      padding: 8px 15px;
      font-size: 17px;
      transition: color 0.4s;
    }

    .nav li a {
      text-decoration: none;
      color: rgb(85, 163, 157);
    }

    .nav li a:hover {
      color: rgb(219, 222, 228);
    }

    .buttons, .user-section {
      margin-left: 100px;
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .buttons button, .profile-btn {
      padding: 8px 15px;
      background-color: rgb(73, 138, 132);
      border: none;
      color: white;
      font-size: 15px;
      border-radius: 40px;
      cursor: pointer;
      transition: opacity 0.3s;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .buttons button:hover, .profile-btn:hover {
      opacity: 0.8;
    }

    .greeting {
      color: white;
      font-size: 16px;
      font-weight: bold;
    }

    .profile-btn i {
      font-size: 16px;
    }

    /* Language Dropdown Styling */
    .lang-switch {
      position: relative;
      display: inline-block;
    }

    .lang-switch select {
      padding: 8px 15px;
      background-color: rgb(73, 138, 132);
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }

    .lang-switch select:hover {
      background-color: #0056b3;
    }

    .lang-switch select:focus {
      outline: none;
    }
  </style>
</head>
<body>

  <div class="header">

    <div class="logo">
      <img src="./Images/logo.jpg">
      <div class="site-name">Tepi CBHI</div>
    </div>

    <div class="middle-list">
      <ul class="nav">
        <li><a href="index.php?lang=<?php echo $lang; ?>"><?php echo $current_translation['home']; ?></a></li>
        <li><a href="PHP/ContactUs.php?lang=<?php echo $lang; ?>" class="action"><?php echo $current_translation['contact']; ?></a></li>
        <li><a href="PHP/about.php?lang=<?php echo $lang; ?>"><?php echo $current_translation['about']; ?></a></li>
        <li><a href="PHP/package.php?lang=<?php echo $lang; ?>"><?php echo $current_translation['packages']; ?></a></li>
        <li><a href="PHP/help.php?lang=<?php echo $lang; ?>"><?php echo $current_translation['help']; ?></a></li>
      </ul>

      <div class="lang-switch">
        <form method="get" style="display: inline;">
          <select name="lang" onchange="this.form.submit()">
            <option value="en" <?php echo (isset($_SESSION['lang']) && $_SESSION['lang'] == 'en') ? 'selected' : ''; ?>>🇬🇧 English</option>
            <option value="am" <?php echo (isset($_SESSION['lang']) && $_SESSION['lang'] == 'am') ? 'selected' : ''; ?>>🇪🇹 አማርኛ</option>
          </select>
        </form>
      </div>
    </div>

    <?php if (isset($_SESSION['Username'])): ?>
    <div class="user-section">
      <div class="greeting"><?php echo $current_translation['greeting'] . htmlspecialchars($_SESSION['Username']); ?></div>
        
      <?php if ($_SESSION['Role'] == 'User'): ?>
          <a href="PHP/profilePage.php?lang=<?php echo $lang; ?>">
              <button class="profile-btn">
                  <i class="fas fa-user-circle"></i> My Profile
              </button>
          </a>
      <?php elseif ($_SESSION['Role'] == 'Admin'): ?>
          <a href="PHP/admin.php?lang=<?php echo $lang; ?>">
              <button class="profile-btn">
                  <i class="fas fa-cog"></i> Admin Panel
              </button>
          </a>
      <?php elseif ($_SESSION['Role'] == 'Hiofficier'): ?>
          <a href="PHP/hospitalOfficier.php?lang=<?php echo $lang; ?>">
              <button class="profile-btn">
                  <i class="fas fa-hospital"></i> Health Officer
              </button>
          </a>
      <?php elseif ($_SESSION['Role'] == 'KebeleManager'): ?>
          <a href="PHP/kebeleManager.php?lang=<?php echo $lang; ?>">
              <button class="profile-btn">
                  <i class="fas fa-users"></i> Kebele Manager
              </button>
          </a>
      <?php elseif ($_SESSION['Role'] == 'HealthInsuranceManager'): ?>
          <a href="PHP/healthInsuranceManager.php?lang=<?php echo $lang; ?>">
              <button class="profile-btn">
                  <i class="fas fa-shield-alt"></i> Health Insurance Manager
              </button>
          </a>
      <?php endif; ?>
    </div>
    <?php else: ?>
    <div class="buttons">
      <a href="PHP/signup.php?lang=<?php echo $lang; ?>"><button><?php echo $current_translation['signup']; ?></button></a>
      <a href="PHP/login.php?lang=<?php echo $lang; ?>"><button><?php echo $current_translation['login']; ?></button></a>
    </div>
    <?php endif; ?>

  </div>

</body>
</html>
