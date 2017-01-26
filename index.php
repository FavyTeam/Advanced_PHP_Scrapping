<?php
error_reporting(E_ALL);
include_once('Config/env.php');

?>

<!Doctype html>
<head>
    <title>Hotel Information from 6 Sites</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" href="template/css/common.css">
</head>
<body>
    <br><br><h2>Hotel Information from Expedia.com, Booking.com, Bookhotelbeds.com, Hotels.com, Bestday.com, despegar.com </h2><br>
    <hr></hr>
      <div class="row" style="width:100%;">
          <div class="col-md-4">
            <div class="landing-page">
              <div class="form-appointment">
                <div class="wpcf7" id="wpcf7-f560-p590-o1">
                  <form action="/landing-page-template-do-not-delete/#wpcf7-f560-p590-o1" method="post" class="wpcf7-form" novalidate="novalidate" _lpchecked="1">
                    <div class="group">
                        <span class="wpcf7-form-control-wrap text-680"><input type="text" name="text-680" value="" size="45" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" placeholder="Destination, Property name or address (City Name e.g : Guatemala City, Mixco)"></span><br>
                    <div style="width: 48%; float: left;">
                      <span class="wpcf7-form-control-wrap text-680"><input type="text" name="text-680" value="" size="45" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" placeholder="Check-In"></span><br>
                      <span class="wpcf7-form-control-wrap text-680"><input type="text" name="text-680" value="" size="30" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" placeholder="Rooms"></span><br>
                      <span class="wpcf7-form-control-wrap text-680"><input type="text" name="text-680" value="" size="30" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" placeholder="Adults"></span><br>
                      <span class="wpcf7-form-control-wrap text-680"><input type="text" name="text-680" value="" size="30" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" placeholder="Children"></span><br>
                    </div>
                    <div style="width: 48%; float: right;">
                      <span class="wpcf7-form-control-wrap text-680"><input type="text" name="text-680" value="" size="45" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" placeholder="Check-Out"></span><br>
                      <h4>Where do you want to Search?</h4>
                      <p>
                        <span class="wpcf7-form-control-wrap radio-98"><span class="wpcf7-form-control wpcf7-radio"><span class="wpcf7-list-item"><label><input type="radio" name="radio-98" value="Phone">&nbsp;<span class="wpcf7-list-item-label">Expedia.com</span></label></span>
                        <span class="wpcf7-list-item"><label><input type="radio" name="radio-98" value="Email">&nbsp;<span class="wpcf7-list-item-label">Booking.com</span></label></span></span></span>
                        <span class="wpcf7-list-item"><label><input type="radio" name="radio-98" value="Email">&nbsp;<span class="wpcf7-list-item-label">Hotels.com</span></label></span></span></span>
                        <span class="wpcf7-list-item"><label><input type="radio" name="radio-98" value="Email">&nbsp;<span class="wpcf7-list-item-label">Bestday.com</span></label></span></span></span>
                        <span class="wpcf7-list-item"><label><input type="radio" name="radio-98" value="Email">&nbsp;<span class="wpcf7-list-item-label">Bookhotelbeds.com</span></label></span></span></span>
                        <span class="wpcf7-list-item"><label><input type="radio" name="radio-98" value="Email">&nbsp;<span class="wpcf7-list-item-label">Despegar.com</span></label></span></span></span>
                      </p>
                      </div>
                    </div>
              <div style="text-align: center; padding-top: 2em; border-top: 1px solid rgb(153, 202, 129); margin-top: 1em;"><input type="submit" value="Search Hotels" class="wpcf7-form-control wpcf7-submit"><img class="ajax-loader" src="http://www.professionalaudiologicalservices.com/wp-content/plugins/contact-form-7/images/ajax-loader.gif" alt="Sending ..." style="visibility: hidden;"></div>
              <div class="wpcf7-response-output wpcf7-display-none"></div></form></div></div></div>
          </div>

          <div class="col-md-8">
              <h3>Search result from query</h3>
          </div>
      </div>
</body>
</html>

<!--

<h4>Days of the week you are available for appointment:</h4>
<p><span class="wpcf7-form-control-wrap checkbox-465"><span class="wpcf7-form-control wpcf7-checkbox"><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-465[]" value="Monday">&nbsp;<span class="wpcf7-list-item-label">Monday</span></label></span><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-465[]" value="Tuesday">&nbsp;<span class="wpcf7-list-item-label">Tuesday</span></label></span><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-465[]" value="Wednesday">&nbsp;<span class="wpcf7-list-item-label">Wednesday</span></label></span><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-465[]" value="Thursday">&nbsp;<span class="wpcf7-list-item-label">Thursday</span></label></span><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-465[]" value="Friday">&nbsp;<span class="wpcf7-list-item-label">Friday</span></label></span></span></span></p>
<h4>Best time of day for your appointment:</h4>
<p><span class="wpcf7-form-control-wrap checkbox-246"><span class="wpcf7-form-control wpcf7-checkbox"><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-246[]" value="Morning">&nbsp;<span class="wpcf7-list-item-label">Morning</span></label></span><span class="wpcf7-list-item"><label><input type="checkbox" name="checkbox-246[]" value="Afternoon">&nbsp;<span class="wpcf7-list-item-label">Afternoon</span></label></span></span></span></p>

-->
