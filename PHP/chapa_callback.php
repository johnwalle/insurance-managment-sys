<?php
$chapaSecretKey = "YOUR_SECRET_KEY"; // Same secret key you used earlier

// Get Chapa's callback data (it will be a JSON object)
$data = json_decode(file_get_contents('php://input'), true);

// Verify the payment status
if ($data['status'] === 'success' && isset($data['data']['tx_ref'])) {
    $txRef = $data['data']['tx_ref'];
    $amount = $data['data']['amount'];

    // Add custom logic for your order processing, such as:
    // - Update database to mark the order as paid
    // - Send an email to the user for confirmation

    // Example: Simple output to verify
    echo "Payment successful! Transaction Reference: " . $txRef . " for amount: " . $amount . " ETB.";
} else {
    echo "Payment failed. Please try again.";
}
?>
