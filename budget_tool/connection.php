<?php
    $server = 'localhost'; 
    $user = 'root';
    $password = '';
    $database = 'budget_tool';

    $connection = mysqli_connect($server, $user, $password, $database);
    if($connection == false){
        die('Connection failed! ' . mysqli_connect_error());
    // }else{
    //     echo 'Connection established!';
    }
?>