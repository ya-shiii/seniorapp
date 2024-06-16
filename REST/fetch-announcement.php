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

$sql = "SELECT * FROM tblannouncement ORDER BY Creation_date DESC";
$result = mysqli_query($connection, $sql);

$announcements = array();
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $announcements[] = $row;
    }
} else {
    $announcements[] = array('msg' => 'No Information found!');
}

echo json_encode($announcements);
mysqli_close($connection);
?>
