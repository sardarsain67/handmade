<?php
// Include your server.php file for database connection
include('server.php');

// Check if the bookingId is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bookingId'])) {
    // Get bookingId from the POST data
    $bookingId = $_POST['bookingId'];

    // Delete the booking from the database
    $deleteQuery = "DELETE FROM bookings WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $bookingId);

    if ($deleteStmt->execute()) {
        // Deletion successful
        echo json_encode(['status' => 'success', 'message' => 'Booking deleted successfully']);
    } else {
        // Deletion failed
        echo json_encode(['status' => 'error', 'message' => 'Error deleting booking']);
    }

    // Close the statement
    $deleteStmt->close();
} else {
    // Handle the case where bookingId is not provided
    echo json_encode(['status' => 'error', 'message' => 'Booking ID not provided']);
}

// Close the database connection
$conn->close();
?>
