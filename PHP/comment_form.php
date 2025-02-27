<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Insurance user | complains</title>
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Body and Background Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('images/bg14.jpg'); /* Make sure this path is correct */
            background-size: cover;
            background-position: center;
            color: #333;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Container Styling */
        .container {
            background: rgba(255, 255, 255, 0.9); /* Slightly transparent background */
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            padding: 30px;
            max-width: 500px;
            width: 100%;
        }

        /* Headings */
        h2 {
            text-align: center;
            color: #444;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Form Styling */
        form {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .form-group input, 
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .form-group textarea {
            height: 120px;
            resize: none;
        }

        .form-group button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        /* Status Message Styling */
        .status-message {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }

        .status-message.success {
            color: #28a745; /* Green */
        }

        .status-message.error {
            color: #dc3545; /* Red */
        }
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
            margin-left: 10px;
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
<div class="top-right-buttons">
        <a href="profilePage.php" class="button"><i class="fas fa-home"></i>Back to Home</a>
        <a href="./logout.php" class="button"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
<div class="container">
    <h2>Please Leave a Complain Below Here </h2>

    <?php
    $status_message = ""; // Initialize status message variable

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Database connection
        $servername = "localhost";
        $username = "root"; // your database username
        $password = ""; // your database password
        $dbname = "final_project"; // your database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            $status_message = "<p class='status-message error'>Connection failed: " . $conn->connect_error . "</p>";
        } else {
            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO comments (customer_name, comment) VALUES (?, ?)");
            $stmt->bind_param("ss", $customer_name, $comment);

            // Set parameters and execute
            $customer_name = $_POST['customer_name'];
            $comment = $_POST['comment'];

            if ($stmt->execute()) {
                $status_message = "<p class='status-message success'>Comment submitted successfully!</p>";
            } else {
                $status_message = "<p class='status-message error'>Error: " . $stmt->error . "</p>";
            }

            // Close connection
            $stmt->close();
            $conn->close();
        }
    }
    ?>

    <!-- Comment Form -->
    <form action="" method="post">
        <div class="form-group">
            <label for="customer_name">Name</label>
            <input type="text" id="customer_name" name="customer_name" required>
        </div>
        <div class="form-group">
            <label for="comment">Your Complain Here</label>
            <textarea id="comment" name="comment" required></textarea>
        </div>
        <div class="form-group">
            <button type="submit">Submit</button>
        </div>
    </form>

    <!-- Status Message -->
    <?php
    // Display status message
    echo $status_message;
    ?>
</div>

</body>
</html>
