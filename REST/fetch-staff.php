<?php
// Include the database connection file
include 'conn.php';

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Query to fetch all staffs
    $query = "SELECT * FROM tblstaff";

    // Execute the query
    $result = mysqli_query($connection, $query);

    // Initialize an empty array to store staff data
    $staff_data = array();

    // Check if there are any staffs
    if (mysqli_num_rows($result) > 0) {
        // Fetch staff data and store it in the array
        while ($row = mysqli_fetch_assoc($result)) {
            $staff_data[] = $row;
        }
    } else {
        // If no staffs found, return a message
        $staff_data[] = array('msg' => 'No Information found!');
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($staff_data);

    // Close the database connection
    mysqli_close($connection);
} else {
    // If the request method is not GET
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('status' => 'fail', 'msg' => 'Invalid request method.'));
}
?>
