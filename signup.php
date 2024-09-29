<?php
include('server.php');

// Define a fixed salt (replace this with your own secure, random salt)
$fixedSalt = 'pmsain'; // Make sure this is a long, unique string

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $security_question = $_POST['security_question'];
    $security_answer = $_POST['security_answer'];

    // Combine the password with the fixed salt
    $passwordWithSalt = $password . $fixedSalt;
    // Hash the password with bcrypt (recommended)
    $hashed_password = password_hash($passwordWithSalt, PASSWORD_BCRYPT);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format. Please enter a valid email address.'); window.location.href='signup.html';</script>";
        exit();
    }

    // Check if the username or email is already in use
    $checkUserQuery = "SELECT * FROM userlogin WHERE username='$username' OR email='$email'";
    $result = mysqli_query($conn, $checkUserQuery);

    if (mysqli_num_rows($result) > 0) {
        // Username or email already exists
        echo "<script>alert('Username or Email already in use. Please choose another one.'); window.location.href='signup.html';</script>";
        exit();
    }

    // Prepare the SQL query to insert the user data into the userlogin table
    $sql = "INSERT INTO userlogin (username, email, password, sec_answer) VALUES ('$username', '$email', '$hashed_password', '$security_answer')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Signup successful, show an alert and redirect to login page
        echo "<script>alert('Signup successful! Please login with your new account.'); window.location.href='signin.html';</script>";
        exit();
    } else {
        // Error in inserting data
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
