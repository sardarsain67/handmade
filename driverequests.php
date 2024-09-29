<?php
// Include your server.php file for database connection
include('server.php');

// Fetch approved booking data from the 'bookings' table (status = 1)
$sqlApproved = "SELECT * FROM bookings WHERE status = 1";
$resultApproved = $conn->query($sqlApproved);

// Fetch under review booking data from the 'bookings' table (status = 0)
$sqlUnderReview = "SELECT * FROM bookings WHERE status = 0 ORDER BY schedule_date DESC";
$resultUnderReview = $conn->query($sqlUnderReview);

// Fetch rejected booking data from the 'bookings' table (status = 2)
$sqlRejected = "SELECT * FROM bookings WHERE status = 2";
$resultRejected = $conn->query($sqlRejected);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>product Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
            <!-- Include jQuery (required for intl-tel-input) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add these links to include Swiper CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</head>

<body>

<div class="container">
        <h2>Approved Bookings</h2>
        <table class="table">
            <!-- Add table header with column names -->
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Product ID</th>
                    <th>Username</th>
                    <th>Schedule Date</th>
                    <th>Schedule Time</th>
                    <th>Status</th>
                    <th>Payment Amount</th>
                    <th>Payment Status</th>
                    <!-- Add more columns if needed -->
                </tr>
            </thead>
            <tbody>
                <?php while ($rowApproved = $resultApproved->fetch_assoc()) : ?>
                    <!-- Add rows with data for approved bookings -->
                    <tr>
                        <td><?= $rowApproved['id'] ?></td>
                        <td><?= $rowApproved['car_id'] ?></td>
                        <td><?= $rowApproved['username'] ?></td>
                        <td><?= $rowApproved['schedule_date'] ?></td>
                        <td><?= $rowApproved['schedule_time'] ?></td>
                        <td>Approved</td>
                        <td><?= $rowApproved['payment_amount'] ?></td>
                        <td><?= ($rowApproved['payment_status'] == 1) ? 'Done' : 'Pending' ?></td>
                        <!-- Add more columns if needed -->
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2>Under Review Bookings</h2>
<table class="table">
    <!-- Add table header with column names -->
    <thead>
        <tr>
            <th>Booking ID</th>
            <th>Product ID</th>
            <th>Username</th>
            <th>Schedule Date</th>
            <th>Schedule Time</th>
            <th>Status</th>
            <th>Payment Amount</th>
            <th>Payment Status</th>
            <th>Actions</th>
            <!-- Add more columns if needed -->
        </tr>
    </thead>
    <tbody>
        <?php while ($rowUnderReview = $resultUnderReview->fetch_assoc()) : ?>
            <!-- Add rows with data for under review bookings -->
            <tr>
                <td><?= $rowUnderReview['id'] ?></td>
                <td><?= $rowUnderReview['car_id'] ?></td>
                <td><?= $rowUnderReview['username'] ?></td>
                <td><?= $rowUnderReview['schedule_date'] ?></td>
                <td><?= $rowUnderReview['schedule_time'] ?></td>
                <td>Under Review</td>
                <td><?= $rowUnderReview['payment_amount'] ?></td>
                <td><?= ($rowUnderReview['payment_status'] == 1) ? 'Done' : 'Pending' ?></td>
                <td>
                    <!-- Add Bootstrap buttons for actions -->
                    <button class="btn btn-primary" onclick="updatestatus(<?= $rowUnderReview['id'] ?>)">view/update</button>
                    
                    <button class="btn btn-danger" onclick="deleteBooking(<?= $rowUnderReview['id'] ?>)">Delete</button>
                </td>
                <!-- Add more columns if needed -->
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

        <h2>Rejected Bookings</h2>
        <table class="table">
            <!-- Add table header with column names -->
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Product ID</th>
                    <th>Username</th>
                    <th>Schedule Date</th>
                    <th>Schedule Time</th>
                    <th>Status</th>
                    <th>Payment Amount</th>
                    <th>Actions</th>
                    <!-- Add more columns if needed -->
                </tr>
            </thead>
            <tbody>
                <?php while ($rowRejected = $resultRejected->fetch_assoc()) : ?>
                    <!-- Add rows with data for rejected bookings -->
                    <tr>
                        <td><?= $rowRejected['id'] ?></td>
                        <td><?= $rowRejected['car_id'] ?></td>
                        <td><?= $rowRejected['username'] ?></td>
                        <td><?= $rowRejected['schedule_date'] ?></td>
                        <td><?= $rowRejected['schedule_time'] ?></td>
                        <td>Rejected</td>
                        <td><?= $rowRejected['payment_amount'] ?></td>
                        <!-- Add more columns if needed -->
                        <td>
                    <!-- Add Bootstrap buttons for actions -->
                    <button class="btn btn-primary" onclick="updatestatus(<?= $rowRejected['id'] ?>)">view/update</button>
                    
                    <button class="btn btn-danger" onclick="deleteBooking(<?= $rowRejected['id'] ?>)">Delete</button>
                </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Add any additional scripts here -->
    <script>
        function changePaymentAmount(bookingId) {
            // Implement logic to change payment amount (e.g., show a modal)
            // You can use AJAX to interact with the server
            console.log('Change payment amount for booking ID: ' + bookingId);
        }

        function deleteBooking(bookingId) {
            // Implement logic to delete booking (e.g., show a confirmation modal)
            // You can use AJAX to interact with the server
            console.log('Delete booking with ID: ' + bookingId);
        }
    </script>


    <!-- Bootstrap JS and Popper.js (Optional for Bootstrap components that require JavaScript) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-GLhlTQ8iKJE9H3Lt9G3OQzXn5ZLOhC5w8ebu9Ongjtc1/JPa35/bGFiQNa9DBpiD" crossorigin="anonymous"></script>

</body>

</html>
