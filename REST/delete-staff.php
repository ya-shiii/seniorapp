<?php
// Allow CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight requests (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}
// Include the database connection file
include 'conn.php';

// Check if the request method is DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Get the raw input
    $input = file_get_contents('php://input');
    
    // Decode the JSON object
    $data = json_decode($input, true);

    // Extract staffid from the request
    $staffid = $data['staffid'];

    // Delete the staff from the database
    $query = "DELETE FROM tblstaff WHERE staffid='$staffid'";
    $result = mysqli_query($connection, $query);

    // Check if the query was successful
    if ($result) {
        // Return success message
        echo json_encode(array('status' => 'success', 'msg' => 'Staff deleted successfully.'));
    } else {
        // Return error message
        echo json_encode(array('status' => 'fail', 'msg' => 'Failed to delete staff.'));
    }

    // Close the database connection
    mysqli_close($connection);
} else {
    // If the request method is not DELETE
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('status' => 'fail', 'msg' => 'Invalid request method.'));
}
?>
