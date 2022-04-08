<?php
include('setup_db.php');
$mysqli = db_iconnect("equipment");

// delete device
$delete_serial_number = $_POST['delete_serial_number'];
$delete_serial_number = trim($delete_serial_number, "SN-");
$query = "";

$fetchDuplicate = $mysqli->query("SELECT * FROM devices WHERE serial_number = '$delete_serial_number' LIMIT 1") or die($mysqli->error());

if (mysqli_num_rows($fetchDuplicate) == 0) {
    header("location: index.php?deletenotfound");
    exit();
}

$query = "DELETE FROM devices WHERE serial_number = '$delete_serial_number' LIMIT 1";
$mysqli->query($query) or die($mysqli->error());
header("location: index.php?deletesuccess");