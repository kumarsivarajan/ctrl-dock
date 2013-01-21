<?
include("config.php");
if (!check_feature(16)){feature_error();exit;}  
?>
<?
$SELECTED="TASKS";
include("header.php");
?>

<table class="reporttable" width=1000>
<tr>
	<td colspan=7 align=right>
		<a style="text-decoration: none" href="task_add.php">
		<font color="#99CC33" face="Arial" size="2"><b>Add Task</font></a>
	</td>
</tr>


<?php
$sql = "select task_id,task_summary,task_description,scheduled_date,task_posted,recurchoice,recur from scheduled_tasks order by task_summary";
$result = mysql_query($sql);
$row_count=mysql_num_rows($result);
if($row_count>0){
?>
<tr>
	<td class="reportheader" width=40>Sl. No.</td>
	<td class="reportheader">Summary</td>
	<td class="reportheader" width=110>Scheduled Date</td>
	<td class="reportheader" width=100>Next Scheduled</td>
	<td class="reportheader" width=100>Recur</td>
	<td class="reportheader" width=40>Edit</td>
	<td class="reportheader" width=40>Delete</td>
</tr>
<?
}
$i=1;

while ($row = mysql_fetch_row($result)){
	$summary	 =$row[1];
	$description =$row[2];
	$scheduledate=$row[3];
	$nextschedule=$row[4];
	$recurtype	 =$row[5];
	$recur	     =$row[6];
	
	if ($scheduledate == NULL or $scheduledate == 0){
		$scheduledate = "Not Set";
	}else{
		$scheduledate = date('d-m-Y H:i:s',$scheduledate);
	}
	if ($recur == 0 || $recur == -1){$recur_text="No";}
	if ($recur==1 && $recurtype=='day'){$recur_text=$recur." Day";} elseif ($recur==1 && $recurtype=='week'){$recur_text=$recur." Week";} elseif ($recur==1 && $recurtype=='date'){$recur_text=$recur." Month";} elseif ($recur==1 && $recurtype=='last day of month'){$recur_text="Last Day of the Month with recur value $recur";}
	if ($recur>1 && $recurtype=='day'){$recur_text=$recur." Days";} elseif ($recur>1 && $recurtype=='week'){$recur_text=$recur." Weeks";} elseif ($recur>1 && $recurtype=='date'){$recur_text=$recur." Months";} elseif ($recur>1 && $recurtype=='last day of month'){$recur_text="Last Day of the Month with recur value $recur";}
	
		
?>
	<tr bgcolor=#EDEDE4>
		<td class='reportdata' style='text-align:center;'><? echo $i; ?></td>
		<td class='reportdata'><? echo $summary; ?></td>
		<td class='reportdata' width=110>&nbsp;<? echo $scheduledate; ?></td>
		<td class='reportdata' width=110>&nbsp;<? if($nextschedule > 0){echo date('d-m-Y H:i:s',$nextschedule);} else{ echo 'Not Set'; }?></td>
		<td class='reportdata' width=100>&nbsp;<? echo $recur_text; ?></td>
		<td class=reportdata width=40 style='text-align: center;'><a href='task_edit.php?task_id=<?echo $row[0];?>'><img src=images/edit.gif border=0></img></a></td>
		<td class=reportdata width=40 style='text-align: center;'><a href='task_delete.php?task_id=<?echo $row[0];?>'><img src=images/delete.gif border=0></img></a></td>
	</tr>
	<tr bgcolor=#FFFFFF>
		<td class='reportdata' colspan=6>
		<?=nl2br($description);?>
		</td>
	</tr>
	<?	
	$i++;
 }
?>
</table>
</body>
</html>
