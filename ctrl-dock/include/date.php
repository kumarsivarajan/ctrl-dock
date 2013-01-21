<?php
/*
function date_to_int ($calendar_date){
	$day=substr($calendar_date,0,2);
	$month=substr($calendar_date,3,2);
	$year=substr($calendar_date,6,4);
	$date_int=mktime(0,0,0,$month,$day,$year);	
	return($date_int);
}
*/
function date_to_int ($calendar_date){
	$day=substr($calendar_date,0,strpos($calendar_date,"-"));
	$calendar_date=substr($calendar_date,strpos($calendar_date,"-")+1);
	$month=substr($calendar_date,0,strpos($calendar_date,"-"));
	$year=substr($calendar_date,strpos($calendar_date,"-")+1);
	if ($year>1970){
		if ($day<10) {$day="0" . "$day";}
		if ($month<10) {$month="0" . "$month";}
		$date_int=mktime(0,0,0,$month,$day,$year);
	} else {
		$date_int=$day . "-" . $month . "-" . "$year";
	}
		
	return($date_int);
}
?>
