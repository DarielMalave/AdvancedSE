<?php
include ('functions/setup_db.php');
include ("functions/structure_query.php");

// filters and parameters:
// first should be serial_number in question for modifying
// then type, manufacturer, active

$missing_parameters = array(0, 0, 0, 0);

$mod_serial_number;
// new serial number is optional
$mod_new_serial_number;
$mod_type;
$mod_manufacturer;
$mod_active;
$query;

if (isset($_REQUEST['serial_number'])) {
    $mod_serial_number = $_REQUEST['serial_number'];
} else {
    $missing_parameters[0] = 1;
}

if (isset($_REQUEST['type'])) {
    $mod_type = $_REQUEST['type'];
} else {
    $missing_parameters[1] = 1;
}

if (isset($_REQUEST['manufacturer'])) {
    $mod_manufacturer = $_REQUEST['manufacturer'];
} else {
    $missing_parameters[2] = 1;
}

if (isset($_REQUEST['active'])) {
    $mod_active = $_REQUEST['active'];
} else {
    $missing_parameters[3] = 1;
}

if (isset($_REQUEST['new_serial_number'])) {
    $mod_new_serial_number = $_REQUEST['new_serial_number'];
}

// error checking here
if (in_array(1, $missing_parameters)) {
    $error_message = "Missing parameters: ";
    $error_message .= ($missing_parameters[0] == 1) ? "serial_number, " : "";
    $error_message .= ($missing_parameters[1] == 1) ? "type, " : "";
    $error_message .= ($missing_parameters[2] == 1) ? "manufacturer, " : "";
    $error_message .= ($missing_parameters[3] == 1) ? "active" : "";

    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output['status'] = "Error";
    $output['message'] = $error_message;
    $output['data'] = "";
    $responseData = json_encode($output);
    echo $responseData;
    die();
}

// establish database connection
$mysqli = db_iconnect("equipment");

// If user does not want to update serial number, do not update serial number and update everything else
// If user does want to update serial number, update serial number and update everything else
if (empty($mod_new_serial_number)) {
    $query = "UPDATE devices SET type = '$mod_type', manufacturer = '$mod_manufacturer', active = '$mod_active' WHERE serial_number = '$mod_serial_number'";
}
else {
    $query = "UPDATE devices SET type = '$mod_type', manufacturer = '$mod_manufacturer', active = '$mod_active', serial_number = '$mod_new_serial_number' WHERE serial_number = '$mod_serial_number'";
}

$result = $mysqli->query($query);

// if the result from query is empty, then an error occured
// NOTE: I'm not sure if this will catch any errors, but I'm leaving this in just in case
if (empty($result)) {
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output['status'] = "Error";
    $output['message'] = $mysqli->error;
    $output['data'] = "";
    $responseData = json_encode($output);
    echo $responseData;
    die();
}

// if query is successful, return result as JSON
header('Content-Type: application/json');
header('HTTP/1.1 200 OK');
$output['status'] = "OK";
$output['message'] = "Device successfully updated.";
$output['data'] = "";

$responseData = json_encode($output);
echo $responseData;
die();