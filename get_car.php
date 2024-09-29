<?php
// Include your server.php file for database connection
include('server.php');

// Check if the carId is provided
if (isset($_POST['postId'])) {
    $carId = $_POST['postId'];

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
    } else {
        // Handle the error case
        echo 'Error fetching product details';
        exit();
    }

    // Close the statement
    $stmt->close();
} else {
    // Return an error message if carId is not provided
    echo 'product ID not provided';
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <!-- Back button -->
    <!--<a class="btn btn-primary mb-3" href="#" onclick="goBack()">Back</a>-->

    <!-- product Details -->
    <h2><?= $carDetails['carName'] ?></h2>
    <p>Cost: <?= $carDetails['carModel'] ?></p>
    
    <!-- Additional Information -->
    <p>ID: <?= $carDetails['id'] ?></p>
    <p>Username: <?= $carDetails['username'] ?></p>
    <p>Name: <?= $carDetails['name'] ?></p>
    <p>Phone: <?= $carDetails['phone'] ?></p>
    <p>Email: <?= $carDetails['email'] ?></p>
    <p>Start Date: <?= $carDetails['serviceStartDate'] ?></p>
    <p>End Date: <?= $carDetails['serviceEndDate'] ?></p>

    <!-- Features -->
    <h3>Features:</h3>
    <?php if (!empty($carDetails['features'])) : ?>
        <ul class="list-group">
            <?php foreach ($carDetails['features'] as $feature) : ?>
                <li class="list-group-item"><?= $feature['name'] ?>: <?= $feature['description'] ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p class="text-muted">No features available</p>
    <?php endif; ?>

    <!-- Images -->
    <h3 class="mt-3">Images:</h3>
    <?php if (!empty($carDetails['images'])) : ?>
        <div class="row">
            <?php foreach ($carDetails['images'] as $imagePath) : ?>
                <div class="col-md-3">
                    <img src="<?= $imagePath ?>" alt="product Image" class="img-thumbnail img-fluid">
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p class="text-muted">No images available</p>
    <?php endif; ?>
</div>

<!-- Bootstrap JS and Popper.js (Optional for Bootstrap components that require JavaScript) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>


</body>
</html>
