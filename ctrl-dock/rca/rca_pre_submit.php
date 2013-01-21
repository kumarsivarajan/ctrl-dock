<?php 
include_once("config.php");

$activity_id	=$_REQUEST["activity_id"];
?>
<center>
<form method=POST action='rca_submit.php?activity_id=<?=$activity_id;?>'>
<table border=1 width=100% cellspacing=0 cellpadding=4 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#FFCC00>
<tr>
	<td align=center>
		<input type=submit value="SUBMIT ROOT CAUSE ANALYSIS FOR APPROVAL" name="Submit" class=forminputtext>
		<input id="btCancel" onclick="Javascript:history.back();" type="button" value="Cancel" name="btCancel" class=forminputtext>
	</td>
</tr>
</table>
</form>
<?include_once("rca_view.php");?>
