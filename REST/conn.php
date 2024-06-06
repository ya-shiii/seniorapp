<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "senior_app";

// Create connection
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optional: Set the character set to UTF-8
mysqli_set_charset($connection, "utf8");

// You can now use $connection to perform database operations
?>
