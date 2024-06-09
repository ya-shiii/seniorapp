<?php
session_start();

header('Content-Type: application/json');

if (isset($_SESSION['usertype'])) {
    $response = array(
        'status' => 'success',
        'usertype' => $_SESSION['usertype']
    );
} else {
    $response = array(
        'status' => 'fail',
        'msg' => 'No usertype found in session.'
    );
}

echo json_encode($response);
?>
