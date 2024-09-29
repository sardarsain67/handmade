<?php
// Include your server.php file for database connection
include('server.php');

// Check if the carId is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['carId'])) {
    // Get carId from the POST data
    $carId = $_POST['carId'];

    // Update the status in the database
    $updateQuery = "UPDATE cars SET status = 1 WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("i", $carId);

    if ($updateStmt->execute()) {
        // Update successful
        echo json_encode(['status' => 'success', 'message' => 'product added to the website successfully']);
    } else {
        // Update failed
        echo json_encode(['status' => 'error', 'message' => 'Error adding product to the website']);
    }

    // Close the statement
    $updateStmt->close();
} else {
    // Handle the case where carId is not provided
    echo json_encode(['status' => 'error', 'message' => 'product ID not provided']);
}

// Close the database connection
$conn->close();
?>
