<?php 
include("config.php"); 
$SELECTED="ADD HOST";
include("header.php");


$hostname=mysql_real_escape_string($_REQUEST["hostname"]);
$description=mysql_real_escape_string($_REQUEST["description"]);
$platform=$_REQUEST["platform"];
$status=$_REQUEST["status"];


if ($hostname==""){ 

?>


<form method=POST action=add_host.php>

<table border=0 cellpadding=1 cellspacing=1 width=100% bgcolor=#F7F7F7>

<tr>
	<td class='tdformlabel'><b>Description</font></b></td>
	<td align=right><input name="description" size="40" class='forminputtext'></td>
</tr>

<tr>
	<td class='tdformlabel'><b>Hostname / IP Address</font></b></td>
	<td align=right><input name="hostname" size="40" class='forminputtext'></td>
</tr>
<tr>
<td class='tdformlabel'><b>Platform</font></b></td>
        <td align=right>
                <select size=1 name=platform class='formselect'>
                    <option value='WINDOWS'>WINDOWS</option>
					<option value='LINUX'>LINUX</option>
					<option value='UNIX'>UNIX</option>
					<option value='OTHERS'>OTHERS</option>
                </select>
        </td>
</tr>
<tr>
<td class='tdformlabel'><b>Status</font></b></td>
        <td align=right>
                <select size=1 name=status class='formselect'>
                    <option value='1'>Active</option>
					<option value='0'>Disabled</option>
                </select>
        </td>
</tr>
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Save" name="Submit" class='forminputbutton'>
	</td>
</tr>
</form>
</table>
<?
}else{
  $sql = "select count(*) from hosts_master where hostname='$hostname'";
  $result = mysql_query($sql);
  while ($count = mysql_fetch_row($result)) { 
	if ($count[0] > 0){
		$error=1;
	}
  }
   if ($error!=1){
 	$sql = "INSERT INTO hosts_master (hostname,status,platform,description) VALUES ('$hostname','$status','$platform','$description')";
	mysql_query($sql);
?>
		<center><i><b><font color="#003366" face="Arial" size=2>The Host has been successfully added.</font></b></i></center>
		<meta http-equiv="Refresh" content="1; URL=index.php">
<?
	}else{
?>
	<b><font color="#003366" size=2 face="Arial"><br>The Host already exists.</font> 
<?
  }
}
?>