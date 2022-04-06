<?php
include ("setup_db.php");
$mysqli = db_iconnect("equipment");
$all_devices = array();
$all_filters_placeholder = array();
$device_type = $_POST['device_type'];
$manufacturer = $_POST['manufacturer'];
$serial_number = $_POST['serial_number'];
$serial_number = trim($serial_number, "SN-");
$cardUpdatedCount = $_POST['cardCountUpdated'];
$rowsPerPage = $_POST['rowsPerPage'];
$all_filters = array("type" => $device_type, "manufacturer" => $manufacturer, "serial_number" => $serial_number);
$query = (!array_filter($all_filters)) ? "SELECT * FROM devices" : "SELECT * FROM devices WHERE ";

foreach ($all_filters as $key => $filter) {
    if (empty($filter)) {
        continue;
    }

    $all_filters_placeholder[] = "$key = '$filter'";
}

foreach ($all_filters_placeholder as $key => $filter) {
    if ($key == count($all_filters_placeholder) - 1) {
        $query .= $filter;
        continue;
    }

    $query .= $filter . " AND ";
}

$query .= " LIMIT $cardUpdatedCount, $rowsPerPage;";

$result = $mysqli->query($query) or die($mysqli->error);


while($row = $result->fetch_assoc()) {
    $all_devices[] = $row;
}

$updated_all_devices = rawurlencode(json_encode($all_devices));
echo $updated_all_devices;