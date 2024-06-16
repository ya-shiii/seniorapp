<?php
// Allow CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight requests (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}
session_start();

header('Content-Type: application/json');

if (isset($_SESSION['usertype']) && isset($_SESSION['fullname'])) {
    $response = array(
        'status' => 'success',
        'usertype' => $_SESSION['usertype'],
        'brgy' => $_SESSION['brgy'],
        'fullname' => $_SESSION['fullname']
    );
} else {
    $response = array(
        'status' => 'fail',
        'msg' => 'No usertype or fullname found in session.'
    );
}

echo json_encode($response);
?>
