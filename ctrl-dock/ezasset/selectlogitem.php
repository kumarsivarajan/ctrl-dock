<HEAD><TITLE>Asset change information</TITLE>
<HTML>
<FORM action=viewlog.php method=post>
<select size=1 name=assetid style="font-size: 8pt; font-family: Arial">
<?php
	include("config.php");
	$sql = "select assetid from asset order by assetid";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_row($result)) {
		echo "<option value=$row[0]>$row[0]</option>";
	}
?>
</select>
<INPUT type=submit value=Submit name=B1>
</FORM>
</HTML>