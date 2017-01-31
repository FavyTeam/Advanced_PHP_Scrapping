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

 function HotelsAPI($cityName, $check_in, $check_out, $room, $adult, $child){
    $url = "https://www.hotels.com/search.do?resolved-location=CITY%3A1635869%3AUNKNOWN%3AUNKNOWN&destination-id=1635869&q-destination=Antigua%20Guatemala,%20Guatemala&q-rooms=1&q-room-0-adults=2&q-room-0-children=0&sort-order=DISTANCE_FROM_LANDMARK";
    getHtmlFromHotelsAPI($url);
 }



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
              //echo "exist<br>";
          }else{
              $item["hotelAddress"][] =  $element->first_child()->children(0)->innertext . $element->first_child()->children(1)->innertext . $element->first_child()->children(2)->innertext . $element->first_child()->children(3)->innertext;
              //echo "not exist<br>";
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
          echo "Hotel data is not exist!!!";
      }else{
          //echo dirname(__FILE__);
           include_once(dirname(__FILE__) . "\..\db\dbconnect.php");
           $date = new DateTime();
           $conn = connect();

           ini_set('max_execution_time', 100000);

           $priceA = 0;  $priceB = 0;

          for ($i=0; $i<$hotel_count;$i++){
            //  echo $item["hotelName"][$i] . " , ";
            //  echo $item["hotelAddress"][$i] . " , ";
            //  echo $item["rating"][$i] . " , ";
            //  echo $item["review"][$i] . " , ";

              if ($item["price1"][$i] == "price3"){
              //    echo $item["price3"][$i] . " , ";
              //    echo $item["price3"][$i] . " ";
                  $priceA = $item["price3"][$i];
                  $priceB = $item["price3"][$i];
              }else{
              //  echo $item["price1"][$i] . " , ";
              //  echo $item["price2"][$i] . " ";
                $priceA = $item["price1"][$i];
                $priceB = $item["price2"][$i];
              }

              $insertSql = "INSERT INTO tbl_hotels (id, hotelName, rating, review, hotelAddress, discountPrice, actualPrice ,check_in, check_out) VALUES (?,?,?,?,?,?,?,?,?)";

              //$params = array($i, "1/31/2017", "2/1/2017", $item["hotelName"][$i] , $item["rating"][$i], $item["review"][$i], $item["hotelAddress"][$i], $priceA, $priceB);
              $params = array($i, $item["hotelName"][$i],  $item["rating"][$i], $item["review"][$i], $item["hotelAddress"][$i], $priceB, $priceA, "1/31/2017","1/2/2017");

              sqlsrv_query($conn, $insertSql,$params);
          }

          sqlsrv_close($conn);
      }
  }
}

?>
