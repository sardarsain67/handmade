<?php
// Include your server.php file for database connection
include('server.php');

// Check if the form data is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['postId'], $_POST['newStatus'], $_POST['newPaymentAmount'], $_POST['newPaymentStatus'])) {
    // Get form data
    $bookingId = $_POST['postId'];
    $newStatus = $_POST['newStatus'];
    $newPaymentAmount = $_POST['newPaymentAmount'];
    $newPaymentStatus = $_POST['newPaymentStatus'];

    // Update the booking details in the database
    $updateQuery = "UPDATE bookings SET status = ?, payment_amount = ?, payment_status = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("idis", $newStatus, $newPaymentAmount, $newPaymentStatus, $bookingId);

    if ($updateStmt->execute()) {
        // Close the statement
        $updateStmt->close();

        // Echo or return the JSON response with enhanced formal Bootstrap classes
        echo json_encode([
            'status' => 'success'
            
        ]);
    } else {
        // Update failed
        // Close the statement
        $updateStmt->close();

        echo json_encode([
            'status' => 'error',
            'message' => '<div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0" role="alert" style="border: 1px solid #721c24; background-color: #f8d7da; color: #721c24;">
                            <strong>Error:</strong> Unable to update booking details.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>'
        ]);
    }
} else {
    // Handle the case where form data is not provided
    echo json_encode([
        'status' => 'error',
        'message' => '<div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0" role="alert" style="border: 1px solid #721c24; background-color: #f8d7da; color: #721c24;">
                        <strong>Error:</strong> Form data not provided.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>'
    ]);
}

// Close the database connection
$conn->close();
?>
