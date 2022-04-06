<?php
include('setup_db.php');
$mysqli = db_iconnect("equipment");

// update device type
$mod_type = $_POST['mod_type'];
// update manufacturer
$mod_manufacturer = $_POST['mod_manufacturer'];
// get serial number
$mod_serial_number = $_POST['mod_serial_number'];
// perhaps new serial number
$new_mod_serial_number = $_POST['new_mod_serial_number'];
// string holding query
$query = "";

// trim to take care of "SN-"
$mod_serial_number = trim($mod_serial_number, "SN-");
$new_mod_serial_number = trim($new_mod_serial_number, "SN-");

// array of all 30 manufacturers
$manufacturers = array("Microsoft", "Sony", "LG", "Chrysler", "Samsung", "KIA", "OnePlus", "Apple", "Ford", "IBM", "Epson", "GM", "HP", "Dell", "Westinghouse","Lenovo", "TCL", "VIZIO", "Jeep", "Acer", "Hyundai", "Asus", "Optoma","Panasonic", "Hisense", "Generic", "ViewSonic", "Chervolet", "Insignia","Gateway");

if (!in_array($mod_manufacturer, $manufacturers)) {
    header("location: index.php?manfail");
}

$fetchDuplicate = $mysqli->query("SELECT serial_number FROM devices WHERE serial_number = '$mod_serial_number'") or die($mysqli->error());
if (mysqli_num_rows($fetchDuplicate) == 0) {
    header("location: index.php?modnotfound");
}

if (empty($new_mod_serial_number)) {
    $query = "UPDATE devices SET manufacturer = '$mod_manufacturer', type = '$mod_type' WHERE serial_number = '$mod_serial_number'";
}
else {
    $query = "UPDATE devices SET manufacturer = '$mod_manufacturer', type = '$mod_type', serial_number = '$new_mod_serial_number' WHERE serial_number = '$mod_serial_number'";
}

$mysqli->query($query) or die($mysqli->error());
header("location: index.php?modsuccess");