<?php

require("class/Calendar.php");


$cal = new Calendar();

var_dump( $cal->completeCalendarJson( date('Y-m-d', strtotime('2015-02-10'))) );







