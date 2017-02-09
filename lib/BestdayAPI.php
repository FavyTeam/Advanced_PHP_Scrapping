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

      <scritp>
          /*    
          $.get("https://www.bestday.com/Audubon-New-Jersey/Hotels/?GAcat=SearchHotels&origen_base=&origen_base_tipo=&origen_base_desc=&origen_base_prod=&destino_base=10457&destino_base_tipo=D&destino_base_desc=Audubon%2C+PA%2C+United+States&destino_base_prod=ht&carpeta_base=Audubon-New-Jersey&background_size_ht=3132372e3933383334323936373234343725203538307078&dia_desde=6&mes_desde=2&anio_desde=2017&dia_hasta=10&mes_hasta=2&anio_hasta=2017&asoc=&cadena=&ajhoteles=Audubon%2C+PA%2C+United+States&Destino=10457&Ciudad=&ajHotel=&ClavDestino=&ClavCiudad=&check-inH=Feb%2F06%2F2017&check-outH=Feb%2F10%2F2017&num_cuartos=1&num_adultos=2&num_ninos=0&promoCouponGTM=", function(html) {
            console.log("Data loading...");
          document.write(html);
          setTimeout(function(){
              window.stop();
            }, 3000);
        });
        */
      </script>
      $html = new simple_html_dom();
      $html->load_file($url);

      echo $html->save();
  }
 }

 ?>
