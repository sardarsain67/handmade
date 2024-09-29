<?php
// Start the session
session_start();

// Include the server.php file that contains the database connection code
include_once('server.php');

// Define a fixed salt (replace this with your own secure, random salt)
$fixedSalt = 'pmsain'; // Make sure this is a long, unique string

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the submitted username and password
    $submittedUsername = $_POST['username'];
    $submittedPassword = $_POST['password'];

    // Prepare the SQL query to retrieve the hashed password for the given username
    $sql = "SELECT id, username, password FROM userlogin WHERE username = ?";
    
    // Use prepared statements to prevent SQL injection
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $submittedUsername);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

   // ...

    // Check if a matching row was found
    if (mysqli_stmt_num_rows($stmt) == 1) {
        // Bind the results to variables
        mysqli_stmt_bind_result($stmt, $userId, $dbUsername, $dbPassword);
        mysqli_stmt_fetch($stmt);

      
        // Combine the password with the fixed salt
    $passwordWithSalt =  $submittedPassword . $fixedSalt;

    // Hash the password with bcrypt (recommended)
    $hashedSubmittedPassword = password_hash($passwordWithSalt, PASSWORD_BCRYPT);

      
// Check if the entered password matches the stored hashed password
if (password_verify($passwordWithSalt, $dbPassword)) {
            // Valid username and password, set the session variables
            $_SESSION['username'] = $dbUsername;
            $_SESSION['userID'] = $userId;

            // Redirect to the home page
            header("Location: car_home.php");
            exit();
        }
    }

    // Invalid username and password, redirect to the login page
    header("Location: index.html");
    exit();
}
?>
