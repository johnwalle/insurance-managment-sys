<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final_project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("<p class='status-message error'>Connection failed: " . $conn->connect_error . "</p>");
}

// Fetch all registered users
$users = [];
$sql = "SELECT Username, First_Name, Last_Name, Email, Phone_Number, Sub_City, Kebele, Home_No, Date_Of_Birth, Gender FROM registered_user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    $errorMessage = "No users found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users | Gondar Health Insurance</title>
    <link rel="icon" type="image/x-icon" href="../Images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
            color: #333;
            background-image: url('../Images/bg14.jpg'); no-repeat center center fixed;

        }

        h2 {
            color: #444;
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
        }

        .user-list {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            border-collapse: collapse;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .user-list th, .user-list td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
            vertical-align: middle;
        }

        .user-list th {
            background-color: #007bff;
            color: white;
            text-transform: uppercase;
            font-size: 14px;
            white-space: nowrap;
        }

        .user-list td {
            background-color: #f9f9f9;
            font-size: 14px;
        }

        .user-list th i, .user-list td i {
            margin-right: 6px;
        }

        .status-message {
            text-align: center;
            padding: 10px;
            background-color: #f8d7da;
            color: #721c24;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        /* Back to Home Icon */
        .back-to-home {
            position: fixed;
            top: 20px;
            right: 20px;
            text-decoration: none;
            color: #fff;
            background: #007bff;
            border-radius: 50px;
            padding: 10px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transition: background 0.3s, transform 0.3s;
        }

        .back-to-home:hover {
            background: #0056b3;
            transform: scale(1.1);
        }

        .back-to-home i {
            margin-right: 8px;
            font-size: 18px;
        }

        .back-to-home span {
            font-size: 14px;
            font-weight: 500;
        }
    </style>
</head>
<body>

<!-- Back to Home button -->
<a href="kebeleManager.php" class="back-to-home"><i class="fas fa-home"></i><span>Back to Home</span></a>

<h2>All Registered Users</h2>

<?php if (isset($errorMessage)): ?>
    <p class="status-message"><?= htmlspecialchars($errorMessage); ?></p>
<?php else: ?>
    <table class="user-list">
        <thead>
            <tr>
                <th><i class="fas fa-user"></i> Username</th>
                <th><i class="fas fa-id-badge"></i> First Name</th>
                <th><i class="fas fa-id-badge"></i> Last Name</th>
                <th><i class="fas fa-envelope"></i> Email</th>
                <th><i class="fas fa-phone"></i> Phone Number</th>
                <th><i class="fas fa-map-marker-alt"></i> Sub City</th>
                <th><i class="fas fa-building"></i> Kebele</th>
                <th><i class="fas fa-home"></i> Home No</th>
                <th><i class="fas fa-calendar-alt"></i> Date of Birth</th>
                <th><i class="fas fa-venus-mars"></i> Gender</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['Username']); ?></td>
                <td><?= htmlspecialchars($user['First_Name']); ?></td>
                <td><?= htmlspecialchars($user['Last_Name']); ?></td>
                <td><a href="mailto:<?= htmlspecialchars($user['Email']); ?>"><?= htmlspecialchars($user['Email']); ?></a></td>
                <td><?= htmlspecialchars($user['Phone_Number']); ?></td>
                <td><?= htmlspecialchars($user['Sub_City']); ?></td>
                <td><?= htmlspecialchars($user['Kebele']); ?></td>
                <td><?= htmlspecialchars($user['Home_No']); ?></td>
                <td><?= htmlspecialchars($user['Date_Of_Birth']); ?></td>
                <td><?= htmlspecialchars($user['Gender']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
