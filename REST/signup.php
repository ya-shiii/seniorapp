<?php
// Include the database connection file
include 'conn.php';

// Check if the request method is PUT
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Get the raw input
    $input = file_get_contents('php://input');
    
    // Decode the JSON object
    $data = json_decode($input, true);
    
    // Check if all required fields are provided
    if (isset($data['username'], $data['fullname'], $data['password'])) {
        $username = mysqli_real_escape_string($connection, $data['username']);
        $fullname = mysqli_real_escape_string($connection, $data['fullname']);
        $password = mysqli_real_escape_string($connection, $data['password']);
        $status = 'pending';
        
        // Check for duplicates in tblsenior and tblstaff
        $duplicate_check_senior = "SELECT * FROM tblsenior WHERE username='$username'";
        $duplicate_check_staff = "SELECT * FROM tblstaff WHERE username='$username'";
        
        $result_senior = mysqli_query($connection, $duplicate_check_senior);
        $result_staff = mysqli_query($connection, $duplicate_check_staff);
        
        if (mysqli_num_rows($result_senior) > 0 || mysqli_num_rows($result_staff) > 0) {
            // If username already exists in either table
            $response = array('status' => 'fail', 'msg' => 'Username already exists.');
        } else {
            
            
            // Insert the new user into the tblsenior table
            $sql = "INSERT INTO tblsenior (username, fullname, password, status) VALUES ('$username', '$fullname', '$password', '$status')";
            
            if (mysqli_query($connection, $sql)) {
                // If insertion is successful
                $response = array('status' => 'success', 'msg' => 'Signup successful.');
            } else {
                // If there's an error during insertion
                $response = array('status' => 'fail', 'msg' => 'Signup failed: ' . mysqli_error($connection));
            }
        }
    } else {
        // If required fields are missing
        $response = array('status' => 'fail', 'msg' => 'Incomplete data.');
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
