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
// active?
$active_state = $_POST['active'];
// string holding query
$query = "";

// trim to take care of "SN-"
$mod_serial_number = trim($mod_serial_number, "SN-");
$new_mod_serial_number = trim($new_mod_serial_number, "SN-");

// array of all 30 manufacturers
$manufacturers = array("Microsoft", "Sony", "LG", "Chrysler", "Samsung", "KIA", "OnePlus", "Apple", "Ford", "IBM", "Epson", "GM", "HP", "Dell", "Westinghouse","Lenovo", "TCL", "VIZIO", "Jeep", "Acer", "Hyundai", "Asus", "Optoma","Panasonic", "Hisense", "Generic", "ViewSonic", "Chervolet", "Insignia","Gateway");
echo in_array($mod_manufacturer, $manufacturers) ? "in array" : "not in array";
if (!in_array($mod_manufacturer, $manufacturers)) {
    echo "manufacturer fail";
    header("location: index.php?manfail");
    exit();
}

$query = "SELECT * FROM devices WHERE serial_number = '$mod_serial_number' LIMIT 1";
$fetchDuplicate = $mysqli->query($query) or die($mysqli->error());
if (mysqli_num_rows($fetchDuplicate) == 0) {
    header("location: index.php?modnotfound");
    exit();
}


if (empty($new_mod_serial_number)) {
    $query = "UPDATE devices SET manufacturer = '$mod_manufacturer', type = '$mod_type', active = '$active_state' WHERE serial_number = '$mod_serial_number' LIMIT 1";
}
else {
    $query = "UPDATE devices SET manufacturer = '$mod_manufacturer', type = '$mod_type', serial_number = '$new_mod_serial_number', active = '$active_state' WHERE serial_number = '$mod_serial_number' LIMIT 1";
}

$mysqli->query($query) or die($mysqli->error());
header("location: index.php?modsuccess");