<!DOCTYPE html>
<?php
// Enable PHP error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// PHPMailer setup
require __DIR__ . '/../PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/../PHPMailer-master/src/SMTP.php';
require __DIR__ . '/../PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
include "db_conn.php";
include "header_Before_login.php";

// Language switcher
$lang = "en";
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'am'])) {
    $lang = $_GET['lang'];
    setcookie('lang', $lang, time() + (86400 * 30), '/');
    $_COOKIE['lang'] = $lang;
} elseif (isset($_COOKIE['lang'])) {
    $lang = $_COOKIE['lang'];
}

// Function to hash the password
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // echo "Form submitted.<br>";

    $firstName = mysqli_real_escape_string($conn, $_POST['name']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $bday = mysqli_real_escape_string($conn, $_POST['bday']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $subCity = mysqli_real_escape_string($conn, $_POST['sub_city']);
    $kebele = mysqli_real_escape_string($conn, $_POST['kebele']);
    $homeNo = mysqli_real_escape_string($conn, $_POST['homeno']);
    $username = mysqli_real_escape_string($conn, $_POST['uname']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['re_password']);
    $userType = mysqli_real_escape_string($conn, $_POST['usertype']);

    if ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        $error = "Password must be at least 8 characters long and include one uppercase, one lowercase, one number, and one special character.";
    } else {
        $emailCheck = "SELECT * FROM Users WHERE Email='$email'";
        $usernameCheck = "SELECT * FROM Users WHERE Username='$username'";
        $emailResult = mysqli_query($conn, $emailCheck);
        $usernameResult = mysqli_query($conn, $usernameCheck);

        if (mysqli_num_rows($emailResult) > 0) {
            $error = "Email already exists.";
        } elseif (mysqli_num_rows($usernameResult) > 0) {
            $error = "Username already exists. Please choose another.";
        } else {
            $verification_token = bin2hex(random_bytes(16));
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO Users (FirstName, LastName, Email, Phone, BirthDate, Gender, SubCity, Kebele, HomeNo, Username, Password, UserType, VerificationToken, IsVerified) 
                    VALUES ('$firstName', '$lastName', '$email', '$phone', '$bday', '$gender', '$subCity', '$kebele', '$homeNo', '$username', '$hashedPassword', '$userType', '$verification_token', 0)";

if (mysqli_query($conn, $sql)) {
    $verification_link = "http://localhost/insurance-managment-sys/PHP/verify_email.php?token=$verification_token";

    echo "<script>console.log('DEBUG: User registered successfully. Preparing email...');</script>";

    $mail = new PHPMailer(true);
    echo "<script>console.log('DEBUG: PHPMailer initialized');</script>";
    
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'fastxdelivery7@gmail.com';
        $mail->Password   = 'dyjd gnzu geqk mqiq';  // Be careful with exposing this
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('fastxdelivery7@gmail.com', 'FastX Delivery');
        $mail->addAddress($email, $firstName);

        $mail->isHTML(true);
$mail->Subject = "Email Verification for Your Account";
$mail->Body = "
    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; background-color: #f9f9f9;'>
        <h2 style='color: #333;'>Email Verification</h2>
        <p>Hi <strong>$firstName</strong>,</p>
        <p>Thank you for registering! Please verify your email by clicking the button below:</p>
        
        <a href='$verification_link' style='
            display: inline-block;
            padding: 12px 24px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 6px;
        '>Confirm Email</a>
        
        <p style='margin-top: 30px;'>If the button doesn't work, copy and paste this link into your browser:</p>
        <p style='word-break: break-all;'>$verification_link</p>

        <p style='margin-top: 30px;'>Thanks,<br>Tepi CBHI Team</p>
    </div>
";

        echo "<script>console.log('DEBUG: Sending email to {$email}');</script>";

        if ($mail->send()) {
            echo "<script>console.log('DEBUG: Verification email sent successfully to {$email}');</script>";
            header("Location: email_confirmation_notice.php");
            exit();      
        } else {
            echo "<script>console.log('ERROR: Failed to send email. Mailer Error: " . addslashes($mail->ErrorInfo) . "');</script>";
            $error = "Failed to send email. Mailer Error: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "<script>console.log('EXCEPTION: " . addslashes($e->getMessage()) . "');</script>";
        $error = "Exception while sending email: " . $e->getMessage();
    }
} else {
    echo "<script>console.log('ERROR: Failed to register user: " . addslashes(mysqli_error($conn)) . "');</script>";
    $error = "Failed to register user: " . mysqli_error($conn);
}

        }
    }
}
?>

<!-- Display errors or success messages -->
<?php if ($error): ?>
    <div style="color: red; font-weight: bold;"><?= $error ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div style="color: green; font-weight: bold;"><?= $success ?></div>
<?php endif; ?>



<!DOCTYPE html>
<html lang="<?php echo $lang == 'en' ? 'en' : 'am'; ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang == 'en' ? 'Sign Up | Tepi Health Insurance' : 'መመዝገብ | ተፒ የጤና መድን'; ?></title>
    <link rel="stylesheet" type="text/css" href="../CSS/registerStyles.css">
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <script type="module" src="https://unpkg.com/@ionic/core/dist/ionic/ionic.esm.js"></script>
    <script nomodule src="https://unpkg.com/@ionic/core/dist/ionic/ionic.js"></script>


    <style>
        /* ስህተት እና ስኬት አሳይ ንድፍ */
        #error {
            background-color: #dd2020;
            color: white;
            padding: 10px;
            width: 95%;
            border-radius: 5px;
            margin: 20px auto;
            text-align: center;
        }

        #success {
            background: #0ec138;
            color: white;
            padding: 10px;
            width: 95%;
            border-radius: 5px;
            margin: 20px auto;
            text-align: center;
        }

        /* የማስገቢያ መስኮቶች ንድፍ */
        .input-box {
            margin-bottom: 20px;
        }

        .input-box label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .input-box input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
            outline: none;
        }

        .input-box input:focus {
            border-color: #0ec138;
        }

        .column {
            display: flex;
            gap: 15px;
        }

        /* ጾታ ክፍል ንድፍ */
        .gender-box {
            margin-bottom: 20px;
        }

        .gender-box label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .gender-option {
            display: flex;
            gap: 20px;
        }

        /* የመዝግብ አዝራር ንድፍ */
        input[type="submit"] {
            background-color: #0ec138;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:disabled {
            background-color: #ddd;
        }

        /* አንድነት ንድፍ */
        .wrapper {
            max-width: 700px;
            margin: 50px auto;
            background: rgba(248, 248, 248, 0.6);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-box {
            padding: 20px;
        }

        .form-box h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-box .login-register {
            text-align: center;
            margin-top: 20px;
        }

        .form-box .login-register p {
            margin: 0;
        }

        .form-box .login-register .link-login {
            color: #0ec138;
            text-decoration: none;
        }

        .form-box .login-register .link-login:hover {
            text-decoration: underline;
        }

        /* የመዝጊያ አዶ ንድፍ */
        .icon-close {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 30px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <span class="icon-close"><a href="../index.php" style="color: white;"><ion-icon name="close"></ion-icon></a></span>

        <div class="form-box register">
            <h2><?php echo $lang == 'en' ? 'Registration' : 'መመዝገብ'; ?></h2>

            <!-- Display Errors -->
            <?php if ($error): ?>
                <p id="error"><?php echo $error; ?></p>
            <?php endif; ?>

            <!-- Display Success -->
            <?php if ($success): ?>
                <p id="success"><?php echo $success; ?></p>
            <?php endif; ?>

            <form action="" method="POST">
                <!-- Name Input -->
                <div class="input-box">
                    <label for="name"><?php echo $lang == 'en' ? 'Name' : 'ስም'; ?></label>
                    <div class="column">
                        <input type="text" name="name" placeholder="<?php echo $lang == 'en' ? 'First Name' : 'ስም'; ?>" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" required>
                        <input type="text" name="lname" placeholder="<?php echo $lang == 'en' ? 'Last Name' : 'የአባት ስም'; ?>" value="<?php echo isset($_POST['lname']) ? $_POST['lname'] : ''; ?>" required>
                    </div>
                </div>

                <!-- Email Input -->
                <div class="input-box">
                    <label for="email"><?php echo $lang == 'en' ? 'E-mail' : 'ኢሜይል'; ?></label>
                    <input type="email" name="email" placeholder="example@gmail.com" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
                </div>

                <!-- Phone Input -->
                <div class="input-box">
                    <label for="phoneNumber"><?php echo $lang == 'en' ? 'Phone Number' : 'ስልክ ቁጥር'; ?></label>
                    <input type="phone" name="phone" placeholder="<?php echo $lang == 'en' ? '1234567890' : 'ስልክ ቁጥር ያስገቡ'; ?>" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>" required>
                </div>

                <!-- Date of Birth -->
                <div class="input-box">
                    <label for="birthday"><?php echo $lang == 'en' ? 'Date of Birth' : 'የትውልድ ቀን'; ?></label>
                    <input type="date" name="bday" value="<?php echo isset($_POST['bday']) ? $_POST['bday'] : ''; ?>" required>
                </div>

                <!-- Gender -->
                <div class="gender-box">
                    <label><?php echo $lang == 'en' ? 'Gender' : 'ፆታ'; ?></label>
                    <div class="gender-option">
                        <input type="radio" name="gender" value="Male" <?php echo (!isset($_POST['gender']) || $_POST['gender'] === 'Male') ? 'checked' : ''; ?>> <?php echo $lang == 'en' ? 'Male' : 'ወንድ'; ?>
                        <input type="radio" name="gender" value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Female') ? 'checked' : ''; ?>> <?php echo $lang == 'en' ? 'Female' : 'ሴት'; ?>
                    </div>
                </div>

                <!-- Address -->
                <div class="input-box">
                    <label for="address"><?php echo $lang == 'en' ? 'Address' : 'አድራሻ'; ?></label>
                    <input type="text" name="sub_city" placeholder="<?php echo $lang == 'en' ? 'Sub City' : 'ክ/ከተማ'; ?>" value="<?php echo isset($_POST['sub_city']) ? $_POST['sub_city'] : ''; ?>" required>
                    <input type="text" name="kebele" placeholder="<?php echo $lang == 'en' ? 'Kebele' : 'ቀበሌ'; ?>" value="<?php echo isset($_POST['kebele']) ? $_POST['kebele'] : ''; ?>" required>
                    <input type="text" name="homeno" placeholder="<?php echo $lang == 'en' ? 'Home No' : 'የቤት ቁጥር'; ?>" value="<?php echo isset($_POST['homeno']) ? $_POST['homeno'] : ''; ?>" required>
                </div>

                <!-- Username Input -->
                <div class="input-box">
                    <label for="username"><?php echo $lang == 'en' ? 'Username' : 'የተጠቃሚ ስም'; ?></label>
                    <input type="text" name="uname" placeholder="<?php echo $lang == 'en' ? 'Username' : 'የተጠቃሚ ስም'; ?>" value="<?php echo isset($_POST['uname']) ? $_POST['uname'] : ''; ?>" required>
                </div>

                <!-- Password Input -->
                <div class="input-box">
                    <label for="password"><?php echo $lang == 'en' ? 'Password' : 'የይለፍ ቃል'; ?></label>
                    <input type="password" name="password" placeholder="<?php echo $lang == 'en' ? 'Password' : 'የይለፍ ቃል'; ?>" required>
                </div>

                <!-- Confirm Password -->
                <div class="input-box">
                    <label for="reEnterPassword"><?php echo $lang == 'en' ? 'Re-Enter Password' : 'የይለፍ ቃልን ድጋሚ ያስገቡ'; ?></label>
                    <input type="password" name="re_password" placeholder="<?php echo $lang == 'en' ? 'Re-Enter Password' : 'የይለፍ ቃልን ድጋሚ ያስገቡ'; ?>" required>
                </div>

                <input type="hidden" name="usertype" value="User">

                <!-- Submit Button -->
                <input type="submit" value="<?php echo $lang == 'en' ? 'Register' : 'ይመዝገቡ'; ?>" name="submit">
            </form>
        </div>
    </div>
</body>

</html>
