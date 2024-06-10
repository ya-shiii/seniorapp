<?php
include 'conn.php';
session_start();
$brgy = $_SESSION['brgy'];


$sql = "SELECT * FROM tblappointment WHERE brgy  ='$brgy' ORDER BY appointment_date ASC";
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
