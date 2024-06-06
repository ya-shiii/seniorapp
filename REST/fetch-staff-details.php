<?php
// Include the database connection file
include 'conn.php';
session_start();

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the staffid from the session
    if (isset($_SESSION['session_id'])) {
        $staffid = mysqli_real_escape_string($connection, $_SESSION['session_id']);

        // Initialize the response array
        $response = array();

        // Query to fetch staff details
        $query = "SELECT * FROM tblstaff WHERE staffid='$staffid'";
        $result = mysqli_query($connection, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Populate the response with user data and session ID
            $response = array(
                'status' => 'success',
                'data' => $user,
                'session_id' => session_id()
            );
        } else {
            // If staffid is not found
            $response = array('status' => 'fail', 'msg' => 'Staff member not found.');
        }
    } else {
        // If staffid is not in the session
        $response = array('status' => 'fail', 'msg' => 'No staff ID in session.');
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);

    // Close the database connection
    mysqli_close($connection);
} else {
    // If the request method is not GET
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('status' => 'fail', 'msg' => 'Invalid request method.'));
}
?>
