<?php
/**
 * All of the Defines for the classes below.
 * @author Dovydas.B <Dovydas.b@outlook.com>
 * @version 1.0
 * @package BookhotelbedsAPI.php
 * @subpackage Parse API for Bookhotelbeds.com
 */

 error_reporting(E_ALL);
 include_once('simple_html_dom.php');

function GenerateHotelBedsUrl($cityName, $check_in, $check_out, $room, $adult, $child){
    
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
                                echo $key3 . " => <br> {  <br>";

                                foreach ($item3 as $node => $data){   // Keys for hotel information
                                    // echo $node . " => " . $data[0]["text"] . ", <br>";
                                    if ( strpos($node, 'Hotelsri value') !== FALSE ){   // hotel name property
                                        echo "Hotel Name => " . $data[0]["text"] . " , <br>";
                                    }

                                    if ( strpos($node, 'Hotel value 1') !== FALSE ){   // City Name property
                                        echo "City Name => " . $data[0]["text"] . " , <br>";
                                    }

                                    if ( strpos($node, 'Hotel value 2') !== FALSE ){   // Hotel rating
                                        echo "Hotel Rating => " . $data[0]["text"] . " , <br>";
                                    }

                                    if ( strpos($node, 'Basedon number') !== FALSE ){   // Hotel review
                                        echo "Hotel Rating => " . $data[0]["text"] . " , <br>";
                                    }

                                    if ( strpos($node, 'Hotel value 3') !== FALSE ){   // Hotel Info
                                        echo "Hotel Information 1 => " . $data[0]["text"] . " , <br>";
                                    }

                                    if ( strpos($node, 'Hotel value 4') !== FALSE ){   // Hotel Info
                                        echo "Hotel Information 2 => " . $data[0]["text"] . " , <br>";
                                    }

                                    if ( strpos($node, 'Hotel value 5') !== FALSE ){   // Hotel Info
                                        echo "Hotel Information 3 => " . $data[0]["text"] . " , <br>";
                                    }
                                    
                                    if ( strpos($node, 'Hotelprice number') !== FALSE ){   // Hotel Price 1 (discount price, if not discounted, it would be originalPrice)
                                        echo "Discount Price => " . $data[0]["text"] . " , <br>";
                                    }

                                    if ( strpos($node, 'Sriresult number') !== FALSE ){   // Hotel Price 1 (discount price, if not discounted, it would be originalPrice)
                                        echo "Actual Price => " . $data[0]["text"] . " , <br>";
                                    }

                                }
                                echo " } <br>";
                           }
                      }
                  }
              }
          }
      }
 }

 function output_json(){
   // Configuration - Expedia.com paser
   $userGuid = "7f1f9c8f-d842-4b10-8fda-837caff49df5";
   $apiKey = "7f1f9c8fd8424b108fda837caff49df56d5d9dba93dc88105cc0225f9d78270327602e5df561c1cb46591496821e89f450070c9efc269bda121de2c2b616382e8fcbdd2299ffa82a7ab97586802806d8";
//--------------------------------------------------------
     $result = query("278f88a1-db39-42ed-a2ee-de0f463f49a4", $apiKey ,"http://brands.datahc.com/Hotels/Search?destination=place%3AAntigua_And_Barbuda&resultID=4&languageCode=EN&checkin=2017-02-07&checkout=2017-02-08&Rooms=1&Adults_1=2");
     //var_dump($result);
 }

 ?>
