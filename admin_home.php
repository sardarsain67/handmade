<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Admin Page | HandMade-Haven</title>
    <script>
        function refreshPage() {
            // Reload the current page
            window.location.reload();
        }

        // Rest of your existing JavaScript code...
    </script>



    <!---->
    <script language="JavaScript">
        function createobject() {
            var ob;
            try {
                //create the object

                ob = new XMLHttpRequest();
            }
            catch (e) {
                try {
                    ob = new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch (e) {

                    try {
                        ob = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    catch (e) {
                        alert("Your broswer doesnot support javascript");
                    }
                }
            }
            return ob;
        }

        function plist() {
            var ob = createobject();



            ob.onreadystatechange = function () {
                if (ob.readyState == 4)
                    document.getElementById("main").innerHTML = ob.responseText;

            }
            //receive the value of text box




            //send the request the server

            ob.open("GET", "cars.php?", true);

            ob.send();

        }
        ///////////////
        function driveRequestsList(){
            var ob = createobject();



            ob.onreadystatechange = function () {
                if (ob.readyState == 4)
                    document.getElementById("main").innerHTML = ob.responseText;

            }
            //receive the value of text box




            //send the request the server

            ob.open("GET", "driverequests.php?", true);

            ob.send();

        }
        //////////////////
        function openFeaturesModal(pid) {

            var ob = createobject();
            ob.onreadystatechange = function () {
                if (ob.readyState == 4) {
                    document.getElementById("main").innerHTML = ob.responseText;
                }
            };

            var postId = pid;
            var params = "postId=" + encodeURIComponent(postId); // Properly encode the data

            // Send the request to the server using POST method
            ob.open("POST", "get_car.php", true);
            ob.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ob.send(params);
        }
////////////////////
// Function to change payment amount
function updatestatus(bookingId) {
    var ob = createobject();
            ob.onreadystatechange = function () {
                if (ob.readyState == 4) {
                    document.getElementById("main").innerHTML = ob.responseText;
                }
            };

            var postId = bookingId;
            var params = "postId=" + encodeURIComponent(postId); // Properly encode the data

            // Send the request to the server using POST method
            ob.open("POST", "update_request.php", true);
            ob.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ob.send(params);
        }
  //////////////////

  function updateBooking() {
    var ob = createobject();
    ob.onreadystatechange = function () {
        if (ob.readyState == 4) {
            // Parse the JSON response
            var response = JSON.parse(ob.responseText);

            // Display Bootstrap alert based on the response
            var alertClass, alertMessage;
            if (response.status === 'success') {
                alertClass = 'alert-success';
                alertMessage = 'Product request updated successfully.';
            } else {
                alertClass = 'alert-danger';
                alertMessage = 'Unable to update booking details.';
            }

            var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show mb-0 rounded-0" role="alert" style="border: 1px solid #155724; background-color: #d4edda; color: #155724;">' +
                            '<strong>' + response.status.charAt(0).toUpperCase() + response.status.slice(1) + ':</strong> ' + alertMessage +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>';

            // Display the alert message
            document.getElementById("main").innerHTML = alertHtml;
        }
    };

    // Get form data
    var postId = document.getElementsByName("postId")[0].value;
    var newStatus = document.getElementsByName("newStatus")[0].value;
    var newPaymentAmount = document.getElementsByName("newPaymentAmount")[0].value;
    var newPaymentStatus = document.getElementsByName("newPaymentStatus")[0].value;

    // Encode the data
    var params = "postId=" + encodeURIComponent(postId) +
                 "&newStatus=" + encodeURIComponent(newStatus) +
                 "&newPaymentAmount=" + encodeURIComponent(newPaymentAmount) +
                 "&newPaymentStatus=" + encodeURIComponent(newPaymentStatus);

    // Send the request to the server using POST method
    ob.open("POST", "update_booking_info.php", true);
    ob.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ob.send(params);

    // Display a Bootstrap alert while waiting for the response
    var alertHtml = '<div class="alert alert-info alert-dismissible fade show mb-0 rounded-0" role="alert" style="border: 1px solid #0c5460; background-color: #d1ecf1; color: #0c5460;">' +
                    '<strong>Updating:</strong> Please wait while we update the booking details.' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>';
    document.getElementById("main").innerHTML = alertHtml;

    // Prevent the default form submission
    return false;
}


  //////////
  

  function addToWebsite(carId) {
    var ob = createobject();
            ob.onreadystatechange = function () {
                if (ob.readyState == 4) {
                    document.getElementById("main").innerHTML = ob.responseText;
                }
            };

            var postId = carId;
            var params = "postId=" + encodeURIComponent(postId); // Properly encode the data

            // Send the request to the server using POST method
            ob.open("POST", "update_car_status.php", true);
            ob.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ob.send(params);
        }
// Function to delete booking
function deleteBooking(bookingId) {
    // Code to show a confirmation modal
    if (confirm('Are you sure you want to delete this booking?')) {
        // Add logic to delete the booking from the database
    }
}

        /////////////////
       

    </script>

<script>
function addToWebsite(carId) {
    // Create an AJAX object
    var xhr = new XMLHttpRequest();

    // Define the callback function to handle the response
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            // Parse the JSON response
            var response = JSON.parse(xhr.responseText);

            // Display an alert based on the response
            if (response.status === 'success') {
                alert(response.message);
                // Reload the page on success
                location.reload();
            } else {
                alert(response.message);
            }
        }
    };

    // Set up the request
    xhr.open('POST', 'update_car_status.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    // Send the request with the carId as POST data
    xhr.send('carId=' + encodeURIComponent(carId));
}
</script>
<script>
function deleteCar(carId) {
    // Confirm with the user before proceeding with deletion
    var confirmation = confirm("Are you sure you want to delete this product?");

    if (confirmation) {
        // Create an AJAX object
        var xhr = new XMLHttpRequest();

        // Define the callback function to handle the response
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                // Parse the JSON response
                var response = JSON.parse(xhr.responseText);

                // Display an alert based on the response
                if (response.status === 'success') {
                    alert(response.message);
                    // Reload the page on success
                    location.reload();
                } else {
                    alert(response.message);
                }
            }
        };

        // Set up the request
        xhr.open('POST', 'delete_car.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        // Send the request with the carId as POST data
        xhr.send('carId=' + encodeURIComponent(carId));
    }
}
</script>
<!-- Add this script to your HTML file -->
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
                var response = JSON.parse(xhr.responseText);

                // Display an alert based on the response
                if (response.status === 'success') {
                    alert(response.message);
                    // Optionally, you can update the UI or perform other actions on success
                    // For example, you may want to remove the deleted row from the HTML table
                    document.getElementById("bookingRow" + bookingId).remove();
                    // Reload the page on success
                    location.reload();
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
</script>


</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- Mobile Navigation -->
            <button class="custom-navbar-toggler d-md-none" type="button" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mobileNav">
                <div class="navbar-brand-profile">
                    <img src="img/logo.jpeg" alt="Profile Picture" class="rounded-circle"
                        style="width: 80px; height: 80px;">
                    <span style="color: #fff;">HandMade-Haven</span>
                </div>

                <!-- Center-aligned Links -->
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="refreshPage()">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick=plist()>Product Request</a>
                    </li>
                    <!-- Add more links as needed -->
                </ul>

                <!-- Logout Button (Right-aligned) -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="admin.html"><button class="btn btn-danger nav-link" href="#"
                                id="logoutButton">Logout</button></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar and Main Content Area -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar (Hidden in Mobile View) -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block d-lg-block bg-light sidebar collapse">
                <!-- Same Sidebar Content Goes Here -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="refreshPage()">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick=plist()>See Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick=driveRequestsList()>See Product Request</a>
                    </li>
                    <!-- Add more links as needed -->
                    <!-- c&p Button -->
                    <!--<li class="nav-item">
                        <a class="nav-link" href="#" onclick=viewContactandPro()>C&P</a>
                    </li>-->
                    <!-- Profile -->
                    <!--<li class="nav-item">
    <a class="nav-link" href="#" onclick="showProfile()">Profile</a>
</li>-->


                    <!-- Logout -->
                    <li class="nav-item">
                        <a href="admin.html"><button class="btn btn-danger nav-link"
                                id="logoutButton">Logout</button></a>
                    </li>
                </ul>
            </nav>

            <!-- Main Content Area -->
            <div role="main" id="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="container mt-5">
                    <!-- Admin Page Heading -->
                    <h2>Welcome to the Admin Panel</h2>

                    <!-- Admin Page Content -->
                    <div class="mt-5">
    <h4>Handmade Haven Management System - Admin Panel</h4>
    <p>Welcome to the admin panel of our Handmade Haven Management System. Here, you can efficiently manage and oversee all aspects of our handmade products platform.</p>

    <h5>Manage Listed Products</h5>
    <p>View and manage the handmade products that are currently listed on the platform. You can see details such as product ID, name, description, and take actions like viewing all features or deleting a product.</p>

    <h5>Manage Product Requests</h5>
    <p>Handle product requests that are pending approval. Add requested products to the website or view all features before making a decision.</p>

    <h5>Order Management</h5>
    <p>Effortlessly manage product orders, update their status, and handle payment details.</p>

    <h5>Artisan Management</h5>
    <p>Administer artisan accounts, review artisan activity, and manage permissions for a secure and smooth operation of the system.</p>

</div>



                    <!-- Statistics Section -->
                    <div class="row mt-5">
                        <!-- Total cars -->
                        <?php
include_once('server.php');

// Fetch the total number of rows from the cars table
$sql = "SELECT COUNT(*) AS total_cars FROM cars";
$result = $conn->query($sql);
$totalCars = 0; // Initialize the variable

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalCars = $row['total_cars'];
}
?>

                        <!-- Total Cars -->
                        <div class="col-md-4">
                            <div class="card" onclick="plist()">
                                <div class="card-body">
                                    <h5 class="card-title">Total Products</h5>
                                    <p class="card-text">
                                        <?php echo $totalCars; ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Total product requests -->
<?php
include_once('server.php');

// Fetch the total number of product requests from the bookings table with status 0 (pending)
$sqlDriveRequests = "SELECT COUNT(*) AS total_drive_requests FROM bookings ";
$resultDriveRequests = $conn->query($sqlDriveRequests);
$totalDriveRequests = 0; // Initialize the variable

if ($resultDriveRequests->num_rows > 0) {
    $rowDriveRequests = $resultDriveRequests->fetch_assoc();
    $totalDriveRequests = $rowDriveRequests['total_drive_requests'];
}
?>

<!-- Total product requests -->
<div class="col-md-4">
    <div class="card" onclick="driveRequestsList()">
        <div class="card-body">
            <h5 class="card-title">Total Products Requests</h5>
            <p class="card-text">
                <?php echo $totalDriveRequests; ?>
            </p>
        </div>
    </div>
</div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript to toggle the sidebar on mobile view
        document.addEventListener("DOMContentLoaded", function () {
            const mobileToggle = document.querySelector(".custom-navbar-toggler");
            const sidebar = document.querySelector("#sidebar");

            mobileToggle.addEventListener("click", function () {
                sidebar.classList.toggle("show");
            });
        });
    </script>
</body>

</html>