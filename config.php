<?php
    session_start();
    ob_start();

    $host = 'localhost';
    $db_name = 'anunt';
    $db_username = 'root'; 
    $db_password = ''; 

    try
    {
        $con = new PDO('mysql:host='. $host .';dbname='.$db_name, $db_username, $db_password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    catch (PDOException $e)
    {
       echo "Connection failed: " . $e->getMessage();
    }
?>