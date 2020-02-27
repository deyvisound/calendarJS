<?php

require("class/Calendar.php");


$dateParam = date('Y-m-d'); //, strtotime('2015-02-10'));

$cal = new Calendar();

$completeCalendar = $cal->completeCalendarArray($dateParam);
$completeCalendar['dateParamText'] = $cal->dateText($dateParam);

echo json_encode( $completeCalendar );







