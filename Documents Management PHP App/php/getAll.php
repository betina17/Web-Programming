<?php
header('Access-Control-Allow-Origin: *'); //allow requests from any origin
header('Content-type: application/json'); //set response content type to json
include('dbConnection.php');
    $conn = OpenConnection();
    $sql = "SELECT * FROM `documents`;";
    $result = $conn->query($sql);  //the query method of the connection object

    if(!$result){
        trigger_error('Invalid query!' . $conn->error); //the dot appends to the string. the error can be seen in the console
    }


    /*fetch_assoc() is a method of the MySQLi result object.
It fetches a result row as an associative array, where the keys are the column names and the values are the corresponding data.
It returns false when there are no more rows to fetch*/ 

    $rows = array();
    while($row = $result->fetch_assoc()){
        $rows[] = $row;       //we construct an array of fetched objects  (it's like a list of dictioanries in python)
    }   //that is how we append to an array in php
    //array() is an associative array in php, which is like a dictionary in python, because it maps keys to values,
    //and those keys can be strings or integers, and the values can be any type of data

    echo json_encode($rows);  //we encode the array to json and send it as response

    CloseConnection($conn);

