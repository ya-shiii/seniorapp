<?php
// Allow CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Barangay");

// Handle preflight requests (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

include 'conn.php';

// Check if X-Barangay header is present
if (isset($_SERVER['HTTP_BARANGAY'])) {
    $barangay = $_SERVER['HTTP_BARANGAY'];

    // Sanitize barangay value to prevent SQL injection
    $barangay = mysqli_real_escape_string($connection, $barangay);

    // Query to fetch announcements filtered by barangay
    $sql = "SELECT * FROM tblannouncement WHERE Barangay = '$barangay' ORDER BY Creation_date DESC";
    $result = mysqli_query($connection, $sql);

    $announcements = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $announcements[] = $row;
        }
    } else {
        $announcements[] = array('msg' => 'No Information found!');
    }

    echo json_encode($announcements);
} else {
    // X-Barangay header is missing
    echo json_encode(array('error' => 'Barangay header is missing'));
}

mysqli_close($connection);
?>
