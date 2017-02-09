<?php
/**
 * All of the Defines for the classes below.
 * @author Dovydas.B <Dovydas.b@outlook.com>
 * @version 1.0
 * @package ExpediaAPI.php
 * @subpackage Parse API for Expedia.com
 */

include_once('simple_html_dom.php');

//Implement - query function

 function query($queryID, $api, $url ) {

     $url = "https://extraction.import.io/query/extractor/" . urlencode($queryID) . "?_apikey=" . urlencode($api) . "&url=" . urlencode($url);

     $hotelCount = 0;

     ini_set('max_execution_time', 100000);

     $html = file_get_html($url);

     $jsondata = json_decode($html, true);

     foreach ($jsondata as $key => $item) {   // 6 keys there : extractorData, pageData, url, runtimeConfigId, timestamp, sequenceNumber (extractorData is important for scraping.)
          if ($key == "extractorData"){
              echo "<br>";
                foreach ($item as $key1 => $item1){  // 3 keys there : url, resourceId, data ( data is important for scraping. )
                      if ($key1 == "data"){
                          foreach ($item1[0] as $key2 => $item2){ // 1 key there
                                foreach ($item2 as $key3 => $item3){  // keys are count of array - Hotel data;
                                      echo $key3 . " => <br> {  <br>";
                                      foreach ($item3 as $node => $data){   // Keys for hotel information
                                      /*      if ( strpos($node, 'Visuallyhidden value 1') !== FALSE ){  //Hotel Name
                                                echo $data[0]["text"];
                                                //var_dump($data);
                                            } */
                                            if ( strpos($node, 'Hotelinfo contents') !== FALSE ){
                                            /*    $ExpediaItem["hotelName"][] = $data[0]["text"];     // Hotel Name
                                                $ExpediaItem["hotelRating"][] = $data[2]["text"];   // Hotel Rating
                                                $ExpediaItem["CityName"][] = $data[3]["text"];      // City Name
                                                $ExpediaItem["Telephone"][] = $data[5]["text"];     // Telphone Number
                                                $ExpediaItem["hotelReivew"][] = $data[6]["text"];   // Hotel Review

                                                echo $data[0]["text"] . " , <br>";                  // Hotel Name
                                                echo $data[2]["text"] . " , <br>";                  // Hotel Rating
                                                echo $data[3]["text"] . " , <br>";                  // City Name
                                                echo $data[5]["text"] . " , <br>";                  // Telphone Number
                                                echo $data[6]["text"] . " , <br>";                  // Hotel Review*/

            /*                                    if ( strpos( $data[0]["text"], 'Top Hotel') !== FALSE || strpos( $data[0]["text"], 'New to Expedia') !== FALSE ){    // The is top hotel that annoucement in site
                                                    $ExpediaItem["hotelName"][] =  $data[1]["text"];
                                                    $ExpediaItem["hotelRating"][] =  $data[3]["text"];
                                                    $ExpediaItem["CityName"][] =  $data[4]["text"];
                                                    $ExpediaItem["Telephone"][] = $data[6]["text"];     // Telphone Number
                                                    $ExpediaItem["hotelReivew"][] = $data[7]["text"];   // Hotel Review
                                                }else{
                                                  $ExpediaItem["hotelName"][] = $data[0]["text"];
                                                  $ExpediaItem["hotelRating"][] = $data[2]["text"];

                                                  if ( strpos( $data[3]["text"], 'VIP Access') !== FALSE ){
                                                      $ExpediaItem["CityName"][] = $data[4]["text"];
                                                      $ExpediaItem["Telephone"][] = $data[6]["text"];     // Telphone Number
                                                      $ExpediaItem["hotelReivew"][] = $data[7]["text"];   // Hotel Review
                                                  }else{
                                                      if ( strpos( $data[4]["text"], 'Map Toggle map') !== FALSE ){
                                                          $ExpediaItem["Telephone"][] = $data[6]["text"];     // Telphone Number
                                                          $ExpediaItem["hotelReivew"][] = $data[5]["text"];   // Hotel Review
                                                      }else{
                                                          $ExpediaItem["Telephone"][] = $data[5]["text"];     // Telphone Number
                                                          $ExpediaItem["hotelReivew"][] = $data[6]["text"];   // Hotel Review
                                                      }
                                                      $ExpediaItem["CityName"][] = $data[3]["text"];

                                                  }
                                                  //$ExpediaItem["CityName"][] = $data[3]["text"];
                                                }
                                        */

                                                // Here is cases because ....

                                                if (strpos( $data[0]["text"], 'New to Expedia') !== FALSE){
                                                      $ExpediaItem["hotelName"][] = $data[1]["text"];     // Hotel Name
                                                      $ExpediaItem["hotelRating"][] = $data[3]["text"];   // Hotel Rating
                                    //                  $ExpediaItem["CityName"][] = $data[4]["text"];      // City Name
                                                      $ExpediaItem["Telephone"][] = $data[6]["text"];     // Telphone Number
                                                      $ExpediaItem["hotelReivew"][] = "New to Expedia";   // Hotel Review
                                                }else if (strpos( $data[0]["text"], 'Top Hotel') !== FALSE){
                                                      $ExpediaItem["hotelName"][] = $data[1]["text"];     // Hotel Name
                                                      $ExpediaItem["hotelRating"][] = $data[3]["text"];   // Hotel Rating
                                    //                  $ExpediaItem["CityName"][] = $data[4]["text"];      // City Name
                                                      $ExpediaItem["Telephone"][] = $data[6]["text"];     // Telphone Number
                                                      if (strpos( $data[7]["text"], 'Price is rate') !== FALSE){
                                                          $ExpediaItem["hotelReivew"][] = "Top Hotel";   // Hotel Review
                                                      }else{
                                                          $ExpediaItem["hotelReivew"][] = $data[7]["text"];   // Hotel Review
                                                      }
                                                }else{    //This mean is that first element of dictory is * hotel name *

                                                      $ExpediaItem["hotelName"][] = $data[0]["text"];     // Hotel Name
                                                      $ExpediaItem["hotelRating"][] = $data[2]["text"];   // Hotel Rating

                                                      if (strpos( $data[3]["text"], 'VIP Access') !== FALSE){  //It include *VIP-Access* tab
                                  //                        $ExpediaItem["CityName"][] = $data[4]["text"];      // City Name
                                                          $ExpediaItem["Telephone"][] = $data[6]["text"];     // Telphone Number

                                                          if (strpos( $data[7]["text"], 'Price is rate') !== FALSE){ // Hotel Review
                                                                $ExpediaItem["hotelReivew"][] = "Not yet reviewed";
                                                          }else{
                                                                $ExpediaItem["hotelReivew"][] = $data[7]["text"];
                                                          }
                                                      }else if (strpos( $data[4]["text"], 'Map Toggle') !== FALSE){

                                                          $ExpediaItem["Telephone"][] = $data[5]["text"];
                                                          $ExpediaItem["hotelReivew"][] = $data[6]["text"];

                                                      }else{
                                  //                        $ExpediaItem["CityName"][] = $data[3]["text"];      // City Name
                                                          $ExpediaItem["Telephone"][] = $data[5]["text"];     // Telphone Number
                                                          if (strpos( $data[6]["text"], 'Price is rate') !== FALSE){ // Hotel Review
                                                                $ExpediaItem["hotelReivew"][] = "Not yet reviewed";
                                                          }else{
                                                                $ExpediaItem["hotelReivew"][] = $data[6]["text"];
                                                          }
                                                      }
                                                }


                                                foreach ($data as $node => $element){
                                                      echo  "-        -" . $node . " -> " . $element["text"] . "<br>";
                                                }

                                            }

                                            if ( strpos($node, 'Hotelugclink value') !== FALSE ){
                                                $ExpediaItem["hotelGustRating"][$hotelCount] = $data[0]["text"];   //Hotel Guest Rating...
                                            }else

                                            if (!isset($ExpediaItem["hotelGustRating"][$hotelCount])) $ExpediaItem["hotelGustRating"][$hotelCount] = "Not yet reviewed by Guest";

                                            if ( strpos($node, 'Overlink price') !== FALSE ){     // Hotel Room Actual Price
                                                if (substr($data[0]["text"],0,1) == '$'){         // Dollar currency
                                                    $ExpediaItem["currency"][] = "USD";
                                                }
                                                $ExpediaItem["hotelActualPrice"][$hotelCount] = substr($data[0]["text"],1);  // Hotel Room Actual Price
                                            }
                                            if ( strpos($node, 'Priceisnow price') !== FALSE ){                   // Hotel Room Discount Price

                                                if (substr($data[0]["text"],0,1) == '$'){                         // Dollar currency
                                //                    echo "USD ";
                                                }
                                                $ExpediaItem["hotelDiscountPrice"][$hotelCount] = substr($data[0]["text"],1); // Hotel Room Discount Price

                                                if (!isset($ExpediaItem["hotelActualPrice"][$hotelCount])) $ExpediaItem["hotelActualPrice"][$hotelCount] = "none";
                                            }
                                      }
                                      echo " } <br><br>";
                                      $hotelCount++;
                                }
                          }
                      }
                }
          }
      }

    //-------------All data are combined in $ExpediaItem Dictionary ----------------------------
    // Save data in SQL Server using $ExpediaItem Dic
    if ($hotelCount==0){
        echo "Hotel data is not exist!!!";
    }else{
         include_once(dirname(__FILE__) . "\..\db\dbconnect.php");
         $date = new DateTime();
        $conn = connect();

         //-------------------Must get database count so that you can start the save after count index (for avoid duplicate)---------------------------

        for ($i=0; $i<$hotelCount;$i++){

            echo $i . " => {" . "<br>";

            echo "cityName : " . "Antigua Guatemala" . " , <br>";
            echo "hotelName : " . $ExpediaItem["hotelName"][$i] . " , <br>";
            echo "hotelReview : " . $ExpediaItem["hotelReivew"][$i] . " , <br>";
            echo "hotelRating : " . $ExpediaItem["hotelRating"][$i] . " , <br>";
            echo "hotelGuestRating : " . $ExpediaItem["hotelGustRating"][$i] . " , <br>";
            echo "hotelTelephone : " . $ExpediaItem["Telephone"][$i] . " , <br>";
            echo "ActualPrice : " . $ExpediaItem["hotelActualPrice"][$i] . " , <br>";
            echo "DiscountPrice : " . $ExpediaItem["hotelDiscountPrice"][$i] . " , <br>";
            echo "currency : " . "USD" . " , <br>";

            echo " } <br><br>";


            $insertSql = "INSERT INTO tbl_expedia (id, city, check_in, check_out, hotelName, hotelReview, hotelRating, hotelGuestRating, hotelTelephone, ActualPrice, DiscountPrice, currency) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";

            if ($ExpediaItem["hotelActualPrice"][$i] == "none"){
              $params = array($i, "Antigua Guatemala", "2/5/2017","2/6/2017",$ExpediaItem["hotelName"][$i], $ExpediaItem["hotelReivew"][$i], $ExpediaItem["hotelRating"][$i], $ExpediaItem["hotelGustRating"][$i]
            , $ExpediaItem["Telephone"][$i], $ExpediaItem["hotelDiscountPrice"][$i] , $ExpediaItem["hotelDiscountPrice"][$i] , "USD");
            }else{
                $params = array($i, "Antigua Guatemala", "2/5/2017","2/6/2017",$ExpediaItem["hotelName"][$i], $ExpediaItem["hotelReivew"][$i], $ExpediaItem["hotelRating"][$i], $ExpediaItem["hotelGustRating"][$i]
              , $ExpediaItem["Telephone"][$i], $ExpediaItem["hotelActualPrice"][$i] , $ExpediaItem["hotelDiscountPrice"][$i] , "USD");
            }

            sqlsrv_query($conn, $insertSql,$params);


        }

    //    sqlsrv_close($conn);
    }

 }

 function output_json(){
   // Configuration - Expedia.com paser
   $userGuid = "7f1f9c8f-d842-4b10-8fda-837caff49df5";
   $apiKey = "7f1f9c8fd8424b108fda837caff49df56d5d9dba93dc88105cc0225f9d78270327602e5df561c1cb46591496821e89f450070c9efc269bda121de2c2b616382e8fcbdd2299ffa82a7ab97586802806d8";
//--------------------------------------------------------
     $result = query("e72ebc9a-2f37-4f2b-9998-e976abf6223f", $apiKey ,"https://www.expedia.com/Hotel-Search?#&destination=Antigua%20Guatemala,%20Guatemala&startDate=02/05/2017&endDate=02/06/2017&regionId=180589&latLong=14.556826,-90.733704&adults=2");
     //var_dump($result);
 }

 ?>
