<?php
session_start();
include 'conn.php';

header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$session_id = $_SESSION['session_id'];
$fullname = $_SESSION['fullname'];
$brgy = $data['Barangay'];
$appointment_date = $data['Appointment_date'];
$time = $data['Appointment_time'];

$response = array();

if (empty($brgy) || empty($appointment_date) || empty($time)) {
    $response['status'] = 'error';
    $response['message'] = 'All fields are required.';
    echo json_encode($response);
    exit;
}

$checkSql = "SELECT * FROM tblappointment WHERE senior_code = '$session_id' AND fullname = '$fullname' AND status = 'pending'";
$result = mysqli_query($connection, $checkSql);

if (mysqli_num_rows($result) > 0) {
    $response['status'] = 'error';
    $response['message'] = 'You already have a pending appointment.';
    echo json_encode($response);
    exit;
}

$insertSql = "INSERT INTO tblappointment (senior_code, fullname, brgy, appointment_date, time, status) 
              VALUES ('$session_id', '$fullname', '$brgy', '$appointment_date', '$time', 'pending')";

if (mysqli_query($connection, $insertSql)) {
    $response['status'] = 'success';
    $response['message'] = 'Appointment added successfully.';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Failed to add appointment.';
}

mysqli_close($connection);

echo json_encode($response);
?>
