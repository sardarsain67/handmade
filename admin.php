<?php
// Start the session
session_start();

// Include the server.php file that contains the database connection code
include_once('server.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the submitted username and password
    $submittedUsername = $_POST['username'];
    $submittedPassword = $_POST['password'];

    // Prepare the SQL query to check the username and password
    $sql = "SELECT * FROM admin WHERE admin_name = '$submittedUsername' AND admin_pass = '$submittedPassword'";
    $result = mysqli_query($conn, $sql);

    // Check if a matching row was found
    if (mysqli_num_rows($result) > 0) {
        // Valid username and password, set the session variable to indicate the user is logged in
        $_SESSION['username'] = $submittedUsername;
        // After successful login, set the userID in the session
        //$_SESSION['userID'] = $userID; // Replace $userID with the actual user ID value

        header("Location: admin_home.php");
        exit();
    } else {
        // Invalid username and password, redirect to index.html
        header("Location: admin.html");
        exit();
    }
}


?>