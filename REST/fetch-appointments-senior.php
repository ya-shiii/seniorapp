<?php
// Allow CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight requests (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

include 'conn.php';

// Retrieve username from query parameter
if (isset($_GET['fullname'])) {
    $fullname = mysqli_real_escape_string($connection, $_GET['fullname']);

    // Query appointments based on username
    $sql = "SELECT * FROM tblappointment WHERE fullname = '$fullname' ORDER BY appointment_date ASC";
    $result = mysqli_query($connection, $sql);

    $appointments = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $appointments[] = $row;
        }
    } else {
        $appointments[] = array('msg' => 'No Information found!');
    }

    echo json_encode($appointments);
} else {
    // Handle case where username parameter is missing
    http_response_code(400); // Bad Request
    echo json_encode(array('error' => 'Username parameter is missing'));
}

mysqli_close($connection);
?>
