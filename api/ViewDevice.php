<?php
include ('functions/setup_db.php');
include ("functions/structure_query.php");

// filters and paramters: auto_id, type, manufacturer, serial_number, active, page

// establish database connection
$mysqli = db_iconnect("equipment_new");

// all devices returned from query will be compiled into this array
$all_devices = array();

// JSON output data will be stored into this array
$output = array();

// set up variables involved in creating query
$string_url = "";
$page_number = 1;
$rows_per_page = 100;

// Handle API call if it's a POST request
if ($_POST) {
    $string_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    if (isset($_POST['page'])) {
        $page_number = $_POST['page'];
        unset($_POST['page']);
    }

    $string_url = (str_contains($string_url, "?")) ? $string_url : $string_url . "?";

    foreach ($_POST as $filter => $value) {
        $string_url .= $filter . "=" . $value;
        $string_url .= "&";
    }

    $string_url = substr($string_url, 0, -1);
}

// Handle API call if it's a GET request
if ($_GET) {
    $string_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    if (isset($_GET['page'])) {
        $page_number = $_GET['page'];
        unset($_GET['page']);
    }
}

// SQL query will be structured on the URL of API
$query = structure_query($string_url);
$page_number = ($page_number - 1) * $rows_per_page;
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