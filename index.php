<?php
error_reporting(E_ALL);

include_once('Config/env.php');
// include_once($DB_DIR . 'addcity.php');
?>

<!Doctype html>
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Hotel Information from 6 Sites</title>
    <meta content="text/html;charset=UTF-8" http-equiv="content-type"/>
    <meta name="description" content="">
    <meta name="author" content="">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" href="template/css/common.css">
    <link rel="stylesheet" type="text/css" href="template/css/datapicker.css">

    <script src="template/js/jQuery.js"></script>
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
                            <label>City Name :</label>
                           <select id="citylist" name="cityName">
                              <?php
                                  if (isset($_POST['cityName'])){
                                      echo "<option>" . $_POST['cityName'];
                                  }
                                  $count_city = count($Citys);
                                    for ($i = 0 ; $i < $count_city ; $i++ ) {
                                          echo "<option>" . $Citys[$i] ;
                                    }
                              ?>
                            </select>
                        </span><br>
                    <div style="width: 48%; float: left;">
                      <span class="wpcf7-form-control-wrap text-680">
                        <label>Check-In : </label>
                          <input type="text"  id="datapicker1" name="fromDate"
                           <?php
                            if (isset($_POST['fromDate'])){
                                  echo "value='" . $_POST['fromDate'] . "'";
                            }else{
                                  echo null;
                            }
                          ?> size="45" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" placeholder="MM-DD-YYYY">
                      </span><br>
                      <span class="wpcf7-form-control-wrap text-680">
                        <label>Room Count : </label>
                        <select id="RoomList" name="roomCount">
                          <?php
                                if (isset($_POST['roomCount'])){
                                      echo "<option>" . $_POST['roomCount'];
                                }
                                for ($i = 1 ; $i < 11 ; $i++ ) {
                                      echo "<option>" . $i ;
                                }
                          ?>
                        </select>
                      </span><br>
                      <span class="wpcf7-form-control-wrap text-680">
                        <label>Adult Count : </label>
                        <select id="adultList" name="adultCount">
                          <?php
                                if (isset($_POST['adultCount'])){
                                      echo "<option>" . $_POST['adultCount'];
                                }
                                for ($i = 1 ; $i < 11 ; $i++ ) {
                                      echo "<option>" . $i ;
                                }
                          ?>
                        </select>
                      </span><br>
                      <span class="wpcf7-form-control-wrap text-680">
                        <label>Child Count : </label>
                        <select id="childList" name="childCount">
                          <?php
                                if (isset($_POST['childCount'])){
                                      echo "<option>" . $_POST['childCount'];
                                }
                                for ($i = 0 ; $i < 11 ; $i++ ) {
                                      echo "<option>" . $i ;
                                }
                          ?>
                        </select>
                      </span><br>
                      
                    </div>
                    <div style="width: 48%; float: right;">
                      <span class="wpcf7-form-control-wrap text-680">
                        <label>Check-Out :</label>
                        <input type="text" id="datapicker2" name="toDate" 
                        <?php
                            if (isset($_POST['toDate'])){
                                  echo "value='" . $_POST['toDate'] . "'";
                            }else{
                                  echo null;
                            }
                        ?>size="45" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" placeholder="MM-DD-YYYY">
                      </span><br>
                      <h4><label style="text-align: center;">Where do you want to Search?</label></h4>
                      <p>
                        <span class="wpcf7-form-control-wrap radio-98">
                          <span class="wpcf7-form-control wpcf7-radio">
                              <span class="wpcf7-list-item"><label><input type="radio" name="urls" value="Expedia.com">&nbsp;<span class="wpcf7-list-item-label">Expedia.com</span></label></span>
                              <span class="wpcf7-list-item"><label><input type="radio" name="urls" value="Booking.com">&nbsp;<span class="wpcf7-list-item-label">Booking.com</span></label></span>
                              <span class="wpcf7-list-item"><label><input type="radio" name="urls" value="Hotels.com">&nbsp;<span class="wpcf7-list-item-label">Hotels.com</span></label></span>
                              <span class="wpcf7-list-item"><label><input type="radio" name="urls" value="Bestday.com">&nbsp;<span class="wpcf7-list-item-label">Bestday.com</span></label></span>
                              <span class="wpcf7-list-item"><label><input type="radio" name="urls" value="Bookhotelbeds.com">&nbsp;<span class="wpcf7-list-item-label">Bookhotelbeds.com</span></label></span>
                              <span class="wpcf7-list-item"><label><input type="radio" name="urls" value="Despegar.com">&nbsp;<span class="wpcf7-list-item-label">Despegar.com</span></label></span>
                          </span>
                        </span>
                      </p>
                      </div>
                    </div>
                    <div style="text-align: center; padding-top: 2em; border-top: 1px solid rgb(153, 202, 129); margin-top: 1em;"><input type="submit" value="Search Hotels & Send data to Azure Database" class="wpcf7-form-control wpcf7-submit"><img class="ajax-loader" src="http://www.professionalaudiologicalservices.com/wp-content/plugins/contact-form-7/images/ajax-loader.gif" alt="Sending ..." style="visibility: hidden;"></div>
                    <div class="wpcf7-response-output wpcf7-display-none"></div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-8">
              <!--
              <div class = "row">
                <div class = "container" id="subMenu">
                    <a href="#" class="action-button shadow animate green">Export to CSV</a>
                    <a href="#" class="action-button shadow animate red">Export to CSV</a>
                    <a href="#" class="action-button shadow animate green">Export to CSV</a>
                    <a href="#" class="action-button shadow animate green">Export to CSV</a>
                  </div>
              </div>
            -->
              <br><br>
              <div class = "row">
                <p id="hello" style="color: #fff;">
                    <?php
                          if (isset($_POST['cityName']) && isset($_POST['roomCount']) && isset($_POST['adultCount']) && isset($_POST['childCount']) 
                                                        && isset($_POST['fromDate']) && isset($_POST['toDate']) && isset($_POST['urls']) ){  // call each hotels API here
                              switch($_POST['urls']){
                                case 'Expedia.com':
                                      {
                                          include_once('lib/ExpediaAPI.php');

                                          GenerateExpediaUrl($_POST['cityName'], $_POST['fromDate'], $_POST['toDate'], $_POST['roomCount'], $_POST['adultCount'], $_POST['childCount']);
                                         
                                          //output_json();
                                      }
                                      
                                  break;
                                case 'Booking.com':
                                      {
                                          include_once('lib/BookingAPI.php');

                                          GenerateBookingUrl($_POST['cityName'], $_POST['fromDate'], $_POST['toDate'], $_POST['roomCount'], $_POST['adultCount'], $_POST['childCount']);

                                          //parseStart("abb", "1/2/2017", "1/3/2017", "2", "2", "0");
                                      }
                                  break;
                                case 'Hotels.com':
                                      {
                                          include_once('lib/HotelsAPI.php');

                                          GenerateHotelUrl($_POST['cityName'], $_POST['fromDate'], $_POST['toDate'], $_POST['roomCount'], $_POST['adultCount'], $_POST['childCount']);
                                          //HotelsAPI("abb", "1/2/2017", "1/3/2017", "2", "2", "0");
                                      }
                                      
                                  break;
                                case 'Bestday.com':
                                      {
                                          include_once('lib/BestdayAPI.php');

                                          //output_json();
                                          GenerateBestdayUrl($_POST['cityName'], $_POST['fromDate'], $_POST['toDate'], $_POST['roomCount'], $_POST['adultCount'], $_POST['childCount']);
                                      }
                                      
                                  break;
                                case 'Bookhotelbeds.com':
                                      {
                                          include_once('lib/BookhotelbedsAPI.php');

                                          GenerateHotelBedsUrl($_POST['cityName'], $_POST['fromDate'], $_POST['toDate'], $_POST['roomCount'], $_POST['adultCount'], $_POST['childCount']);
                                          //output_json();
                                      }
                                      
                                  break;
                                case 'Despegar.com':
                                      {
                                          include_once('lib/DespegarAPI.php');

                                          GenerateDespegarUrl($_POST['cityName'], $_POST['fromDate'], $_POST['toDate'], $_POST['roomCount'], $_POST['adultCount'], $_POST['childCount']);
                                          //output_json();
                                      } 
                                    break;
                              }
                          }else{
                             echo "<script>" . 
                                  "alert('Please fill correct or full content in the Search From!!!');" . 
                                  "</script>";
                          }
                    ?>
                </p>
              </div>
          </div>
      </div>
</body>
</html>

<script src="template/js/bootstrap-datapicker.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datapicker1').datepicker({
            format: "dd/mm/yyyy",
            autoclose: true
        });
        $('#datapicker2').datepicker({
            format: "dd/mm/yyyy",
            autoclose: true
        });
  });
</script>
<!--

<h4>Days of the week you are available for appointment:</h4>
<p><span class="wpcf7-form-control-wrap checkbox-465"><span class="wpcf7-form-control wpcf7-checkbox"><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-465[]" value="Monday">&nbsp;<span class="wpcf7-list-item-label">Monday</span></label></span><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-465[]" value="Tuesday">&nbsp;<span class="wpcf7-list-item-label">Tuesday</span></label></span><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-465[]" value="Wednesday">&nbsp;<span class="wpcf7-list-item-label">Wednesday</span></label></span><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-465[]" value="Thursday">&nbsp;<span class="wpcf7-list-item-label">Thursday</span></label></span><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-465[]" value="Friday">&nbsp;<span class="wpcf7-list-item-label">Friday</span></label></span></span></span></p>
<h4>Best time of day for your appointment:</h4>
<p><span class="wpcf7-form-control-wrap checkbox-246"><span class="wpcf7-form-control wpcf7-checkbox"><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-246[]" value="Morning">&nbsp;<span class="wpcf7-list-item-label">Morning</span></label></span><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-246[]" value="Afternoon">&nbsp;<span class="wpcf7-list-item-label">Afternoon</span></label></span></span></span></p>

-->
