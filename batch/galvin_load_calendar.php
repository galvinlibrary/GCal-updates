<?php
  require_once("../batchFunctions/batchFunctions.php");
  
  $table='hours_gdata_galvin';
  $galvinCalendar='iit.edu_8l0d8qd4qtfn7skmgkiu55uv58%40group.calendar.google.com';
  load_calendar_data(60, $galvinCalendar, $table);
  
?>