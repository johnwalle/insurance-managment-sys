<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help | Gondar Health Insurance</title>
    <link rel="stylesheet" type="text/css" href="../CSS/about.css">
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('../Images/bg14.jpg'); /* Adjust the path to your background image */
            background-size: cover;
            background-position: center;
            color: #333;
        }

        /* Back to Home Button Styling */
        .top-right-buttons {
            position: fixed; /* Fixed positioning for the button */
            top: 10px;
            right: 10px;
            z-index: 1000;
        }

        .top-right-buttons .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .top-right-buttons .button:hover {
            background-color: #0056b3;
        }

        .top-right-buttons .fa {
            margin-right: 5px;
        }

        /* Ensure full-width content */
        #aboutbody {
            padding: 20px;
            margin: 0; /* Remove margin to fit the entire page */
        }

        .para1 {
            padding: 40px; /* Adjust padding as needed */
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent background */
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            margin: 20px 0;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin: 0 0 20px;
            text-align: center; /* Center-align text for better readability */
        }
    </style>
</head>
<body>
    <!-- Back to Home Button -->
    <div class="top-right-buttons">
        <a href="profilePage.php" class="button"><i class="fas fa-home"></i>Back to Home</a>
    </div>

    <div id="aboutbody">
        <div class="para1">
            <h1>How does the website work?</h1>
            <p>Posting on Health insurance is a simple process. All you need to do is to register and create an account to get started. Fill up the form to complete the registration. Then you can sign in to your account.</p>
            <h1>How to access the website?</h1>
            <p>Authorized users first log in to the system by entering their Username and Password. After an authorized person enters the system by inserting a valid Username and Password, they can access the system according to their activity.</p>
            <h1>I can't register on the website?</h1>
            <p>Make sure you have filled out all required fields on the registration page. Once the registration form is filled out and submitted, an email notification will be sent to your email account with a link to validate your account. Please access your email to validate your account.</p>
            <h1>Who can access the website?</h1>
            <p>
                <li>Guest users of Health Insurance can access the pages About Us and Help.</li>
                <li>External users who want to be customers of our Hospital can verify their certificate by registering Hospital Card Officer and Customer to become a customer in a given Agency.</li>
                <li>Administrator</li>
                <li>Hospital HI Officer</li>
                <li>Kebele Manager</li>
                <li>Customer</li>
                <li>Health Insurance Manager</li>
            </p>
        </div>
    </div>

    <!-- Include Font Awesome for icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
