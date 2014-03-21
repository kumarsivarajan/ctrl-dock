<?
include("config.php"); 
if (!check_feature(16)){feature_error();exit;}

$SELECTED="SERVICES";
include("header.php");
?>

<table class="reporttable" width=100%>
<tr>
	<td colspan=4 align=right>
		<a style="text-decoration: none" href="add_service.php">
		<font color="#99CC33" face="Arial" size="2"><b>Add Service</font></a>
	</td>
</tr>

<tr>
	<td class="reportheader">Service Name</td>
	<td class="reportheader">Service Description</td>
	<td class="reportheader">Edit</td>
	<td class="reportheader">Delete</td>
</tr>
<?php
$sql = "select * from services order by service";
$result = mysql_query($sql);
$i=1;
$row_color="#FFFFFF";
while ($row = mysql_fetch_row($result)){
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
?>
	<tr bgcolor=<?echo $row_color; ?>>
		<td class='reportdata'><? echo $row[0]; ?></td>
		<td class='reportdata'><? echo $row[1]; ?></td>
		<td class='reportdata' style='text-align: center;'><a href="edit_service_1.php?service=<? echo $row[0]; ?>"><img border=0 src="images/edit.gif"></a></td>
		<td class=reportdata width=40 style='text-align: center;'><a href='service_delete.php?service=<?echo $row[0];?>'><img src=images/delete.gif border=0></img></a></td>
	</tr>
	<?	
	$i++;
 }
  
  
?>
</table>
</body>
</html>
