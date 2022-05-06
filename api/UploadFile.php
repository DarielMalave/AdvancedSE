<?php
// Script will throw a warning if user attempts to upload an empty file, so supress that warning
error_reporting(E_ERROR | E_PARSE);
include ('functions/setup_db.php');

$mysqli = db_iconnect("equipment");

// This endpoint will allow a user to upload a PDF file with:
// file_serial_number PDF file will be associated with
// file_name (name of file)
// file_path (path to PDF file in their system)

$file_serial_number;
$file_name;
$file_path;
$upload_directory = "C:/xampp/htdocs/Advanced/api/files/";
//$upload_directory = "/var/www/";
$missing_parameters = array(0, 0, 0);

if (isset($_REQUEST['serial_number'])) {
    $file_serial_number = $_REQUEST['serial_number'];
} else {
    $missing_parameters[0] = 1;
}

if (isset($_REQUEST['file_name'])) {
    $file_name = $_REQUEST['file_name'];
} else {
    $missing_parameters[1] = 1;
}

if (isset($_REQUEST['file_path'])) {
    $file_path = $_REQUEST['file_path'];
} else {
    $missing_parameters[2] = 1;
}

// check for any missing parameters
if (in_array(1, $missing_parameters)) {
    $error_message = "Missing parameters: ";
    $error_message .= ($missing_parameters[0] == 1) ? "serial_number, " : "";
    $error_message .= ($missing_parameters[1] == 1) ? "file_name, " : "";
    $error_message .= ($missing_parameters[2] == 1) ? "file_path " : "";

    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output['status'] = "Error";
    $output['message'] = $error_message;
    $output['data'] = "";
    $responseData = json_encode($output);
    echo $responseData;
    die();
}

// If file_serial_number is not found, then throw an error. File_serial_number must exist
$fetchDuplicate = $mysqli->query("SELECT serial_number, auto_id FROM devices WHERE serial_number = '$file_serial_number' LIMIT 1") or die($mysqli->error());
if (mysqli_num_rows($fetchDuplicate) == 0) {
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output['status'] = "Error";
    $output['message'] = "Serial number not found. Please use serial number that exists in database.";
    $output['data'] = "";
    $responseData = json_encode($output);
    echo $responseData;
    die();
}

// If user uploads an empty file (or potentially don't have permissions to access files), throw an error.
if (!file_get_contents($file_path)) {
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output['status'] = "Error";
    $output['message'] = "Empty file detected. Please check if you are using correct file path or you have appropriate permissions enabled to access file.";
    $output['data'] = "";
    $responseData = json_encode($output);
    echo $responseData;
    die();
}

// After error checking, grab device_id and insert PDF information to database
$row = $fetchDuplicate->fetch_assoc();
$device_id = $row['auto_id'];
$upload_directory .= $file_name;
$query = "INSERT INTO files (device_id, file_name, file_type, file_size, location) VALUES ('$device_id', '$file_name', 'application/pdf', '1', '$upload_directory')";
$mysqli->query($query) or die($mysqli->error());

// Copy the file in question to my server's file directory (file management system > storing PDF as blob in database)
copy($file_path, $upload_directory);

header('Content-Type: application/json');
header('HTTP/1.1 200 OK');
$output['status'] = "OK";
$output['message'] = "File successfully uploaded to device serial number " . $file_serial_number . ".";
$output['data'] = "";
$responseData = json_encode($output);
echo $responseData;
die();