<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Check if the user is logged in
if (!isset($_SESSION["Username"]) || $_SESSION["Role"] !== "HealthInsuranceManager") {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final_project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("<p class='status-message error'>Connection failed: " . $conn->connect_error . "</p>");
}

// Fetch user details based on user type
$users = [];
$sql = "SELECT UserId, Username, FirstName, LastName, Email, Phone, SubCity, Kebele, HomeNo, BirthDate, Gender, insurance_expiry 
        FROM Users 
        WHERE UserType = 'User'"; // Adjust 'user' to match the actual user type value

$result = $conn->query($sql);

if ($result === FALSE) {
    die("<p class='status-message error'>SQL Error: " . $conn->error . "</p>");
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $currentDate = new DateTime();
        $expiryDate = new DateTime($row['insurance_expiry']);
        $row['status'] = ($currentDate < $expiryDate) ? 'Active' : 'Expired';
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
<title>Insurance Renewal | Gondar Health Insurance</title>
<link rel="icon" type="image/x-icon" href="../Images/logo.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        background-image: url('../Images/bg14.jpg');
        background-size: cover;
        color: #333;
        height: 100vh;
        overflow: hidden;
        position: relative;
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
    .user-list td i {
        margin-right: 6px;
    }
    .renew, .expired {
        padding: 8px 16px;
        color: #fff;
        border-radius: 5px;
        text-decoration: none;
        transition: background 0.3s;
    }
    .renew {
        background-color: #28a745;
    }
    .expired {
        background-color: #dc3545;
    }
    .renew:hover {
        background-color: #218838;
    }
    .expired:hover {
        background-color: #c82333;
    }
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
<a href="healthInsuranceManager.php" class="back-to-home"><i class="fas fa-home"></i><span>Back to Home</span></a>

<h2>Insurance Renewal</h2>

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
                <th><i class="fas fa-calendar-alt"></i> Date of Birth</th>
                <th><i class="fas fa-id-card"></i> Insurance Expiry</th>
                <th><i class="fas fa-cog"></i> Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['Username']); ?></td>
                <td><?= htmlspecialchars($user['FirstName']); ?></td>
                <td><?= htmlspecialchars($user['LastName']); ?></td>
                <td><?= htmlspecialchars($user['Email']); ?></td>
                <td><?= htmlspecialchars($user['Phone']); ?></td>
                <td><?= htmlspecialchars($user['SubCity']); ?></td>
                <td><?= htmlspecialchars($user['Kebele']); ?></td>
                <td><?= htmlspecialchars($user['BirthDate']); ?></td>
                <td><?= htmlspecialchars($user['insurance_expiry']); ?></td>
                <td>
                    <?php if ($user['status'] == 'Expired'): ?>
                        <a href="renew_insurance.php?user_id=<?= $user['UserId']; ?>" class="renew">Renew</a>
                    <?php else: ?>
                        <span class="expired">Active</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
