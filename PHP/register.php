<?php
session_start();
require_once "db_conn.php"; // Ensure your database connection is properly set here

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $fname = $_POST['name'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $bday = $_POST['bday'] ?? '';  // Date of birth (now "BirthDate")
    $gender = $_POST['gender'] ?? '';
    $sub_city = $_POST['sub_city'] ?? '';
    $kebele = $_POST['kebele'] ?? '';
    $homeno = $_POST['homeno'] ?? '';
    $usertype = $_POST['usertype'] ?? 'User'; 
    $uname = $_POST['uname'] ?? '';
    $password = $_POST['password'] ?? '';
    $re_password = $_POST['re_password'] ?? '';

    // Validate required fields
    if (empty($fname) || empty($lname) || empty($email) || empty($phone) || empty($bday) || empty($gender) || empty($uname) || empty($password) || empty($re_password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $re_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT * FROM Users WHERE Username = ?");
        $stmt->bind_param("s", $uname); // Bind the parameter (s = string)
        $stmt->execute();
        $stmt->store_result(); // Store the result to be able to check num_rows
        
        if ($stmt->num_rows > 0) {
            $error = "Username already exists.";
        } else {
            // Proceed with the registration process
            // Securely hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user into the database (using the correct column names from your schema)
            $sql = "INSERT INTO Users (FirstName, LastName, Email, Phone, BirthDate, Gender, SubCity, Kebele, HomeNo, UserType, Username, Password,Status) VALUES ('$fname', '$lname', '$email', '$phone', '$bday', '$gender', '$sub_city', '$kebele', '$homeno', '$usertype', '$uname', '$hashed_password','Deactivate')";
            if(mysqli_query($conn,$sql)){
                $_SESSION['id'] = $conn->insert_id;
                $success = "Registration successful! Redirecting...";
                header("refresh:2;url=admin.php"); 
                exit();
            }
            else {
                 $error = "Failed to register. Please try again.";
                }

            // $stmt->bind_param("",$fname, $lname, $email, $phone, $bday, $gender, $sub_city, $kebele, $homeno, $usertype, $uname, $hashed_password);

            // $success = $stmt->execute();

            // if ($success) {
            //     // Get user ID and start session
            //     $_SESSION['id'] = $conn->insert_id;
            //     $success = "Registration successful! Redirecting...";
            //     header("refresh:2;url=admin.php");  // Redirect after 2 seconds
            //     exit();
            // } else {
            //     $error = "Failed to register. Please try again.";
            // }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Tepi Health Insurance</title>
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <link rel="stylesheet" href="../CSS/registerStyles.css">
    <style>
        #wrapper__form {
            max-width: 700px;
            margin: 50px auto;
            background:rgba(248, 248, 248, 0.6);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        input[type="submit"]:active {
            background-color: #003366;
        }
    </style>
</head>
<body>
    <div class="wrapper" id="wrapper__form">

       

        <!-- Registration form -->
        <form action="register.php" method="POST">
             <!-- Display error or success messages -->
        <?php if ($error): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p style="color: green;"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>
        <h2>Registration</h2>

            <div class="input-box">
                <label>Full Name</label>
                <div class="column">
                    <input type="text" name="name" placeholder="First Name" value="<?= htmlspecialchars($fname) ?>" required>
                    <input type="text" name="lname" placeholder="Last Name" value="<?= htmlspecialchars($lname) ?>" required>
                </div>
            </div>

            <div class="input-box">
                <label>Email</label>
                <input type="email" name="email" placeholder="ex: myName@gmail.com" value="<?= htmlspecialchars($email) ?>" required>
            </div>

            <div class="column">
                <div class="input-box">
                    <label>Phone Number</label>
                    <input type="text" name="phone" placeholder="xxxxxxxxxx" value="<?= htmlspecialchars($phone) ?>" required>
                </div>
                <div class="input-box">
                    <label>Date of Birth</label>
                    <input type="date" name="bday" value="<?= htmlspecialchars($bday) ?>" required>
                </div>
            </div>

            <div class="gender-box">
                <h3>Gender</h3>
                <div class="gender-option">
                    <label><input type="radio" name="gender" value="Male" <?= $gender == 'Male' ? 'checked' : '' ?>> Male</label>
                    <label><input type="radio" name="gender" value="Female" <?= $gender == 'Female' ? 'checked' : '' ?>> Female</label>
                </div>
            </div>

            <div class="input-box">
                <label>Address</label>
                <div class="column">
                    <input type="text" name="sub_city" placeholder="Sub City" value="<?= htmlspecialchars($sub_city) ?>" required>
                    <input type="text" name="kebele" placeholder="Kebele" value="<?= htmlspecialchars($kebele) ?>" required>
                    <input type="text" name="homeno" placeholder="Home No" value="<?= htmlspecialchars($homeno) ?>" required>
                </div>
            </div>

            <div class="uType-box">
                <h3>User Type</h3>
                <div class="uType-option">
                    <label><input type="radio" name="usertype" value="User" <?= $usertype == 'User' ? 'checked' : '' ?>> User</label>
                    <label><input type="radio" name="usertype" value="Admin" <?= $usertype == 'Admin' ? 'checked' : '' ?>> Admin</label>
                    <label><input type="radio" name="usertype" value="KebeleManager" <?= $usertype == 'KebeleManager' ? 'checked' : '' ?>> Kebele Manager</label>
                    <label><input type="radio" name="usertype" value="HealthInsuranceManager" <?= $usertype == 'HealthInsuranceManager' ? 'checked' : '' ?>> Health Insurance Manager</label>
                    <label><input type="radio" name="usertype" value="Hiofficier" <?= $usertype == 'Hiofficier' ? 'checked' : '' ?>> HI Officer</label>
                </div>
            </div>

            <div class="input-box">
                <label>Username</label>
                <input type="text" name="uname" placeholder="Username" value="<?= htmlspecialchars($uname) ?>" required>
            </div>

            <div class="input-box">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter password" required>
            </div>

            <div class="input-box">
                <label>Confirm Password</label>
                <input type="password" name="re_password" placeholder="Re-enter password" required>
            </div>

            <div class="check">
                <input type="checkbox" required> I have read and agree to the <a href="terms.php">Terms & Conditions</a>
            </div>

            <input type="submit" value="Register">

            <h4>Already have an account? <a href="login.php">Log in</a></h4>
        </form>
    </div>
</body>
</html>
