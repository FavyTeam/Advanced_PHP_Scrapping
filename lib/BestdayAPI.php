<?php
/**
 * All of the Defines for the classes below.
 * @author Dovydas.B <Dovydas.b@outlook.com>
 * @version 1.0
 * @package BestdayAPI.php
 * @subpackage Parse API for Bestday.com
 */

 error_reporting(E_ALL);
 include_once('simple_html_dom.php');

function GenerateBestdayUrl($cityName, $check_in, $check_out, $room, $adult, $child){
    
}

 function query($queryID, $api, $url ) {

     $url = "https://extraction.import.io/query/extractor/" . urlencode($queryID) . "?_apikey=" . urlencode($api) . "&url=" . urlencode($url);

     $hotelCount = 0;

     ini_set('max_execution_time', 100000);

     $html = file_get_html($url);

     $jsondata = json_decode($html, true);

     echo "<br>";

     foreach ($jsondata as $key => $item) {   // 6 keys there : extractorData, pageData, url, runtimeConfigId, timestamp, sequenceNumber (extractorData is important for scraping.)
          if ($key == "extractorData"){
              foreach ($item as $key1 => $item1) {  // 3 keys there : url, resourceId, data
                  if ($key1 == "data"){
                      foreach ($item1[0] as $key2 => $item2){ // 1 key there
                           foreach ($item2 as $key3 => $item3){  // keys are count of array - Hotel data;

                                // Initialize hotel info data by count
                                $hotelInfo["hotelName"][$hotelCount] = "Not Available";
                                $hotelInfo["hotelRating"][$hotelCount] = "Not Available";
                                $hotelInfo["hotelService"][$hotelCount] = "Not Available";
                                $hotelInfo["hotelActualPrice"][$hotelCount] = "Not Available";
                                $hotelInfo["hotelDiscountPrice"][$hotelCount] = "Not Available";
                                $hotelInfo["hotelDiscountInfo"][$hotelCount] = "Not Available";
                                $hotelInfo["hotelDiscountPercent"][$hotelCount] = "Not Available";

                                foreach ($item3 as $node => $data){   // Keys for hotel information
                                    
                                    if (strpos( $node, 'Hotelname link') !== FALSE){
                                          $hotelInfo["hotelName"][$hotelCount] = $data[0]["text"];  // Hotel Name
                                    }

                                    if (strpos( $node, 'Content link') !== FALSE){
                                          $hotelInfo["hotelRating"][$hotelCount] = $data[0]["text"];  // Hotel Rating
                                    }

                                    if (strpos( $node, 'Lastchance value') !== FALSE){
                                          $hotelInfo["hotelService"][$hotelCount] = $data[0]["text"];  // Hotel Service Info
                                    }

                                    if (strpos( $node, 'Currencyitem value') !== FALSE){
                                          $hotelInfo["hotelActualPrice"][$hotelCount] = $data[0]["text"];  // Hotel Actual Price
                                    }

                                    if (strpos( $node, 'Currency number') !== FALSE){
                                          $hotelInfo["hotelDiscountPrice"][$hotelCount] = $data[0]["text"];  // Hotel Discount Price
                                    }

                                    if (strpos( $node, 'Tooltip descriptions') !== FALSE){
                                          $hotelInfo["hotelDiscountInfo"][$hotelCount] = $data[0]["text"];  // Hotel Discount Info
                                    }

                                    if (strpos( $node, 'Promotag value') !== FALSE){
                                          $hotelInfo["hotelDiscountPercent"][$hotelCount] = $data[0]["text"];  // Hotel Discount Percent
                                    }


                                }
                                $hotelCount++;
                           }
                      }
                  }
              }
          }
      }


      if ($hotelCount==0){
        echo "Hotel data is not exist!!!";
      }
      else
      {
            include_once(dirname(__FILE__) . "\..\db\dbconnect.php");
            $date = new DateTime();
            $conn = connect();

            for ($i =0 ; $i < $hotelCount ; $i++ ){
              
                echo $i . " => <br> {  <br>";

                echo "Hotel Name -> " . $hotelInfo["hotelName"][$i] . " , <br>";
                echo "Hotel Rating -> " . $hotelInfo["hotelRating"][$i] . " , <br>";
                echo "Hotel Service Info -> " . $hotelInfo["hotelService"][$i] . " , <br>";
      

                if ($hotelInfo["hotelActualPrice"][$i] == "Not Available"){
                    $hotelInfo["hotelActualPrice"][$i] = $hotelInfo["hotelDiscountPrice"][$i];
                }
                echo "Hotel Actual Price -> " . $hotelInfo["hotelActualPrice"][$i] . ", <br>";
                echo "Hotel Discount Price -> " . $hotelInfo["hotelDiscountPrice"][$i] . ", <br>";
                echo "Hotel Discount Info -> " . $hotelInfo["hotelDiscountInfo"][$i] . ", <br>";
                echo "Hotel Discount Percent -> " . $hotelInfo["hotelDiscountPercent"][$i] . ", <br>";
                
                echo " } <br>";

                if ($hotelInfo["hotelActualPrice"][$i] != "Not Available"){
                  if (isset(explode(" ",$hotelInfo["hotelActualPrice"][$i])[1])) 
                      $hotelInfo["hotelActualPrice"][$i] = (float) explode(" ",$hotelInfo["hotelActualPrice"][$i])[1];
                }else{
                    $hotelInfo["hotelActualPrice"][$i] = 0;
                    $hotelInfo["hotelDiscountPrice"][$i] = 0;
                }

                $hotelInfo["hotelActualPrice"][$i] = (float) $hotelInfo["hotelActualPrice"][$i];
                $hotelInfo["hotelDiscountPrice"][$i] = (float) $hotelInfo["hotelDiscountPrice"][$i];

                /*
                $insertSql = "INSERT INTO tbl_bestday (id, cityName , check_in, check_out, hotelName, hotelRating, hotelServiceInfo, hotelActualPrice, hotelDiscountPrice, currency, DiscountInfo, DiscountPercent ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";

                $params = array($i, "Antigua Guatemala", "2/12/2017","2/13/2017",$hotelInfo["hotelName"][$i], $hotelInfo["hotelRating"][$i], $hotelInfo["hotelService"][$i], 
                  $hotelInfo["hotelActualPrice"][$i] , $hotelInfo["hotelDiscountPrice"][$i], "USD" , $hotelInfo["hotelDiscountInfo"][$i] , $hotelInfo["hotelDiscountPercent"][$i]);


                sqlsrv_query($conn, $insertSql,$params);
                */
            }

            sqlsrv_close($conn);
      }


 }

 function output_json(){
   // Configuration - Expedia.com paser
   $userGuid = "7f1f9c8f-d842-4b10-8fda-837caff49df5";
   $apiKey = "7f1f9c8fd8424b108fda837caff49df56d5d9dba93dc88105cc0225f9d78270327602e5df561c1cb46591496821e89f450070c9efc269bda121de2c2b616382e8fcbdd2299ffa82a7ab97586802806d8";
//--------------------------------------------------------
     $result = query("3052796b-b32e-4698-9bd5-31eedc0fcaf1", $apiKey ,"https://www.bestday.com/Antigua-Guatemala/Hotels/?GAcat=SearchHotels&origen_base=&origen_base_tipo=&origen_base_desc=&origen_base_prod=&destino_base=900003&destino_base_tipo=D&destino_base_desc=Antigua+Guatemala%2C+Guatemala&destino_base_prod=ht&carpeta_base=Antigua-Guatemala&background_size_ht=3132372e373435363634373339383834333925203537387078&dia_desde=18&mes_desde=2&anio_desde=2017&dia_hasta=22&mes_hasta=2&anio_hasta=2017&asoc=&cadena=&ajhoteles=Antigua+Guatemala%2C+Guatemala&Destino=900003&Ciudad=&ajHotel=&ClavDestino=&ClavCiudad=&check-inH=Feb%2F18%2F2017&check-outH=Feb%2F22%2F2017&num_cuartos=1&num_adultos=2&num_ninos=0&promoCouponGTM=");
 }

 ?>
