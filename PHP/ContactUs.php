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
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "final_project";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Collect and sanitize form data
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $phone = $conn->real_escape_string(trim($_POST['phone']));
    $subject = $conn->real_escape_string(trim($_POST['subject']));
    $message = $conn->real_escape_string(trim($_POST['message']));

    // Prepare and bind the SQL statement to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO message_from_user (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

    // Execute the statement and check if successful
    if ($stmt->execute()) {
        echo "<p>Message sent successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang == "en" ? "Contact Us | Tepi Health Insurance" : "ያግኙን | ቴፒ ጤና መድን"; ?></title>
    <link rel="stylesheet" href="../CSS/ContactUs.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../Images/logooo.png">
</head>

<body>
    <div class="all-container"> 
        <div class="header">
            <div class="logo">
                <img src="../Images/logooo.png" >
                <div class="site-name"><?php echo $lang == "en" ? "Tepi CBHI" : "ቴፒ ሲቢኤችአይ"; ?></div>
            </div>
        
            <div class="middle-list">
            <ul>
                    <li><a href="../index.php"><?php echo $lang == "en" ? "Home" : "መነሻ"; ?></a></li>
                    <li><a href="./package.php"><?php echo $lang == "en" ? "Packages" : "ፓኬጆች"; ?></a></li>
                    <li><a href="#" class="action"><?php echo $lang == "en" ? "Contact us" : "ያግኙን"; ?></a></li>
                    <li><a href="./about.php"><?php echo $lang == "en" ? "About us" : "ስለ እኛ"; ?></a></li>
                </ul>
            </div>
        
            <div class="right-section">
            <div class="buttons">
                    <button><?php echo $lang == "en" ? "Sign up" : "ይመዝገቡ"; ?></button> 
                    <button><?php echo $lang == "en" ? "Login" : "ግባ"; ?></button>
                </div>

            </div>
        </div>

        <div class="sidebar">
            <div class="main-details">
                <div class="message-image">
                    <img src="../Images/callme1.jpg" style="width:75%;margin-left:30px;">
                </div>

                <div class="address">
                    <div class="card">
                        <img src="../Images/location.png" >
                        <?php echo $lang == "en" ? "Address" : "አድራሻ"; ?>                    </div>
                    <div class="details">
                    <a href="#"> <?php echo $lang == "en" ? "Tepi South Western Ethiopia." : "ተፒ፣ ደቡብ ምዕራባዊ ኢትዮጵያ።"; ?></a>                 
                </div>
                </div>

                <div class="contact">
                    <div class="card">
                        <img src="../Images/phone.png" >
                        <?php echo $lang == "en" ? "Contact Number" : "የእውቂያ ቁጥር"; ?>
                    </div>
                    <div class="details">
                    <a href="#"> +251938143654</a>
                    </div>
                </div>

                <div class="mail">
                    <div class="card">
                        <img src="../Images/email.png" >
                     <?php echo $lang == "en" ? "General Support" : "አጠቃላይ ድጋፍ"; ?>                 
                       </div>
                    <div class="details">
                    <a href="#">Tepihealthinfo@gmail.com</a>
                    </div>
                </div>
            </div>      
        </div>

        <div class="container">     
            <div class="middle-picture">
            <div class="caption"><?php echo $lang == "en" ? "Let's Talk About Everything" : "ስለ ሁሉም ነገር እንወያይ"; ?></div>
                <img src="../Images/picture.png">
        
                <div class="icon-bar">
                    <div class="icon">
                        <a href="https://www.facebook.com" class="image"> <img src="../Images/facebook.png" ></a>
                        <div class="tooltip"><?php echo $lang == "en" ? "Facebook" : "ፌስቡክ"; ?></div>
                        </div>        
                    <div class="icon">
                        <a href="https://twitter.com" class="image"><img src="../Images/twitter.png" ></a>
                        <div class="tooltip"><?php echo $lang == "en" ? "Twitter" : "ትዊተር"; ?></div>
                     </div>
        
                    <div class="icon">
                        <a href="https://linkedin.com" class="image" ><img src="../Images/linkedin1.png" ></a>
                        <div class="tooltip"><?php echo $lang == "en" ? "LinkedIn" : "ሊንኪድኢን"; ?></div>
                    </div>

                    <div class="icon">
                        <a href="https://www.instagram.com" class="image"><img src="../Images/instagram.png" ></a>
                        <div class="tooltip"><?php echo $lang == "en" ? "Instagram" : "ኢንስታግራም"; ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="right-content"> 
            <div class="right-container">
                <div class="message-text">
                    <?php echo $lang == "en" ? "Send us a Message" : "መልእክት ይላኩልን"; ?>
                </div>  

                <!-- Form starts here -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="name">
                        <label for="name"><?php echo $lang == "en" ? "Name" : "ስም"; ?> 
                        <input type="text" name="name" required></label>
                    </div>

                    <div class="email">
                        <label for="mail"><?php echo $lang == "en" ? "Email" : "ኢሜይል"; ?> 
                        <input type="email" name="email" required></label>
                    </div>

                    <div class="phone">
                        <label for="phone"><?php echo $lang == "en" ? "Phone Number" : "የስልክ ቁጥር"; ?> 
                        <input type="tel" maxlength="10" name="phone" required></label>
                    </div>

                    <div class="subject">
                        <label for="subject"><?php echo $lang == "en" ? "Subject" : "ርዕስ"; ?> 
                        <input type="text" name="subject"></label>
                    </div>

                    <div class="message">
                        <?php echo $lang == "en" ? "Message" : "መልእክት"; ?>
                        <textarea name="message" cols="40" rows="8" required></textarea>
                    </div>


                    <!-- Submit Button -->
                    <button type="submit">
                        <img src="../Images/send.png" alt="Send">
                        <?php echo $lang == "en" ? "Send" : "ላክ"; ?>
                    </button>
                </form>
                <!-- Form ends here -->
            </div>
        </div>
    </div>
</body>
</html>
