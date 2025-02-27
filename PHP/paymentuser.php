<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/payment.css">
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <title>Payment Methods | Gondar Health Insurance</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('../Images/bg14.jpg'); /* Adjust the path to your background image */
            background-size: cover;
            background-position: center;
            color: #333;
            margin: 0;
            padding: 0;
        }

        #paymentbody {
            margin-top: 100px;
            padding: 0 10px; /* Add padding to ensure content is not too close to the edges */
        }

        .card {
            margin: 10px; /* Reduced margin for better spacing */
        }

        /* Button Styling */
        .top-right-buttons {
            position: absolute;
            top: 10px;
            right: 10px;
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

        /* Container Styling */
        .container {
            background: rgba(255, 255, 255, 0.9); /* Slightly transparent background */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Reduced shadow for a lighter effect */
            padding: 20px; /* Reduced padding for a more compact look */
            max-width: 300px; /* Set a smaller max-width for containers */
            margin: 10px auto; /* Center containers and reduce margin */
            /* Adjust width as needed */
        }

        /* Text Centering */
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Back to Home Button -->
    <div class="top-right-buttons">
        <a href="profilePage.php" class="button"><i class="fas fa-home"></i>Back to Home</a>
    </div>

    <div id="paymentbody">
        <h1>Pay Through Your Mobile Banking</h1>
        <br><br>

        <div class="row">
            <div class="card">
                <div class="column">
                    <a href="https://www.combanketh.et/en/mobile-banking/"><img src="../Images/Commercial-Bank-logo.jpg" alt="Commercial Bank of Ethiopia" style="width:100%"></a>
                </div>
                <div class="container">
                    <h4><b>Commercial Bank of Ethiopia</b></h4>
                </div>
            </div>

            <div class="card">
                <div class="column">
                  <a href="https://www.ezcash.lk/"><img src="../Images/abyssinia.jpg" alt="Bank of Abyssinia" style="width:100%"></a>
                </div>
                <div class="container">
                    <h4><b>Bank of Abyssinia</b></h4>
                </div>
            </div>

            <div class="card">
                <div class="column">
                  <a href="https://mobitel.lk/mcash"><img src="../Images/awash.jpg" alt="Awash Bank" style="width:100%"></a>
                </div>
                <div class="container">
                    <h4><b>Awash Bank</b></h4>
                </div>
            </div>
        </div>

        <br><br>

        <div class="row">
            <div class="card">
                <div class="column">
                    <a href="https://www.ethiotelecom.et/telebirr/"><img src="../Images/telebirr.png" alt="Tele Birr" style="width:100%"></a>
                </div>
                <div class="container">
                    <h4><b>Tele Birr</b></h4>
                </div>
            </div>

            <div class="card">
                <div class="column">
                    <a href="https://www.ndbbank.com/"><img src="../Images/cbebirr.jpg" alt="CBE Birr" style="width:100%"></a>
                </div>
                <div class="container">
                    <h4><b>CBE Birr</b></h4>
                </div>
            </div>

            <div class="card">
                <div class="column">
                    <a href="https://www.sampath.lk/"><img src="../Images/awashbirr.jpg" alt="Awash E Birr" style="width:100%"></a>
                </div>
                <div class="container">
                    <h4><b>Awash E Birr</b></h4>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
