<?php
/**
 * All of the Defines for the classes below.
 * @author Dovydas.B <Dovydas.b@outlook.com>
 * @version 1.0
 * @package BookingAPI.php
 * @subpackage Parse API for Booking.com
 */



error_reporting(E_ALL);
include_once('simple_html_dom.php');

function GenerateBookingUrl($cityName, $check_in, $check_out, $room, $adult, $child){
    
}

function parseStart($cityName, $check_in, $check_out, $room, $adult, $child){
    $booking_url = "https://www.booking.com/searchresults.html?label=gen173nr-1DCAEoggJCAlhYSDNiBW5vcmVmaIgBiAEBmAExuAEIyAEP2AED6AEB-AECkgIBeagCAw;sid=5a99936e7d8bd47abf7ec5cb1265e7da;checkin_month=2&checkin_monthday=12&checkin_year=2017&checkout_month=2&checkout_monthday=13&checkout_year=2017&class_interval=1&dest_id=-1131627&dest_type=city&dtdisc=0&group_adults=2&group_children=0&hlrd=0&hyb_red=0&inac=0&label_click=undef&mcs=0&mih=0&nha_red=0&no_rooms=1&offset=0&postcard=0&raw_dest_type=city&redirected_from_city=0&redirected_from_landmark=0&redirected_from_region=0&room1=A%2CA&sb_price_type=total&search_selected=1&src=index&src_elem=sb&ss=Antigua%20Guatemala%2C%20Guatemala&ss_all=0&ss_raw=anti&ssb=empty&sshis=0&";
    
    $booking_offset_url = "https://www.booking.com/searchresults.html?aid=304142&label=gen173nr-1DCAEoggJCAlhYSDNiBW5vcmVmaIgBiAEBmAExuAEIyAEP2AED6AEB-AECkgIBeagCAw&sid=5a99936e7d8bd47abf7ec5cb1265e7da&checkin_month=2&checkin_monthday=12&checkin_year=2017&checkout_month=2&checkout_monthday=13&checkout_year=2017&class_interval=1&dest_id=-1131627&dest_type=city&dtdisc=0&group_adults=2&group_children=0&hlrd=0&hyb_red=0&inac=0&label_click=undef&mcs=0&mih=0&nha_red=0&no_rooms=1&postcard=0&raw_dest_type=city&redirected_from_city=0&redirected_from_landmark=0&redirected_from_region=0&room1=A%2CA&sb_price_type=total&search_selected=1&src=index&src_elem=sb&ss=Antigua%20Guatemala%2C%20Guatemala&ss_all=0&ss_raw=anti&ssb=empty&sshis=0&";

    $increase_count = 20;

    for ($i = 0; $i<140 ; $i+=$increase_count ){
        if ($i==0){
            getHtmlBody($booking_url);
        }
        else
        {
          $pandingURL = $booking_offset_url . "row=20&offset=" . $i;
          $result = getHtmlBody($pandingURL);
          if ($result == "None"){
              break;
          }
        }    
    }
}

function getHtmlBody($url){
    if ($url){
        $booking_html = file_get_html($url);
        if ($booking_html){
            paringData($booking_html);
        }else{
          return "None";
        }
    }
}

function paringData($html){
    echo "<br>";

    $hotel_count = 0;

    foreach($html->find("span.sr-hotel__name") as $element){   // ** Hotel Name  **
        $hotel["hotelName"][] = $element->innertext;
        $hotel_count++;
    }

    foreach($html->find("div.address a") as $element){   // ** Hotel Address  **
        $hotel["hotelAddress"][] = $element->innertext;
    }

    foreach($html->find("div.lbsr") as $element){   // ** Booking Status  **
        //$hotel["bookingStatus"][] = $element->innertext;

        if ($element->children(0)->children(0)){
            $hotel["hotelBookingStatus"][] = $element->children(0)->children(0)->innertext;
        }else{
            $hotel["hotelBookingStatus"][] = $element->children(0)->innertext;
        }

    }

    // If i have time , I will add Hotel Room's Service and Infomation such as Room Type, Room Service , ...

    foreach($html->find("span.js--hp-scorecard-scoreval") as $element){   // ** Hotel Rating  **
        $hotel["hotelRating"][] = $element->innertext;
    }

    foreach($html->find("span.score_from_number_of_reviews") as $element){   // ** Hotel Review  **
        //echo explode(" ",$element->innertext)[1] . "<br>";
        $hotel["hotelReview"][] = explode(" ",$element->innertext)[1];
    }

    foreach($html->find("div.smart_price_style") as $element){   // ** Hotel Discount Price  **
        //echo $element->plaintext . "<br>";
    }

    foreach($html->find("div.address a") as $element){   // ** Hotel Actual Price  **
        //echo $element->plaintext . "<br>";

    }

    if ($hotel_count==0){
        echo "Hotel data is not exist!!!";
    }else{

      include_once(dirname(__FILE__) . "\..\db\dbconnect.php");
      $date = new DateTime();
      $conn = connect();

      ini_set('max_execution_time', 100000);

      //---------------Get sql count from Azure Database---------------------------

      $sql = "SELECT * FROM tbl_booking";
      $params = array();
      $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
      $stmt = sqlsrv_query( $conn, $sql , $params, $options );
      $row_count = sqlsrv_num_rows( $stmt );

      if ($row_count === false)
         $row_count = 0;
      //-----------------------------------------

      for ($i=0; $i < $hotel_count ; $i++){

    /*      echo $i . " => { " ."<br>";
          echo "hotel name -> " . $hotel["hotelName"][$i] . "<br>";
          echo "hotel Address -> " . $hotel["hotelAddress"][$i] . "<br>";
          echo "hotel BookingStatus -> " . $hotel["hotelBookingStatus"][$i] . "<br>";
          echo "hotel Rating -> " . $hotel["hotelRating"][$i] . "<br>";
          echo "hotel Review -> " . $hotel["hotelReview"][$i] . "<br>";
          echo " } " . "<br>";
    */

          // Here is the step that delete <script> in bookingStatus Tags.

          if ( (strpos($hotel["hotelBookingStatus"][$i], '<') !== FALSE) && (strpos($hotel["hotelBookingStatus"][$i], '>') !== FALSE) ){
                $nfrom = strrpos($hotel["hotelBookingStatus"][$i], '>');
                $hotel["hotelBookingStatus"][$i] = substr($hotel["hotelBookingStatus"][$i], $nfrom+1);
          }
        
     //     $insertSql = "INSERT INTO tbl_booking (id, cityName, check_in, check_out, hotelName, hotelAddress, bookingStatus, hotelRating, hotelReview /*, discountPrice, actualPrice, currency */ ) VALUES (?,?,?,?,?,?,?,?,?)";

     //     $params = array( $row_count + $i, "Antigua Guatemala", "2/12/2017", "2/13/2017", $hotel["hotelName"][$i], $hotel["hotelAddress"][$i], $hotel["hotelBookingStatus"][$i], $hotel["hotelRating"][$i], $hotel["hotelReview"][$i]);

     //     sqlsrv_query($conn, $insertSql,$params);
    

      }

      sqlsrv_close($conn);
    }

}

?>
