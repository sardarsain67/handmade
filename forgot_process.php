<?php
include_once('server.php');

// Define a fixed salt (replace this with your own secure, random salt)
$fixedSalt = 'pmsain'; // Make sure this is a long, unique string

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the form data
    $username = $_POST['username'];
    $security_answer = $_POST['security_answer'];

    // Prepare the SQL query to check the username and security answer
    $sql = "SELECT * FROM userlogin WHERE username = '$username' AND sec_answer = '$security_answer'";
    $result = mysqli_query($conn, $sql);

    // Check if a matching row was found
    if (mysqli_num_rows($result) > 0) {
        // Valid security answer, allow the user to reset the password
        // Redirect to a password reset page where the user can enter a new password
        header("Location: reset_password.php?username=$username");
        exit();
    } else {
        // Invalid security answer, redirect to forgot.html with an error flag
        header("Location: forgot.html?error=1");
        exit();
    }
}

?>
