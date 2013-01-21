<?
include("config.php"); 
if (!check_feature(43)){feature_error();exit;} 

$group=$_REQUEST["group"];
$id=$_REQUEST["id"];

$SELECTED="PROFILE MEMBERS : ".$group; 
include("header.php");

?>
	
	<table class="reporttable" border=0 width=100% cellpadding=0 cellspacing=1> 
	<tr><td align=center valign=top width=300>	
	
	<table border=0 width=300> 
	<tr><td class='reportheader'><b>Available Users</font></b></td></tr>
	<tr>
		<td align=center>
			<form method="POST" action="manage_profile_member.php?id=<?echo $id;?>&group=<?echo $group;?>&action=add">
			<select size=10 name=member[] class='formselect' style=' height: 300px;' multiple>
			<?php
			    $sql = "select username,first_name,last_name from user_master where account_status='Active' and username not in (select username from rim_user_group where group_id='$id') order by username";	
				
				$result = mysql_query($sql);
				while ($row = mysql_fetch_row($result)) {
		        		echo "<option value='$row[0]'>$row[1] $row[2]</option>";
				}
			?>
		</select>
		</td>
	</tr>
	<tr>
	<td align=center>		
		<br><input type=submit value="Add Member(s)" name="Submit"  class='forminputbutton'>
		</form>
	</td>
	</tr>
	</table>
	</td><td align=center valign=top valign=600>
	
<?
	$sql = "select a.username,b.first_name,b.last_name from rim_user_group a, user_master b where a.group_id='$id' and a.username=b.username and b.account_status='Active' order by username";	
	$result = mysql_query($sql);	  
	$num_rows=mysql_num_rows($result);
	
	if ($num_rows<=0){
	?>
		<table class="reporttable" width=500>
		<tr>	
		<td class="reportdata" colspan=2>This profile has no members currently</td>
		</tr>
		</table>
	<?
	}
	if ($num_rows>0){
		?>
		<table class="reporttable" width=500>
		<tr>	
		<td class="reportheader">Name</td>
		<td class="reportheader">Username</td>
		<td class="reportheader">Select</td>
		</tr>
		
		<form method="POST" action="manage_profile_member.php?id=<?echo $id;?>&group=<?echo $group;?>&action=del">
		<?
			while ($row = mysql_fetch_row($result)){
				echo "<tr>";			
				echo "<td class=reportdata >$row[1] $row[2]</td>";
				echo "<td class=reportdata >$row[0]</td>";
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