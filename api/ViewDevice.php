<?php
include ('functions/setup_db.php');
include ("functions/structure_query.php");

$string_url;
$page_number;
$rows_per_page = 100;


if ($_POST) {
    $string_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    if (isset($_POST['page'])) {
        $page_number = $_POST['page'];
        unset($_POST['page']);
    }
    else {
        $page_number = 1;
    }

    $string_url = (str_contains($string_url, "?")) ? $string_url : $string_url . "?";

    foreach ($_POST as $filter => $value) {
        $string_url .= $filter . "=" . $value;
        $string_url .= "&";
    }

    $string_url = substr($string_url, 0, -1);
}
else {
    $page_number = 1;
}

// if ($_GET) {
//     echo "GET method detected.\n";
//     print_r($_GET);
// }

$query = structure_query($string_url);

$page_number = ($page_number - 1) * $rows_per_page;

$query .= " LIMIT $page_number, $rows_per_page;";

echo $query;