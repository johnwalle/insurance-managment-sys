<?php
include "db_conn.php";

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $query = "UPDATE Users SET IsVerified = 1 WHERE VerificationToken = '$token' AND IsVerified = 0";
    $result = mysqli_query($conn, $query);

    if (mysqli_affected_rows($conn) > 0) {
        // Success: token matched and user verified
        echo "
            <html>
            <head>
                <meta http-equiv='refresh' content='5;url=login.php' />
                <style>
                    body { font-family: Arial, sans-serif; text-align: center; margin-top: 100px; }
                    .box {
                        display: inline-block;
                        padding: 20px 40px;
                        background-color: #e0ffe0;
                        border: 1px solid #b2fab4;
                        border-radius: 10px;
                    }
                </style>
            </head>
            <body>
                <div class='box'>
                    <h2>Email Verified Successfully!</h2>
                    <p>You will be redirected to the login page in 5 seconds...</p>
                </div>
            </body>
            </html>
        ";
    } else {
        // Either token is invalid or already used
        echo "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; text-align: center; margin-top: 100px; }
                    .box {
                        display: inline-block;
                        padding: 20px 40px;
                        background-color: #ffe0e0;
                        border: 1px solid #f5b2b2;
                        border-radius: 10px;
                    }
                </style>
            </head>
            <body>
                <div class='box'>
                    <h2>Invalid or Expired Token</h2>
                    <p>This verification link is no longer valid.</p>
                </div>
            </body>
            </html>
        ";
    }
} else {
    echo "No token provided.";
}
?>
