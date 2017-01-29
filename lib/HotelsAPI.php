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
    //$url = "https://www.hotels.com/search.do?resolved-location=CITY%3A1635869%3AUNKNOWN%3AUNKNOWN&destination-id=1635869&q-destination=Antigua%20Guatemala,%20Guatemala&q-check-in=2017-01-29&q-check-out=2017-01-30&q-rooms=1&q-room-0-adults=2&q-room-0-children=0";
    $url = "http://www.despegar.com/search/Hotel/2442/2017-01-29/2017-01-30/2?from=SB#sorting=best_selling_descending&page=1&view=list";
    getHtmlFromHotelsAPI($url);
 }



function getHtmlFromHotelsAPI($url){
  if ($url){
      $html = file_get_html($url);
      echo "<br>" . $html;
     /*  foreach($html->find("h3.p-name a") as $element){
          echo $element->innertext . "<br>";
      }
    */
  }
}

?>
