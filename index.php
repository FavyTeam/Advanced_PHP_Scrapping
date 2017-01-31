<?php
error_reporting(E_ALL);

include_once('Config/env.php');
// include_once($DB_DIR . 'addcity.php');

?>

<!Doctype html>
<head>
    <title>Hotel Information from 6 Sites</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" href="template/css/common.css">
    <link rel="stylesheet" type="text/css" href="template/css/datapicker.css">
</head>
<body>
    <br><br><h2>Hotel Information from Expedia.com, Booking.com, Bookhotelbeds.com, Hotels.com, Bestday.com, despegar.com </h2><br>
    <hr></hr>
      <div class="row" style="width:100%;">
          <div class="col-md-4">
            <div class="landing-page">
              <div class="form-appointment">
                <div class="wpcf7" id="wpcf7-f560-p590-o1">
                  <form action="index.php" method="post" class="wpcf7-form" novalidate="novalidate" _lpchecked="1">
                    <div class="group">
                        <span class="wpcf7-form-control-wrap text-680">
                            <input type="text" name="cityName" list="citylist" size="45" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" placeholder="Destination, Property name or address (City Name e.g : Guatemala City, Mixco)">
                            <datalist id="citylist">
                              <?php
                                  $count_city = count($Citys);
                                    for ($i = 0 ; $i < $count_city ; $i++ ) {
                                          echo "<option>" . $Citys[$i] ;
                                    }
                              ?>
                            </datalist>
                        </span><br>
                    <div style="width: 48%; float: left;">
                      <span class="wpcf7-form-control-wrap text-680">
                          <input type="text"  id="datapicker1" name="fromDate" value="" size="45" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" placeholder="Check-In">
                      </span><br>
                      <span class="wpcf7-form-control-wrap text-680">
                        <input type="text" name="RoomCount" list="RoomList" value="" size="30" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" placeholder="Rooms">
                        <datalist id="RoomList">
                          <?php
                                for ($i = 1 ; $i < 11 ; $i++ ) {
                                      echo "<option>" . $i ;
                                }
                          ?>
                        </datalist>
                      </span><br>
                      <span class="wpcf7-form-control-wrap text-680">
                        <input type="text" name="AdultCount" value="" list="adultList" size="30" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" placeholder="Adults">
                        <datalist id="adultList">
                          <?php
                                for ($i = 1 ; $i < 11 ; $i++ ) {
                                      echo "<option>" . $i ;
                                }
                          ?>
                        </datalist>
                      </span><br>
                      <span class="wpcf7-form-control-wrap text-680">
                        <input type="text" name="ChildCount" value="" list="childList" size="30" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" placeholder="Children">
                        <datalist id="childList">
                          <?php
                                for ($i = 0 ; $i < 11 ; $i++ ) {
                                      echo "<option>" . $i ;
                                }
                          ?>
                      </span><br>
                      </datalist>
                    </div>
                    <div style="width: 48%; float: right;">
                      <span class="wpcf7-form-control-wrap text-680">
                        <input type="text" id="datapicker2" name="toDate" value="" size="45" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" placeholder="Check-Out">
                      </span><br>
                      <h4>Where do you want to Search?</h4>
                      <p>
                        <span class="wpcf7-form-control-wrap radio-98"><span class="wpcf7-form-control wpcf7-radio"><span class="wpcf7-list-item"><label><input type="radio" name="radio-98" value="Phone">&nbsp;<span class="wpcf7-list-item-label">Expedia.com</span></label></span>
                        <span class="wpcf7-list-item"><label><input type="radio" name="urls" value="Booking.com">&nbsp;<span class="wpcf7-list-item-label">Booking.com</span></label></span></span></span>
                        <span class="wpcf7-list-item"><label><input type="radio" name="urls" value="Hotels.com">&nbsp;<span class="wpcf7-list-item-label">Hotels.com</span></label></span></span></span>
                        <span class="wpcf7-list-item"><label><input type="radio" name="urls" value="Bestday.com">&nbsp;<span class="wpcf7-list-item-label">Bestday.com</span></label></span></span></span>
                        <span class="wpcf7-list-item"><label><input type="radio" name="urls" value="Bookhotelbeds.com">&nbsp;<span class="wpcf7-list-item-label">Bookhotelbeds.com</span></label></span></span></span>
                        <span class="wpcf7-list-item"><label><input type="radio" name="urls" value="Despegar.com">&nbsp;<span class="wpcf7-list-item-label">Despegar.com</span></label></span></span></span>
                      </p>
                      </div>
                    </div>
                    <div style="text-align: center; padding-top: 2em; border-top: 1px solid rgb(153, 202, 129); margin-top: 1em;"><input type="submit" value="Search Hotels" class="wpcf7-form-control wpcf7-submit"><img class="ajax-loader" src="http://www.professionalaudiologicalservices.com/wp-content/plugins/contact-form-7/images/ajax-loader.gif" alt="Sending ..." style="visibility: hidden;"></div>
                    <div class="wpcf7-response-output wpcf7-display-none"></div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-8">
              <h3>Search result from query</h3>
              <a href="#" class="action-button shadow animate green">Send data to Azure Database</a><br><br>
              <p id="hello" style="color: #fff;">
                  <?php
                        if (isset($_POST['cityName'])){  // call each hotels API here
                            switch($_POST['urls']){
                              case 'Expedia.com':
                                    include_once('lib/ExpediaAPI.php');
                                    //Use another API from lib

                                break;
                              case 'Booking.com':
                                    {
                                        include_once('lib/BookingAPI.php');
                                        parseStart("abb", "1/2/2017", "1/3/2017", "2", "2", "0");
                                    }
                                break;
                              case 'Hotels.com':
                                    include_once('lib/HotelsAPI.php');
                                    HotelsAPI("abb", "1/2/2017", "1/3/2017", "2", "2", "0");
                                break;
                              case 'Bestday.com':
                                    // Use another Library
                                    include_once('lib/BestdayAPI.php');
                                    BestdayAPI("abb", "1/2/2017", "1/3/2017", "2", "2", "0");
                                break;
                              case 'Bookhotelbeds.com':
                                    include_once('lib/BookhotelbedsAPI.php');
                                    BookhotelbedsAPI("abb", "1/2/2017", "1/3/2017", "2", "2", "0");
                                break;
                              case 'Despegar.com':

                                    include_once('lib/DespegarAPI.php');
                                  break;
                            }
                        }
                  ?>
              </p>
          </div>
      </div>
</body>
</html>

<script src="template/js/jQuery.js"></script>
<script src="template/js/bootstrap-datapicker.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datapicker1').datepicker({
            format: "dd/mm/yyyy"
        });
        $('#datapicker2').datepicker({
            format: "dd/mm/yyyy"
        });

    /*    $.get("https://www.bestday.com/Audubon-New-Jersey/Hotels/?GAcat=SearchHotels&origen_base=&origen_base_tipo=&origen_base_desc=&origen_base_prod=&destino_base=10457&destino_base_tipo=D&destino_base_desc=Audubon%2C+PA%2C+United+States&destino_base_prod=ht&carpeta_base=Audubon-New-Jersey&background_size_ht=3132372e3933383334323936373234343725203538307078&dia_desde=6&mes_desde=2&anio_desde=2017&dia_hasta=10&mes_hasta=2&anio_hasta=2017&asoc=&cadena=&ajhoteles=Audubon%2C+PA%2C+United+States&Destino=10457&Ciudad=&ajHotel=&ClavDestino=&ClavCiudad=&check-inH=Feb%2F06%2F2017&check-outH=Feb%2F10%2F2017&num_cuartos=1&num_adultos=2&num_ninos=0&promoCouponGTM=", function(html) {
            console.log("Data loading...");
          document.write(html);
          setTimeout(function(){
              window.stop();
            }, 3000);
        });
      */
  });
</script>
<!--

<h4>Days of the week you are available for appointment:</h4>
<p><span class="wpcf7-form-control-wrap checkbox-465"><span class="wpcf7-form-control wpcf7-checkbox"><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-465[]" value="Monday">&nbsp;<span class="wpcf7-list-item-label">Monday</span></label></span><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-465[]" value="Tuesday">&nbsp;<span class="wpcf7-list-item-label">Tuesday</span></label></span><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-465[]" value="Wednesday">&nbsp;<span class="wpcf7-list-item-label">Wednesday</span></label></span><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-465[]" value="Thursday">&nbsp;<span class="wpcf7-list-item-label">Thursday</span></label></span><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-465[]" value="Friday">&nbsp;<span class="wpcf7-list-item-label">Friday</span></label></span></span></span></p>
<h4>Best time of day for your appointment:</h4>
<p><span class="wpcf7-form-control-wrap checkbox-246"><span class="wpcf7-form-control wpcf7-checkbox"><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-246[]" value="Morning">&nbsp;<span class="wpcf7-list-item-label">Morning</span></label></span><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-246[]" value="Afternoon">&nbsp;<span class="wpcf7-list-item-label">Afternoon</span></label></span></span></span></p>

-->
