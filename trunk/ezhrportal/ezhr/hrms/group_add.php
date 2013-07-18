<?php 
include("config.php");
if (!check_feature(17)){feature_error();exit;} 

$group=mysql_real_escape_string($_REQUEST["group"]);
$group_desc=mysql_real_escape_string($_REQUEST["group_desc"]);


if ($group=="" || $group_desc==""){ 
?>
<center>
<form method="POST" action="group_add.php">
<table border=0 cellpadding=3 cellspacing=1 width=600 bgcolor=#F7F7F7>
<tr>
	<td class='tdformlabel'><b>&nbsp;Profile</font></b></td>
	<td align=right><input name="group" size="40" class=forminputtext></td>
</tr>
<tr>
	<td class='tdformlabel'><b>&nbsp;Description</font></b></td>
	<td align=right><input name="group_desc" size="40" class=forminputtext></td>
</tr>
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Save" name="Submit" class=forminputbutton>
	</td>
</tr>
</table>
</form>
</table>

<?php
}else {
  $sql = "select count(*) from ezhr_groups where group_name='$group'";
  $result = mysql_query($sql);
  while ($count = mysql_fetch_row($result)) { 
	if ($count[0] > 0){
		$error=1;
	}
  }
 
  if ($error!=1){
 	  $sql = "insert into ezhr_groups (group_name,group_description) values ('$group','$group_desc')";
	  mysql_query($sql);
		?>
		<center><b><font color="#003366" face="Arial" size=2>The New Profile has been successfully added.</font></b></center>
		<meta http-equiv="Refresh" content="1; URL=groups.php">

		<?php
		$service="";
		$comments="";
  } else {
	?>	
	<b><font color="#003366" size=2 face="Arial"><br>A Profile with this name already exists. Please wait and try again..</font> 
	<meta http-equiv="Refresh" content="2; URL=groups.php">
	<?php
  }
}
?>

