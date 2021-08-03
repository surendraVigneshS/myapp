<?php

    $host = "localhost";  
    // $user = "freeztek_erpuser";  
    // $password = "bLX&Uew{S9,5";  
    $user = "root";  
    $password = "";  
    $dbname = "freeztek_erp";  
    date_default_timezone_set('Asia/Kolkata'); 
    $dbconnection = mysqli_connect($host, $user, $password, $dbname);
    $dbconnection -> set_charset("utf8");
    if (!$dbconnection) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>