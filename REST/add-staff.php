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

    $fullname = $data['fullname'];
    $username = $data['username'];
    $password = $data['password'];
    $addbrgy = $data['brgy'];
    $user_type = $data['usertype'];

    // Check for duplicates in tblstaff
    $staff_query = "SELECT * FROM tblstaff WHERE username='$username'";
    $staff_result = mysqli_query($connection, $staff_query);

    // Check if username already exists in tblstaff
    if (mysqli_num_rows($staff_result) > 0) {
        // Return error message
        echo json_encode(array('status' => 'fail', 'message' => 'Username already exists for staff account.'));
    } else {
        // Check for duplicates in tblsenior
        $senior_query = "SELECT * FROM tblsenior WHERE username='$username'";
        $senior_result = mysqli_query($connection, $senior_query);

        // Check if username already exists in tblsenior
        if (mysqli_num_rows($senior_result) > 0) {
            // Return error message
            echo json_encode(array('status' => 'fail', 'message' => 'Username already exists for senior account.'));
        } else {
            // Insert the staff information into the database
            $query = "INSERT INTO tblstaff (fullname, username, password, brgy, usertype) VALUES ('$fullname', '$username', '$password', '$addbrgy', '$user_type')";
            $result = mysqli_query($connection, $query);

            // Check if the query was successful
            if ($result) {
                // Return success message
                echo json_encode(array('status' => 'success', 'message' => 'Staff added successfully.'));
            } else {
                // Return error message
                echo json_encode(array('status' => 'fail', 'message' => 'Failed to add staff.'));
            }
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
