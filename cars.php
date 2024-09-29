<?php
include_once('server.php');

// Fetch listed cars (status = 1)
$sqlListed = "SELECT * FROM cars WHERE status = 1 ORDER BY id DESC";
$resultListed = $conn->query($sqlListed);

// Fetch cars with status 0 (requests)
$sqlRequests = "SELECT * FROM cars WHERE status = 0 ORDER BY id DESC";
$resultRequests = $conn->query($sqlRequests);
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
 

</head>

<body>

    <div class="container mt-5">
        <h2>Listed Products</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Cost</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($rowListed = $resultListed->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $rowListed['id'] ?></td>
                        <td><?= $rowListed['carName'] ?></td>
                        <td><?= $rowListed['carModel'] ?></td>
                        <td>
                        <button onclick="openFeaturesModal('<?= $rowListed['id'] ?>')" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#featuresModal">See All Features</button>
                            <button class="btn btn-danger" onclick="deleteCar(<?= $rowListed['id'] ?>)">Delete</button>
                        </td>
                    </tr>

                    
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2>Product Listed Requests</h2>
        <table class="table">
            <thead>
                <tr>
                <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Cost</th>
                    <th>Add to Website</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($rowRequests = $resultRequests->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $rowRequests['id'] ?></td>
                        <td><?= $rowRequests['carName'] ?></td>
                        <td><?= $rowRequests['carModel'] ?></td>
                        <td>
                        <button onclick="openFeaturesModal('<?= $rowRequests['id'] ?>')" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#featuresModal">See All Features</button>
                            <button class="btn btn-success" onclick="addToWebsite(<?= $rowRequests['id'] ?>)">Add to Website</button>
                            <button class="btn btn-danger" onclick="deleteCar(<?= $rowRequests['id'] ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

<!-- Add this script to your HTML file -->

 

    <!-- Bootstrap JS and Popper.js (Optional for Bootstrap components that require JavaScript) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-GLhlTQ8iKJE9H3Lt9G3OQzXn5ZLOhC5w8ebu9Ongjtc1/JPa35/bGFiQNa9DBpiD" crossorigin="anonymous"></script>

</body>

</html>
