<?php
// Create a database connection
$servername = "localhost"; // Database server (usually localhost)
$username = "root"; // Database username
$password = null; // Database password (empty for XAMPP)
$dbname = "handmade"; // Database name
 //Create a database connection
//$servername = "sql12.freesqldatabase.com"; // Database server (usually localhost)
//$username = "sql12664116"; // Database username
//$password = "4MMEV6gyjU"; // Database password (empty for XAMPP)
//$dbname = "sql12664116"; // Database name
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
