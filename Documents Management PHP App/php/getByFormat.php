<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
include('dbConnection.php');

$format = strtolower($_GET['format']);  //This retrieves the format parameter from the URL query string (e.g. format=pdf)

$conn = OpenConnection();

$sql = "SELECT * FROM `documents` WHERE `format` = ?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $format);
$stmt->execute();
$result = $stmt->get_result();

if(!$result){
    trigger_error('Invalid query!' . $conn->error);
}

$rows = array();
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}


echo json_encode($rows);

CloseConnection($conn);
