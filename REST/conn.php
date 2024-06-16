<?php
// Database connection details
$servername = "localhost"; //srv1457.hstgr.io
$username = "root"; //u663034616_alvaradoken29
$password = ""; //Kshmrken123
$dbname = "senior_app"; //u663034616_senior_app

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
