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

//$html = file_get_html('http://www.booking.com/searchresults.html?label=gen173nr-1FCAEoggJCAlhYSDNiBW5vcmVmaIgBiAEBmAExuAEIyAEP2AEB6AEB-AECqAID;sid=5a99936e7d8bd47abf7ec5cb1265e7da;checkin_month=1&checkin_monthday=26&checkin_year=2017&checkout_month=1&checkout_monthday=27&checkout_year=2017&class_interval=1&dest_id=-1131627&dest_type=city&dtdisc=0&group_adults=2&group_children=0&hlrd=0&hyb_red=0&inac=0&label_click=undef&nha_red=0&no_rooms=1&offset=0&onclick_sh=1&postcard=0&raw_dest_type=city&redirected_from_city=0&redirected_from_landmark=0&redirected_from_region=0&room1=A%2CA&sb_price_type=total&search_selected=1&src=index&src_elem=sb&ss=Antigua%20Guatemala%2C%20Guatemala&ss_all=0&ssb=empty&sshis=0&');
/*
foreach($html->find("div#search_results_table") as $element){
    echo $element;
}
       //echo $element->src . '<br>';
*/
function parseStart($cityName, $check_in, $check_out, $room, $adult, $child){
    $booking_url = 'http://www.booking.com/searchresults.html?label=gen173nr-1DCAEoggJCAlhYSDNiBW5vcmVmaIgBiAEBmAExuAEIyAEP2AED6AEB-AECqAID;sid=5a99936e7d8bd47abf7ec5cb1265e7da;checkin_month=1&checkin_monthday=27&checkin_year=2017&checkout_month=1&checkout_monthday=28&checkout_year=2017&class_interval=1&dest_id=-1133206&dest_type=city&dtdisc=0&group_adults=2&group_children=0&hlrd=0&hyb_red=0&inac=0&label_click=undef&nha_red=0&no_rooms=1&offset=0&onclick_recs=1&postcard=0&raw_dest_type=city&redirected_from_city=0&redirected_from_landmark=0&redirected_from_region=0&room1=A%2CA&sb_price_type=total&search_selected=1&src=index&src_elem=sb&ss=Guatemala%2C%20Guatemala%2C%20Guatemala&ss_all=0&ssb=empty&sshis=0&';
    getHtmlBody($booking_url);
}

function getHtmlBody($url){
    if ($url){
        $booking_html = file_get_html($url);
        paringData($booking_html);
    }
}

function paringData($html){
  echo "<br>";

  /*
    $hotels = [];
    $hotelInfo = array(
          "hotelName" => "",  //This is the Key (  hotelName => {hotel data} )
          "recommend" => "",
          "reviewCount" => "",
          "RoomType" => "",
          "bookedStatus" => "",
          "originPrice" => "",
          "actualPrice" => ""
    );

  */

    foreach($html->find("div.sr_item") as $element){
        //echo $element . "<br>";
        $m_hotelName = $element->find("span.sr-hotel__name");
        var_dump($m_hotelName);
    //    $m_hotelRecommend = $element->find("span.js--hp-scorecard-scoreword") . " " . $element->find("span.average");
    //    $m_hotelreviewCount = $element->find("span.score_from_number_of_reviews");
    //    $m_roomType = $element->find("span.room_link");
    //    $m_bookedStatus = $element->find("div.rollover-s1");

      //  $subelement = $element->find("span#b_tt_holder_3");
      //  $m_originPrice = $subelement->find("b");

    //    $m_actualPrice = $element->find("div.price")->find("b");

    //    echo $m_hotelName.plaintext . "=> {";
      //      echo "Recommend => " . $m_hotelRecommend . ", <br>";
    //        echo "ReviewCount => " . $m_hotelreviewCount . ", <br>";
    //        echo "RoomType => " . $m_roomType . ", <br>";
    //        echo "BookedStatus => " . $m_bookedStatus . ", <br>";
      //      echo "originPrice => " . $m_originPrice . ", <br>";
      //      echo "actualPrice => " . $m_actualPrice . ", <br>";
    //    echo "}";
    }

}

?>
