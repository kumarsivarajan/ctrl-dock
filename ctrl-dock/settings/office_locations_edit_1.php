<?php 
include("config.php"); 
if (!check_feature(10)){feature_error();exit;} 

$office_index=$_REQUEST["office_index"];

$sql = "select * from office_locations where office_index='$office_index'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$SELECTED="EDIT OFFICE LOCATION : ".$office_index; 
include("header.php");
?>


<form method=POST action=office_locations_edit_2.php>

<table border=0 cellpadding=0 cellspacing=0 width=100% bgcolor=#F7F7F7>
<tr>
	<td class='tdformlabel'><b>&nbsp;Registered Name and Address</font></b></td>
	<td align=right><textarea rows="3" name="address" cols="72" class='formtextarea'><? echo $row[1]; ?></textarea></td>
</tr>
<tr>
	<td class='tdformlabel'><b>&nbsp;Location</font></b></td>
	<td align=right><input name="country" value="<? echo htmlentities($row[2]); ?>" size="70" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>&nbsp;Phone</font></b></td>
	<td align=right><input name="phone" value="<? echo $row[3]; ?>" size="70" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>&nbsp;Fax</font></b></td>
	<td align=right><input name="fax" value="<? echo $row[4]; ?>" size="70" class='forminputtext'></td>
</tr>

<!-- Show Hide Option added -->
<tr>
	<td class='tdformlabel'><b>&nbsp;Show / Hide</font></b></td>
	<td align=right><select name="showhide" style="width:123px; font-size:12px; border:1px solid #DFDFDF; margin:2px;"><option value="1" <?php if($row[5]==1){echo "selected";}?>>Show</option><option value="0" <?php if($row[5]==0){echo "selected";}?>>Hide</option></select></td>
</tr>

<td><input name="office_index" type=hidden value="<? echo $row[0]; ?>" size="40"></td>

<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Save Changes" name="Submit" class='forminputbutton'>
	</td>
</tr>
</form>
</table>
