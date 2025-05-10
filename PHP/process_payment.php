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

// Assuming you are using session to store logged-in username
session_start();

// Redirect to login if the user is not logged in or not an admin
if (!isset($_SESSION["Username"]) || $_SESSION["Role"] !== "User") {
    header("Location: login.php");
    exit();
}

// Fetch user information
$loggedInUsername = $_SESSION['Username']; // Adjust this as necessary

$userInfo = [];
if ($loggedInUsername) {
    $stmt = $conn->prepare("SELECT Username, FirstName, LastName, Email, Phone, BirthDate, Gender, SubCity, Kebele, HomeNo FROM Users WHERE Username = ?");
    $stmt->bind_param("s", $loggedInUsername);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userInfo['Username'], $userInfo['FirstName'], $userInfo['LastName'], $userInfo['Email'], $userInfo['Phone'], $userInfo['BirthDate'], $userInfo['Gender'], $userInfo['SubCity'], $userInfo['Kebele'], $userInfo['HomeNo']);
        $stmt->fetch();
    } else {
        $userInfo['Error'] = "User not found.";
    }
    $stmt->close();
}

$conn->close();

// Check if user information is retrieved successfully
if (isset($userInfo['Error'])) {
    echo $userInfo['Error'];
    exit();
}

// User information (for payment processing)
$firstName = $userInfo['FirstName'];
$lastName = $userInfo['LastName'];
$email = $userInfo['Email'];
$phone = $userInfo['Phone'];

// Chapa Secret Key
$chapaSecretKey = "CHASECK_TEST-JRNaC7G4rWt3gTGr4CtsygwPK2s1GniA";

// Prepare data for payment
$data = [
    'amount' => $_POST['amount'],
    'currency' => $_POST['currency'],
    'email' => $email,
    'first_name' => $firstName,
    'last_name' => $lastName,
    'tx_ref' => 'tepi-' . uniqid(),
    'callback_url' => 'http://localhost/insurance-managment-sys/PHP/chapa_callback.php',
    'return_url' => 'http://localhost/insurance-managment-sys/PHP/payment_success.php',
    'customization' => [
        'title' => 'Tepi Health', // Shortened title to be within 16 characters
        'description' => 'Secure Payment via Chapa'
    ]
];

// Initialize CURL for payment
$ch = curl_init('https://api.chapa.co/v1/transaction/initialize');

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $chapaSecretKey,
    'Content-Type: application/json'
]);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);

// If CURL request fails
if ($err) {
    echo "<script>console.log('CURL Error: " . $err . "');</script>";
    die("cURL Error: $err");
}

// Decode the response
$responseData = json_decode($response, true);

// Console log the response for debugging
echo "<script>console.log('Response Data: " . json_encode($responseData) . "');</script>";

// Handle the response
if ($responseData['status'] === 'success') {
    header('Location: ' . $responseData['data']['checkout_url']);
    exit();
} else {
    // Check if 'message' is an array and handle accordingly
    if (is_array($responseData['message'])) {
        // Convert the array to a string
        $errorMessages = implode(", ", $responseData['message']);
        echo "<script>console.log('Payment initialization failed: " . $errorMessages . "');</script>";
        echo "Payment initialization failed: " . $errorMessages;
    } else {
        echo "<script>console.log('Payment initialization failed: " . $responseData['message'] . "');</script>";
        echo "Payment initialization failed: " . $responseData['message'];
    }
}
?>
