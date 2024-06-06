<?php
// Include the database connection file
include 'conn.php';

// Check if the request method is PUT
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Parse the JSON input
    $data = json_decode(file_get_contents("php://input"), true);

    $fullname = $data['fullname'];
    $dob = $data['dob'];
    $age = $data['age'];
    $address = $data['address'];
    $contactnumber = $data['contactnumber'];
    $username = $data['username'];
    $password = $data['password'];

    // Check for duplicates in tblsenior
    $senior_query = "SELECT * FROM tblsenior WHERE username='$username'";
    $senior_result = mysqli_query($connection, $senior_query);

    // Check for duplicates in tblstaff
    $staff_query = "SELECT * FROM tblstaff WHERE username='$username'";
    $staff_result = mysqli_query($connection, $staff_query);

    // Check if username already exists in either table
    if (mysqli_num_rows($senior_result) > 0 || mysqli_num_rows($staff_result) > 0) {
        // Return error message
        echo json_encode(array('status' => 'fail', 'message' => 'Username already exists.'));
    } else {
        // Insert the senior information into the database
        $query = "INSERT INTO tblsenior (fullname, dob, age, address, contactnumber, username, password) 
                  VALUES ('$fullname', '$dob', '$age', '$address', '$contactnumber', '$username', '$password')";
        $result = mysqli_query($connection, $query);

        // Check if the query was successful
        if ($result) {
            // Return success message
            echo json_encode(array('status' => 'success', 'message' => 'Senior added successfully.'));
        } else {
            // Return error message
            echo json_encode(array('status' => 'fail', 'message' => 'Failed to add senior.'));
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
