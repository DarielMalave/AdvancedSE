<?php
include ("setup_db.php");
$mysqli = db_iconnect("equipment");
$all_devices = array();
$query = "SELECT * FROM devices LIMIT 0,100";
$result = $mysqli->query($query) or die($mysqli->error);


while($row = $result->fetch_assoc()) {
    $all_devices[] = $row;
}

$updated_all_devices = rawurlencode(json_encode($all_devices));
echo $updated_all_devices;

// echo "<pre>";
// print_r($all_devices);
// echo "</pre>";