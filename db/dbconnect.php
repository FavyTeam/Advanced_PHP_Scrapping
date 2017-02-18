<?php
include_once("config/env.php");

  function connect(){

    $serverName = "tcp:indisersa.database.windows.net,1433";
    $userName = 'otto';
    $userPassword = 'Knoke@1958';
    $dbName = "hotel_info";

    $connectionInfo = array("Database"=>$dbName, "UID"=>$userName, "PWD"=>$userPassword ,"CharacterSet" =>"UTF-8","ConnectionPooling" => "1", "MultipleActiveResultSets"=>"0");

    //sqlsrv_configure('WarningsReturnAsErrors', 0);
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    if($conn === false)
    {
      FatalError("Failed to connect...");
    }else{
      //echo "connection Success!!!"; 
    }

    return $conn;
  }

?>
