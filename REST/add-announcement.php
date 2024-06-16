<?php
// Allow CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight requests (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Read the input stream
    $input = file_get_contents('php://input');
    // Decode the JSON data
    $data = json_decode($input, true);

    $Barangay = $data['Barangay'];
    $Announcement_title = $data['Announcement_title'];
    $Announcement_description = $data['Announcement_description'];

    $sql = "INSERT INTO tblannouncement (Barangay, Announcement_title, Announcement_description) 
            VALUES ('$Barangay', '$Announcement_title', '$Announcement_description')";
    
    if (mysqli_query($connection, $sql)) {
        echo json_encode(array('status' => 'success', 'message' => 'Announcement added successfully.'));
    } else {
        echo json_encode(array('status' => 'fail', 'message' => 'Failed to add announcement.'));
    }

    mysqli_close($connection);
} else {
    http_response_code(405);
    echo json_encode(array('status' => 'fail', 'message' => 'Invalid request method.'));
}
?>
