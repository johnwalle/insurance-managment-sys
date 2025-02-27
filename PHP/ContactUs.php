<?php
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
    $stmt = $conn->prepare("INSERT INTO messeage (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
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
    <title>Contact Us | Gondar Health Insurance</title>
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
                <div class="site-name">Gondar CBHI</div>
            </div>
        
            <div class="middle-list">
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="./package.php">Packages</a></li>
                    <li><a href="#" class="action">Contact us</a></li>
                    <li><a href="./about.php">About us</a></li>
                </ul>
            </div>
        
            <div class="right-section">
                <div class="buttons">
                    <button>Sign up</button> 
                    <button>Login</button>
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
                        Address
                    </div>
                    <div class="details">
                        <a href="#"> Gondar Amhara Ethiopia.</a>
                    </div>
                </div>

                <div class="contact">
                    <div class="card">
                        <img src="../Images/phone.png" >
                        Contact Number
                    </div>
                    <div class="details">
                        <a href="#"> +251707949412.</a>
                    </div>
                </div>

                <div class="mail">
                    <div class="card">
                        <img src="../Images/email.png" >
                        General Support
                    </div>
                    <div class="details">
                        <a href="#">Gondarhealthinfo@gmail.com</a>
                    </div>
                </div>
            </div>      
        </div>

        <div class="container">     
            <div class="middle-picture">
                <div class="caption">Let's Talk About Everything </div>
                <img src="../Images/picture.png">
        
                <div class="icon-bar">
                    <div class="icon">
                        <a href="https://www.facebook.com" class="image"> <img src="../Images/facebook.png" ></a>
                        <div class="tooltip">Facebook</div>
                    </div>        
                    <div class="icon">
                        <a href="https://twitter.com" class="image"><img src="../Images/twitter.png" ></a>
                        <div class="tooltip">Twitter</div>
                    </div>
        
                    <div class="icon">
                        <a href="https://linkedin.com" class="image" ><img src="../Images/linkedin1.png" ></a>
                        <div class="tooltip">linkedIn</div>
                    </div>

                    <div class="icon">
                        <a href="https://www.instagram.com" class="image"><img src="../Images/instagram.png" ></a>
                        <div class="tooltip">Instagram</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="right-content"> 
            <div class="right-container">
                <div class="message-text">
                    Send us a Message
                </div>  

                <!-- Form starts here -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="name">
                        <label for="name">Name <input type="text" name="name" required></label>
                    </div>

                    <div class="email">
                        <label for="mail">Email <input type="email" name="email" required></label>
                    </div>

                    <div class="phone">
                        <label for="phone">Phone Number <input type="tel" maxlength="10" name="phone" required></label>
                    </div>

                    <div class="subject">
                        <label for="subject">Subject <input type="text" name="subject"></label>
                    </div>

                    <div class="message">
                        Message 
                        <textarea name="message" cols="40" rows="8" required></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit">
                        <img src="../Images/send.png" alt="Send">
                        Send
                    </button>
                </form>
                <!-- Form ends here -->
            </div>
        </div>
    </div>
</body>
</html>
