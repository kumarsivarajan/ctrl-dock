<?php 
include_once("config.php");
if (!check_feature(50)){feature_error();exit;}

$activity_id	=$_REQUEST["activity_id"];


$sql="select a.project,a.action_by,a.action_date from poa_master a where a.activity_id='$activity_id'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$project=$row[0];
$sub_sql="select first_name,last_name from user_master where username='$row[1]'";
$sub_result = mysql_query($sub_sql);
$sub_row = mysql_fetch_row($sub_result);
$action_by=$sub_row[0]." ".$sub_row[1];

$action_date	=date("d M Y H:i",$row[2]);


$sql="select activity_id,scheduled_start_date,scheduled_end_date,actual_start_date,actual_end_date,location,activity_description,activity_impact,activity_services,activity_verification,release_notes";
$sql.=" from poa_information where activity_id='$activity_id' order by record_index DESC limit 1";

$result = mysql_query($sql);
$record_count=mysql_num_rows($result);
if($record_count>0){
	while ($row = mysql_fetch_row($result)){
		$activity_id	=$row[0];

		if($row[1]>0){
			$s_from_date	=date("d-m-Y",$row[1]);
			$s_from_time_hh	=date("H",$row[1]);
			$s_from_time_mm	=date("i",$row[1]);
		}
		if($row[2]>0){
			$s_end_date		=date("d-m-Y",$row[2]);
			$s_end_time_hh	=date("H",$row[2]);
			$s_end_time_mm	=date("i",$row[2]);
		}

		if($row[3]>0){
			$a_from_date	=date("d-m-Y",$row[3]);
			$a_from_time_hh	=date("H",$row[3]);
			$a_from_time_mm	=date("i",$row[3]);
		}
			
		if($row[4]>0){
			$a_end_date		=date("d-m-Y",$row[4]);
			$a_end_time_hh	=date("H",$row[4]);
			$a_end_time_mm	=date("i",$row[4]);
		}
		
		$location		=$row[5];

		$activity_description	=$row[6];
		$activity_impact		=$row[7];
		$activity_services		=$row[8];
		$activity_verification	=$row[9];
		$release_notes		=$row[10];
	}
}
?>


<table border=0 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#F5F5F5>
<tr>
	<td height=40 align=left><b><font face=Arial size=3>&nbsp;PLANNED ACTIVITY - <?=$activity_id;?></font></b></td>
	<td align=right><b><font face="Arial" color="#CC0000" size="1"><a href=index.php><font face=Arial size=1 color=#BBBBBB><b>BACK</font></b></a></td>
</tr>
</table>


<form method=POST action=pa_edit_2.php?activity_id=<?=$activity_id;?>>


<br>
<table border=1 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#F5F5F5>
<tr><td class=reportheader style='text-align:left' colspan=2>&nbsp;Summary</font></td></tr>
<tr>
	<td class=reportdata width=500>Project / Activity</td>
	<td class=reportdata width=500><input name="project" size="60" class=forminputtext value="<?=$project;?>"></td>
	
</tr>
<tr>
	<td class=reportdata width=500>Initiated By</td>
	<td class=reportdata width=500><?=$action_by;?></td>
</tr>
<tr>
	<td class=reportdata width=500>Initiated On</td>
	<td class=reportdata width=500><?=$action_date;?></td>
</tr>
</table>
<br>

<table border=1 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#F5F5F5>
<tr><td class=reportheader style='text-align:left' colspan=2>&nbsp;Schedule & Location</td></tr>
<tr>
	<td class=reportdata width=500>Scheduled Start Date / Time</td>
	<td class=reportdata width=500>
		<input style="width: 80px;" class=forminputtext name=s_from_date id="s_from_date" value="<?=$s_from_date;?>" onclick="fPopCalendar('s_from_date')">
		<select size=1 class=formselect name="s_from_time_hh">
		<option value='<?=$s_from_time_hh;?>'><?=$s_from_time_hh;?></option>
			<?
					for($i=0;$i<24;$i++){
					if ($i<10){$i="0".$i;}
					echo "<option value='$i'>$i</option>";
				}
			?>
		</select>
		<select size=1 class=formselect name="s_from_time_mm">
		<option value='<?=$s_from_time_mm;?>'><?=$s_from_time_mm;?></option>
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
	<td class=reportdata width=500>Scheduled End Date / Time</td>
	<td class=reportdata width=500>
		<input style="width: 80px;" class=forminputtext name=s_to_date id="s_to_date" value="<?=$s_end_date;?>" onclick="fPopCalendar('s_to_date')">
		<select size=1 class=formselect name="s_to_time_hh">
		<option value='<?=$s_end_time_hh;?>'><?=$s_end_time_hh;?></option>
			<?
				for($i=0;$i<24;$i++){
					if ($i<10){$i="0".$i;}
					echo "<option value='$i'>$i</option>";
				}
			?>
		</select>
		<select size=1 class=formselect name="s_to_time_mm">
		<option value='<?=$s_end_time_mm;?>'><?=$s_end_time_mm;?></option>
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
	<td class=reportdata width=500>Actual Start Date / Time</td>
	<td class=reportdata width=500>
		<input style="width: 80px;" class=forminputtext name=a_from_date id="a_from_date" value="<?=$a_from_date;?>" onclick="fPopCalendar('a_from_date')">
		<select size=1 class=formselect name="a_from_time_hh">
		<option value='<?=$a_from_time_hh;?>'><?=$a_from_time_hh;?></option>
			<?
					for($i=0;$i<24;$i++){
					if ($i<10){$i="0".$i;}
					echo "<option value='$i'>$i</option>";
				}
			?>
		</select>
		<select size=1 class=formselect name="a_from_time_mm">
		<option value='<?=$a_from_time_mm;?>'><?=$a_from_time_mm;?></option>
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
	<td class=reportdata width=500>Actual End Date / Time</td>
	<td class=reportdata width=500>
		<input style="width: 80px;" class=forminputtext name=a_to_date id="a_to_date" value="<?=$a_end_date;?>" onclick="fPopCalendar('a_to_date')">
		<select size=1 class=formselect name="a_to_time_hh">
		<option value='<?=$a_end_time_hh;?>'><?=$a_end_time_hh;?></option>
			<?
				for($i=0;$i<24;$i++){
					if ($i<10){$i="0".$i;}
					echo "<option value='$i'>$i</option>";
				}
			?>
		</select>
		<select size=1 class=formselect name="a_to_time_mm">
		<option value='<?=$a_end_time_mm;?>'><?=$a_end_time_mm;?></option>
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
	<td class=reportdata width=500>Location</td>
	<td>
	<input name="location" size="60" class=forminputtext value="<?=$location;?>">
	</td>
</tr>
</table>

<table border=1 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#F5F5F5>
<tr><td class=reportheader style='text-align:left' colspan=2>&nbsp;Activity Information</td></tr>

<tr>
	<td class=reportdata width=500>Description of Activity</td>
	<td>
	<textarea rows="3" name="activity_description" cols="75" class='formtextarea'><?=$activity_description;?></textarea>
	</td>
</tr>

<tr>
	<td class=reportdata width=500>Scope of Impact <br>(Areas/Services/Customers potentially impacted)</td>
	<td>
		<textarea rows="3" name="activity_impact" cols="75" class='formtextarea'><?=$activity_impact;?></textarea>
	</td>
</tr>

<tr>
	<td class=reportdata width=500>Testing of Services after Implementation</td>
	<td>
	<textarea rows="3" name="activity_services" cols="75" class='formtextarea'><?=$activity_services;?></textarea>
	</td>
</tr>

<tr>
	<td class=reportdata width=500>Verification of Activity<br>(Information to verify that the activity has been completed successfully)</td>
	<td>
	<textarea rows="3" name="activity_verification" cols="75" class='formtextarea'><?=$activity_verification;?></textarea>
	</td>
</tr>

<tr>
	<td class=reportdata width=500>Release Notes (if any)</td>
	<td>
	<textarea rows="3" name="release_notes" cols="75" class='formtextarea'><?=$release_notes;?></textarea>
	</td>
</tr>

<tr>
	<td align=center colspan=2>
		<input type=submit value="Submit Changes" name="Submit" class=forminputbutton>
	</td>
</tr>
</table>
</form>

<br>



<?
// Detailed Activity Plan
$table="poa_activity_plan";
?>
<table border=1 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#F5F5F5" bgcolor=#F5F5F5>
<tr><td class=reportheader style='text-align:left' colspan=7>&nbsp;Detailed Activity Plan</td></tr>
<tr>
<td class=reportheader style='text-align:center;background-color: #BBBBBB' width=50>Sl. No.</td>
<td class=reportheader style='text-align:center;background-color: #BBBBBB' width=40 colspan=2>Re-order</td>
<td class=reportheader style='text-align:center;background-color: #BBBBBB' >Task</td>
<td class=reportheader style='text-align:center;background-color: #BBBBBB' width=150>Duration</td>
<td class=reportheader style='text-align:center;background-color: #BBBBBB' width=200 colspan=2>Task Owner</td>
</tr>


<form method=POST action='pa_add_task.php?activity_id=<?=$activity_id;?>&table=<?=$table;?>'>

		<td colspan=3 width=90></td>
		<td><input name="task_description" class=forminputtext style="width: 100%"></td>
		<td style='text-align:center'>
				<select size=1 class=formselect name="task_duration">				
				<?
					for($i=0;$i<121;$i=$i+5){
					if ($i<10){$i="0".$i;}
					echo "<option value='$i'>$i</option>";
				}
				?>
		</select><font class=reportdata>&nbsp;mins</font>
		</td>
		<td width=150><input name="task_owner" class=forminputtext style="width: 100%"></td>
		<td><input type=submit value="Add Task" name="Submit" class=forminputbutton></td>
</tr>
</form>
<?

$sql="select record_index,task_description,task_duration,task_owner,item_order";
$sql.=" from $table where activity_id='$activity_id' GROUP BY task_description HAVING COUNT(task_description) = 1 order by item_order";
$result = mysql_query($sql);
$record_count=mysql_num_rows($result);

$i=1;
$prev_record_index="";
while ($row= mysql_fetch_row($result)){
	$record_index		=$row[0];
	$task_description	=$row[1];
	$task_duration		=$row[2];
	$task_owner			=$row[3];
	$item_order			=$row[4];
	
	// Fetch the Next Record_Index
	$sub_sql="select record_index";
	$sub_sql.=" from $table where activity_id='$activity_id' and item_order>'$item_order' GROUP BY task_description HAVING COUNT(task_description) = 1 order by item_order LIMIT 1";		
	$sub_result = mysql_query($sub_sql);
	$sub_row= mysql_fetch_row($sub_result);
	$next_record_index=$sub_row[0];
	
	$reorder_url="reorder_item.php?table=$table&record_index=$record_index&activity_id=$activity_id&prev_record=$prev_record_index&next_record=$next_record_index";
	
?>
	<tr>
		<td class=reportdata style='text-align:center' width=50><?=$i;?></td>
		<? if($i==1){?><td class=reportdata style='text-align:center' width=16>&nbsp;</td><?}else{?>
			<td class=reportdata style='text-align:center'><a href="<?=$reorder_url;?>&action=up"><img border=0 src=../admin/images/up.gif></a></td>
		<?}?>
		<? if($i==$record_count){?><td class=reportdata style='text-align:center' width=16>&nbsp;</td><?}else{?>
			<td class=reportdata style='text-align:center'><a href="<?=$reorder_url;?>&action=down"><img border=0 src=../admin/images/down.gif></a></td>
		<?}?>
		<td class=reportdata><?=$task_description;?></td>
		<td class=reportdata style='text-align:center'><?=$task_duration;?> mins</td>
		<td class=reportdata><?=$task_owner;?></td>
		<td class=reportdata style='text-align:center' width=16><a href=pa_remove_task.php?record_index=<?=$record_index;?>&activity_id=<?=$activity_id;?>&table=<?=$table;?>><img border=0 src=../admin/images/delete.gif></a></td>
	</tr>
<?
$i++;
$prev_record_index=$record_index;

}
?>
</table>
<br>

<?
// Roll Back Plan
$table="poa_rollback_plan";
?>

<table border=1 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#F5F5F5" bgcolor=#F5F5F5>
<tr><td class=reportheader style='text-align:left' colspan=7>&nbsp;Roll-back Plan</td></tr>
<tr>
<td class=reportheader style='text-align:center;background-color: #BBBBBB' width=50>Sl. No.</td>
<td class=reportheader style='text-align:center;background-color: #BBBBBB' width=40 colspan=2>Re-order</td>
<td class=reportheader style='text-align:center;background-color: #BBBBBB' >Task</td>
<td class=reportheader style='text-align:center;background-color: #BBBBBB' width=150>Duration</td>
<td class=reportheader style='text-align:center;background-color: #BBBBBB' width=200 colspan=2>Task Owner</td>
</tr>


<form method=POST action='pa_add_task.php?activity_id=<?=$activity_id;?>&table=<?=$table;?>'>

		<td colspan=3 width=90></td>
		<td><input name="task_description" class=forminputtext style="width: 100%"></td>
		<td style='text-align:center'>
				<select size=1 class=formselect name="task_duration">				
				<?
					for($i=0;$i<121;$i=$i+5){
					if ($i<10){$i="0".$i;}
					echo "<option value='$i'>$i</option>";
				}
				?>
		</select><font class=reportdata>&nbsp;mins</font>
		</td>
		<td width=150><input name="task_owner" class=forminputtext style="width: 100%"></td>
		<td><input type=submit value="Add Task" name="Submit" class=forminputbutton></td>
</tr>
</form>
<?

$sql="select record_index,task_description,task_duration,task_owner,item_order";
$sql.=" from $table where activity_id='$activity_id' GROUP BY task_description HAVING COUNT(task_description) = 1 order by item_order";
$result = mysql_query($sql);
$record_count=mysql_num_rows($result);

$i=1;
$prev_record_index="";
while ($row= mysql_fetch_row($result)){
	$record_index		=$row[0];
	$task_description	=$row[1];
	$task_duration		=$row[2];
	$task_owner			=$row[3];
	$item_order			=$row[4];
	
	// Fetch the Next Record_Index
	$sub_sql="select record_index";
	$sub_sql.=" from $table where activity_id='$activity_id' and item_order>'$item_order' GROUP BY task_description HAVING COUNT(task_description) = 1 order by item_order LIMIT 1";		
	$sub_result = mysql_query($sub_sql);
	$sub_row= mysql_fetch_row($sub_result);
	$next_record_index=$sub_row[0];
	
	$reorder_url="reorder_item.php?table=$table&record_index=$record_index&activity_id=$activity_id&prev_record=$prev_record_index&next_record=$next_record_index";
	
?>
	<tr>
		<td class=reportdata style='text-align:center' width=50><?=$i;?></td>
		<? if($i==1){?><td class=reportdata style='text-align:center' width=16>&nbsp;</td><?}else{?>
			<td class=reportdata style='text-align:center'><a href="<?=$reorder_url;?>&action=up"><img border=0 src=../admin/images/up.gif></a></td>
		<?}?>
		<? if($i==$record_count){?><td class=reportdata style='text-align:center' width=16>&nbsp;</td><?}else{?>
			<td class=reportdata style='text-align:center'><a href="<?=$reorder_url;?>&action=down"><img border=0 src=../admin/images/down.gif></a></td>
		<?}?>
		<td class=reportdata><?=$task_description;?></td>
		<td class=reportdata style='text-align:center'><?=$task_duration;?> mins</td>
		<td class=reportdata><?=$task_owner;?></td>
		<td class=reportdata style='text-align:center' width=16><a href=pa_remove_task.php?record_index=<?=$record_index;?>&activity_id=<?=$activity_id;?>&table=<?=$table;?>><img border=0 src=../admin/images/delete.gif></a></td>
	</tr>
<?
$i++;
$prev_record_index=$record_index;

}
?>
</table>
<br>

<?include_once("pa_attachment.php");?>
<br>


<?
// Activity Approval 
$table="poa_approval_history";
?>

<table border=1 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#F5F5F5" bgcolor="#F5F5F5">
<tr><td class=reportheader style='text-align:left' colspan=6>&nbsp;Activity Approval</td></tr>		
<tr>		
		<td class=reportheader width=50 style='background-color: #BBBBBB'>Sl. No.</td>
		<td class=reportheader width=40 colspan=2 style='background-color: #BBBBBB'>Re-order</td>
		<td class=reportheader style='background-color: #BBBBBB'>Approver Name</td>
		<td class=reportheader width=316 colspan=2 style='background-color: #BBBBBB'>Approver E-Mail</td>				
</tr>
<form method=POST action='pa_add_approver.php?activity_id=<?=$activity_id;?>'>
		<td colspan=3></td>
		<td width=500 colspan=3>
		<select size=1 class=formselect name="approver">				
		<?
			$sql="select first_name,last_name,official_email from user_master where account_status='Active' order by first_name";
			$result = mysql_query($sql);
			while ($row= mysql_fetch_row($result)){
				echo "<option value='$row[0] $row[1]||$row[2]'>$row[0] $row[1] - $row[2]</option>";
			}
		?>	
		</select>&nbsp;&nbsp;
		<input type=submit value="Add Approver" name="Submit" class=forminputbutton>
		</form>
		</td>
</tr>

<?
$sql="select record_index,approver_name,approver_email,item_order";
$sql.=" from poa_approval_history where activity_id='$activity_id' and action in ('ADDED') order by item_order";
$result = mysql_query($sql);
$record_count=mysql_num_rows($result);

$i=1;
$prev_record_index="";
while ($row= mysql_fetch_row($result)){
	$record_index		=$row[0];
	$approver_name		=$row[1];
	$approver_email		=$row[2];
	$item_order			=$row[3];
	
	// Fetch the Next Record_Index
	$sub_sql="select record_index";
	$sub_sql.=" from poa_approval_history where activity_id='$activity_id' and item_order>'$item_order' and action in ('ADDED') order by item_order LIMIT 1";		
	$sub_result = mysql_query($sub_sql);
	$sub_row= mysql_fetch_row($sub_result);
	$next_record_index=$sub_row[0];
	
	$reorder_url="reorder_item.php?table=$table&record_index=$record_index&activity_id=$activity_id&prev_record=$prev_record_index&next_record=$next_record_index";
	
?>
	<tr>
		<td class=reportdata style='text-align:center' width=50><?=$i;?></td>
		<? if($i==1){?><td class=reportdata style='text-align:center' width=16>&nbsp;</td><?}else{?>
			<td class=reportdata style='text-align:center'><a href="<?=$reorder_url;?>&action=up"><img border=0 src=../admin/images/up.gif></a></td>
		<?}?>
		<? if($i==$record_count){?><td class=reportdata style='text-align:center'  width=16>&nbsp;</td><?}else{?>
			<td class=reportdata style='text-align:center'><a href="<?=$reorder_url;?>&action=down"><img border=0 src=../admin/images/down.gif></a></td>
		<?}?>
		<td class=reportdata><?=$approver_name;?></td>		
		<td class=reportdata><?=$approver_email;?></td>
		<td class=reportdata style='text-align:center' width=50><a href=pa_remove_approver.php?record_index=<?=$record_index;?>&activity_id=<?=$activity_id;?>><img border=0 src=../admin/images/delete.gif></a></td>
	</tr>
<?
$i++;
$prev_record_index=$record_index;

}
?>
</table>

