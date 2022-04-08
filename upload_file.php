<?php
include('setup_db.php');
$mysqli = db_iconnect("equipment");
$file_serial_number = $_POST['file_serial_number'];
$file_serial_number = trim($file_serial_number, "SN-");
$device_id = "";

$fetchDuplicate = $mysqli->query("SELECT * FROM devices WHERE serial_number = '$file_serial_number' LIMIT 1") or die($mysqli->error());
if (mysqli_num_rows($fetchDuplicate) == 0) {
    header("location: index.php?deletenotfound");
    exit();
}

$row = $fetchDuplicate->fetch_assoc();
$device_id = $row['auto_id'];
echo $_FILES['userfile']['type'];

if (isset($_POST['upload_file']) && $_FILES['userfile']['type'] != "application/pdf") {
    echo "Not a PDF file. Please try again.";
    exit();
}

if (isset($_POST['upload_file']) && $_FILES['userfile']['size'] > 0) {
    $upload_directory = "C:/xampp/htdocs/Advanced/files";

    $fileName = $_FILES['userfile']['name'];
    $tmpName  = $_FILES['userfile']['tmp_name'];
    $fileSize = $_FILES['userfile']['size'];
    $fileType = $_FILES['userfile']['type'];

    $location = "$upload_directory/$fileName";
    move_uploaded_file($tmpName, $location);

    $query = "INSERT INTO files (device_id, file_name, file_type, file_size, location) VALUES ('$device_id', '$fileName', '$fileType', '$fileSize', '$location')";

    $mysqli->query($query) or die($mysqli->error());

    echo "<br>File $fileName uploaded<br>";
}