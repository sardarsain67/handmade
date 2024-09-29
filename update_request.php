<?php
// Include your server.php file for database connection
include('server.php');

// Check if the bookingId is provided
if (isset($_POST['postId'])) {
    $bookingId = $_POST['postId'];

    // Fetch booking details for the specified bookingId
    $query = "SELECT * FROM bookings WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $bookingId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query was successful
    if ($result) {
        $bookingDetails = $result->fetch_assoc();
    } else {
        // Handle the error case
        echo 'Error fetching booking details';
        exit;
    }

    // Close the statement
    $stmt->close();
} else {
    // Handle the case where bookingId is not provided
    echo 'Booking ID not provided';
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newStatus'], $_POST['newPaymentAmount'], $_POST['newPaymentStatus'])) {
    // Get form data
    $newStatus = $_POST['newStatus'];
    $newPaymentAmount = $_POST['newPaymentAmount'];
    $newPaymentStatus = $_POST['newPaymentStatus'];

    // Update the booking details in the database
    $updateQuery = "UPDATE bookings SET status = ?, payment_amount = ?, payment_status = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    //$updateStmt->bind_param("idii", $newStatus, $newPaymentAmount, $newPaymentStatus, $bookingId);
    $updateStmt->bind_param("idis", $newStatus, $newPaymentAmount, $newPaymentStatus, $bookingId);

    if ($updateStmt->execute()) {
        // Update successful
        header('Location: driverequests.php'); // Redirect to the page showing all requests
        exit;
    } else {
        // Update failed
        echo 'Error updating booking details';
    }

    // Close the statement
    $updateStmt->close();
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HandMade-Haven Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
            <!-- Include jQuery (required for intl-tel-input) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add these links to include Swiper CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <!-- Add this script to handle the form submission and show alert -->

</head>

<body>

<div class="container mt-5">
        <h2>Update Booking</h2>

     <!-- Display booking details in a form -->
<form method="post" onsubmit="return updateBooking()">
    <input type="hidden" name="postId" value="<?= $bookingDetails['id'] ?>">
    <div class="mb-3">
        <label for="carId" class="form-label">Product ID</label>
        <input type="text" class="form-control" id="carId" name="carId" value="<?= $bookingDetails['car_id'] ?>" readonly>
    </div>
    <!-- ... (other fields) ... -->
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="newStatus">
            <option value="0" <?= ($bookingDetails['status'] == 0) ? 'selected' : '' ?>>Under Review</option>
            <option value="1" <?= ($bookingDetails['status'] == 1) ? 'selected' : '' ?>>Approved</option>
            <option value="2" <?= ($bookingDetails['status'] == 2) ? 'selected' : '' ?>>Rejected</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="paymentAmount" class="form-label">Payment Amount</label>
        <input type="text" class="form-control" id="paymentAmount" name="newPaymentAmount" value="<?= $bookingDetails['payment_amount'] ?>">
    </div>
    <div class="mb-3">
        <label for="paymentStatus" class="form-label">Payment Status</label>
        <select class="form-select" id="paymentStatus" name="newPaymentStatus">
            <option value="0" <?= ($bookingDetails['payment_status'] == 0) ? 'selected' : '' ?>>Pending</option>
            <option value="1" <?= ($bookingDetails['payment_status'] == 1) ? 'selected' : '' ?>>Done</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Save Changes</button>
</form>
<!-- Add this script to handle the form submission and show alert -->


    </div>




    <!-- Bootstrap JS and Popper.js (Optional for Bootstrap components that require JavaScript) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-GLhlTQ8iKJE9H3Lt9G3OQzXn5ZLOhC5w8ebu9Ongjtc1/JPa35/bGFiQNa9DBpiD" crossorigin="anonymous"></script>

</body>

</html>
