<?php
// validate_coupon.php

// validate_coupon.php

// Retrieve the bookingId and coupon code from the request
$bookingId = $_POST['bookingId'];
$couponCode = $_POST['couponCode'];
error_log('Received booking ID: ' . $bookingId);
error_log('Received coupon code: ' . $couponCode);

// Sample response structure
$response = ['success' => false, 'message' => 'Invalid coupon code'];

// Check if the bookingId exists in the bookings table
// Assuming you have a database connection established

// Include your server.php file for database connection
include('server.php');

// Fetch product id from the bookings table
$bookingQuery = "SELECT car_id FROM bookings WHERE id = ?";
$stmt = $conn->prepare($bookingQuery);
$stmt->bind_param('i', $bookingId);
$stmt->execute();
$stmt->bind_result($productId);
$stmt->fetch();
$stmt->close();

if ($productId) {
    // If product id is found, fetch the couponCode from the cars table
    $carQuery = "SELECT couponCode FROM cars WHERE id = ?";
    $stmt = $conn->prepare($carQuery);
    $stmt->bind_param('i', $productId);
    $stmt->execute();
    $stmt->bind_result($validCouponCode);
    $stmt->fetch();
    $stmt->close();

    if ($validCouponCode && $validCouponCode === $couponCode) {
        // Valid coupon code
        $response['success'] = true;
        // Extract the last two digits from the coupon code for discount
        $discountPercentage = intval(substr($couponCode, -2)) / 100;
        $response['discount'] = $discountPercentage;
        $response['message'] = 'Coupon code applied successfully';
    }
}

// Close the database connection
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);

?>
