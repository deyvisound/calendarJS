<?php

require("class/Calendar.php");


if(isset($_POST["data"])){
	parse_str($_POST["data"], $searchArray);
	if($searchArray["proximoMes"]){
		$dateParam	= date('Y-m-d', strtotime($searchArray["proximoMes"]));
	}else if($searchArray["mesAnterior"]){
		$dateParam	= date('Y-m-d', strtotime($searchArray["mesAnterior"]));
	}else{
		$dateParam = date('Y-m-d');	
	}
}else{
	$dateParam = date('Y-m-d');
}


$cal = new Calendar();

$completeCalendar = $cal->completeCalendarArray($dateParam);
$completeCalendar['dateParamText'] = $cal->dateText($dateParam);
$completeCalendar['proximoMes'] = $cal->nextMonth($dateParam);
$completeCalendar['mesAnterior'] = $cal->lastMonth($dateParam);

echo json_encode( $completeCalendar );







