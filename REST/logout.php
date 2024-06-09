<?php
session_start();
session_destroy();
header('Location: ../index.html'); // Adjust the path to your login page
exit();
?>
