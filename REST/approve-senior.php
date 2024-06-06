<?php
// Include the database connection file
include 'conn.php';

// Check if the request method is PUT
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Parse the JSON input
    $data = json_decode(file_get_contents("php://input"), true);
    $seniorcode = $data['seniorcode'];

    // Update the status of the senior citizen to approved
    $query = "UPDATE tblsenior SET status='approved' WHERE seniorcode='$seniorcode'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        // Success
        echo json_encode(array('status' => 'success', 'message' => 'Senior account approved successfully.'));
    } else {
        // Error
        echo json_encode(array('status' => 'fail', 'message' => 'Failed to approve senior account.'));
    }

    // Close the database connection
    mysqli_close($connection);
} else {
    // If the request method is not PUT
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('status' => 'fail', 'message' => 'Invalid request method.'));
}
?>
