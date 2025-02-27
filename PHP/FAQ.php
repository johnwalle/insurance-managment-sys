
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ | CBHI Gondar</title>
    <link rel="stylesheet" href="../CSS/FAQ.css">
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

        header {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        header h1 {
            margin: 0;
            font-size: 2em;
            color: #007bff;
        }

        main.cont {
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent background */
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            margin: 20px auto;
            max-width: 800px;
        }

        .faq {
            margin: 20px 0;
        }

        .faq-item {
            margin-bottom: 20px;
        }

        .faq-question {
            font-size: 1.5em;
            color: #007bff;
            margin: 0;
        }

        .faq-answer {
            font-size: 1em;
            margin: 10px 0;
        }

        /* Back to Home Button Styling */
        .top-right-buttons {
            position: fixed;
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
    </style>
</head>
<body>
    <!-- Back to Home Button -->
    <div class="top-right-buttons">
        <a href="/Final-Year-Project-2/index.php" class="button"><i class="fas fa-home"></i> Back to Home</a>
    </div>

    <header>
        <h1>FAQ - CBHI Gondar</h1>
    </header>

    <main class="cont">
        <div class="faq">
            <!-- Updated FAQ items based on your requirements -->
            
            <div class="faq-item">
                <h2 class="faq-question">What is CBHI Gondar?</h2>
                <p class="faq-answer">CBHI Gondar (Community-Based Health Insurance) provides affordable health insurance to residents in Gondar, especially targeting low-income and rural communities. We aim to make healthcare accessible and reduce out-of-pocket expenses for medical treatments.</p>
            </div>

            <div class="faq-item">
                <h2 class="faq-question">How can I register for CBHI Gondar?</h2>
                <p class="faq-answer">You can register for CBHI Gondar directly through our website by visiting the <a href="signup.php">Sign Up</a> page. Simply fill out the form, and you’ll be guided through the registration process.</p>
            </div>

<div class="faq-item">
                <h2 class="faq-question">What types of coverage do you offer?</h2>
                <p class="faq-answer">We offer a wide range of coverage, including:
                    <ul>
                        <li>Outpatient care</li>
                        <li>Inpatient hospital services</li>
                        <li>Maternal and child healthcare</li>
                        <li>Emergency services</li>
                        <li>Prescription medications at participating pharmacies</li>
                    </ul>
                Our plans are designed to ensure comprehensive and affordable care for all members.
                </p>
            </div>

            <div class="faq-item">
                <h2 class="faq-question">Where is the CBHI Gondar office located?</h2>
                <p class="faq-answer">Our main office is located at Piassa, Gondar. You can visit us during business hours for in-person support and inquiries.</p>
            </div>

            <div class="faq-item">
                <h2 class="faq-question">How can I submit a complaint?</h2>
                <p class="faq-answer">You can submit complaints through the <a href="comment_form.php">Complaints</a> page on the user portal. Our team will review your submission and get back to you as soon as possible.</p>
            </div>
        </div>
    </main>

    <!-- Include Font Awesome for icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>