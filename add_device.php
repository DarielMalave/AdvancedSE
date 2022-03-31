<?php
include('setup_db.php');
$mysqli = db_iconnect("equipment");

$new_type = $_POST['new_type'];
$new_manufacturer = $_POST['new_manufacturer'];
$new_serial_number = $_POST['new_serial_number'];
$new_serial_number = trim($new_serial_number, "SN-");
$manufacturers = array("Microsoft", "Sony", "LG", "Chrysler", "Samsung", "KIA", "OnePlus", "Apple", "Ford", "IBM", "Epson", "GM", "HP", "Dell", "Westinghouse","Lenovo", "TCL", "VIZIO", "Jeep", "Acer", "Hyundai", "Asus", "Optoma","Panasonic", "Hisense", "Generic", "ViewSonic", "Chervolet", "Insignia","Gateway");
// $new_arr = array_map(function($piece){
//     return (string) $piece;
// }, $manufacturers);


// if (!preg_match("/[A-Za-z]+/", $new_manufacturer) || strlen($new_manufacturer) > 32 || !in_array($new_manufacturer, $manufacturers)) {
//     header("location: index.php?manfail");
// }

// print_r($manufacturers);
// echo "<br>";
// print_r($new_arr);

if (!in_array($new_manufacturer, $manufacturers)) {
    header("location: index.php?manfail");
}

if (!preg_match("/[A-Za-z]+[A-Za-z0123456789-]+/", $new_serial_number) || strlen($new_serial_number) > 64) {
    header("location: index.php?serialfail");
}

$fetchDuplicate = $mysqli->query("SELECT serial_number FROM devices WHERE serial_number = '$new_serial_number'") or die($mysqli->error());
if (mysqli_num_rows($fetchDuplicate) > 0) {
    header("location: index.php?duplicate");
}

// if (count($rowForDuplicate) > 0) {
//     header("location: index.php?duplicate");
// }

//$query = "INSERT INTO devices (type, manufacturer, serial_number) VALUES ('$new_type', '$new_manufacturer', '$new_serial_number');";