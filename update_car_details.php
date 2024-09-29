<?php
// update_car_details.php
session_start();

// Include your server.php file for database connection
include('server.php');

// Retrieve data from the AJAX request
$carId = $_POST['carId'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$carName = $_POST['carName'];
$carModel = $_POST['carModel'];
$features = $_POST['features'];
$serviceStartDate = $_POST['serviceStartDate'];
$serviceEndDate = $_POST['serviceEndDate'];
$couponCode = $_POST['couponCode'];

// Debugging: Print received data
error_log("product ID: $carId");
error_log("Name: $name");
error_log("Phone: $phone");
error_log("Email: $email");
error_log("product Name: $carName");
error_log("product Model: $carModel");
error_log("Features: $features");
error_log("Service Start Date: $serviceStartDate");
error_log("Service End Date: $serviceEndDate");
error_log("Coupon Code: $couponCode");

// Update the product details in the database
$query = "UPDATE cars SET
            name = ?,
            phone = ?,
            email = ?,
            carName = ?,
            carModel = ?,
            features = ?,
            serviceStartDate = ?,
            serviceEndDate = ?,
            couponCode = ?
          WHERE id = ?";

// Using prepared statements to prevent SQL injection
$stmt = $conn->prepare($query);
$stmt->bind_param('sssssssssi', $name, $phone, $email, $carName, $carModel, $features, $serviceStartDate, $serviceEndDate, $couponCode, $carId);

// Execute the statement
$result = $stmt->execute();

if ($result) {
    // Update successful
    echo json_encode(['success' => true]);
} else {
    // Update failed
    echo json_encode(['success' => false]);
}

// Close the statement and database connection if needed
$stmt->close();
$conn->close();
?>
