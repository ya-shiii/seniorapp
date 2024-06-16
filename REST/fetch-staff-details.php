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

    // Get the staffid from the session
    if (isset($_GET['session_id'])) {
        $staffid = mysqli_real_escape_string($connection, $_GET['session_id']);

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

