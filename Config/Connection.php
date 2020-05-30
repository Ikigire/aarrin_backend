<?php
    include("Config.php");
    //Tools required
    require_once(__DIR__.'/../Tools/TokenTool.php');

    $host = $config['host'];
    $dataBase = $config['dataBase'];
    $userName = $config['userName'];
    $password = $config['password'];
    //creating the dsn
    $dsn = "mysql:dbname=$dataBase;host=$host";
    try{
    $dbConnection = new PDO($dsn, $userName, $password);
    $dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbConnection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $dbConnection->query("SET NAMES 'utf8'");//formating data to utf-8
    } catch (PDOException $e){
        echo "Connection Fails, check the connection config";
    }
?>