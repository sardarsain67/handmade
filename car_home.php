
<?php
// Start the PHP session
session_start();

// Check if the user is not logged in, redirect to index.html
if (!isset($_SESSION['username'])) {
    header('Location: index.html');
    exit();
}
?>

<?php
// Include your server.php file for database connection
include('server.php');

// Fetch productdata from the 'cars' table
$query = "SELECT *, JSON_UNQUOTE(features) AS features FROM cars WHERE status = 1";
$result = $conn->query($query);

// Check if there are rows in the result set
if ($result->num_rows > 0) {
    $cars = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $cars = [];
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

    <style>
        .product {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .product-details {
            flex-grow: 1;
        }

        .features {
            padding-left: 10px;
        }

        .book-now {
            text-align: right;
            /*margin-top: 10px;*/
        }

        .features button {
            margin-top: 10px; /* Add margin to separate the buttons */
        }
    </style>




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

    <!-- Swiper Slider Section -->
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


<!-- productRental Fleet Section -->

<section class="craft" id="about">
    <h1 class="text-center">Handmade Products</h1>
    <div class="container my-2 py-2" id="products-frame">
        <input type="text" id="productSearch" class="form-control my-3" placeholder="Search for cars">
        <div class="row" id="products">
            <?php foreach ($cars as $car) : ?>
                <div class="col-md-4">
                    <div class="product" id="product<?= $car['id'] ?>">
                        <!-- Display the first image of the product-->
                        <?php
                        $imagePaths = json_decode($car['images'], true);
                        if (!empty($imagePaths)) : ?>
                            <img src="<?= $imagePaths[0] ?>" alt="<?= $car['carName'] ?>">
                        <?php endif; ?>
                        <div class="product-details">
                            <p><strong>Product Name:</strong><?= $car['carName'] ?></p>
                            <p><strong>Cost:</strong><?= $car['carModel'].'$' ?></p>
                            <button onclick="openFeaturesModal('<?= $car['id'] ?>')" class="btn btn-link">See All Features</button>
                            

                        </div>
                        <div class="book-now">
                            <!-- Add a book now button -->
                           
                            <button onclick="openBookingModal('<?= $car['id'] ?>', '<?= $_SESSION['username'] ?>')" class="btn btn-primary">Book Now</button>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>



<!-- Modal -->
<div class="modal fade" id="featuresModal" tabindex="-1" aria-labelledby="featuresModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="featuresModalLabel">Products Features</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Features and Images will be displayed here -->
            </div>
        </div>
    </div>
</div>

<!-- JavaScript function to open the booking modal -->
<script>
    function openBookingModal(carId, username) {
        // Create a modal
        var modal = document.createElement('div');
        modal.classList.add('modal', 'fade');
        modal.id = 'bookingModal';
        modal.setAttribute('tabindex', '-1');
        modal.setAttribute('aria-labelledby', 'bookingModalLabel');
        modal.setAttribute('aria-hidden', 'true');

        // Create modal dialog
        var modalDialog = document.createElement('div');
        modalDialog.classList.add('modal-dialog', 'modal-dialog-centered');
        modalDialog.setAttribute('role', 'document');

        // Create modal content
        var modalContent = document.createElement('div');
        modalContent.classList.add('modal-content');

        // Create modal header
        var modalHeader = document.createElement('div');
        modalHeader.classList.add('modal-header');

        // Add close button to header
        modalHeader.innerHTML = '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';

        // Create modal body
        var modalBody = document.createElement('div');
        modalBody.classList.add('modal-body');

        // Add form to modal body
        modalBody.innerHTML = `
            <form id="bookingForm">
                <div class="mb-3">
                    <label for="scheduleDate" class="form-label">Schedule Date:</label>
                    <input type="date" class="form-control" id="scheduleDate" name="scheduleDate" required>
                </div>
                <div class="mb-3">
                    <label for="scheduleTime" class="form-label">Schedule Time:</label>
                    <input type="time" class="form-control" id="scheduleTime" name="scheduleTime" required>
                </div>
                <button type="button" class="btn btn-primary" onclick="submitBookingForm('${carId}', '${username}')">Book Now</button>
            </form>
        `;

        // Append header and body to content, and content to dialog
        modalContent.appendChild(modalHeader);
        modalContent.appendChild(modalBody);
        modalDialog.appendChild(modalContent);
        modal.appendChild(modalDialog);

        // Append modal to body
        document.body.appendChild(modal);

        // Initialize Bootstrap modal
        var bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();
    }

    function submitBookingForm(carId, username) {
    // You can use AJAX to submit the form data to save_booking.php
    var scheduleDate = document.getElementById('scheduleDate').value;
    var scheduleTime = document.getElementById('scheduleTime').value;

    // Example AJAX call using jQuery
    $.ajax({
        url: 'save_booking.php',
        type: 'POST',
        dataType: 'json',
        data: {
            carId: carId,
            username: username,
            scheduleDate: scheduleDate,
            scheduleTime: scheduleTime,
        },
        success: function (data) {
            // Handle the response
            if (data.success) {
                // Show a success message
                alert('Your producthas been booked. Please wait for confirmation.');
                // Redirect to the confirmation page
                window.location.href = 'books.php';
            } else {
                // Show an error message
                alert('Booking failed. Please try again.');
            }
        },
        error: function (error) {
            console.error('Error submitting booking:', error);
        },
        complete: function () {
            var modal = document.getElementById('bookingModal');
            var bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.hide();
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
                                <p class="card-text">"Smooth and reliable service. The productwas in excellent condition."</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="img/testimonials/testimonials-2.jpg" alt="Customer Image 2" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">Satisfied Traveler</h5>
                                <p class="card-text">"Great selection of cars, and the rental process was straightforward."</p>
                            </div>
                        </div>
                    </div>
                    <!-- Add more customer reviews here -->
                </div>
            </div>
        </section>

    </section>
    <div id="footer"></div>
    <script>
        function toggleFeatures(featuresId) {
            const features = document.getElementById(featuresId);
            if (features.style.display === 'none') {
                features.style.display = 'block';
            } else {
                features.style.display = 'none';
            }
        }

        // Add JavaScript for productfiltering based on search input
        document.getElementById('productSearch').addEventListener('input', function () {
            var searchQuery = this.value.toLowerCase();
            var cars = document.querySelectorAll('.product');

            cars.forEach(function (car) {
                var carModel = car.querySelector('p').textContent.toLowerCase();
                if (carModel.includes(searchQuery)) {
                    car.style.display = 'block';
                } else {
                    car.style.display = 'none';
                }
            });
        });
    </script>
<!-- Your existing HTML code -->



<!-- Your existing HTML code continues -->

    <!-- Your scripts and closing body/html tags here -->
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

<!-- Add this script to your HTML file -->
<script>
    function openFeaturesModal(carId) {
        const modal = new bootstrap.Modal(document.getElementById('featuresModal'), {
            backdrop: 'static',
            keyboard: false
        });

        // Fetch features and images for the selected productusing AJAX
        $.ajax({
            url: 'get_car_details.php', // Replace with the actual server endpoint
            type: 'GET',
            data: { carId: carId },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    const car= response.data;
                    const featuresList = document.querySelector('#featuresModal .modal-body');

                    // Clear previous content
                    featuresList.innerHTML = '';

                    // Add features to the modal
                    if (Array.isArray(car.features) && car.features.length > 0) {
                        const featuresTitle = document.createElement('h6');
                        featuresTitle.classList.add('mb-3');
                        featuresTitle.textContent = 'Features:';
                        featuresList.appendChild(featuresTitle);

                        const featuresUl = document.createElement('ul');
                        featuresUl.classList.add('list-group');
                        car.features.forEach(feature => {
                            const li = document.createElement('li');
                            li.classList.add('list-group-item');
                            li.textContent = `${feature.name}: ${feature.description}`;
                            featuresUl.appendChild(li);
                        });
                        featuresList.appendChild(featuresUl);
                    } else {
                        featuresList.innerHTML = '<p class="text-muted">No features available</p>';
                    }

                    // Add images to the modal
                    if (Array.isArray(car.images) && car.images.length > 0) {
                        const imagesTitle = document.createElement('h6');
                        imagesTitle.classList.add('mt-3', 'mb-3');
                        imagesTitle.textContent = 'Images:';
                        featuresList.appendChild(imagesTitle);

                        car.images.forEach(imagePath => {
                            const img = document.createElement('img');
                            img.classList.add('img-thumbnail', 'mr-2', 'mb-2', 'img-fluid');
                            img.src = imagePath;
                            img.alt = car.carName;
                            featuresList.appendChild(img);
                        });
                    } else {
                        featuresList.innerHTML += '<p class="text-muted">No images available</p>';
                    }

                    // Show the modal
                    modal.show();
                } else {
                    // Handle the error case
                    console.error(response.message);
                }
            },
            error: function (error) {
                console.error('Error fetching productdetails:', error);
            }
        });
    }
</script>




    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
