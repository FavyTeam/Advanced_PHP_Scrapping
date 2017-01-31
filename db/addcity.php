<?php
include_once($DB_DIR . "dbconnect.php");

   $count = count($Citys);
   $conn = connect();

   ini_set('max_execution_time', 100000);

   $result = sqlsrv_query($conn,"SELECT * FROM tbl_cities;",array(),array( "Scrollable" => 'static' ));

  // echo sqlsrv_num_rows($result);

   if (sqlsrv_num_rows($result)<1){
     for ($i=0; $i<$count;$i++){
      //  echo $Citys[$i] . "<br>";
        $insertSql = "INSERT INTO tbl_cities (id, cityName) VALUES (?,?)";
        $params = array($i, $Citys[$i]);

        sqlsrv_query($conn, $insertSql,$params);
     }
   }
   sqlsrv_close($conn);
 ?>
