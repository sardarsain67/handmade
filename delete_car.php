<?php
// Include your server.php file for database connection
include('server.php');

// Check if the carId is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['carId'])) {
    // Get carId from the POST data
    $carId = $_POST['carId'];

    // Perform the deletion in the database
    $deleteQuery = "DELETE FROM cars WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $carId);

    if ($deleteStmt->execute()) {
        // Deletion successful
        echo json_encode(['status' => 'success', 'message' => 'product deleted successfully']);
    } else {
        // Deletion failed
        echo json_encode(['status' => 'error', 'message' => 'Error deleting car']);
    }

    // Close the statement
    $deleteStmt->close();
} else {
    // Handle the case where carId is not provided
    echo json_encode(['status' => 'error', 'message' => 'product ID not provided']);
}

// Close the database connection
$conn->close();
?>
