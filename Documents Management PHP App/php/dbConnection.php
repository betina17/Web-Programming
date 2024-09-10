<?php

function OpenConnection(): mysqli   //function by default public
{
    $server = "localhost";
    $user = "root";
    $password = "";
    $database = "documentsdb";

    $con = mysqli_connect($server, $user, $password, $database);

    if(!$con){
        die('Could not connect to database!');  //terminates the php script with message
    }
    
    return $con;
}

function CloseConnection(mysqli $con): void
{
    $con->close();
}
?>