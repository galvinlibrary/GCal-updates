<?php
  require_once("../batchFunctions/batchFunctions.php");
  
  $IFSHtable='hours_gdata_ncfst';
  $IFSHcalendar='iit.edu_5i0pd1jtpscfvfbebc1b2of5jc@group.calendar.google.com';
  load_calendar_data(60, $IFSHcalendar, $IFSHtable);
  
?>