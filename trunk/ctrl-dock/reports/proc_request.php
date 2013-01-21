<?php
include("config.php");

function convert_date ($calendar_date,$hh,$mm,$ss){	
	
	$day=substr($calendar_date,0,strpos($calendar_date,"-"));
	$calendar_date=substr($calendar_date,strpos($calendar_date,"-")+1);
	$month=substr($calendar_date,0,strpos($calendar_date,"-"));
	$year=substr($calendar_date,strpos($calendar_date,"-")+1);
	
	if ($year>1970){
		if ($day<10) {$day="0" . "$day";}
		if ($month<10) {$month="0" . "$month";}
		$date_int=mktime($hh,$mm,$ss,$month,$day,$year);
	}
		
	return($date_int);
}



?>
<table class="reporttable" width=100% cellspacing=1 cellpadding=2>
<tr>
	<td class='reportdata' width=80% colspan=4><b>Report Generated From : <?echo $start_date; ?> To : <?echo $end_date; ?></td>
	<?if($_REQUEST["xls"]!=1){?>
	<td class='reportdata' style='text-align:right' width=18%><b><a href=report.php?xls=1&start_date=<?=$start_date;?>&end_date=<?=$end_date;?>>Export to Excel</a></td>
	<?}?>
</tr>
</table>
<br>

<?

$start_date	=convert_date($start_date,0,0,0);
$end_date	=convert_date($end_date,23,59,59);
?>