<?php 
include("config.php"); 
if (!check_feature(18)){feature_error();exit;}
$account=$_REQUEST["account"];

$sql = "select first_name,last_name,account_status from user_master where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$first_name		=$row[0];
$last_name		=$row[1];
$account_status	=$row[2];
?>

<center>
<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr>
	<td align=left>
		<b><font face="Arial" color="#CC0000" size="2">Vehicle / License Information for : <?=$first_name?> <?=$last_name;?></font></b>
	</td>
	<td align=right>
		<a href="user_home.php?account=<?=$account?>"><font face="Arial" color="#336699" size="1"><b>BACK</b></font></a>
	</td>
</tr>
</table>
<br>

<table border=0 width=100% cellspacing=0 cellpadding=3 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
<td bgcolor=#EBEBE0 valign=top align=center>

<table border=1 width=100% cellspacing=0 cellpadding=3 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
		<td class=reportheader>Vehicle Type</font></b></td>
		<td class=reportheader>Vehicle Make</font></b></td>
		<td colspan=2 class=reportheader>Vehicle No.</font></b></td>

</tr>
<?php
$sql = "select * from user_vehicle where username='$account'";
$result = mysql_query($sql);
$i=1;
$row_color="#FFFFFF";
while ($row = mysql_fetch_row($result)){
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
?>
	<tr bgcolor=<?echo $row_color; ?>>
		<td class=reportdata><? echo $row[1]; ?></font></td>
		<td class=reportdata><? echo $row[2]; ?></font></td>
		<td class=reportdata><? echo $row[3]; ?></font></td>
		<td class=reportdata width=20><a href="delete_vehicle.php?account=<? echo $account; ?>&vehicle_no=<? echo $row[3]; ?>"><img border=0 src="images/delete.gif"></a></font></td>
	</tr>
	<?	
	$i++;
 }
  
  
?>
</table>
<br>
<?
include("add_vehicle_information_1.php"); 
?>
</td>
<td bgcolor=#EBEBE0 valign=top align=center>
<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
		<td class=reportheader>License No</font></b></td>
		<td class=reportheader>Issue Date</font></b></td>
		<td class=reportheader>Valid Till</font></b></td>
		<td class=reportheader colspan=2>Category</font></b></td>
</tr>
<?php
$sql = "select * from user_driving_license where username='$account'";
$result = mysql_query($sql);
$i=1;
$row_color="#FFFFFF";
while ($row = mysql_fetch_row($result)){
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
?>
	<tr bgcolor=<?echo $row_color; ?>>
		<td class=reportdata><? echo $row[1]; ?></font></td>
        <td class=reportdata><? if (true==strstr($row[2],'-')){echo $row[2];} else { echo date("d-m-Y",$row[2]);} ?></font></td>
        <td class=reportdata><? if (true==strstr($row[3],'-')){echo $row[3];} else { echo date("d-m-Y",$row[3]);} ?></font></td>
		<td class=reportdata><? echo $row[4]; ?></font></td>
		<td class=reportdata width=20><a href="delete_driving_license.php?account=<? echo $account; ?>&license_no=<? echo $row[1]; ?>"><img border=0 src="images/delete.gif"></a></font></td>
	</tr>
	<?	
	$i++;
 }
  
  
?>
</table>
<br>
<?
include("add_driving_license_1.php"); 
?>

</td>
</tr>
</table>
