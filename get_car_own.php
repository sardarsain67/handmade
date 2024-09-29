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

        // Generate HTML for the modal
        $modalContent = '<div class="modal-dialog" role="document">';
        $modalContent .= '<div class="modal-content">';
        $modalContent .= '<div class="modal-header">';
        $modalContent .= '<h5 class="modal-title">Product Details</h5>';
        $modalContent .= '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        $modalContent .= '</div>';
        $modalContent .= '<div class="modal-body">';
        $modalContent .= '<p><strong>Name:</strong> ' . $carDetails['name'] . '</p>';
        $modalContent .= '<p><strong>Username:</strong> ' . $carDetails['username'] . '</p>';
        $modalContent .= '<p><strong>Service Start Date:</strong> ' . $carDetails['serviceStartDate'] . '</p>';
        $modalContent .= '<p><strong>Service End Date:</strong> ' . $carDetails['serviceEndDate'] . '</p>';

        // Features
        $modalContent .= '<h5>Features:</h5>';
        if (!empty($carDetails['features'])) {
            $modalContent .= '<ul>';
            foreach ($carDetails['features'] as $feature) {
                $modalContent .= '<li>' . $feature['name'] . ': ' . $feature['description'] . '</li>';
            }
            $modalContent .= '</ul>';
        } else {
            $modalContent .= '<p class="text-muted">No features available</p>';
        }

        // Images
        $modalContent .= '<h5 class="mt-3">Images:</h5>';
        if (!empty($carDetails['images'])) {
            $modalContent .= '<div class="row">';
            foreach ($carDetails['images'] as $imagePath) {
                $modalContent .= '<div class="col-md-3">';
                $modalContent .= '<img src="' . $imagePath . '" alt="product Image" class="img-thumbnail img-fluid">';
                $modalContent .= '</div>';
            }
            $modalContent .= '</div>';
        } else {
            $modalContent .= '<p class="text-muted">No images available</p>';
        }

        $modalContent .= '</div>';
        $modalContent .= '<div class="modal-footer">';
        $modalContent .= '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
        $modalContent .= '</div>';
        $modalContent .= '</div>';
        $modalContent .= '</div>';

        // Return the HTML content for the modal
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'product details retrieved successfully', 'modalContent' => $modalContent]);
        exit();
    } else {
        // Handle the error case
        $errorMessage = 'Error fetching product details';
    }
} else {
    // Return an error message if carId is not provided
    $errorMessage = 'product ID not provided';
}

// Return a JSON response for error cases
header('Content-Type: application/json');
echo json_encode(['success' => false, 'message' => $errorMessage]);
exit();
?>
