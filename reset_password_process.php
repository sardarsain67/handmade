<?php
include_once('server.php');

// Define a fixed salt (replace this with your own secure, random salt)
$fixedSalt = 'pmsain'; // Make sure this is a long, unique string

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    $username = $_POST['username'];

    // Check if the new password matches the confirmation
    if ($newPassword === $confirmPassword) {
        // Hash the new password (with a salt if desired)
        $passwordWithSalt = $newPassword . $fixedSalt;

        // Hash the password with bcrypt (recommended)
        $hashed_password = password_hash($passwordWithSalt, PASSWORD_BCRYPT);
        // Update the user's password in the database
        $updateSql = "UPDATE userlogin SET password = '$hashed_password' WHERE username = '$username'";
        if (mysqli_query($conn, $updateSql)) {
            // Password reset successful
            // Redirect to signin.html with a success parameter
            header("Location: signin.html?success=1");
            exit(); 
        } else {
            // Error updating the password
            echo "Error updating password: " . mysqli_error($conn);
        }
        
    } 
    else {
        // Passwords do not match, redirect back to the reset_password.php page with an error message
        header("Location: reset_password.php?username=$username&error=password_mismatch");
        exit();
    }
}
?>
