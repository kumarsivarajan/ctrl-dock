<?php 

include_once("config.php");
include_once("header.php");
?>

<form method=POST action=save_settings.php>
<br>
<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr>
	<td class=tdformlabel>Leave Calendar Start Month (1-Jan,12-Dec)</td>
	<td align=right><input type=text name="lcs" size="5" value='<?=$lc_start;?>' style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Compensatory Leave Validity (in Days)</td>
	<td align=right><input type=text name="clv" size="5" value='<?=$compensatory_leave_validity;?>' style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Leave Credit Threshold</td>
	<td align=right><input type=text name="lct" size="5" value='<?=$lc_threshold;?>' style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Save Settings" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>