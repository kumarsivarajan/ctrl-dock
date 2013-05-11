<?php 
include_once("config.php");
if (!check_feature(48)){feature_error();exit;}

$activity_id	=$_REQUEST["activity_id"];

$sql="select a.project,a.action_by,a.action_date from rca_master a where a.activity_id='$activity_id'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$project=$row[0];
$sub_sql="select first_name,last_name from user_master where username='$row[1]'";
$sub_result = mysql_query($sub_sql);
$sub_row = mysql_fetch_row($sub_result);
$action_by=$sub_row[0]." ".$sub_row[1];

$action_date="";
if(strlen($row[2])>0){
	$action_date	=date("d M Y H:i",$row[2]);
}
$sql="select activity_id,open_date,attended_date,closure_date,description,symptoms,impact_analysis,ca_root_cause,ca_reason,ca_action,pa_action,recommendations,observations";
$sql.=" from rca_information where activity_id='$activity_id' order by record_index DESC limit 1";

$result = mysql_query($sql);
$record_count=mysql_num_rows($result);
if($record_count>0){
	while ($row = mysql_fetch_row($result)){
		$activity_id	=$row[0];

		if($row[1]>0){
			$open_date		=date("d-m-Y",$row[1]);
			$open_time_hh	=date("H",$row[1]);
			$open_time_mm	=date("i",$row[1]);
		}
		if($row[2]>0){
			$attended_date		=date("d-m-Y",$row[2]);
			$attended_time_hh	=date("H",$row[2]);
			$attended_time_mm	=date("i",$row[2]);
		}

		if($row[3]>0){
			$closure_date		=date("d-m-Y",$row[3]);
			$closure_time_hh	=date("H",$row[3]);
			$closure_time_mm	=date("i",$row[3]);
		}
		
		$description		=$row[4];

		$symptoms			=$row[5];
		$impact_analysis	=$row[6];		
		$ca_root_cause		=$row[7];
		$ca_reason			=$row[8];
		$ca_action			=$row[9];
		$pa_action			=$row[10];
		$recommendations	=$row[11];
		$observations		=$row[12];
	}
}
?>


<center>
<form method=POST action="rca_edit_2.php?activity_id=<?=$activity_id;?>">
<table border=0 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#F5F5F5>
<tr>
	<td height=40 align=left><b><font face=Arial size=3>&nbsp;ROOT CAUSE ANALYSIS</font></b></td>
	<td align=right><b><font face="Arial" color="#CC0000" size="1"><a href=javascript:history.back()>BACK</a></font></b></td>
</tr>
</table>
<table border=1 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#F5F5F5>
<tr><td class=reportheader style='text-align:left' colspan=2><b>&nbsp;Summary</font></b></td></tr>
<tr>
	<td class=reportdata width=500>Ticket ID</td>
	<td class=reportdata><?=$activity_id;?></td>
</tr>
<tr>
	<td class=reportdata width=500>Description</td>
	<td class=reportdata><input name=project class=forminputtext size=50 value="<?=$project;?>"></td>
</tr>
<tr>
	<td class=reportdata width=500>Submitted By</td>
	<td class=reportdata width=500><?=$action_by;?></td>
</tr>
<tr>
	<td class=reportdata width=500>Submitted On</td>
	<td class=reportdata width=500><?=$action_date;?></td>
</tr>
</table>

<table border=1 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#F5F5F5>
<tr><td colspan=2 class=reportheader style='text-align:left'><b>&nbsp;Activity Information</font></b></td></tr>
<tr>
	<td class=reportdata width=500>Incident Date / Time</td>
	<td>
		<input class=forminputtext name=open_date id="open_date" value="<?=$open_date;?>" style="font-size: 9pt; font-family: Arial; width:165px;" onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF>
		<select size=1 class=formselect name="open_time_hh">
		<option value='<?=$open_time_hh;?>'><?=$open_time_hh;?></option>
			<?
					for($i=0;$i<24;$i++){
					if ($i<10){$i="0".$i;}
					echo "<option value='$i'>$i</option>";
				}
			?>
		</select>
		<select size=1 class=formselect name="open_time_mm">
		<option value='<?=$open_time_mm;?>'><?=$open_time_mm;?></option>
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
	<td class=reportdata width=500>Attended Date / Time</td>
	<td>
		<input class=forminputtext name=attended_date id="attended_date" value="<?=$attended_date;?>" style="font-size: 9pt; font-family: Arial; width:165px;" onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF>
		<select size=1 class=formselect name="attended_time_hh">
		<option value='<?=$attended_time_hh;?>'><?=$attended_time_hh;?></option>
			<?
				for($i=0;$i<24;$i++){
					if ($i<10){$i="0".$i;}
					echo "<option value='$i'>$i</option>";
				}
			?>
		</select>
		<select size=1 class=formselect name="attended_time_mm">
		<option value='<?=$attended_time_mm;?>'><?=$attended_time_mm;?></option>
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
	<td class=reportdata width=500>Closure Date / Time</td>
	<td>
		<input class=forminputtext name=closure_date id="closure_date" value="<?=$closure_date;?>" style="font-size: 9pt; font-family: Arial; width:165px;" onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF>
		<select size=1 class=formselect name="closure_time_hh">
		<option value='<?=$closure_time_hh;?>'><?=$closure_time_hh;?></option>
			<?
					for($i=0;$i<24;$i++){
					if ($i<10){$i="0".$i;}
					echo "<option value='$i'>$i</option>";
				}
			?>
		</select>
		<select size=1 class=formselect name="closure_time_mm">
		<option value='<?=$closure_time_mm;?>'><?=$closure_time_mm;?></option>
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
	<td class=reportdata width=500>Description</td>
	<td>
	<textarea rows="3" name="description" cols="85" class='formtextarea'><?=$description;?></textarea>	
	</td>
</tr>
<tr>
	<td class=reportdata width=500>Symptoms Observed</td>
	<td>
	<textarea rows="3" name="symptoms" cols="85" class='formtextarea'><?=$symptoms;?></textarea>
	</td>
</tr>
<tr>
	<td class=reportdata width=500>Impact on systems, services</td>
	<td>
	<textarea rows="3" name="impact_analysis" cols="85" class='formtextarea'><?=$impact_analysis;?></textarea>
	</td>
</tr>
<tr><td colspan=2 class=reportheader style='text-align:left'><b>&nbsp;Root Cause Information</font></b></td></tr>
<tr>
	<td class=reportdata width=500>Analysis</td>
	<td>
	<textarea rows="3" name="ca_root_cause" cols="85" class='formtextarea'><?=$ca_root_cause;?></textarea>
	</td>
</tr>
<tr>
	<td class=reportdata width=500>Background Information</td>
	<td>
	<textarea rows="3" name="ca_reason" cols="85" class='formtextarea'><?=$ca_reason;?></textarea>
	</td>
</tr>
<tr>
	<td class=reportdata width=500>Remedial Action</td>
	<td>
	<textarea rows="3" name="ca_action" cols="85" class='formtextarea'><?=$ca_action;?></textarea>
	</td>
</tr>
<tr><td colspan=2 class=reportheader style='text-align:left'><b>&nbsp;Next Steps</font></b></td></tr>
<tr>
	<td class=reportdata width=500>Short Term Preventive Action</td>
	<td>
	<textarea rows="3" name="pa_action" cols="85" class='formtextarea'><?=$pa_action;?></textarea>
	</td>
</tr>
<tr>
	<td class=reportdata width=500>Long Term Recommendations</td>
	<td>
	<textarea rows="3" name="recommendations" cols="85" class='formtextarea'><?=$recommendations;?></textarea>
	</td>
</tr>
<tr>
	<td class=reportdata width=500>Other Observations (if any) </td>
	<td>
	<textarea rows="3" name="observations" cols="85" class='formtextarea'><?=$observations;?></textarea>
	</td>
</tr>
</table>
<br>
<tr>
	<td align=center>
		<input type=submit value="Submit Changes" name="Submit" class=forminputbutton>
	</td>
</tr>
</table>
</form>
<br>
<?
include_once("rca_attachment.php");
?>
<br>
<?
// Activity Approval 
$table="rca_approval_history";
?>
<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor="#E5E5E5">
<tr><td class=reportheader style='text-align:left' colspan=3><b>&nbsp;Review & Approval</font></b></td></tr>		
		<form method=POST action='rca_add_approver.php?activity_id=<?=$activity_id;?>'>
		<tr>
		<td><font class=reportdata>&nbsp;Select Approver </font></td>
		<td>
		<select style='width:300' size=1 class=formselect name="approver">		
		<?
			
			//$sql="select first_name,last_name,official_email from user_master where account_status='Active' and username in ('$approvers') order by first_name";
			$sql="select first_name,last_name,official_email from user_master where account_status='Active' order by first_name";

			$result = mysql_query($sql);
			while ($row= mysql_fetch_row($result)){
				echo "<option value='$row[0] $row[1]||$row[2]'>$row[0] $row[1] - $row[2]</option>";
			}
		?>	
		</select>
		</td>
		<td align=left>
		<input type=submit value="Add" name="Submit" class=forminputbutton></td>
		</form>
		</tr>
</table>

<?if (check_feature(47)){?>
	<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
	<tr>		
			<td class=reportheader width=50><b>Sl. No.</font></b></td>
			<td class=reportheader width=612><b>Approver Name</font></b></td>
			<td class=reportheader width=316 colspan=2><b>Approver E-Mail</font></b></td>				
	</tr>
	<?

	$sql="select record_index,approver_name,approver_email,item_order";
	$sql.=" from rca_approval_history where activity_id='$activity_id' and action in ('ADDED','DELETED','REJECTED') GROUP BY approver_email HAVING COUNT(approver_email) = 1 order by item_order";
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
		$sub_sql.=" from rca_approval_history where activity_id='$activity_id' and item_order>'$item_order' and action in ('ADDED','DELETED','REJECTED') GROUP BY approver_email HAVING COUNT(approver_email) = 1 order by item_order LIMIT 1";		
		$sub_result = mysql_query($sub_sql);
		$sub_row= mysql_fetch_row($sub_result);
		$next_record_index=$sub_row[0];
		
		$reorder_url="reorder_item.php?table=$table&record_index=$record_index&activity_id=$activity_id&prev_record=$prev_record_index&next_record=$next_record_index";
		
	?>
		<tr>
			<td class=reportdata style='text-align:center'><?=$i;?></td>
			<td class=reportdata><?=$approver_name;?></td>		
			<td class=reportdata><?=$approver_email;?></td>
			<td class=reportdata style='text-align:center' width=16><a href=rca_remove_approver.php?record_index=<?=$record_index;?>&activity_id=<?=$activity_id;?>><img border=0 src=../admin/images/delete.gif></a></td>
		</tr>
	<?
	$i++;
	$prev_record_index=$record_index;
	}
}
?>
</table>

