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

// Check if the request method is PUT
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Get the raw input
    $input = file_get_contents('php://input');
    
    // Decode the JSON object
    $data = json_decode($input, true);

    // Extract data from the request
    $staffid = $data['staffid'];
    $fullname = $data['fullname'];
    $username = $data['username'];
    $password = $data['password'];
    $brgy = $data['brgy'];
    $user_type = $data['usertype'];

    // Initialize response array
    $response = array();

    // Check if usertype is 'senior'
    if ($user_type === 'senior') {
        // Insert into tblsenior
        $insert_query = "INSERT INTO tblsenior (username, fullname, password) VALUES ('$username', '$fullname', '$password')";
        $insert_result = mysqli_query($connection, $insert_query);

        // Check if insertion was successful
        if ($insert_result) {
            // Delete from tblstaff
            $delete_query = "DELETE FROM tblstaff WHERE staffid='$staffid'";
            $delete_result = mysqli_query($connection, $delete_query);

            // Check if deletion was successful
            if ($delete_result) {
                // Success response
                $response = array('status' => 'success', 'msg' => 'Staff information updated successfully.');
            } else {
                // Error response for tblstaff deletion failure
                $response = array('status' => 'fail', 'msg' => 'Failed to delete staff from tblstaff.');
            }
        } else {
            // Error response for tblsenior insertion failure
            $response = array('status' => 'fail', 'msg' => 'Failed to add senior staff.');
        }
    } else {
        // Update tblstaff for other user types
        $query = "UPDATE tblstaff SET fullname='$fullname', username='$username', password='$password', usertype='$user_type', brgy='$brgy' WHERE staffid='$staffid'";
        $result = mysqli_query($connection, $query);

        // Check if the query was successful
        if ($result) {
            // Success response
            $response = array('status' => 'success', 'msg' => 'Staff information updated successfully.');
        } else {
            // Error response
            $response = array('status' => 'fail', 'msg' => 'Failed to update staff information.');
        }
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);

    // Close the database connection
    mysqli_close($connection);
} else {
    // If the request method is not PUT
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('status' => 'fail', 'msg' => 'Invalid request method.'));
}
?>
