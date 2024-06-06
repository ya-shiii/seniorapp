<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);
    $AnnouncementID = $input['AnnouncementID'];
    $Barangay = $input['Barangay'];
    $Announcement_title = $input['Announcement_title'];
    $Announcement_description = $input['Announcement_description'];

    $sql = "UPDATE tblannouncement SET Barangay='$Barangay', Announcement_title='$Announcement_title', Announcement_description='$Announcement_description' WHERE AnnouncementID='$AnnouncementID'";
    
    if (mysqli_query($connection, $sql)) {
        echo json_encode(array('status' => 'success', 'message' => 'Announcement updated successfully.'));
    } else {
        echo json_encode(array('status' => 'fail', 'message' => 'Failed to update announcement.'));
    }

    mysqli_close($connection);
} else {
    http_response_code(405);
    echo json_encode(array('status' => 'fail', 'message' => 'Invalid request method.'));
}
?>
