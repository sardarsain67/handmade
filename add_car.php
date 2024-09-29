<?php
// Start the session
session_start();

// Include your server.php file for database connection
include('server.php');

// Check if the session variable is set
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $carName = $_POST["carName"];
    $carModel = $_POST["carModel"];
    $featureNames = $_POST["featureNames"];
    $featureDescriptions = $_POST["featureDescriptions"];
    $serviceStartDate = $_POST["serviceStartDate"];
    $serviceEndDate = $_POST["serviceEndDate"];
    $couponCode = $_POST["couponCode"]; // New coupon code field

    // Combine features into a single column (e.g., as JSON)
    $features = [];
    for ($i = 0; $i < count($featureNames); $i++) {
        $feature = [
            "name" => $featureNames[$i],
            "description" => $featureDescriptions[$i]
        ];
        $features[] = $feature;
    }
    $featuresJSON = json_encode($features);

    // Handle uploaded images
    $imageNames = [];
    if (isset($_FILES['carImages'])) {
        $uploadDirectory = "images/"; // Set your general upload directory
        $userDirectory = $uploadDirectory . $username . "/"; // Create a directory for each user

        // Create user directory if it doesn't exist
        if (!file_exists($userDirectory)) {
            mkdir($userDirectory, 0777, true);
        }

        $imageCount = count($_FILES['carImages']['name']);

        for ($i = 0; $i < $imageCount; $i++) {
            $imageName = uniqid() . '_' . $_FILES['carImages']['name'][$i];
            $targetPath = $userDirectory . $imageName;

            if (move_uploaded_file($_FILES['carImages']['tmp_name'][$i], $targetPath)) {
                $imageNames[] = $targetPath; // Store the image path
            }
        }
    }

    // Combine image paths into a single column (e.g., as JSON)
    $imagesJSON = json_encode($imageNames);

    // Insert data into the 'cars' table
    $insertQuery = "INSERT INTO cars (username, name, carName, carModel, features, images, serviceStartDate, serviceEndDate, phone, email, couponCode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);

    if (!$stmt) {
        die("Error in preparing insert statement: " . $conn->error);
    }

    $stmt->bind_param("sssssssssss", $username, $name, $carName, $carModel, $featuresJSON, $imagesJSON, $serviceStartDate, $serviceEndDate, $phone, $email, $couponCode);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // productadded successfully. Redirect or show a success message.
        header("Location: car_add_success.php");
        exit();
    } else {
        // Error occurred. Redirect to an error page.
        header("Location: car_add_error.php");
        exit();
    }

    $stmt->close(); // Close the insert statement

    // Close the database connection
    $conn->close();
}
?>
