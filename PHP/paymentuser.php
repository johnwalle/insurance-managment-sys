<?php
session_start();
if (!isset($_SESSION["Username"]) || $_SESSION["Role"] !== "User") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Payment Methods | Tepi Health Insurance</title>
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('../Images/bg14.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        .top-right-buttons {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .top-right-buttons .button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .top-right-buttons .button:hover {
            background-color: #0056b3;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        form input[type="hidden"] {
            display: none;
        }

        form button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #218838;
        }

        @media (max-width: 500px) {
            .container {
                margin: 50px 15px;
                padding: 20px;
            }

            .top-right-buttons {
                top: 10px;
                right: 10px;
            }

            .top-right-buttons .button {
                padding: 8px 16px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<!-- Back to Home Button -->
<div class="top-right-buttons">
    <a href="profilePage.php" class="button"><i class="fas fa-home"></i> Home</a>
</div>

<!-- Chapa Payment Form -->
<div class="container">
    <h1>Pay with Chapa</h1>
    <form method="POST" action="process_payment.php">
        <input type="hidden" name="amount" value="10" />
        <input type="hidden" name="currency" value="ETB" />
        <input type="hidden" name="email" value="israel@negade.et" />
        <input type="hidden" name="first_name" value="Israel" />
        <input type="hidden" name="last_name" value="Goytom" />
        <button type="submit"><i class="fas fa-credit-card"></i> Pay Now</button>
    </form>
</div>

</body>
</html>
