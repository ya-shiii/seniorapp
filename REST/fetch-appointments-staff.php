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
$brgy = $_GET['brgy'];


$sql = "SELECT * FROM tblappointment WHERE brgy='$brgy' ORDER BY appointment_date ASC";
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
mysqli_close($connection);
?>
