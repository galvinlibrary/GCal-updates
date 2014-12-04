<?php
  require_once("../batchFunctions/batchFunctions.php");
  
  $GRCtable='hours_gdata_grc';
  $GRCcalendar='iit.edu_gdc17jibvf25gjurjjmgi1dod0@group.calendar.google.com';
  load_calendar_data(60, $GRCcalendar, $GRCtable);
  
?>