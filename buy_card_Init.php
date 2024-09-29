<?php
include('server.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $initialAmount = $_POST['initialAmount'];

    // Generate a unique 16-digit card number
    $cardNumber = generateUniqueCardNumber();

    if ($cardNumber) {
        // Insert the card information into the database
        $insertQuery = "INSERT INTO card (name, card_number, username, balance) VALUES ('$name', '$cardNumber', '{$_SESSION['username']}', $initialAmount)";
        $insertResult = $conn->query($insertQuery);

        if ($insertResult) {
            // Card purchase successful
            $response = ['success' => true];
        } else {
            // Card purchase failed
            $response = ['success' => false, 'message' => 'Failed to buy the card.'];
        }
    } else {
        // Unable to generate a unique card number
        $response = ['success' => false, 'message' => 'Failed to generate a unique card number. Please try again.'];
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Invalid request method
    http_response_code(405); // Method Not Allowed
    echo 'Invalid request method.';
}

function generateUniqueCardNumber() {
    global $conn;

    // Generate a 16-digit card number
    $cardNumber = generateCardNumber();

    // Check if the card number is unique
    $uniqueQuery = "SELECT COUNT(*) as count FROM card WHERE card_number = '$cardNumber'";
    $uniqueResult = $conn->query($uniqueQuery);

    if ($uniqueResult && $uniqueResult->num_rows > 0) {
        $row = $uniqueResult->fetch_assoc();
        $count = $row['count'];

        // If the card number is not unique, generate a new one recursively
        if ($count > 0) {
            return generateUniqueCardNumber();
        }
    }

    return $cardNumber;
}

function generateCardNumber() {
    $min = pow(10, 15); // Minimum 16-digit number
    $max = pow(10, 16) - 1; // Maximum 16-digit number

    return mt_rand($min, $max);
}
?>
