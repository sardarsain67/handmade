<?php
// fetch_car_details.php

// Assuming you have a database connection in your server script
include('server.php');

// Get the carId from the GET request
$carId = $_GET['carId'];

// Fetch product details from the 'cars' table
$query = "SELECT * FROM cars WHERE id = $carId";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Fetch the first row (assuming carId is unique)
    $carDetails = $result->fetch_assoc();

    // Return the product details as JSON
    header('Content-Type: application/json');
    echo json_encode($carDetails);
} else {
    // Return an empty JSON object if no product is found
    header('Content-Type: application/json');
    echo json_encode([]);
}

// Close the database connection
$conn->close();
?>
