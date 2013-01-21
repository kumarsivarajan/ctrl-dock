<?php 
include("config.php");
if (!check_feature(9)){feature_error();exit;} 

$SELECTED="ADD OFFICE LOCATION";
include("header.php");
?>

<form method=POST action=office_locations_add_2.php>

<table border=0 cellpadding=0 cellspacing=0 width=100% bgcolor=#F7F7F7>
<tr>
	<td class='tdformlabel'><b>&nbsp;Registered Name & Address</font></b></td>
	<td align=right><textarea rows="5" name="address" cols="72" class='formtextarea'></textarea></td>
</tr>
<tr>
	<td class='tdformlabel'><b>&nbsp;Location</font></b></td>
	<td align=right><input name="country" size="70" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>&nbsp;Phone</font></b></td>
	<td align=right><input name="phone" size="70" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>&nbsp;Fax</font></b></td>
	<td align=right><input name="fax" size="70" class='forminputtext'></td>
</tr>
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Save" name="Submit" class='forminputbutton'>
	</td>
</tr>
</form>
</table>
