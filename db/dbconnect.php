<?php
include_once('Config/dbconfig.php');

$connectionInfo = array("Database"=>$dbName, "UID"=>$userName, "PWD"=>$userPassword, "MultipleActiveResultSets"=>true);

  sqlsrv_configure('WarningsReturnAsErrors', 0);
  $conn = sqlsrv_connect( $serverName, $connectionInfo);
  if($conn === false)
  {
    FatalError("Failed to connect...");
  }

 ?>
