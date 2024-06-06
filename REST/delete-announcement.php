<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $input = json_decode(file_get_contents('php://input'), true);
    $AnnouncementID = $input['AnnouncementID'];

    $sql = "DELETE FROM tblannouncement WHERE AnnouncementID='$AnnouncementID'";
    
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
