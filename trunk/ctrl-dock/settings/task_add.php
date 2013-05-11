<?

include("config.php"); 
if (!check_feature(17)){feature_error();exit;}

$currtimestamp		=mktime();
$currentday			=date('D',$currtimestamp);

$task_summary		=$_REQUEST["task_summary"];
$task_description	=$_REQUEST["task_description"];

$task_date			=$_REQUEST['schedule_date'];
$task_hr			=$_REQUEST['time_hh'];
$task_min			=$_REQUEST['time_mm'];
$recurtype		    =$_REQUEST['recurtype'];

if ($recurtype == "day"){
	$factor=1;
}elseif ($recurtype == "week"){
	$factor=7;
}

$recurvalue			=$_REQUEST['recur'];

$scheduledate		=date_to_int($task_date);
$scheduledate		=$scheduledate+($task_hr*3600)+($task_min*60);

if($recurtype == 'last day of month')
{
	$lastdate = date('t',$currtimestamp); // current month no. of days
	$currmonth= date('m',$currtimestamp);
	$curryear = date('Y',$currtimestamp);

	$scheduledate = mktime($task_hr,$task_min,00,$currmonth,$lastdate,$curryear);
}

$scheduleday		=date('D',$scheduledate);
if($scheduleday == $currentday)
{
	$difftimestamp = $scheduledate - $currtimestamp;
	if($difftimestamp > 0 && $difftimestamp <= 3600)
	{
		$subject	= $task_summary;
		$message  	= "SCHEDULED ACTIVITY : ".$task_description;
		ticket_post($smtp_email,$smtp_email,"29","$subject","$message",'4');
		if($recurvalue > 0)
		{
			if($recurtype == "day" || $recurtype == "week"){
				$nextschedule= $recurvalue*$factor;
				$nextschedule_month = date('m',strtotime('+'.$nextschedule.' days',$scheduledate));
				$nextschedule_date = date('d',strtotime('+'.$nextschedule.' days',$scheduledate));
				$nextschedule_year = date('Y',strtotime('+'.$nextschedule.' days',$scheduledate));
				$nextscheduledate = mktime($task_hr, $task_min, 00, $nextschedule_month, $nextschedule_date, $nextschedule_year);
			}
			elseif($recurtype == "date")
			{
				$nextscheduledate = strtotime('+'.$recurvalue. 'month',$scheduledate);
			}
			else
			{
				$monthval = date('n',$scheduledate);
				$nextschedule= $recurvalue + $monthval;
				if($nextschedule > 12)
				{
					$nextschedule = $nextschedule % 12;
					if($nextschedule == 0)
					{
						$nextschedule=12;
					}
				}
				$nextmonthfirstdaytimestamp = mktime($task_hr,$task_min,00,$nextschedule,1,date('Y',$scheduledate));
				$lastdate = date('t',$nextmonthfirstdaytimestamp); // next month no. of days
				$currmonth= date('m',$nextmonthfirstdaytimestamp);
				$curryear = date('Y',$nextmonthfirstdaytimestamp);

				$nextscheduledate = mktime($task_hr,$task_min,00,$currmonth,$lastdate,$curryear);
			}
		}
		else
		{
			$recurvalue = -1;
			$nextscheduledate = 0;
		}
	}
	elseif($difftimestamp > 3600)
	{
		$nextscheduledate = $scheduledate;
	}
	else
	{
		if($recurvalue > 0)
		{
			if($recurtype == "day" || $recurtype == "week"){
				$nextschedule= $recurvalue*$factor;
				$nextschedule_month = date('m',strtotime('+'.$nextschedule.' days',$scheduledate));
				$nextschedule_date = date('d',strtotime('+'.$nextschedule.' days',$scheduledate));
				$nextschedule_year = date('Y',strtotime('+'.$nextschedule.' days',$scheduledate));
				$nextscheduledate = mktime($task_hr, $task_min, 00, $nextschedule_month, $nextschedule_date, $nextschedule_year);
				
				while($nextscheduledate < $currtimestamp)
					{
					$nextschedule_month = date('m',strtotime('+'.$nextschedule.' days',$nextscheduledate));
					$nextschedule_date = date('d',strtotime('+'.$nextschedule.' days',$nextscheduledate));
					$nextschedule_year = date('Y',strtotime('+'.$nextschedule.' days',$nextscheduledate));
					$nextscheduledate = mktime($task_hr, $task_min, 00, $nextschedule_month, $nextschedule_date, $nextschedule_year);
					}
			}
			elseif($recurtype == "date")
			{
				$nextscheduledate = strtotime('+'.$recurvalue. 'month',$scheduledate);
				while($nextscheduledate < $currtimestamp)
					{
					$nextscheduledate = strtotime('+'.$recurvalue. 'month',$nextscheduledate);
					}
			}
			else
			{
				$monthval = date('n',$scheduledate);
				$nextschedule= $recurvalue + $monthval;
				if($nextschedule > 12)
				{
					$nextschedule = $nextschedule % 12;
					if($nextschedule == 0)
					{
						$nextschedule=12;
					}
				}
				$nextmonthfirstdaytimestamp = mktime($task_hr,$task_min,00,$nextschedule,1,date('Y',$scheduledate));
				$lastdate = date('t',$nextmonthfirstdaytimestamp); // next month no. of days
				$currmonth= date('m',$nextmonthfirstdaytimestamp);
				$curryear = date('Y',$nextmonthfirstdaytimestamp);

				$nextscheduledate = mktime($task_hr,$task_min,00,$currmonth,$lastdate,$curryear);
				
				while($nextscheduledate < $currtimestamp)
					{
					$nextschedule= $recurvalue + $nextschedule;
					$nextmonthfirstdaytimestamp = mktime($schedulehr,$schedulemm,00,$nextschedule,1,date('Y',$nextscheduledate));
					$lastdate = date('t',$nextmonthfirstdaytimestamp); // next month no. of days
					$currmonth= date('m',$nextmonthfirstdaytimestamp);
					$curryear = date('Y',$nextmonthfirstdaytimestamp);

					$nextscheduledate = mktime($task_hr, $task_min,00,$currmonth,$lastdate,$curryear);
					}
			}
		}
		else
		{
			$todaytasktimestamp = mktime($task_hr, $task_min, 00, date('m',$currtimestamp), date('d',$currtimestamp), date('Y',$currtimestamp));
			if($todaytasktimestamp > $currtimestamp)
			{
				$nextscheduledate = $todaytasktimestamp;
			}
			else
			{
			$returndate = date('d', strtotime("next $scheduleday"));
			$returnmonth = date('m', strtotime("next $scheduleday"));
			$returnyear = date('Y', strtotime("next $scheduleday"));
			$returnvalue1 = mktime($task_hr, $task_min, 00, $returnmonth, $returndate, $returnyear);
			$nextscheduledate = $returnvalue1;
			}
		}
	}
}
else
{
	$difftimestamp = $scheduledate - $currtimestamp;
	if($difftimestamp > 0)
	{
		$nextscheduledate = $scheduledate;
	}
	else
	{
		if($recurvalue > 0)
		{
			if($recurtype == "day" || $recurtype == "week"){
				$nextschedule= $recurvalue*$factor;
				$nextschedule_month = date('m',strtotime('+'.$nextschedule.' days',$scheduledate));
				$nextschedule_date = date('d',strtotime('+'.$nextschedule.' days',$scheduledate));
				$nextschedule_year = date('Y',strtotime('+'.$nextschedule.' days',$scheduledate));
				$nextscheduledate = mktime($task_hr, $task_min, 00, $nextschedule_month, $nextschedule_date, $nextschedule_year);
				while($nextscheduledate < $currtimestamp)
					{
					$nextschedule_month = date('m',strtotime('+'.$nextschedule.' days',$nextscheduledate));
					$nextschedule_date = date('d',strtotime('+'.$nextschedule.' days',$nextscheduledate));
					$nextschedule_year = date('Y',strtotime('+'.$nextschedule.' days',$nextscheduledate));
					$nextscheduledate = mktime($task_hr, $task_min, 00, $nextschedule_month, $nextschedule_date, $nextschedule_year);
					}
			}
			elseif($recurtype == "date")
			{
				$nextscheduledate = strtotime('+'.$recurvalue. 'month',$scheduledate);
				while($nextscheduledate < $currtimestamp)
					{
					$nextscheduledate = strtotime('+'.$recurvalue. 'month',$nextscheduledate);
					}
			}
			else
			{
				$monthval = date('n',$scheduledate);
				$nextschedule= $recurvalue + $monthval;
				if($nextschedule > 12)
				{
					$nextschedule = $nextschedule % 12;
					if($nextschedule == 0)
					{
						$nextschedule=12;
					}
				}
				$nextmonthfirstdaytimestamp = mktime($task_hr,$task_min,00,$nextschedule,1,date('Y',$scheduledate));
				$lastdate = date('t',$nextmonthfirstdaytimestamp); // next month no. of days
				$currmonth= date('m',$nextmonthfirstdaytimestamp);
				$curryear = date('Y',$nextmonthfirstdaytimestamp);

				$nextscheduledate = mktime($task_hr,$task_min,00,$currmonth,$lastdate,$curryear);
				
				while($nextscheduledate < $currtimestamp)
					{
					$nextschedule= $recurvalue + $nextschedule;
					$nextmonthfirstdaytimestamp = mktime($schedulehr,$schedulemm,00,$nextschedule,1,date('Y',$nextscheduledate));
					$lastdate = date('t',$nextmonthfirstdaytimestamp); // next month no. of days
					$currmonth= date('m',$nextmonthfirstdaytimestamp);
					$curryear = date('Y',$nextmonthfirstdaytimestamp);

					$nextscheduledate = mktime($task_hr, $task_min,00,$currmonth,$lastdate,$curryear);
					}
			}
		}
		else
		{
			$returndate = date('d', strtotime("next $scheduleday"));
			$returnmonth = date('m', strtotime("next $scheduleday"));
			$returnyear = date('Y', strtotime("next $scheduleday"));
			$returnvalue1 = mktime($task_hr, $task_min, 00, $returnmonth, $returndate, $returnyear);
			$nextscheduledate = $returnvalue1;
		}
	}
}

if ($task_summary=="" || $task_description==""){

$SELECTED="ADD A TASK";
include("header.php");
?>
<script type="text/javascript">
function functionrecur(str)
{
	if(str == 'last day of month')
	{
	document.getElementById('schedule_date').value='';
	document.getElementById('schedule_date').disabled=true;
	}
	else
	{
	document.getElementById('schedule_date').disabled=false;
	}
}
</script>

<form method="POST" action="task_add.php">
<table border=0 cellpadding=1 cellspacing=1 width=1000 bgcolor=#F7F7F7>

<tr>
	<td class='tdformlabel'><b>&nbsp;Summary</font></b></td>
	<td align=right><input name="task_summary" size="70" class=forminputtext></td>
</tr>
<tr>
	<td class='tdformlabel'><b>&nbsp;Description</font></b></td>
	<td align=right><textarea rows="3" name="task_description" cols="68" class='formtextarea'></textarea></td>
	
</tr>
<br>
			<tr>
				<td class='tdformlabel'><b>&nbsp;Schedule Date</font></b></td>
				<td align=right><input class=formnputtext name=schedule_date id="schedule_date" style="font-size: 9pt; font-family: Arial; width:165px;" onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF></td>
			</tr>

<tr>
				<td class='tdformlabel'><b>&nbsp;Schedule Time</font></b></td>					
				<td align=right>
					<select size=1 class=formselect name="time_hh">
					<?
						for($i=0;$i<24;$i++){
							if ($i<10){$i="0".$i;}
							echo "<option value='$i'>$i</option>";
						}
					?>
					</select>
					<select size=1 class=formselect name="time_mm">
					<?
						for($i=0;$i<60;$i++){
							if ($i<10){$i="0".$i;}
							echo "<option value='$i'>$i</option>";
						}
					?>
					</select>
				</td>
			</tr>

<tr>
	<td class='tdformlabel' width=250><b>&nbsp;Recur Type</font></b></td>
	<td align=right>
	<select name='recurtype' class=formselect onchange="functionrecur(this.value)">
	<option value=''>Select Type</option>
	<option value='day'>Days</option>
	<option value='week'>Weeks</option>
	<option value='date'>Date / Month</option>
	<option value='last day of month'>Last day of the Month</option>
	</select>
	</td>
</tr>
<tr>
	<td class='tdformlabel'><b>&nbsp;Recur value</font></b></td>
	<td align=right><input type="text" name="recur" size="70" class=forminputtext /></td>
</tr>
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Save" name="Submit" class=forminputbutton>&nbsp;&nbsp;<input type="button" onclick="window.location=''" value="Reset" class=forminputbutton>
	</td>
</tr>
</table>
</form>

<?php
}else {
	$task_summary		=clean_string($task_summary);
	$task_description	=clean_string($task_description);
	
	$sql = "INSERT INTO scheduled_tasks (task_summary,task_description,scheduled_date,scheduled_hr,scheduled_min,recurchoice,recur,task_posted) VALUES ('$task_summary','$task_description','$scheduledate','$task_hr','$task_min','$recurtype','$recurvalue','$nextscheduledate')";
	mysql_query($sql);
?>
	<center><i><b><font color="#003366" face="Arial" size=2>The New Task has been successfully added.</font></b></i></center>
	<meta http-equiv="Refresh" content="1; URL=tasks.php">
<?	
}
?>

