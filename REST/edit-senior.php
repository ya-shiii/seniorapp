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
    // Parse the JSON input
    $data = json_decode(file_get_contents("php://input"), true);

    $seniorcode = $data['seniorcode'];
    $fullname = $data['fullname'];
    $dob = $data['dob'];
    $age = $data['age'];
    $address = $data['address'];
    $contactnumber = $data['contactnumber'];
    $username = $data['username'];
    $password = $data['password'];

    // Check for duplicates in tblsenior
    $senior_query = "SELECT * FROM tblsenior WHERE username='$username' AND seniorcode != '$seniorcode'";
    $senior_result = mysqli_query($connection, $senior_query);

    // Check for duplicates in tblstaff
    $staff_query = "SELECT * FROM tblstaff WHERE username='$username'";
    $staff_result = mysqli_query($connection, $staff_query);

    // Check if username already exists in tblsenior or tblstaff
    if (mysqli_num_rows($senior_result) > 0 || mysqli_num_rows($staff_result) > 0) {
        // Return error message
        echo json_encode(array('status' => 'fail', 'message' => 'Username already exists for senior or staff account.'));
    } else {
        // Update the senior information in the database
        $query = "UPDATE tblsenior SET fullname='$fullname', dob='$dob', age='$age', address='$address', contactnumber='$contactnumber', username='$username', password='$password' WHERE seniorcode='$seniorcode'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            // Success
            echo json_encode(array('status' => 'success', 'message' => 'Senior information updated successfully.'));
        } else {
            // Error
            echo json_encode(array('status' => 'fail', 'message' => 'Failed to update senior information.'));
        }
    }

    // Close the database connection
    mysqli_close($connection);
} else {
    // If the request method is not PUT
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('status' => 'fail', 'message' => 'Invalid request method.'));
}
?>
