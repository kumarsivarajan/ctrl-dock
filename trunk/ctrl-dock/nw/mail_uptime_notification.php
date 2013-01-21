<?
/******************************************************************************************
Auth: Aneesh
Cre Date: 18/05/2012
Function: Display a link to add Emails, if alreay emails are there in database display them 
******************************************************************************************/
include("config.php");
if (!check_feature(16)){
	feature_error();
	exit;
}  
$host_id  = $_REQUEST["host_id"];
$hostname =$_REQUEST["hostname"];

$SELECTED="HOST UP E-MAIL NOTIFICATION : ".$hostname;
include("header.php");

?>
<table class="reporttable" width=1000>
<tr>
	<td colspan=7 align=right>
		<a style="text-decoration: none" href="email_add_sysup.php?host_id=<?php echo $host_id?>&hostname=<?=$hostname;?>">
		<font color="#99CC33" face="Arial" size="2"><b>Add Email</font></a>
	</td>
</tr>
<?php
$select_query = sprintf("SELECT * 
			 FROM sys_uptime_email
			 WHERE host_id=%d",$host_id);

$result = mysql_query($select_query);
$row_count=mysql_num_rows($result);
if($row_count>0){
?>
<tr>
	<td class="reportheader" width=40>Sl. No.</td>
	<td class="reportheader">Email</td>
	<td class="reportheader" width=110>Status</td>
	<td class="reportheader" width=40>Edit</td>
	<td class="reportheader" width=40>Delete</td>
</tr>
<?
}
while ($row = mysql_fetch_row($result)){
	$id	 =$row[0];
	$email =$row[1];
	$status=$row[3];
?>
	<tr bgcolor=#EDEDE4>
		<td class='reportdata' style='text-align:center;'><? echo $id; ?></td>
		<td class='reportdata'><? echo $email; ?></td>
		<td class='reportdata' width=110>&nbsp;<? echo ucfirst($status); ?></td>
		<td class=reportdata width=40 style='text-align: center;'><a href='email_edit_sysup.php?id=<?echo $row[0];?>'>
		<img src=images/edit.gif border=0></img></a></td>
		<td class=reportdata width=40 style='text-align: center;'><a href='email_delete_sysup.php?id=<?echo $row[0];?>'>
		<img src=images/delete.gif border=0></img></a></td>
	</tr>
<?	
}
?>
</table>
</body>
</html>
