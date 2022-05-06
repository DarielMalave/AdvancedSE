<?php
include ('functions/setup_db.php');
include ("functions/structure_query.php");

// Insert endpoint is for inserting a new device (not inserting a new device type or manufacturer)
// Given a new serial number and corresponding type, manufacturer, active state - 
// insert the device into database (as long as serial number does not exist)

$mysqli = db_iconnect("equipment");

$new_type;
$new_manufacturer;
$new_serial_number;
$new_active;
$manufacturers = array("Microsoft", "Sony", "LG", "Chrysler", "Samsung", "KIA", "OnePlus", "Apple", "Ford", "IBM", "Epson", "GM", "HP", "Dell", "Westinghouse","Lenovo", "TCL", "VIZIO", "Jeep", "Acer", "Hyundai", "Asus", "Optoma","Panasonic", "Hisense", "Generic", "ViewSonic", "Chervolet", "Insignia","Gateway");
$missing_parameters = array(0, 0, 0, 0);

if (isset($_REQUEST['serial_number'])) {
    $new_serial_number = $_REQUEST['serial_number'];
} else {
    $missing_parameters[0] = 1;
}

if (isset($_REQUEST['type'])) {
    $new_type = $_REQUEST['type'];
} else {
    $missing_parameters[1] = 1;
}

if (isset($_REQUEST['manufacturer'])) {
    $new_manufacturer = $_REQUEST['manufacturer'];
} else {
    $missing_parameters[2] = 1;
}

if (isset($_REQUEST['active'])) {
    $new_active = $_REQUEST['active'];
} else {
    $missing_parameters[3] = 1;
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

// If new_manufacturer is not within the 30 defined manufacturers, throw an error
if (!in_array($new_manufacturer, $manufacturers)) {
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output['status'] = "Error";
    $output['message'] = "Please insert valid manufacturer name. Case sensitive.";
    $output['data'] = "";
    $responseData = json_encode($output);
    echo $responseData;
    die();
}

// If new_serial_number does not fit the structure of serial_number, throw an error
if (!preg_match("/^[A-Za-z]+[A-Za-z0123456789-]+$/", $new_serial_number) || strlen($new_serial_number) > 64) {
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output['status'] = "Error";
    $output['message'] = "Please insert valid serial number. Must begin with SN- followed by hexadecimal digits.";
    $output['data'] = "";
    $responseData = json_encode($output);
    echo $responseData;
    die();
}

// If new_serial_number already exists, throw an error. New device must have unique, new serial number
$fetchDuplicate = $mysqli->query("SELECT serial_number FROM devices WHERE serial_number = '$new_serial_number' LIMIT 1") or die($mysqli->error());
if (mysqli_num_rows($fetchDuplicate) > 0) {
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output['status'] = "Error";
    $output['message'] = "Duplicate serial number found. Please use unique, unused serial number.";
    $output['data'] = "";
    $responseData = json_encode($output);
    echo $responseData;
    die();
}

// After error checking, insert device
$query = "INSERT INTO devices (type, manufacturer, serial_number, active) VALUES ('$new_type', '$new_manufacturer', '$new_serial_number', '$new_active');";
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
$output['message'] = "Device successfully inserted.";
$output['data'] = "";

$responseData = json_encode($output);
echo $responseData;
die();