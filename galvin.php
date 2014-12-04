<?php

// Global variables for PHP functions

$two_days_ago = date("Y-m-d", time()-172800);
$nextOpen = array();
$daysToLoad = 60;        
$timeMin = $two_days_ago . 'T00:00:00.000Z';
$timeMax = date("Y-m-d", time()+(($daysToLoad*86400)+86400)) . 'T23:59:00.000Z';
$calendar = 'iit.edu_8l0d8qd4qtfn7skmgkiu55uv58%40group.calendar.google.com';

$key = file_get_contents('api_key.txt'); // not included in github account for security. Uses digitalservices API key

$url='https://www.googleapis.com/calendar/v3/calendars/' . $calendar . '/events?singleEvents=true&orderby=startTime&timeMin=2014-12-11T00:00:00.000Z&timeMax=2014-12-13T23:59:00.000Z&key=' . $key;
//$url='https://www.googleapis.com/calendar/v3/calendars/' . $calendar . '/events?singleEvents=true&orderby=startTime&timeMin=' . $timeMin . '&timeMax=' . $timeMax . '&key=' . $key;
	//require_once("../mysqli_connect_update.php");

	$debug=true;
  $table = "hours_gdata_galvin";
	$sql="";
	$sql_intro = "INSERT INTO " . $table . " (event_title, ymd, dow, opening, closing, is_closed, is_24) VALUES ";
	$dateFormat="Y-m-d";
	$timeFormat="Hi";
//	$userid = 'cmcclur1@iit.edu';
//	$magicCookie = 'cookie';

$json_file = file_get_contents($url);
// convert the string to a json object
$jsonObj = json_decode($json_file);

$items = $jsonObj->items;
// listing post

foreach ($items as $item) {
    $title = $item->summary;
    if (preg_match("/closed/i", $title)) {$closed = 1; } else {$closed = 0;}// search for closed in title
    if (preg_match("/24/i", $title)) {$is24 = 1; } else {$is24 = 0;} // search for 24 in title in case entry does not have the correct date
    
    // Google Calendar API v3 uses dateTime field if event is less than 24 hours, or date field if it is
    if (isset($item->start->dateTime)){
      $startTime = date($timeFormat, strtotime(substr($item->start->dateTime, 0, 19)));
      $endTime = date($timeFormat,strtotime(substr($item->end->dateTime, 0,19)));
      $eventDate = date($dateFormat,strtotime($item->start->dateTime));
    }
    else {
      $startTime='0000';
      $endTime = 2400;
      $eventDate = date($dateFormat,strtotime($item->start->date));
    }
    
//    if ($startTime == 0){
//      $startTime = 0000;
//    }
    $dow = date('l',strtotime($eventDate));
    $sql .=  "('$title', '$eventDate', '$dow', '$startTime', '$endTime', '$closed', '$is24'), ";
      
    if ($debug) {
      echo "$eventDate | $startTime - $endTime |Open 24 hours? $is24 | Closed? $closed | $dow | $title <br/>";
//      echo "$eventDate<br/>";
    }
}

// remove that final ", " from our string
$sql = substr($sql, 0, -2);
$query = $sql_intro . $sql . ";";

if ($debug){
  echo "<p>$query</p>";
}
?>