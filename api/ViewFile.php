<?php
include ('functions/setup_db.php');
$mysqli = db_iconnect("equipment");

$file_serial_number;
$device_id = "";
$all_file_paths = array();
$upload_directory = "C:/xampp/htdocs/Advanced/api/files/";

if (!isset($_REQUEST['serial_number'])) {
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output['status'] = "Error";
    $output['message'] = "Missing parameters: serial_number";
    $output['data'] = "";
    $responseData = json_encode($output);
    echo $responseData;
    die();
}
else {
    $file_serial_number = $_REQUEST['serial_number'];
}

$fetchDuplicate = $mysqli->query("SELECT * FROM devices WHERE serial_number = '$file_serial_number' LIMIT 1") or die($mysqli->error());
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

$row = $fetchDuplicate->fetch_assoc();
$device_id = $row['auto_id'];

$query = "SELECT * FROM files WHERE device_id = '$device_id'";
$result = $mysqli->query($query) or die($mysqli->error());
if (mysqli_num_rows($result) == 0) {
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output['status'] = "OK";
    $output['message'] = "No PDF file found associated with device serial number " . $file_serial_number . ".";
    $output['data'] = "";
    $responseData = json_encode($output);
    echo $responseData;
    die();
}

while ($row = $result->fetch_assoc()) {
    $file_path = $upload_directory . $row['file_name'];
    $all_file_paths[] = $file_path;
}

header('Content-Type: application/json');
header('HTTP/1.1 200 OK');
$output['status'] = "OK";
$output['message'] = "Successfully found PDF files for device serial number " . $file_serial_number . ".";
$output['data'] = $all_file_paths;
// Need to escape slashes here so that user can copy and paste links to PDF files without having to parse
// out escape slashes
// NOTE: This could pose a security risk in real world web applications. I'm doing this for convenience
// and this API is not going to be used for real world applications
$responseData = json_encode($output, JSON_UNESCAPED_SLASHES);
echo $responseData;
die();