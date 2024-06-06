<?php
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
