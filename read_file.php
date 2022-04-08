<?php
include('setup_db.php');
$mysqli = db_iconnect("equipment");
$query = "SELECT * FROM files WHERE device_id = 10";
$result = $mysqli->query($query) or die($mysqli->error());

while ($row = $result->fetch_assoc()) {
    //$file = 'Pdf_File/' . $row["Path"];
    $filename = $row["file_name"];
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    //header('Content-Transfer-Encoding: binary');
    //header('Accept-Ranges: bytes');
    readfile("file:///C:/Users/dswor/Downloads/resume_dariel.pdf");
}
?>