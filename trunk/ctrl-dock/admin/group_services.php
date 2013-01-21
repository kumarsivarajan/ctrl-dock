<?
include("config.php"); 
if (!check_feature(4)){feature_error();exit;} 

$group=$_REQUEST["group"];
$id=$_REQUEST["id"];

$SELECTED="SERVICE PROFILE : ".$group; 
include("header.php");
?>
	
<table class="reporttable" border=0 width=900 cellpadding=0 cellspacing=1> 
	<tr><td align=center valign=top width=300>	
	
	<table border=0 width=300> 
	<tr><td class='reportheader'><b>Available Services</font></b></td></tr>
	<tr>
		<td align=center>
			<form method="POST" action="manage_group_service.php?id=<?echo $id;?>&group=<?echo $group;?>&action=add">
			<select size=10 name=member[] class='formselect' style=' height: 300px;' multiple>
			<?php
			    $sql = "select service,comments from services where service not in (select service from group_service where group_id='$id') order by service";	
				
				$result = mysql_query($sql);
				while ($row = mysql_fetch_row($result)) {
		        		echo "<option value='$row[0]'>$row[0] : $row[1]</option>";
				}
			?>
		</select>
		</td>
	</tr>
	<tr>
	<td align=center>		
		<br><input type=submit value="Add Service(s)" name="Submit"  class='forminputbutton'>
		</form>
	</td>
	</tr>
	</table>
	</td><td align=center valign=top valign=600>
	
<?
	$sql = "select a.service,b.comments from group_service a, services b where a.group_id='$id' and a.service=b.service order by service";	
	$result = mysql_query($sql);	  
	$num_rows=mysql_num_rows($result);
	
	if ($num_rows<=0){
	?>
		<table class="reporttable" width=500>
		<tr>	
		<td class="reportdata" colspan=2>This group has no service enabled.</td>
		</tr>
		</table>
	<?
	}
	if ($num_rows>0){
		?>
		<table class="reporttable" width=500>
		<tr>	
		<td class="reportheader">Service</td>
		<td class="reportheader">Display Name</td>
		<td class="reportheader">Select</td>
		</tr>
		
		<form method="POST" action="manage_group_service.php?id=<?echo $id;?>&group=<?echo $group;?>&action=del">
		<?
			while ($row = mysql_fetch_row($result)){
				echo "<tr>";			
				echo "<td class=reportdata >$row[0]</td>";
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