<?php
/**
 * All of the Defines for the classes below.
 * @author Dovydas.B <Dovydas.b@outlook.com>
 * @version 1.0
 * @package DespegarAPI.php
 * @subpackage Parse API for despegar.com
 */

error_reporting(E_ALL);
 include_once('simple_html_dom.php');

 function GenerateDespegarUrl($cityName, $check_in, $check_out, $room, $adult, $child){
    
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
                                $hotelInfo["hotelName"][$hotelCount] = "";
                                $hotelInfo["hotelRating"][$hotelCount] = "";
                                $hotelInfo["hotelReview"][$hotelCount] = "";
                                $hotelInfo["hotelRecommend"][$hotelCount] = "";
                                $hotelInfo["hotelPrice1"][$hotelCount] = "";
                                $hotelInfo["hotelPrice2"][$hotelCount] = "";
                                $hotelInfo["hotelPrice3"][$hotelCount] = "";
                                $hotelInfo["hotelPrice4"][$hotelCount] = "";

                                foreach ($item3 as $node => $data){   // Keys for hotel information

                                    if (strpos( $node, 'Upatracker value') !== FALSE){
                                          $hotelInfo["hotelName"][$hotelCount] = $data[0]["text"];  // Hotel Name
                                    }

                                    if (strpos( $node, 'Raiting number') !== FALSE){
                                          $hotelInfo["hotelRating"][$hotelCount] = $data[0]["text"];   // Hotel Rating
                                    }

                                    if (strpos( $node, 'Basedon value') !== FALSE){
                                          $hotelInfo["hotelReview"][$hotelCount] = $data[0]["text"];   // Hotel Review
                                    }

                                    if (strpos( $node, 'Clusteruser content') !== FALSE){
                                          $hotelInfo["hotelRecommend"][$hotelCount] = $data[0]["text"];   // Hotel Recommend
                                    }

                                    if (strpos( $node, 'Usd number') !== FALSE){
                                          $hotelInfo["hotelPrice1"][$hotelCount] = $data[0]["text"];   // Hotel Value Integer (Discount Price 1)
                                    }

                                    if (strpos( $node, 'Priceboxitem number') !== FALSE){
                                          $hotelInfo["hotelPrice2"][$hotelCount] = $data[0]["text"];   // Hotel Value Point (Discount Price 2)
                                    }

                                    if (strpos( $node, 'Priceboxcont number') !== FALSE){
                                          $hotelInfo["hotelPrice3"][$hotelCount] = $data[0]["text"];   // Hotel Value Integer (Actual Price 1)
                                    }

                                    if (strpos( $node, 'Priceboxtext number') !== FALSE){
                                          $hotelInfo["hotelPrice4"][$hotelCount] = $data[0]["text"];   // Hotel Value Point (Actual Price 2)
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

            $priceA = 0;
            $priceB = 0;
            $hotelReviewCount = 0;
            $hotelRatingCount = 0;

            for ($i =0 ; $i < $hotelCount ; $i++ ){
                echo $i . " => <br> {  <br>";

                echo "Hotel Name -> " . $hotelInfo["hotelName"][$i] . " , <br>";
                echo "Hotel Rating -> " . $hotelInfo["hotelRating"][$i] . " , <br>";              
                echo "Hotel Review -> " . $hotelInfo["hotelReview"][$i] . " , <br>";
                echo "Hotel Recommend -> " . $hotelInfo["hotelRecommend"][$i] . ", <br>";

                if ($hotelInfo["hotelReview"][$i]){
                    if (isset(explode(" ",$hotelInfo["hotelReview"][$i])[1])) 
                        $hotelReviewCount = explode(" ",$hotelInfo["hotelReview"][$i])[1];
                }else{
                    $hotelReviewCount = "Not Available";
                }
                
                if (!$hotelInfo["hotelRating"][$i])
                    $hotelRatingCount = "Not Available";
                else
                    $hotelRatingCount = $hotelInfo["hotelRating"][$i];


                if ($hotelInfo["hotelPrice3"][$i] == ""){
                    echo "Hotel Actual Price -> " . $hotelInfo["hotelPrice1"][$i] . "." . $hotelInfo["hotelPrice2"][$i] . " , <br>";
                    echo "Hotel Discount Price -> " . $hotelInfo["hotelPrice1"][$i] . "." . $hotelInfo["hotelPrice2"][$i] . " , <br>";
                    $priceString = $hotelInfo["hotelPrice1"][$i] . "." . $hotelInfo["hotelPrice2"][$i];
                    $priceA = (float)$priceString;
                    $priceB = (float)$priceString;
                }else{
                    echo "Hotel Actual Price -> " . $hotelInfo["hotelPrice3"][$i] . "." . $hotelInfo["hotelPrice4"][$i] . " , <br>";
                    echo "Hotel Discount Price -> " . $hotelInfo["hotelPrice1"][$i] . "." . $hotelInfo["hotelPrice2"][$i] . " , <br>";

                    $priceString = $hotelInfo["hotelPrice3"][$i] . "." . $hotelInfo["hotelPrice4"][$i];   // Actual Price
                    $priceA = (float)$priceString;
                    $priceString = $hotelInfo["hotelPrice1"][$i] . "." . $hotelInfo["hotelPrice2"][$i];   //Discount Price
                    $priceB = (float)$priceString;
                }

                echo " } <br>";

         /*     $insertSql = "INSERT INTO tbl_despegar (id, cityName, check_in, check_out, hotelName, hotelRating, hotelReview, hotelRecommend, hotelActualPrice, hotelDiscountPrice, currency ) VALUES (?,?,?,?,?,?,?,?,?,?,?)";

              $params = array($i,"Antigua Guatemala", "2/12/2017","2/13/2017" ,$hotelInfo["hotelName"][$i],  $hotelRatingCount, $hotelReviewCount, $hotelInfo["hotelRecommend"][$i], $priceA, $priceB, "USD");
            
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
     $result = query("7d0e8dbf-1b00-4737-af34-3507f6ae19b7", $apiKey ,"http://www.despegar.com/search/Hotel/265/2017-02-12/2017-02-13/2?from=SB#sorting=best_selling_descending&page=1&view=lists");
     //var_dump($result);
 }

 ?>


