<?php
session_start();
include "db_conn.php"; // Include your database connection file

// Function to hash the password
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

$error = ""; // Initialize error variable
$success = ""; // Initialize success variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
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

    // Password validation
   
    if ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        $error = "Password must be at least 8 characters long, include at least one uppercase letter, one lowercase letter, one number, and one special character.";
    }
    
    else {
    // Check if the email already exists
    $emailCheck = "SELECT * FROM Users WHERE Email='$email'";
    $emailResult = mysqli_query($conn, $emailCheck);

    // Check if the username already exists
    $usernameCheck = "SELECT * FROM Users WHERE Username='$username'";
    $usernameResult = mysqli_query($conn, $usernameCheck);

    if (mysqli_num_rows($emailResult) > 0) {
        $error = "Email already exists.";
    } elseif (mysqli_num_rows($usernameResult) > 0) {
        $error = "Username already exists. Please choose another one.";
    } else {
        // Insert the user data into the database
        $hashedPassword = hashPassword($password);
        $sql = "INSERT INTO Users (FirstName, LastName, Email, Phone, BirthDate, Gender, SubCity, Kebele, HomeNo, Username, Password, UserType) 
                VALUES ('$firstName', '$lastName', '$email', '$phone', '$bday', '$gender', '$subCity', '$kebele', '$homeNo', '$username', '$hashedPassword', '$userType')";

        if (mysqli_query($conn, $sql)) {
            // If successful
            $success = "Account created successfully. Redirecting to login page...";
            header("Refresh:3; url=login.php"); // Redirect after 3 seconds
            exit();
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Gondar Health Insurance</title>
    <link rel="stylesheet" type="text/css" href="../CSS/registerStyles.css">
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <script type="module" src="https://unpkg.com/@ionic/core/dist/ionic/ionic.esm.js"></script>
<script nomodule src="https://unpkg.com/@ionic/core/dist/ionic/ionic.js"></script>

   <style>
        /* Error and success styles */
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

        /* Input fields styles */
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

        /* Gender section styles */
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

        /* Submit button styles */
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

        /* Wrapper styles */
        .wrapper {
            max-width: 700px;
            margin: 50px auto;
            background:rgba(248, 248, 248, 0.6);
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

        /* Close icon styles */
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

</span>

        <div class="form-box register">
            <h2>Registration</h2>

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
                    <label for="name">Name</label>
                    <div class="column">
                        <input type="text" name="name" placeholder="First Name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" required>
                        <input type="text" name="lname" placeholder="Last Name" value="<?php echo isset($_POST['lname']) ? $_POST['lname'] : ''; ?>" required>
                    </div>
                </div>

                <!-- Email Input -->
                <div class="input-box">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" placeholder="example@gmail.com" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
                </div>

                <!-- Phone Input -->
                <div class="input-box">
                    <label for="phoneNumber">Phone Number</label>
                    <input type="phone" name="phone" placeholder="1234567890" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>" required>
                </div>

                <!-- Date of Birth -->
                <div class="input-box">
                    <label for="birthday">Date of Birth</label>
                    <input type="date" name="bday" value="<?php echo isset($_POST['bday']) ? $_POST['bday'] : ''; ?>" required>
                </div>

                <!-- Gender -->
                <div class="gender-box">
                    <label>Gender</label>
                    <div class="gender-option">
                        <input type="radio" name="gender" value="Male" <?php echo (!isset($_POST['gender']) || $_POST['gender'] === 'Male') ? 'checked' : ''; ?>> Male
                        <input type="radio" name="gender" value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Female') ? 'checked' : ''; ?>> Female
                    </div>
                </div>

                <!-- Address -->
                <div class="input-box">
                    <label for="address">Address</label>
                    <input type="text" name="sub_city" placeholder="Sub City" value="<?php echo isset($_POST['sub_city']) ? $_POST['sub_city'] : ''; ?>" required>
                    <input type="text" name="kebele" placeholder="Kebele" value="<?php echo isset($_POST['kebele']) ? $_POST['kebele'] : ''; ?>" required>
                    <input type="text" name="homeno" placeholder="Home No" value="<?php echo isset($_POST['homeno']) ? $_POST['homeno'] : ''; ?>" required>
                </div>

                <!-- Username Input -->
                <div class="input-box">
                    <label for="username">Username</label>
                    <input type="text" name="uname" placeholder="Username" value="<?php echo isset($_POST['uname']) ? $_POST['uname'] : ''; ?>" required>
                </div>

                <!-- Password Input -->
                <div class="input-box">
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <!-- Confirm Password -->
                <div class="input-box">
                    <label for="reEnterPassword">Re-Enter Password</label>
                    <input type="password" name="re_password" placeholder="Re-Enter Password" required>
                </div>

                <input type="hidden" name="usertype" value="User">

                <!-- Submit Button -->
                <input type="submit" value="Register" name="submit">
            </form>
        </div>
    </div>
</body>
</html>
