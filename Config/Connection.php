<?php
    include("Config.php");

    $host = $config['host'];
    $dataBase = $config['dataBase'];
    $userName = $config['userName'];
    $password = $config['password'];
    //creating the dsn
    $dsn = "mysql:dbname=$dataBase;host=$host";
    try{
    $dbConnection = new PDO($dsn, $userName, $password);
    
    $dbConnection->query("SET NAMES 'utf8'");//formating data to utf-8
    } catch (PDOException $e){
        echo "Connection Fails, check the connection config";
    }
?>