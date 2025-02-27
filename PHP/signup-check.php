<?php 
session_start(); 
include "db_conn.php";
// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_POST['submit'])) {
    // Retrieve and sanitize input
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $bday = mysqli_real_escape_string($conn, $_POST['bday']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $sub_city = mysqli_real_escape_string($conn, $_POST['sub_city']);
    $kebele = mysqli_real_escape_string($conn, $_POST['kebele']);
    $homeno = mysqli_real_escape_string($conn, $_POST['homeno']);
    $usertype = mysqli_real_escape_string($conn, $_POST['usertype']);
    $username = mysqli_real_escape_string($conn, $_POST['uname']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $re_password = mysqli_real_escape_string($conn, $_POST['re_password']);

    // Validation function
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($username);
    $password = validate($password);
    $re_password = validate($re_password);
    $name = validate($name);

    $user_data = 'uname=' . $username . '&name=' . $name;

    // Validation
    if (empty($username)) {
        header("Location: signup.php?error=Username is required&$user_data");
        exit();
    } else if (empty($password)) {
        header("Location: signup.php?error=Password is required&$user_data");
        exit();
    } else if (empty($re_password)) {
        header("Location: signup.php?error=Re-enter password is required&$user_data");
        exit();
    } else if (empty($name)) {
        header("Location: signup.php?error=Name is required&$user_data");
        exit();
    } else if ($password !== $re_password) {
        header("Location: signup.php?error=Passwords do not match&$user_data");
        exit();
    } else {
        // Hash the password
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Check if username or email already exists
        $sql = "SELECT * FROM registered_user WHERE Username='$username' OR Email='$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            header("Location: signup.php?error=Username or email is already taken&$user_data");
            exit();
        } else {
            // Insert new user into the database
            $sql2 = "INSERT INTO registered_user (UserType, First_Name, Last_Name, Email, Phone_Number, Sub_City, Kebele, Home_No, Date_Of_Birth, Gender, Username, Password) 
                     VALUES ('$usertype', '$name', '$lname', '$email', '$phone', '$sub_city', '$kebele', '$homeno', '$bday', '$gender', '$username', '$password')";

            if (mysqli_query($conn, $sql2)) {
                header("Location: signup.php?success=Your account has been created successfully");
                exit();
            } else {
                $error = mysqli_error($conn);
                header("Location: signup.php?error=Error: $error&$user_data");
                exit();
            }
        }
    }
}
else{
	header("Location: signup.php");
	exit();
}