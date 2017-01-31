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

/*
 function BestdayAPI($cityName, $check_in, $check_out, $room, $adult, $child){
    $url = "https://www.bestday.com/Flores-Guatemala/Hotels/";
    getHtmlFromBestdayAPI($url);
 }

 */

 function BestdayAPI($cityName, $check_in, $check_out, $room, $adult, $child){

 }



 function getHtmlFromBestdayAPI($url){
  if ($url){
      //$html = file_get_html($url);
      //echo "<br>";
      //echo $html;
      /*
      foreach($html->find("div.hc_m_outer") as $element){
          echo $element . "<br>";
      }
      */
      $html = new simple_html_dom();
      $html->load_file($url);

      echo $html->save();
  }
 }

 ?>
