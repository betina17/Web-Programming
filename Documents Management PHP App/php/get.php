<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
include('dbConnection.php');

$documentId = $_GET['id'];  //This retrieves the id parameter from the URL query string (e.g. id=1)

$conn = OpenConnection();

$sql = "SELECT * FROM `documents` where `id` = ?;";  //the id will match a placeholder
$stmt = $conn->prepare($sql);  //use because we have a placeholder
$stmt->bind_param('i', $documentId);    //binds the parameter to the placeholder, i is for integer
$stmt->execute();
$result = $stmt->get_result();

if(!$result){
    trigger_error('Invalid query!' . $conn->error);
}

$row = $result->fetch_assoc();   //fetch the resulted row

echo json_encode($row);   //encode it into json string

CloseConnection($conn);
