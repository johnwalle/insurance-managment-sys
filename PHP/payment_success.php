<?php
session_start();
if (!isset($_SESSION["Username"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Payment Success | Tepi Health Insurance</title>
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
            color: #333;
        }

        .container {
            background-color: #fff;
            border-radius: 12px;
            padding: 40px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0px 8px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.2s ease;
        }

        .container:hover {
            transform: translateY(-5px);
        }

        h1 {
            font-size: 2.5em;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.1em;
            line-height: 1.5;
            color: #7f8c8d;
            margin-bottom: 30px;
        }

        .btn {
            background-color: #3498db;
            color: #fff;
            padding: 12px 25px;
            font-size: 1.1em;
            font-weight: 500;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease, transform 0.2s;
        }

        .btn:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        .icon {
            font-size: 4em;
            color: #3498db;
            margin-bottom: 20px;
        }

        /* Animation */
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(50px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .container {
            animation: fadeIn 1s ease-in-out;
        }
    </style>
</head>
<body>

<!-- Success Message -->
<div class="container">
    <div class="icon">
        <i class="fas fa-check-circle"></i>
    </div>
    <h1>Payment Successful!</h1>
    <p>Your payment has been successfully processed. Thank you for choosing Tepi Health Insurance.</p>
    <p><a href="profilePage.php" class="btn">Back to Home</a></p>
</div>

<!-- Font Awesome for check-circle icon -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>
</html>
