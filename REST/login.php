<?php
// Include the database connection file
include 'conn.php';
session_start();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw input
    $input = file_get_contents('php://input');
    
    // Decode the JSON object
    $data = json_decode($input, true);

    // Check if all required fields are provided
    if (isset($data['username'], $data['password'])) {
        $username = mysqli_real_escape_string($connection, $data['username']);
        $password = $data['password'];
        
        // Initialize the response array
        $response = array();

        // Query to check user in tblsenior
        $query_senior = "SELECT * FROM tblsenior WHERE username='$username'";
        $result_senior = mysqli_query($connection, $query_senior);

        if ($result_senior && mysqli_num_rows($result_senior) > 0) {
            $user = mysqli_fetch_assoc($result_senior);

            if ($user['status'] === 'pending') {
                // If status is 'pending', return fail message
                $response = array('status' => 'fail', 'msg' => 'Account is still pending for admin verification');
            } else {
                // Otherwise, proceed with login authentication
                if ($password === $user['password']) { // Compare plain text password
                    // If password matches, set usertype as 'user'
                    
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['session_id'] = $user['seniorcode'];
                    $_SESSION['usertype'] = 'senior';
                    $_SESSION['fullname'] = $user['fullname'];
                    
                    $response = array(
                        'status' => 'success',
                        'username' => $user['username'],
                        'usertype' => 'user'
                    );
                } else {
                    // If password doesn't match
                    $response = array('status' => 'fail', 'msg' => 'Invalid username or password.');
                }
            }
        } else {
            // Query to check user in tblstaff
            $query_staff = "SELECT * FROM tblstaff WHERE username='$username'";
            $result_staff = mysqli_query($connection, $query_staff);

            if ($result_staff && mysqli_num_rows($result_staff) > 0) {
                $user = mysqli_fetch_assoc($result_staff);

                if ($password === $user['password']) { // Compare plain text password
                    // If password matches, use usertype from tblstaff

                    $_SESSION['username'] = $user['username'];
                    $_SESSION['session_id'] = $user['staffid'];
                    $_SESSION['usertype'] = $user['usertype'];
                    $_SESSION['fullname'] = $user['fullname'];

                    $response = array(
                        'status' => 'success',
                        'username' => $user['username'],
                        'usertype' => $user['usertype'],
                        'fullname' => $user['fullname']
                    );
                } else {
                    // If password doesn't match
                    $response = array('status' => 'fail', 'msg' => 'Invalid username or password.');
                }
            } else {
                // If username is not found in both tables
                $response = array('status' => 'fail', 'msg' => 'Invalid username or password.');
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
    // If the request method is not POST
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('status' => 'fail', 'msg' => 'Invalid request method.'));
}
?>
