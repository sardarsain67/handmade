<?php
// Start the PHP session
session_start();

// Destroy the session data
session_destroy();

// Redirect to the index.html page after logout
header('Location: index.html');
exit();
?>
