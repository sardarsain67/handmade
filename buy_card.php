<?php
// Assume the session has already started
include('server.php');
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the selected card amount from the form
        $cardAmount = $_POST['amount']; // Update the key to match the JavaScript code

        // Perform a query to check if the user already has a card
        $checkQuery = "SELECT * FROM card WHERE username = '$username'";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult !== false) {
            if ($checkResult->num_rows > 0) {
                // User already has a card, update the balance
                $updateQuery = "UPDATE card SET balance = balance + $cardAmount WHERE username = '$username'";
                $updateResult = $conn->query($updateQuery);

                if ($updateResult !== false) {
                    echo json_encode(['success' => true, 'message' => 'Card balance updated successfully.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update card balance.']);
                }
            } else {
                // User doesn't have a card, insert a new row
                $insertQuery = "INSERT INTO card (username, balance, date_of_issue) VALUES ('$username', $cardAmount, CURRENT_DATE)";
                $insertResult = $conn->query($insertQuery);

                if ($insertResult !== false) {
                    echo json_encode(['success' => true, 'message' => 'Card purchased successfully.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to purchase card.']);
                }
            }
        } else {
            // Handle the case where the query fails
            echo json_encode(['success' => false, 'message' => 'Error checking card information.']);
        }
    } else {
        // Handle the case where the form is not submitted
        echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    }
} else {
    // Handle the case where the user is not logged in
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
}
?>
