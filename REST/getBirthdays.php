<?php
// Include database connection
include 'conn.php';

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch birthdays for the current month from the database
    function fetchBirthdays() {
        global $connection;

        // Get current month and year
        $currentMonth = date('m');

        // Construct SQL query to fetch birthdays for the current month
        $sql = "SELECT * FROM tblsenior WHERE MONTH(dob) = $currentMonth";

        // Execute SQL query
        $result = $connection->query($sql);

        if (!$result) {
            // If query execution failed
            return array('error' => 'Error executing SQL query: ' . $connection->error);
        }

        $birthdays = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $birthday = array(
                    'fullname' => $row['fullname'],
                    'dob' => $row['dob']
                );
                $birthdays[] = $birthday;
            }
        }

        // Return birthdays or error message
        return $birthdays ? $birthdays : array('message' => 'No birthdays found for the current month.');
    }

    // Fetch birthdays and return JSON response
    $response = fetchBirthdays();
    echo json_encode($response);
} else {
    // If the request method is not GET
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('status' => 'fail', 'msg' => 'Invalid request method.'));
}
?>
