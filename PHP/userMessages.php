<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final_project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$messages = [];
$error = '';
$usernameInput = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    $usernameInput = trim($_POST['username']);

    // Fetch the 3 most recent messages for the entered username
    $sql = "SELECT message, sent_at FROM messages WHERE username = ? ORDER BY sent_at DESC LIMIT 1";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param('s', $usernameInput);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        die("Query failed: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        // Fetch the messages
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
    } else {
        $error = "No messages found for the username: " . htmlspecialchars($usernameInput);
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Messages | Gondar Health Insurance</title>
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- For Font Awesome Icons -->
    <style>
        /* Body and Background Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('images/bg14.jpg'); /* Ensure this path is correct */
            background-size: cover;
            background-position: center;
            color: #333;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative; /* Added to position the icon */
        }

        /* Back to Home Icon */
        .back-to-home {
            position: absolute;
            top: 20px;
            right: 20px;
            text-decoration: none;
            color: #fff;
            background: #007bff; /* Blue background */
            border-radius: 8px; /* Rounded corners */
            padding: 10px 15px; /* Padding around the text and icon */
            display: flex;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background 0.3s, transform 0.3s;
        }

        .back-to-home:hover {
            background: #0056b3; /* Darker blue on hover */
            transform: scale(1.1); /* Slightly enlarge on hover */
        }

        .back-to-home i {
            margin-right: 8px; /* Space between icon and text */
            font-size: 18px;
        }

        .back-to-home span {
            font-size: 14px;
            font-weight: 500; /* Slightly bold text */
        }

        /* Container Styling */
        .container {
            background: rgba(255, 255, 255, 0.9); /* Slightly transparent background */
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            padding: 30px;
            max-width: 600px;
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
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        label {
            font-size: 16px;
            color: #444;
            margin-bottom: 5px;
        }

        input[type="text"] {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Messages Section */
        .messages-section {
            margin-top: 20px;
        }

        .message {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .message p {
            color: #555;
            margin-bottom: 8px;
        }

        .message small {
            color: #999;
        }

        /* Status Messages */
        .status-message {
            text-align: center;
            font-size: 16px;
            padding: 10px;
            border-radius: 6px;
        }

        .status-message.error {
            color: #d9534f; /* Red for errors */
            background-color: #f2dede;
        }

        .status-message.success {
            color: #5bc0de; /* Green for success */
            background-color: #dff0d8;
        }
        
        /* Hide form when messages are displayed */
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

<a href="profilePage.php" class="back-to-home"><i class="fas fa-home"></i><span>Back to Home</span></a> <!-- Redirect to PHP file -->

<div class="container">
    <h2>View Messages</h2>

    <form method="post" action="" class="<?php echo $messages ? 'hidden' : ''; ?>">
        <label for="username">Enter Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($usernameInput); ?>" required>
        <button type="submit">Search Messages</button>
    </form>

    <?php if ($error): ?>
        <p class='status-message error'><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($messages): ?>
        <div class="messages-section">
            <?php foreach ($messages as $message): ?>
                <div class="message">
                    <p><strong>Message:</strong> <?php echo htmlspecialchars($message['message']); ?></p>
                    <p><small><strong>Sent at:</strong> <?php echo htmlspecialchars($message['sent_at']); ?></small></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
