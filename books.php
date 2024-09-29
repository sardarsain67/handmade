<?php
// Include your server.php file for database connection
include('server.php');

// Start the PHP session
session_start();

// Check if the user is not logged in, redirect to index.html
if (!isset($_SESSION['username'])) {
    header('Location: index.html');
    exit();
}

// Fetch user data from the 'userlogin' table based on the username
$username = $_SESSION['username'];

// Check if the user has made a payment in the bookings table
$queryPaymentCheck = "SELECT COUNT(*) as paymentCount FROM bookings WHERE username = '$username' AND payment_status = 0";
$resultPaymentCheck = $conn->query($queryPaymentCheck);

if ($resultPaymentCheck && $resultPaymentCheck->num_rows > 0) {
    $paymentData = $resultPaymentCheck->fetch_assoc();
    $paymentCount = $paymentData['paymentCount'];

    // If there is at least one unpaid booking, don't apply the discount
    $discount = ($paymentCount > 0) ? 0 : 0.1;
} else {
    // Handle the case where the payment check query fails
    $discount = 0;
}

// Check if the user signed up with an edu.com domain
$queryUser = "SELECT * FROM userlogin WHERE username = '$username'";
$resultUser = $conn->query($queryUser);

if ($resultUser && $resultUser->num_rows > 0) {
    $userData = $resultUser->fetch_assoc();
    $email = $userData['email'];

    // Use array destructuring to get the first and second elements of the exploded array
    $emailParts = explode('@', $email);
    $emailDomain = isset($emailParts[1]) ? $emailParts[1] : '';

    // Check if the email domain is edu.com
    if ($emailDomain === 'my.unt.edu') {
        // Check if it's the user's first booking
        $queryFirstBookingCheck = "SELECT COUNT(*) as bookingCount FROM bookings WHERE username = '$username' AND payment_status = 1";
        $resultFirstBookingCheck = $conn->query($queryFirstBookingCheck);

        if ($resultFirstBookingCheck && $resultFirstBookingCheck->num_rows > 0) {
            $bookingData = $resultFirstBookingCheck->fetch_assoc();
            $bookingCount = $bookingData['bookingCount'];

            // If it's the user's first booking, apply the discount
            if ($bookingCount == 0) {
                $discount = 0.1;
            }
        }
    }
} else {
    // Handle the case where user data is not found
    $discount = 0;
}


// Fetch cars data for the current user from the 'cars' table
$queryCars = "SELECT * FROM cars WHERE username = '$username' ORDER BY id DESC";
$resultCars = $conn->query($queryCars);

// Check if there are rows in the result set
if ($resultCars->num_rows > 0) {
    $cars = $resultCars->fetch_all(MYSQLI_ASSOC);
} else {
    $cars = [];
}

// Fetch booking data for the current user from the 'bookings' table
$queryBookings = "SELECT * FROM bookings WHERE username = '$username' ORDER BY schedule_date DESC";
$resultBookings = $conn->query($queryBookings);

// Check if there are rows in the result set
if ($resultBookings->num_rows > 0) {
    $bookings = $resultBookings->fetch_all(MYSQLI_ASSOC);
} else {
    $bookings = [];
}

// Close the database connection
$conn->close();
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>welcome HandMade-Haven|Home Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Include jQuery (required for intl-tel-input) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add these links to include Swiper CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <link href="craft.css" rel="stylesheet">
    <script>
        $(document).ready(function () {
            $("#head").load("navbar2.html");
        });
        $(document).ready(function () {
            $("#footer").load("footer.html");
        });
    </script>
</head>

<body>
    <div class="head" id="head">
        <!-- Your header content here -->
    </div>
    <section id="hero">
    <div class="swiper-container">
        <div class="swiper-wrapper">
    
            <!-- Slide 1 -->
            <div class="swiper-slide" style="background-image: url(./img/slide-1.jpg)">
                <div class="carousel-container">
                    <div class="container">
                        <h2 class="animate__animated animate__fadeInDown">
                            Discover Unique Handmade Creations on <span>Haven</span>
                        </h2>
                        <p class="animate__animated animate__fadeInUp">
                            Explore a world of craftsmanship and creativity. Find the perfect handmade products crafted
                            with passion and care.
                        </p>
                        <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Browse
                            Products</a>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="swiper-slide" style="background-image: url(img/slide/slide-2.jpg)">
                <div class="carousel-container">
                    <div class="container">
                        <h2 class="animate__animated animate__fadeInDown">
                            Elevate Your Lifestyle with Artisanal Goods
                        </h2>
                        <p class="animate__animated animate__fadeInUp">
                            Immerse yourself in the world of premium handmade products. Experience luxury with our
                            curated selection of high-quality artisanal goods.
                        </p>
                        <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Explore
                            More</a>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="swiper-slide" style="background-image: url(img/slide/slide-3.jpg)">
                <div class="carousel-container">
                    <div class="container">
                        <h2 class="animate__animated animate__fadeInDown">
                            Seamless Shopping Experience
                        </h2>
                        <p class="animate__animated animate__fadeInUp">
                            Our user-friendly platform makes it easy for you to discover, connect with artisans, and
                            purchase unique handmade products. Start your handmade journey with us.
                        </p>
                        <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Shop
                            Now</a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Add Swiper pagination and navigation -->
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section><!-- End Hero -->
    <div class="container mt-5">
    <h2>Your Products Bookings</h2>

    <?php if (!empty($bookings)) : ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Schedule Date</th>
                    <th>Schedule Time</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking) : ?>
                    <tr>
                        <td><?= $booking['car_id'] ?></td>
                        <td><?= $booking['product_name'] ?></td>
                        <td><?= $booking['schedule_date'] ?></td>
                        <td><?= $booking['schedule_time'] ?></td>
                        <td>
                            <?php
                            $status = $booking['status'];
                            switch ($status) {
                                case 0:
                                    echo 'Under Review';
                                    break;
                                case 1:
                                    echo 'Approved';
                                    break;
                                case 2:
                                    echo 'Rejected';
                                    break;
                                default:
                                    echo 'Unknown Status';
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            $paymentAmount = $booking['payment_amount'];
                            if ($status == 2) {
                                $paymentAmount = 0; // For status 2, set amount to 0
                            }
                            echo $paymentAmount;
                            ?>
                        </td>
                        <td>
                            <?php
                            $paymentStatus = $booking['payment_status'];
                            echo ($paymentStatus == 0) ? 'Pending' : 'Done';
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($status == 0 && $paymentAmount != 0 && $booking['payment_status'] == 0) :
                                // Calculate discounted amount based on the discount
                                $discountedAmount = $paymentAmount - ($paymentAmount * $discount);
                            ?>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#paymentModal<?= $booking['id'] ?>" <?= ($status != 0) ? 'disabled' : '' ?>>
                                    Make Payment (<?= $discount * 100 ?>% off)
                                </button>
                                <button type="button" class="btn btn-primary my-2" onclick="deleteBooking(<?= $booking['id'] ?>)"
                                                id="delete<?= $booking['id'] ?>" >Delete</button>
                                           
                            <?php else : ?>
                                <button class="btn btn-primary" disabled>Make Payment</button>
                            <?php endif; ?>
                        </td>

                        <!-- Payment Modal -->
                        <div class="modal fade" id="paymentModal<?= $booking['id'] ?>" tabindex="-1" aria-labelledby="paymentModalLabel<?= $booking['id'] ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="paymentModalLabel<?= $booking['id'] ?>">Make Payment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                        // Calculate discounted amount
                                        $discountedAmount = $paymentAmount - ($paymentAmount * $discount);
                                        ?>
                                        <p>Total Amount: $<?= number_format($paymentAmount, 2) ?></p>
                                        <?php if ($discount > 0) : ?>
                                            <p>Discount (<?= $discount * 100 ?>%): -$<?= number_format($paymentAmount * $discount, 2) ?></p>
                                        <?php endif; ?>
                                       
                                        <!-- Add an ID to the <p> tag that displays the discounted amount -->
                                     <p id="discountedAmountLabel<?= $booking['id'] ?>">Discounted Amount: $<?= number_format($discountedAmount, 2) ?></p>
                                  
                                          <!-- Additional input fields for Discount Coupon -->
                                          <div id="discountCouponInput<?= $booking['id'] ?>">
                                          <label for="discountCoupon">Enter Discount Coupon:</label>
                                           <input type="text" class="form-control" id="discountCoupon<?= $booking['id'] ?>" name="discountCoupon">
                                           </div>
                                           <button type="button" class="btn btn-primary my-2" onclick="applyDiscount(<?= $booking['id'] ?>, <?= $paymentAmount ?>)">
                                              Apply Coupon</button>


                                        <form>
                                            <label for="paymentMethod">Select Payment Method:</label>
                                            <select class="form-select" id="paymentMethod<?= $booking['id'] ?>" name="paymentMethod" onchange="handlePaymentMethodChange(<?= $booking['id'] ?>)">
                                                <option value="" selected disabled>Please select payment method</option>
                                                <option value="credit_card">Credit Card</option>
                                                <option value="paypal">PayPal</option>
                                                <option value="carrent_pro_card">HandMade-Haven Pro Card</option>
                                                <option value="upi">UPI</option>
                                                <!-- Add more options as needed -->
                                            </select>

                                            <!-- Additional input fields for UPI -->
                                            <div id="upiInput<?= $booking['id'] ?>" style="display: none;">
                                                <label for="upiId">Enter UPI ID:</label>
                                                <input type="text" class="form-control" id="upiId<?= $booking['id'] ?>" name="upiId">
                                            </div>

                                            <!-- Additional input fields for Credit Card -->
                                            <div id="creditCardInput<?= $booking['id'] ?>" style="display: none;">
                                                <label for="cardNumber">Card Number:</label>
                                                <input type="text" class="form-control" id="cardNumber<?= $booking['id'] ?>" name="cardNumber">

                                                <label for="cvc">CVC:</label>
                                                <input type="text" class="form-control" id="cvc<?= $booking['id'] ?>" name="cvc">

                                                <label for="expiryDate">Expiry Date:</label>
                                                <input type="text" class="form-control" id="expiryDate<?= $booking['id'] ?>" name="expiryDate" placeholder="MM/YY">

                                                <label for="cardHolderName">Cardholder Name:</label>
                                                <input type="text" class="form-control" id="cardHolderName<?= $booking['id'] ?>" name="cardHolderName">
                                                <!-- Add more input fields as needed -->
                                            </div>

                                            <!-- Additional input fields for PayPal -->
                                            <div id="paypalInput<?= $booking['id'] ?>" style="display: none;">
                                                <label for="paypalId">Enter PayPal ID:</label>
                                                <input type="text" class="form-control" id="paypalId<?= $booking['id'] ?>" name="paypalId">
                                            </div>

                                            <!-- Additional input fields for CarRent Pro Card -->
                                            <div id="carrentProCardInput<?= $booking['id'] ?>" style="display: none;">
                                                <label for="carrentProCardNumber">Enter CarRent Pro Card Number:</label>
                                                <input type="text" class="form-control" id="carrentProCardNumber<?= $booking['id'] ?>" name="carrentProCardNumber">
                                            </div>

                                            <!-- Pay Now button -->
                                            <button type="button" class="btn btn-primary my-2" onclick="makePayment(<?= $booking['id'] ?>, <?= $discountedAmount ?>)"
                                                id="payNowButton<?= $booking['id'] ?>" disabled>Pay Now</button>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No bookings found.</p>
    <?php endif; ?>
</div>

<script>
    function handlePaymentMethodChange(bookingId) {
        // Get the selected payment method
        var selectedPaymentMethod = document.getElementById("paymentMethod" + bookingId).value;

       
        // Hide all additional input fields
        hideAllInputFields(bookingId);

        // Show input fields based on the selected payment method
        switch (selectedPaymentMethod) {
            case "upi":
                document.getElementById("upiInput" + bookingId).style.display = "block";
                break;
            case "credit_card":
                document.getElementById("creditCardInput" + bookingId).style.display = "block";
                break;
            case "paypal":
                document.getElementById("paypalInput" + bookingId).style.display = "block";
                break;
            case "carrent_pro_card":
                document.getElementById("carrentProCardInput" + bookingId).style.display = "block";
                break;
            default:
                // No additional input fields for other payment methods
                break;
        }

        // Enable or disable the "Pay Now" button based on whether a payment method is selected
        var payNowButton = document.getElementById("payNowButton" + bookingId);
        payNowButton.disabled = (selectedPaymentMethod === "");
    }

    function hideAllInputFields(bookingId) {
        document.getElementById("upiInput" + bookingId).style.display = "none";
        document.getElementById("creditCardInput" + bookingId).style.display = "none";
        document.getElementById("paypalInput" + bookingId).style.display = "none";
        document.getElementById("carrentProCardInput" + bookingId).style.display = "none";
    }
</script>

    <!-- Display products Table -->
    <div class="container mt-5">
        <h2>Your Listed Products</h2>

        <?php if (!empty($cars)) : ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Cost</th>
                    <th>Service Start Date</th>
                    <th>Service End Date</th>
                    <th>Action</th> <!-- New column for actions -->
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cars as $car) : ?>
                <tr>
                    <td>
                        <?= $car['id'] ?>
                    </td>
                    <td>
                        <?= $car['carName'] ?>
                    </td>
                    <td>
                        <?= $car['carModel'] ?>
                    </td>
                    <td>
                        <?= $car['serviceStartDate'] ?>
                    </td>
                    <td>
                        <?= $car['serviceEndDate'] ?>
                    </td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteCar(<?= $car['id'] ?>)">Delete</button>
                        <button class="btn btn-primary" onclick="viewCar(<?= $car['id'] ?>)">View</button>
                        <button class="btn btn-warning" onclick="updateCar(<?= $car['id'] ?>)">Update</button>
                    </td>
                    <!-- Add more columns as needed -->
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else : ?>
        <p>No cars found.</p>
        <?php endif; ?>
    </div>
    <!-- Add this modal code in your HTML -->
    <div class="modal fade" id="carDetailsModal" tabindex="-1" aria-labelledby="carDetailsModalLabel"
        aria-hidden="true">
        <!-- Modal content will be dynamically inserted here by JavaScript -->
    </div>

    <script>
        function deleteCar(carId) {

            // Show a confirmation dialog
            var confirmation = confirm("Are you sure you want to delete this car?");
            if (confirmation) {
                // Perform AJAX request to delete_car.php or your preferred endpoint
                $.ajax({
                    url: 'delete_car.php', // Adjust the endpoint
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        carId: carId
                    },
                    success: function (response) {
                        // Handle the response
                        if (response.success) {
                            // Remove the deleted row from the table
                            $('tr[data-car-id="' + carId + '"]').remove();
                            alert(response.message);
                            // Reload the page on success
                            location.reload();
                        } else {
                            alert(response.message);
                            // Reload the page on success
                            location.reload();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error deleting car:', error);
                    }
                });
            }
        }

        function viewCar(carId) {
            // Perform AJAX request to get_car_own.php or your preferred endpoint
            $.ajax({
                url: 'get_car_own.php', // Adjust the endpoint
                type: 'POST',
                dataType: 'json',
                data: {
                    postId: carId // Use postId as the key
                },
                success: function (response) {
                    // Handle the response
                    if (response.success) {
                        // Display the details in a Bootstrap modal
                        $('#carDetailsModal').html(response.modalContent);
                        $('#carDetailsModal').modal('show');
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching productdetails:', error);
                }
            });
        }

    </script>

<script>
    function makePayment(bookingId, discountedAmount) {
        // Get the selected payment method
        var selectedPaymentMethod = document.getElementById("paymentMethod" + bookingId).value || "carrent_pro_card";
        console.log("Selected Payment Method:", selectedPaymentMethod);
        var discountedAmount;

if (window.discountedAmount !== undefined) {
    discountedAmount = window.discountedAmount;
} else {
    // Get the discountedAmount from the UI or wherever it's available
    discountedAmount = discountedAmount /* logic to get discounted amount */;
}
        
        // Get additional input values based on the selected payment method
        var additionalParams = {};
        switch (selectedPaymentMethod) {
            case "upi":
                additionalParams.upiId = document.getElementById("upiId" + bookingId).value;
                break;
            case "credit_card":
                additionalParams.cardNumber = document.getElementById("cardNumber" + bookingId).value;
                additionalParams.cvc = document.getElementById("cvc" + bookingId).value;
                additionalParams.expiryDate = document.getElementById("expiryDate" + bookingId).value;
                additionalParams.cardHolderName = document.getElementById("cardHolderName" + bookingId).value;
                break;
            case "paypal":
                additionalParams.paypalId = document.getElementById("paypalId" + bookingId).value;
                break;
            case "carrent_pro_card":
                additionalParams.carrentProCardNumber = document.getElementById("carrentProCardNumber" + bookingId).value;
                break;
            default:
                // No additional input fields for other payment methods
                break;
        }

        // Log the data being sent to payment.php
        console.log("Sending data to payment.php:", {
            bookingId: bookingId,
            discountedAmount: discountedAmount,
            paymentMethod: selectedPaymentMethod,
            additionalParams: additionalParams,
        });

        // Perform fetch request to payment.php
        fetch('payment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            bookingId: bookingId,
            discountedAmount: discountedAmount,
            paymentMethod: selectedPaymentMethod,
            ...additionalParams,
        }),
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response
        if (data.success) {
            // Update discountedAmount if payment is successful
            discountedAmount = data.discountedAmount;

            // Show a success message
            alert('Payment successful: ' + data.message);

            // Optionally, you can reload the page or update the UI
            window.location.reload();
        }  else {
                    // Show an error message
                    if (data.message === 'No card found for the user. Please buy a card.') {
                        if (confirm(data.message + ' Do you want to go to the card page?')) {
                            // Redirect to card.php
                            window.location.href = 'card.php';
                        }
                    } else if (data.message === 'Insufficient balance in your card. Please add funds.') {
                        alert('Payment failed: ' + data.message);
                        if (confirm(data.message + ' Do you want to go to the card page?')) {
                            // Redirect to card.php
                            window.location.href = 'card.php';
                        }

                    } else {
                        alert('Payment failed for other reasons: ' + data.message);
                    }
                }
            })
            .catch(error => {
                console.error('Error making payment:', error);
                alert('An error occurred while making the payment. Please try again.');
            });
    }
</script>
<script>
function deleteBooking(bookingId) {
    // Confirm with the user before proceeding with the deletion
    if (confirm("Are you sure you want to delete this booking?")) {
        // Create an AJAX object
        var xhr = new XMLHttpRequest();

        // Define the callback function to handle the response
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                // Parse the JSON response
                window.location.reload();
                var response = JSON.parse(xhr.responseText);

                // Display an alert based on the response
                if (response.success) {
                     // Reload the page on success
                   window.location.reload();
                    alert(response.message);
                    // Optionally, you can update the UI or perform other actions on success
                    // For example, you may want to remove the deleted row from the HTML table
                    var deletedRow = document.getElementById("bookingRow" + bookingId);
                    if (deletedRow) {
                        deletedRow.remove();
                    }
                   
                } else {
                    alert(response.message);
                }
            }
        };

        // Set up the request
        xhr.open('POST', 'delete_booking.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        // Send the request with the bookingId as POST data
        xhr.send('bookingId=' + encodeURIComponent(bookingId));
    }
}

////////////////////
function applyDiscount(bookingId, paymentAmount) {
    var discountCoupon = document.getElementById('discountCoupon' + bookingId).value;

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            var response = JSON.parse(xhr.responseText);

            if (response.success) {
                // Coupon code is valid, update the UI with the discounted amount
                var discountedAmount = paymentAmount - (paymentAmount * response.discount);
                updateDiscountedAmount(bookingId, discountedAmount);
            } else {
                alert(response.message);
            }
        }
    };

    xhr.open('POST', 'validate_coupon.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('bookingId=' + bookingId + '&couponCode=' + encodeURIComponent(discountCoupon));

}

// Function to update the discounted amount in the UI
function updateDiscountedAmount(bookingId, discountedAmount) {
    // Update the content of the <p> tag with the discounted amount
    var discountedAmountLabel = document.getElementById('discountedAmountLabel' + bookingId);
    discountedAmountLabel.innerText = 'Discounted Amount: $' + discountedAmount.toFixed(2);

    // Optionally, you can also update the global variable
    window.discountedAmount = discountedAmount;
}




</script>

<!-- Add a modal for updating productdetails -->
<div class="modal" id="updateCarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update productDetails</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form to update productdetails -->
                <form id="updateCarForm">
                    <!-- Display id in a non-editable field -->
                    <div class="mb-3">
                        <label for="updateCarId" class="form-label">Product ID</label>
                        <input type="text" class="form-control" id="updateCarId" name="updateCarId" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="updateCarUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="updateCarUsername" name="updateCarUsername" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="updateCarName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="updateCarName" name="updateCarName" required>
                    </div>

                    <div class="mb-3">
                        <label for="updateCarPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="updateCarPhone" name="updateCarPhone" required>
                    </div>

                    <div class="mb-3">
                        <label for="updateCarEmail" class="form-label">Email</label>
                        <input type="text" class="form-control" id="updateCarEmail" name="updateCarEmail" required>
                    </div>

                    <div class="mb-3">
                        <label for="updateCarCarName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="updateCarCarName" name="updateCarCarName" required>
                    </div>

                    <div class="mb-3">
                        <label for="updateCarCarModel" class="form-label">Product Cost</label>
                        <input type="text" class="form-control" id="updateCarCarModel" name="updateCarCarModel" required>
                    </div>

                    <div class="mb-3">
                        <label for="updateCarFeatures" class="form-label">Features</label>
                        <textarea class="form-control" id="updateCarFeatures" name="updateCarFeatures" required></textarea>
                    </div>

                    <!--<div class="mb-3">
                        <label for="updateCarImages" class="form-label">Images</label>
                        <textarea class="form-control" id="updateCarImages" name="updateCarImages" required></textarea>
                    </div>-->

                    <div class="mb-3">
                        <label for="updateCarServiceStartDate" class="form-label">Service Start Date</label>
                        <input type="text" class="form-control" id="updateCarServiceStartDate" name="updateCarServiceStartDate" required>
                    </div>

                    <div class="mb-3">
                        <label for="updateCarServiceEndDate" class="form-label">Service End Date</label>
                        <input type="text" class="form-control" id="updateCarServiceEndDate" name="updateCarServiceEndDate" required>
                    </div>

                    <div class="mb-3">
                        <label for="updateCarCreatedAt" class="form-label">Created At</label>
                        <input type="text" class="form-control" id="updateCarCreatedAt" name="updateCarCreatedAt" readonly>
                    </div>

                    <!--<div class="mb-3">
                        <label for="updateCarStatus" class="form-label">Status</label>
                        <input type="text" class="form-control" id="updateCarStatus" name="updateCarStatus" required>
                    </div>-->

                    <div class="mb-3">
                        <label for="updateCarCouponCode" class="form-label">Coupon Code</label>
                        <input type="text" class="form-control" id="updateCarCouponCode" name="updateCarCouponCode">
                    </div>

                    <!-- Add more input fields as needed -->

                    <button type="button" class="btn btn-primary" onclick="saveChanges()">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to handle the "Update" button click
    function updateCar(carId) {
        // Make an AJAX request to fetch productdetails by carId
        $.ajax({
            url: 'fetch_car_details.php', // Replace with your server-side script to fetch productdetails
            method: 'GET',
            data: { carId: carId },
            success: function (response) {
                // Populate the modal with productdetails
                $('#updateCarId').val(response.id);
                $('#updateCarUsername').val(response.username);
                $('#updateCarName').val(response.name);
                $('#updateCarPhone').val(response.phone);
                $('#updateCarEmail').val(response.email);
                $('#updateCarCarName').val(response.carName);
                $('#updateCarCarModel').val(response.carModel);
                $('#updateCarFeatures').val(response.features);
                $('#updateCarImages').val(response.images);
                $('#updateCarServiceStartDate').val(response.serviceStartDate);
                $('#updateCarServiceEndDate').val(response.serviceEndDate);
                $('#updateCarCreatedAt').val(response.created_at);
                $('#updateCarStatus').val(response.status);
                $('#updateCarCouponCode').val(response.couponCode);
                // Populate more fields as needed

                // Show the modal
                $('#updateCarModal').modal('show');
            },
            error: function () {
                alert('Failed to fetch productdetails.');
            }
        });
    }

    // Function to handle the "Save Changes" button click
function saveChanges() {
    // Retrieve values from form fields
    var carId = $('#updateCarId').val();
    //console.log('productID to be updated:', carId); // Add this line for debugging
    var name = $('#updateCarName').val();
    var phone = $('#updateCarPhone').val();
    var email = $('#updateCarEmail').val();
    var carName = $('#updateCarCarName').val();
    var carModel = $('#updateCarCarModel').val();
    var features = $('#updateCarFeatures').val();
    //var images = $('#updateCarImages').val(); // Commented out for now
    var serviceStartDate = $('#updateCarServiceStartDate').val();
    var serviceEndDate = $('#updateCarServiceEndDate').val();
    //var status = $('#updateCarStatus').val();
    var couponCode = $('#updateCarCouponCode').val();

    // Construct data to be sent to the server
    var data = {
        carId: carId,
        name: name,
        phone: phone,
        email: email,
        carName: carName,
        carModel: carModel,
        features: features,
        //images: images, // Commented out for now
        serviceStartDate: serviceStartDate,
        serviceEndDate: serviceEndDate,
        status: status,
        couponCode: couponCode
    };

    // Make an AJAX request to update productdetails
    $.ajax({
        url: 'update_car_details.php',
        method: 'POST',
        data: data,
        success: function (response) {
            // Handle success, e.g., show a success message
            alert('Details updated successfully!');
            // Close the modal
            $('#updateCarModal').modal('hide');
            // You might want to refresh the page or update the displayed data
            // based on the update. It depends on your application's flow.
        },
        error: function () {
            // Handle error, e.g., show an error message
            alert('Failed to update productdetails.');
        }
    });
}

</script>







    <!-- Customer Reviews Section -->
<section class="mt-5 py-2">
    <div class="container">
        <h2 class="text-center">Customer Reviews</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="img/testimonials/testimonials-1.jpg" alt="Customer Image 1" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Happy Customer 1</h5>
                        <p class="card-text">"Absolutely delighted with my handmade purchase! The craftsmanship is outstanding."</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="img/testimonials/testimonials-2.jpg" alt="Customer Image 2" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Satisfied Art Lover</h5>
                        <p class="card-text">"Extensive collection of unique handmade products. The ordering process was smooth."</p>
                    </div>
                </div>
            </div>
            <!-- Add more customer reviews here -->
        </div>
    </div>
</section>

    <div id="footer"></div>
    <script>
        var swiper = new Swiper('.swiper-container', {
            // Optional parameters
            loop: true,
            autoplay: {
                delay: 5000, // 5 seconds delay between slides
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>