<?php
session_start();
include "db_conn.php";

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $pwd = $_POST["pwd"];  // Raw password input from user

    // Validation
    if (empty($username)) {
        header("Location: login.php?error=usernameisrequired");
        exit();
    } else if (empty($pwd)) {
        header("Location: login.php?error=passwordisrequired");
        exit();
    } else {
        // Query to check if username exists and if email is verified
        $sql = "SELECT * FROM Users WHERE Username = '$username'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($row) {
            // Check if the email is verified
            if ($row['IsVerified'] == 0) {
                // Email is not verified
                header("Location: login.php?error=EmailNotVerified");
                exit();
            } else {
                // Email is verified, check password
                if (password_verify($pwd, $row['Password'])) {
                    // Password is correct

                    // ✅ Set session variables
                    $_SESSION["Username"] = $username;
                    $_SESSION["Role"] = $row["UserType"]; // Store user role in session

                    // Redirect based on role
                    switch ($row["UserType"]) {
                        case "User":
                            header("Location: profilePage.php");
                            break;
                        case "Admin":
                            header("Location: admin.php");
                            break;
                        case "Hiofficier":
                            header("Location: hospitalOfficier.php");
                            break;
                        case "KebeleManager":
                            header("Location: kebeleManager.php");
                            break;
                        case "HealthInsuranceManager":
                            header("Location: healthInsuranceManager.php");
                            break;
                        default:
                            header("Location: login.php?error=InvalidUserType");
                            break;
                    }
                    exit();
                } else {
                    // Invalid username or password
                    header("Location: login.php?error=IncorrectUsernameOrPassword");
                    exit();
                }
            }
        } else {
            // Invalid username
            header("Location: login.php?error=IncorrectUsernameOrPassword");
            exit();
        }
    }
} else {
    header("Location: login.php");
    exit();
}
?>
