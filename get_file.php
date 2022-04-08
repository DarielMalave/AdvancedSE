<?php
include('setup_db.php');
$mysqli = db_iconnect("equipment");
$get_serial_number = $_POST['get_serial_number'];
$get_serial_number = trim($get_serial_number, "SN-");
$device_id = "";

$fetchDuplicate = $mysqli->query("SELECT * FROM devices WHERE serial_number = '$get_serial_number' LIMIT 1") or die($mysqli->error());
if (mysqli_num_rows($fetchDuplicate) == 0) {
    header("location: index.php?pdfnotfound");
    exit();
}

$row = $fetchDuplicate->fetch_assoc();
$device_id = $row['auto_id'];

$query = "SELECT * FROM files WHERE device_id = '$device_id'";
$result = $mysqli->query($query) or die($mysqli->error());
if (mysqli_num_rows($result) == 0) {
    echo "<p>No PDF found associated with this serial number.</p>";
    exit();
}

while ($row = $result->fetch_assoc()) {
    echo "<a href='./files/" . $row['file_name'] . "' target='_blank'>Click here for file</a>";
    echo "<br>";
}