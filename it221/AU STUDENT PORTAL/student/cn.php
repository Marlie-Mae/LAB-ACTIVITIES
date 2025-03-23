<?php

// Database credentials
$sName = "localhost"; // Server name
$uName = "root";      // User name
$pass = "";          // Password (WARNING: Leaving this empty is a major security risk)
$db_name = "student_portal";    // Database name
$port = 3307;        // Port number

$connection = mysqli_connect($sName, $uName, $pass, $db_name, $port);

// Check connection
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Set character set (important for handling special characters)
mysqli_set_charset($connection, "utf8mb4"); // Recommended: Use utf8mb4 for full Unicode support

// Example usage (optional):
// $sql = "SELECT * FROM your_table";
// $result = mysqli_query($conn, $sql);
// ... process the result ...
?>
