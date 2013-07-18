<?php
function date_to_int ($calendar_date){
	$day=substr($calendar_date,0,2);
	$month=substr($calendar_date,3,2);
	$year=substr($calendar_date,6,4);
	$date_int=mktime(0,0,0,$month,$day,$year);	
	return($date_int);
}
?>
