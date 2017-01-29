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

 function BookhotelbedsAPI($cityName, $check_in, $check_out, $room, $adult, $child){
    $url = "http://brands.datahc.com/Hotels/Search?destination=place%3AAntigua_Guatemala&resultID=8&languageCode=EN&checkin=2017-01-29&checkout=2017-01-30&Rooms=1&Adults_1=2";
    getHtmlFromHotelsAPI($url);
 }



 function getHtmlFromHotelsAPI($url){
  if ($url){
      $html = file_get_html($url);
      echo "<br>";
      foreach($html->find("div.hc_m_outer") as $element){
          echo $element . "<br>";
      }
  }
 }

 ?>
