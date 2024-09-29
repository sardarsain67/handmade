<?php
// Include your server.php file for database connection
include('server.php');

// Start the session
session_start();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the booking ID, discounted amount, payment method, and additional parameters from the POST data
    $bookingId = $_POST['bookingId'];
    $discountedAmount = $_POST['discountedAmount'];
    $paymentMethod = $_POST['paymentMethod'];
    $additionalParams = $_POST;

    // Check if the user is logged in
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        // Check payment method and perform necessary checks
        switch ($paymentMethod) {
            case 'carrent_pro_card':
                // Check if the user has a CarRent Pro Card with the provided card number
                $cardNumber = $additionalParams['carrentProCardNumber'];
                $cardQuery = "SELECT * FROM card WHERE username = '$username' AND card_number = '$cardNumber'";
                $cardResult = $conn->query($cardQuery);

                if ($cardResult && $cardResult->num_rows > 0) {
                    // User has a CarRent Pro Card with the provided card number
                    $response = processPayment();
                } else {
                    // User doesn't have a CarRent Pro Card with the provided card number
                    $response = ['success' => false, 'message' => 'Invalid CarRent Pro Card number.'];
                }
                break;
            default:
                // Unsupported or invalid payment method
                $response = ['success' => false, 'message' => 'Invalid payment method.'];
                break;
        }

        // Close the database connection
        $conn->close();
    } else {
        // User is not logged in
        $response = ['success' => false, 'message' => 'User not logged in.'];
    }

    // Clear any previous output
    ob_clean();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Invalid request method
    http_response_code(405); // Method Not Allowed
    echo 'Invalid request method.';
}

// Function to process payment if checks are successful
function processPayment() {
    global $conn, $username, $bookingId, $discountedAmount;

    // Get the user's card data
    $cardQuery = "SELECT * FROM card WHERE username = '$username'";
    $cardResult = $conn->query($cardQuery);

    if ($cardResult && $cardResult->num_rows > 0) {
        $cardData = $cardResult->fetch_assoc();
        $cardBalance = $cardData['balance'];

        // Check if there is enough balance
        if ($cardBalance >= $discountedAmount) {
            // Deduct the amount from the card balance
            $updatedBalance = $cardBalance - $discountedAmount;
            $updateCardQuery = "UPDATE card SET balance = $updatedBalance WHERE username = '$username'";

            if ($conn->query($updateCardQuery)) {
                // Update the payment_status to 1 (assuming 1 represents a successful payment)
                $updateBookingQuery = "UPDATE bookings SET payment_status = 1 WHERE id = $bookingId";

                if ($conn->query($updateBookingQuery)) {
                    // Payment successful
                    $response = ['success' => true, 'message' => 'Booking payment successful.'];
                } else {
                    // Payment failed
                    $response = ['success' => false, 'message' => 'Failed to update booking payment status.'];
                }
            } else {
                // Failed to update card balance
                $response = ['success' => false, 'message' => 'Failed to update card balance.'];
            }
        } else {
            // Insufficient balance in the card
            $response = ['success' => false, 'message' => 'Insufficient balance in your card. Please add funds.'];
        }
    } else {
        // Failed to fetch card data
        $response = ['success' => false, 'message' => 'Failed to fetch card data.'];
    }

    // Return the response
    return $response;
}
?>
