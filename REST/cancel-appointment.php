<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);
    $appointment_id = $input['appointment_id'];

    $sql = "UPDATE tblappointment SET `status` = 'cancel' WHERE appointment_id='$appointment_id'";
    
    if (mysqli_query($connection, $sql)) {
        echo json_encode(array('status' => 'success', 'message' => 'Announcement deleted successfully.'));
    } else {
        echo json_encode(array('status' => 'fail', 'message' => 'Failed to delete announcement.'));
    }

    mysqli_close($connection);
} else {
    http_response_code(405);
    echo json_encode(array('status' => 'fail', 'message' => 'Invalid request method.'));
}
?>
