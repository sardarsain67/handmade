<?php
// Include your server.php file for database connection
include('server.php');

// Check if the carId is provided
if (isset($_GET['carId'])) {
    $carId = $_GET['carId'];

    // Prepare and execute a query to get details of the specified car
    $query = "SELECT * FROM cars WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $carId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query was successful
    if ($result) {
        $carDetails = $result->fetch_assoc();

        // Format the features JSON string into an array
        $carDetails['features'] = json_decode($carDetails['features'], true);

        // Format the images JSON string into an array
        $carDetails['images'] = json_decode($carDetails['images'], true);

        // Return the data as JSON
        echo json_encode(['success' => true, 'data' => $carDetails]);
    } else {
        // Return an error message
        echo json_encode(['success' => false, 'message' => 'Error fetching product details']);
    }

    // Close the statement
    $stmt->close();
} else {
    // Return an error message if carId is not provided
    echo json_encode(['success' => false, 'message' => 'product ID not provided']);
}

// Close the database connection
$conn->close();
?>
