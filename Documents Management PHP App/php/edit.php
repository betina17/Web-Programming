<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
include('dbConnection.php');

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {  //$_SERVER and $GET are php superglobals
    $documentId = $_GET['id'];

    $data = json_decode(file_get_contents('php://input'), true);
    //decodes the input data from the request body which is in json format 

    $conn = OpenConnection();
    $sql = "UPDATE `documents` SET `title` = ?, `author` = ?, `numberOfPages` = ?, `type` = ?, `format` = ? WHERE `id` = ?";
    $stmt = $conn->prepare($sql);

    if(!$data['title']){
        http_response_code(500);
        echo json_encode(array('message' => 'Please enter a title.'));  //array with key value pair that is encoded to json
        exit();
    }

    if (empty($data['author'])) {
        http_response_code(500); //internal server error
        echo json_encode(array('message' => 'Please enter an author.'));
        exit();
    }
    

    if(!is_numeric($data['numberOfPages'])){
        http_response_code(500);
        echo json_encode(array('message' => 'Please enter a valid number for the number of pages.'));
        exit();
    } else if((int)$data['numberOfPages'] <= 0){
        http_response_code(500);
        echo json_encode(array('message' => 'Please enter a non-null positive number for the number of pages.'));
    }

    if (empty($data['type'])) {
        http_response_code(500); 
        echo json_encode(array('message' => 'Please enter a type.'));
        exit();
    }
    

    if(!$data['format']){
        http_response_code(500);
        echo json_encode(array('message' => 'Please enter a format.'));
        exit();
    }



    $stmt->bind_param('ssissi', $data['title'], $data['author'], $data['numberOfPages'], $data['type'], $data['format'], $documentId);
    //ssissi is a string format for the parameters, s is for string, i is for integer, and is useful to ensure
    //that the data is of the correct type and to prevent sql injection attacks
    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(array('message' => 'Document updated successfully.'));
    } else {
        http_response_code(500);
        echo json_encode(array('message' => 'Error updating document.'));
    }

    CloseConnection($conn);
} else {
    http_response_code(405);
    echo json_encode(array('message' => 'Method not allowed.'));
}

