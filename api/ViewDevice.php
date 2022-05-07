<?php
include ('functions/setup_db.php');
include ("functions/structure_query.php");

// establish database connection
$mysqli = db_iconnect("equipment");
// all devices returned from query will be compiled into this array
$all_devices = array();
// JSON output data will be stored into this array
$output = array();
// set up variables involved in creating query
$rows_per_page = 100;

// filters and paramters: auto_id, type, manufacturer, serial_number, active, page
$auto_id;
$type;
$manufacturer;
$serial_number;
$active;
$page;
$hold_parameters = array();

if (isset($_REQUEST['auto_id'])) {
    $auto_id = $_REQUEST['auto_id'];
    $hold_parameters[] = "auto_id=" . strval($auto_id);
}

if (isset($_REQUEST['type'])) {
    $type = $_REQUEST['type'];
    $hold_parameters[] = "type=" . $type;
}

if (isset($_REQUEST['manufacturer'])) {
    $manufacturer = $_REQUEST['manufacturer'];
    $hold_parameters[] = "manufacturer=" . $manufacturer;
}

if (isset($_REQUEST['serial_number'])) {
    $serial_number = $_REQUEST['serial_number'];
    $hold_parameters[] = "serial_number=" . $serial_number;
}

if (isset($_REQUEST['active'])) {
    $active = $_REQUEST['active'];
    $hold_parameters[] = "active=" . $active;
}

if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}
else {
    $page = 1;
}

$string_url = $_SERVER['HTTP_HOST'] . "/Advanced/api/ViewDevice.php?";
foreach ($hold_parameters as $index => $filter) {
    $string_url .= $filter;
    $string_url .= "&";
}
$string_url = substr($string_url, 0, -1);
// echo $string_url;
// echo "\n";

// print_r($hold_parameters);

// SQL query will be structured on the URL of API
$query = structure_query($string_url);
// echo $query;
// echo "\n";
$page_number = ($page - 1) * $rows_per_page;
$query .= " LIMIT $page_number, $rows_per_page;";

$result = $mysqli->query($query);

// if the result from query is empty, then an error occured
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

$i = 0;
while ($row = $result->fetch_assoc()) {
    $all_devices[$i] = $row;
    $i ++;
}

// if query is successful, return result as JSON
header('Content-Type: application/json');
header('HTTP/1.1 200 OK');
$output['status'] = "OK";
$output['message'] = "Query successfully executed.";
$output['data'] = $all_devices;

$responseData = json_encode($output);
echo $responseData;
die();