<?php
session_start();
include "db_conn.php";

// Initialize variables to store input data for re-population on error
$name = $lname = $email = $phone = $bday = $gender = $subCity = $kebele = $homeNo = $username = "";

// Process the form when submitted
if (isset($_POST['submit'])) {
    // Get form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $bday = mysqli_real_escape_string($conn, $_POST['bday']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $subCity = mysqli_real_escape_string($conn, $_POST['sub_city']);
    $kebele = mysqli_real_escape_string($conn, $_POST['kebele']);
    $homeNo = mysqli_real_escape_string($conn, $_POST['homeno']);
    $username = mysqli_real_escape_string($conn, $_POST['uname']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $rePassword = mysqli_real_escape_string($conn, $_POST['re_password']);
    $userType = "User"; // Default user type

    // Validate password match
    if ($password !== $rePassword) {
        $error = "Passwords do not match";
    } else {
        // Check if email or username already exists
        $emailCheckQuery = "SELECT * FROM Users WHERE Email = '$email'";
        $emailCheckResult = mysqli_query($conn, $emailCheckQuery);
        
        if (mysqli_num_rows($emailCheckResult) > 0) {
            $error = "Email already exists";
        } else {
            $usernameCheckQuery = "SELECT * FROM Users WHERE Username = '$username'";
            $usernameCheckResult = mysqli_query($conn, $usernameCheckQuery);

            if (mysqli_num_rows($usernameCheckResult) > 0) {
                $error = "Username already exists";
            } else {
                // Hash password before storing in the database
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert new user into the database
                $insertQuery = "INSERT INTO Users (Username, FirstName, LastName, Email, Phone, SubCity, Kebele, HomeNo, BirthDate, Gender, Password, UserType)
                                VALUES ('$username', '$name', '$lname', '$email', '$phone', '$subCity', '$kebele', '$homeNo', '$bday', '$gender', '$hashedPassword', '$userType')";

                if (mysqli_query($conn, $insertQuery)) {
                    // Success message, no redirect
                    $success = "Registration successful! Please log in.";
                } else {
                    $error = "Something went wrong, please try again.";
                }
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
    <script src="../JS/registerJS.js"></script>
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">

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

        #bday {
            margin-bottom: 15px;
        }

        #country {
            margin-bottom: 15px;
        }

        #name-feild {
            margin-bottom: 10px;
        }

        .back-home-btn {
            display: block;
            margin: 20px auto;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Back to Home Button (Visible only after successful registration) -->
        <?php if (isset($success)) { ?>
            <div class="back-home-btn">
                <a href="index.php" style="background-color: #0ec138; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Back to Home</a>
            </div>
        <?php } ?>

        <span class="icon-close"><a href="./kebeleManager.php" style="color: white;"><ion-icon name="close"></ion-icon></a></span>
        <div class="form-box register">
            <h2>Registration</h2>
            <form action="kebeleManager.php" id="form" method="POST" onsubmit="return checkPassword()">

                <?php if (isset($error)) { ?>
                    <p id="error"><?php echo $error; ?></p>
                <?php } ?>

                <?php if (isset($success)) { ?>
                    <p id="success"><?php echo $success; ?></p>
                <?php } ?>

                <div class="input-box">
                    <label for="name">Name</label>
                    <div class="column">
                        <input type="text" name="name" placeholder="First Name" required id="name-feild" value="<?php echo $name; ?>"><br>
                        <input type="text" name="lname" placeholder="Last Name" required value="<?php echo $lname; ?>"><br>
                    </div>
                </div>

                <div class="input-box">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="ex: myName@gmail.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}" required value="<?php echo $email; ?>">
                </div>

                <div class="column">
                    <div class="input-box">
                        <label for="phoneNumber">Phone Number</label>
                        <input type="phone" name="phone" placeholder="xxxxxxxxxx" pattern="[0-9]{10}" required value="<?php echo $phone; ?>">
                    </div>

                    <div class="input-box">
                        <label for="birthday">Date of Birth</label>
                        <input type="date" name="bday" id="bday" required value="<?php echo $bday; ?>">
                    </div>
                </div>

                <div class="gender-box">
                    <h3>Gender</h3>
                    <div class="gender-option">
                        <div class="gender">
                            <input type="radio" id="check-male" name="gender" value="Male" <?php echo ($gender == 'Male') ? 'checked' : ''; ?>>
                            <label for="check-male">Male</label>
                        </div>
                        <div class="gender">
                            <input type="radio" id="check-female" name="gender" value="Female" <?php echo ($gender == 'Female') ? 'checked' : ''; ?>>
                            <label for="check-female">Female</label>
                        </div>
                    </div>
                </div>

                <div class="input-box">
                    <label for="address">Address</label>
                    <div class="column">
                        <input type="text" name="sub_city" placeholder="Sub City" required value="<?php echo $subCity; ?>">
                        <input type="text" name="kebele" placeholder="Kebele" required value="<?php echo $kebele; ?>">
                        <input type="text" name="homeno" placeholder="Home No" required value="<?php echo $homeNo; ?>">
                    </div>
                </div>

                <!-- Hidden input to default the user type to "User" -->
                <input type="hidden" name="usertype" value="User">

                <div class="input-box">
                    <label for="username">Username</label>
                    <input type="text" name="uname" placeholder="Username" required value="<?php echo $username; ?>"><br>
                </div>

                <div class="input-box">
                    <label for="password">Password</label>
                    <input type="password" id="pwd" name="password" placeholder="Password" required>
                </div>

                <div class="input-box">
                    <label for="reEnterPassword">Re-Enter Password</label>
                    <input type="password" id="cnfrmpwd" name="re_password" placeholder="Re-Enter Password" required>
                </div>

                <div class="check">
                    <input type="checkbox" class="inputStyle" id="checkbox" onclick="enableButton()"> I have read and agree to the <a href="./Terms and Conditions.php" class="link">Terms & Conditions</a>
                </div>

                <input type="submit" value="Register" name="submit" id="submitBtn" disabled>

                <div class="line"></div>

            </form>
        </div>

        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>
</html>
