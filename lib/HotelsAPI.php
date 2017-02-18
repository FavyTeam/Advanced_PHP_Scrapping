<?php
/**
 * All of the Defines for the classes below.
 * @author Dovydas.B <Dovydas.b@outlook.com>
 * @version 1.0
 * @package HotelsAPI.php
 * @subpackage Parse API for Hotels.com
 */

  error_reporting(E_ALL);
  include_once('simple_html_dom.php');

  ini_set('max_execution_time', 100000);

function GenerateHotelUrl($cityName, $check_in, $check_out, $room, $adult, $child){
    echo "<p>Hotel Information from Hotels.com</p>";
    
    //https://www.hotels.com/search.do?q-destination=Antigua Guatemala, Guatemala&q-check-in=2017-02-14&q-check-out=2017-02-15&q-rooms=1&q-room-0-adults=2&q-room-0-children=0

    $fromDate = explode("/",$check_in)[2] . "-" . explode("/",$check_in)[1] . "-" . explode("/",$check_in)[0];
    $toDate = explode("/",$check_out)[2] . "-" . explode("/",$check_out)[1] . "-" . explode("/",$check_out)[0];
    
    // Currently, it only show -> one room, two adult, zero child

    /*
    $m_url = "https://www.hotels.com/search.do?" . 
             "q-destination=" . $cityName . ", Guatemala" . 
             "&q-check-in=" . $fromDate . 
             "&q-check-out=" . $toDate . 
             "&q-rooms=" . $room;

    for ($i = 0; $i < $room ; $i++){
        $m_temp1 = "&q-room-" . $i . "-adults=" . $adult;
        $m_temp2 = "&q-room-" . $i . "-children=" . $child;
        $m_url = $m_url . $m_temp1 . $m_temp2;
    }
    */

    $room = 1;

    $m_url = "https://www.hotels.com/search.do?" . 
             "q-destination=" . $cityName . ", Guatemala" . 
             "&q-check-in=" . $fromDate . 
             "&q-check-out=" . $toDate . 
             "&q-rooms=" . $room .
             "&q-room-0-adults=" . $adult .
             "&q-room-0-children=" . $child;

    output_json($m_url, $cityName, $check_in, $check_out);
}

function output_json($basicURL, $cityName, $check_in, $check_out){
   // Configuration - Expedia.com paser
   $userGuid = "7f1f9c8f-d842-4b10-8fda-837caff49df5";
   $apiKey = "7f1f9c8fd8424b108fda837caff49df56d5d9dba93dc88105cc0225f9d78270327602e5df561c1cb46591496821e89f450070c9efc269bda121de2c2b616382e8fcbdd2299ffa82a7ab97586802806d8";
//--------------------------------------------------------
   $result = query("4bbe662a-33af-4e61-a2bf-efce8d4b965b", $apiKey , $basicURL, $cityName, $check_in, $check_out);

 }

 function query($queryID, $api, $url, $cityName, $check_in, $check_out) {

     $URLs = "https://extraction.import.io/query/extractor/" . urlencode($queryID) . "?_apikey=" . urlencode($api) . "&url=" . urlencode($url);

     $hotelCount = 0;

     ini_set('max_execution_time', 100000);

     $html = file_get_html($URLs);

     $jsondata = json_decode($html, true);

     //var_dump($jsondata);

     echo "<br>";

     foreach ($jsondata as $key => $item) {   // 6 keys there : extractorData, pageData, url, runtimeConfigId, timestamp, sequenceNumber (extractorData is important for scraping.)
          if ($key == "extractorData"){
              foreach ($item as $key1 => $item1) {  // 3 keys there : url, resourceId, data
                  if ($key1 == "data"){
                      foreach ($item1[0] as $key2 => $item2){ // 1 key there
                           foreach ($item2 as $key3 => $item3){  // keys are count of array - Hotel data;
                                //Initialize Hotel Structure.
         //                       echo $key3 . " => {  <br>";

                                $hotelInfo["hotelName"][$hotelCount] = "";
                                $hotelInfo["hotelAddress"][$hotelCount] = "";
                                $hotelInfo["postalCode"][$hotelCount] = "";
                                $hotelInfo["bookingStatus"][$hotelCount] = "";
                                $hotelInfo["Location1"][$hotelCount] = "";
                                $hotelInfo["Location2"][$hotelCount] = "";
                                $hotelInfo["hotelRating"][$hotelCount] = "";
                                $hotelInfo["hotelReview"][$hotelCount] = "";
                                $hotelInfo["ActualPrice"][$hotelCount] = "";
                                $hotelInfo["DiscountPrice"][$hotelCount] = "";
                                $hotelInfo["Currency"][$hotelCount] = "";

                                foreach ($item3 as $node => $data){   // Keys for hotel information
          //                          echo $node . " :-> " .  $data[0]['text'] . "<br>";

                                    if (strpos( $node, 'Name link') !== FALSE){
                                          $hotelInfo["hotelName"][$hotelCount] = $data[0]["text"];  // Hotel Name
                                    }

                                    if (strpos( $node, 'Street value') !== FALSE){
                                          $hotelInfo["hotelAddress"][$hotelCount] = $data[0]["text"];  // Hotel Street Address
                                    }

                                    if (strpos( $node, 'Postalcode number') !== FALSE){
                                          $hotelInfo["postalCode"][$hotelCount] = $data[0]["text"];  // Hotel Postal Code
                                    }

                                    if (strpos( $node, 'Description value') !== FALSE){
                                          $hotelInfo["bookingStatus"][$hotelCount] = $data[0]["text"];  // Hotel Booking Status
                                    }

                                    if (strpos( $node, 'Locationinfo value 1') !== FALSE){
                                          $hotelInfo["Location1"][$hotelCount] = $data[0]["text"];  // Hotel Location1
                                    }

                                    if (strpos( $node, 'Locationinfo value 2') !== FALSE){
                                          $hotelInfo["Location2"][$hotelCount] = $data[0]["text"];  // Hotel Location2
                                    }

                                    if (strpos( $node, 'Talogo value') !== FALSE){
                                          $hotelInfo["hotelRating"][$hotelCount] = $data[0]["text"];  // Hotel Rating
                                    }

                                    if (strpos( $node, 'Tatotal value') !== FALSE){
                                          $hotelInfo["hotelReview"][$hotelCount] = $data[0]["text"];  // Hotel Review
                                    }

                                    if (strpos( $node, 'Price link') !== FALSE){                      // Hotel Actual & Discount Price
                                          // Hotel Name
                                          if (!isset( explode(" ", $data[0]["text"])[1] )){
                                              $hotelInfo["DiscountPrice"][$hotelCount] = explode(" ", $data[0]["text"])[0];
                                              $hotelInfo["ActualPrice"][$hotelCount] = explode(" ", $data[0]["text"])[0];
                                              $hotelInfo["Currency"][$hotelCount] = "USD";
                                          }else if( explode(" ", $data[0]["text"])[1] == "CAD" ){
                                              $hotelInfo["DiscountPrice"][$hotelCount] = $data[0]["text"];
                                              $hotelInfo["ActualPrice"][$hotelCount] = $data[0]["text"];
                                              $hotelInfo["Currency"][$hotelCount] = "CAD";
                                          }else{
                                              $hotelInfo["DiscountPrice"][$hotelCount] = explode(" ", $data[0]["text"])[1];
                                              $hotelInfo["ActualPrice"][$hotelCount] = explode(" ", $data[0]["text"])[0];
                                              $hotelInfo["Currency"][$hotelCount] = "USD";
                                          }

                                    }

                                }
         //                       echo " } <br>";
                                $hotelCount++;
                           }
                      }
                  }
              }
          }
      }

    //  echo "<br><br><br>";

      if ($hotelCount == 0){

      }else{
          include_once(dirname(__FILE__) . "\..\db\dbconnect.php");
          $date = new DateTime();
          $conn = connect();

          //---------------Get sql count from Azure Database---------------------------

            $sql = "SELECT * FROM tbl_booking";
            $params = array();
            $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
            $stmt = sqlsrv_query( $conn, $sql , $params, $options );
            $row_count = sqlsrv_num_rows( $stmt );

            if ($row_count === false)
               $row_count = 0;

          //-----------------------------------------

          for ($i = 0 ; $i < $hotelCount ; $i++ ){
        
              echo $i . " => {  <br>";

              echo "Hotel Name  ->  " . $hotelInfo["hotelName"][$i] . "<br>";
              echo "Hotel Street Address  ->  " . $hotelInfo["hotelAddress"][$i] . "<br>";
              echo "Hotel Postal Code  ->  " . $hotelInfo["postalCode"][$i] . "<br>";
              echo "Hotel Booking Status  ->  " . $hotelInfo["bookingStatus"][$i] . "<br>";
              echo "Hotel Location1  ->  " . $hotelInfo["Location1"][$i] . "<br>";
              echo "Hotel Location2  ->  " . $hotelInfo["Location2"][$i] . "<br>";
              echo "Hotel Rating  ->  " . $hotelInfo["hotelRating"][$i] . "<br>";
              echo "Hotel Review  ->  " . $hotelInfo["hotelReview"][$i] . "<br>";
              echo "Hotel Actual Price  ->  " . $hotelInfo["ActualPrice"][$i] . "<br>";
              echo "Hotel Discount Price  ->  " . $hotelInfo["DiscountPrice"][$i] . "<br>";
              echo "Currency   ->   " . $hotelInfo["Currency"][$i] . "<br>";

              echo " } <br><br>";

          //    $insertSql = "INSERT INTO tbl_despegar (id, cityName, check_in, check_out, hotelName, hotelRating, hotelReview, hotelRecommend, hotelActualPrice, hotelDiscountPrice, currency ) VALUES (?,?,?,?,?,?,?,?,?,?,?)";

           //   $params = array($i,"Antigua Guatemala", "2/12/2017","2/13/2017" ,$hotelInfo["hotelName"][$i],  $hotelRatingCount, $hotelReviewCount, $hotelInfo["hotelRecommend"][$i], $priceA, $priceB, "USD");
            
           //   sqlsrv_query($conn, $insertSql,$params);


          }
          sqlsrv_close($conn);
      }

      



   }



?>


<!--



https://extraction.import.io/query/extractor/4bbe662a-33af-4e61-a2bf-efce8d4b965b?_apikey=7f1f9c8fd8424b108fda837caff49df56d5d9dba93dc88105cc0225f9d78270327602e5df561c1cb46591496821e89f450070c9efc269bda121de2c2b616382e8fcbdd2299ffa82a7ab97586802806d8&url=https%3A%2F%2Fwww.hotels.com%2Fsearch.do%3Fresolved-location%3DCITY%253A1641809%253AUNKNOWN%253AUNKNOWN%26destination-id%3D1641809%26q-destination%3DGuatemala%2520City%2C%2520Guatemala%26q-check-in%3D2017-02-14%26q-check-out%3D2017-02-15%26q-rooms%3D1%26q-room-0-adults%3D2%26q-room-0-children%3D0


/*
 function HotelsAPI($cityName, $check_in, $check_out, $room, $adult, $child){
    $url = "https://www.hotels.com/search.do?resolved-location=CITY%3A1635869%3AUNKNOWN%3AUNKNOWN&destination-id=1635869&q-destination=Antigua%20Guatemala,%20Guatemala&q-rooms=1&q-room-0-adults=2&q-room-0-children=0&sort-order=DISTANCE_FROM_LANDMARK";
    getHtmlFromHotelsAPI($url);
 }
*/


function getHtmlFromHotelsAPI($url){
  if ($url){
      $html = file_get_html($url);

      $hotel_count = 0;
       foreach($html->find("li article") as $element){
          $item["hotelName"][] = $element->children(0)->children(0)->first_child()->children(0)->innertext;
          $hotel_count++;
       }

       foreach($html->find("div.contact") as $element){
          $last_element = $element->children(0)->children(4);
          if ($last_element){
              $item["hotelAddress"][] =  $element->first_child()->children(0)->innertext . $element->first_child()->children(1)->innertext . $element->first_child()->children(2)->innertext . $element->first_child()->children(3)->innertext . $element->first_child()->children(4)->innertext;
          }else{
              $item["hotelAddress"][] =  $element->first_child()->children(0)->innertext . $element->first_child()->children(1)->innertext . $element->first_child()->children(2)->innertext . $element->first_child()->children(3)->innertext;
          }

       }

        foreach($html->find("span.guest-rating-value strong") as $element){
            $item["rating"][] = $element->innertext;
        }

        foreach($html->find("span.ta-total-reviews") as $element){
            $item["review"][] = explode(" ",$element->innertext)[0];
        }

        foreach($html->find("div.price") as $element){

            if ($element->children(1)->children(1)){
                $item["price3"][] = "price1";
                $item["price1"][] = $element->children(1)->children(0)->innertext;
                $item["price2"][] = $element->children(1)->children(1)->innertext;
            }else{
                $item["price3"][] = $element->children(1)->innertext;
                $item["price1"][] = "price3";
                $item["price2"][] = "price3";
            }
        }


      if ($hotel_count==0){
          echo "<p style='color: #eee;'>Hotel data is not exist!!!</p>";
      }else{
           include_once(dirname(__FILE__) . "\..\db\dbconnect.php");
           $date = new DateTime();
           $conn = connect();

           ini_set('max_execution_time', 100000);

           $priceA = 0;  $priceB = 0;

          for ($i=0; $i<$hotel_count;$i++){
              echo $item["hotelName"][$i] . " , ";
              echo $item["hotelAddress"][$i] . " , ";
              echo $item["rating"][$i] . " , ";
              echo $item["review"][$i] . " , ";

              if ($item["price1"][$i] == "price3"){
                  echo $item["price3"][$i] . " , ";
                  echo $item["price3"][$i] . " ";
                  $priceA = $item["price3"][$i];
                  $priceB = $item["price3"][$i];
              }else{
                echo $item["price1"][$i] . " , ";
                echo $item["price2"][$i] . " ";
                $priceA = $item["price1"][$i];
                $priceB = $item["price2"][$i];
              }

          /*  $insertSql = "INSERT INTO tbl_hotels (id, hotelName, rating, review, hotelAddress, discountPrice, actualPrice ,check_in, check_out) VALUES (?,?,?,?,?,?,?,?,?)";

              $params = array($i, $item["hotelName"][$i],  $item["rating"][$i], $item["review"][$i], $item["hotelAddress"][$i], $priceB, $priceA, "1/31/2017","1/2/2017");

              sqlsrv_query($conn, $insertSql,$params);
          */
          }

          sqlsrv_close($conn);
      }
  }
}


-->