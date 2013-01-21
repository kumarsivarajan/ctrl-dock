<?php 
include("config.php"); 
if (!check_feature(8)){feature_error();exit;} 

$SELECTED="OFFICE LOCATIONS";
include("../admin/header.php");

$office_index=$_REQUEST["office_index"]; if (strlen($office_index)==0){$office_index="%";}
$country = $_REQUEST['country']; if (strlen($country)==0){$country="%";}

?>
<table class="reporttable" width=100%>
<tr>
	<?if (check_feature(9)){?>
	<td colspan=7 align=right>
		<a style="text-decoration: none" href="office_locations_add_1.php">
		<font color="#99CC33" face="Arial" size="2"><b>Add a Location</font></a>
	</td>
	<?}?>
</tr>
<tr>
	<td class="reportheader" width=40>ID</td>
	<td class="reportheader">Address</td>
	<td class="reportheader" width=150>Location</td>
	<td class="reportheader" width=150>Phone</td>
	<td class="reportheader" width=150>Fax</td>
	<?if (check_feature(10)){?>
	<td class="reportheader" width=40>Edit</td>
	<?}?>
	<?if (check_feature(11)){?>
	<td class="reportheader" width=40>Delete</td>
	<?}?>
</tr>
<?php


$sql = "select * from office_locations";
$sql = $sql . " where country like '$country' and office_index like '$office_index'";
$sql = $sql . " order by office_index";

$result = mysql_query($sql);
$i=1;
$row_color="#FFFFFF";
while ($row = mysql_fetch_row($result)){
if($row[5] != 0){
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
?>
	<tr bgcolor=<?echo $row_color; ?>>
		<td class='reportdata' style='text-align: center;'><? echo $row[0]; ?></td>
		<td class='reportdata' ><? echo nl2br($row[1]); ?></td>
		<td class='reportdata' ><? echo "$row[2]"; ?></td>
		<td class='reportdata' ><? echo "$row[3]"; ?></td>
		<td class='reportdata' ><? echo "$row[4]"; ?></td>
		<?if (check_feature(10)){?>
		<td class='reportdata' style='text-align: center;'><a href="office_locations_edit_1.php?office_index=<? echo $row[0]; ?>"><img border=0 src="images/edit.gif"></a></td>		
<!-- Confirmation Javascript added -->
		<?}?>
		<?if (check_feature(11)){?>
		<td class='reportdata' width=5% style='text-align: center;'><a href="office_locations_del.php?office_index=<? echo $row[0]; ?>" onclick="return confirm('Are you sure you want to delete?')"><img border=0 src="images/delete.gif"></a></td>
		<?}?>
		</tr>
	<?	
	$i++;
 }
 }
?>
<tr><td></td></tr>

<!-- show Hidden Files link added -->
<tr>
	<td colspan=7 align=right style="background:#EAEAEA;padding-right:5px;">
		<a style="text-decoration: none" href="hidden_offices.php">
		<font color="#CC0000"><span style="font-size:11px; font-weight:bold; font-family:Arial;">Show Hidden Offices</font></a>
	</td>
</tr>
</table>
</body>
</html>
