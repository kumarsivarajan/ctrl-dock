<?
include("config.php"); 
if (!check_feature(43)){feature_error();exit;}

$group=$_REQUEST["group"];
$id=$_REQUEST["id"];

$SELECTED="FEATURE PROFILE : ".$group; 
include("header.php");
?>
	
<table class="reporttable" border=0 width=100% cellpadding=0 cellspacing=1> 
	<tr><td align=center valign=top width=300>	
	
	<table border=0 width=300> 
	<tr><td class='reportheader'><b>Available Features</font></b></td></tr>
	<tr>
		<td align=center>
			<form method="POST" action="manage_profile_feature.php?id=<?echo $id;?>&group=<?echo $group;?>&action=add">
			<select size=10 name=member[] class='formselect' style=' height: 400px; width: 290px;' multiple>
			<?php
			    $sql = "select feature_id,feature_description from rim_feature_master where feature_id not in (select feature_id from rim_group_feature where group_id='$id') order by feature_description";	
				
				$result = mysql_query($sql);
				while ($row = mysql_fetch_row($result)) {
		        		echo "<option value='$row[0]'>$row[1]</option>";
				}
			?>
		</select>
		</td>
	</tr>
	<tr>
	<td align=center>		
		<br><input type=submit value="Add Features(s)" name="Submit"  class='forminputbutton'>
		</form>
	</td>
	</tr>
	</table>
	</td><td align=center valign=top valign=600>
	
<?
	$sql = "select b.feature_id,b.feature_description from rim_group_feature a, rim_feature_master b where a.group_id='$id' and a.feature_id=b.feature_id order by feature_description";	
	$result = mysql_query($sql);	  
	$num_rows=mysql_num_rows($result);
	
	if ($num_rows<=0){
	?>
		<table class="reporttable" width=500>
		<tr>	
		<td class="reportdata" colspan=2>This profile has no feature enabled.</td>
		</tr>
		</table>
	<?
	}
	if ($num_rows>0){
		?>
		<table class="reporttable" width=500>
		<tr>	
		<td class="reportheader">Feature</td>		
		<td class="reportheader">Select</td>
		</tr>
		
		<form method="POST" action="manage_profile_feature.php?id=<?echo $id;?>&group=<?echo $group;?>&action=del">
		<?
			while ($row = mysql_fetch_row($result)){
				echo "<tr>";			
				echo "<td class=reportdata >$row[1]</td>";				
				echo "<td class=reportdata style='text-align:center'><input name=member[] type='checkbox' value='$row[0]'></td>";
				echo "</tr>";		
			}
		?>
		</table>
		<input type=submit value="Remove Selected" name="Submit"  class='forminputbutton'>
		</form>
	<?}?>
</td></tr>
</table>