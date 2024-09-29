<?php
// Start the PHP session
session_start();

// Include your server.php file for database connection
include('server.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: index.html');
    exit();
}

// Check if the form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $carId = $_POST['carId'];
    $username = $_POST['username'];
    $scheduleDate = $_POST['scheduleDate'];
    $scheduleTime = $_POST['scheduleTime'];
    //$carName = $_POST['carName']; // Added variable

    // Fetch carModel (creation cost) and carName from the cars table based on carId
    $fetchCarDataQuery = "SELECT carModel, carName FROM cars WHERE id = '$carId'";
    $result = $conn->query($fetchCarDataQuery);

    if ($result->num_rows > 0) {
        // Fetch the carModel (creation cost) and carName
        $row = $result->fetch_assoc();
        $carModel = $row['carModel'];
        $carName = $row['carName']; // Update carName with the fetched value

        // Insert booking data into the database with the creation cost as the amount
        $query = "INSERT INTO bookings (car_id, username, schedule_date, schedule_time, payment_amount,  product_name) 
                  VALUES ('$carId', '$username', '$scheduleDate', '$scheduleTime', '$carModel', '$carName')"; // Added carName and product_name

        if ($conn->query($query)) {
            // Booking successful
            $response = ['success' => true, 'message' => 'Booking successful.'];
        } else {
            // Booking failed
            $response = ['success' => false, 'message' => 'Booking failed. Please try again.'];
        }
    } else {
        // product not found
        $response = ['success' => false, 'message' => 'product not found.'];
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);

    // Close the database connection
    $conn->close();
} else {
    // Invalid request method
    http_response_code(405); // Method Not Allowed
    echo 'Invalid request method.';
}
?>
