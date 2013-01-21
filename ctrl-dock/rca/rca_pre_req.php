<?php 
include_once("config.php");

//if (!check_feature(22)){feature_error();exit;}

$activity_id	=$_REQUEST["activity_id"];
$email			=$_REQUEST["email"];

?>
<center>
<form method=POST action='rca_req.php?activity_id=<?=$activity_id;?>&email=<?=$email?>'>
<table border=1 width=1000 cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#CCCCFF>
<tr>
	<td align=center>
		<input type=submit value="RESEND LAST APPROVAL REQUEST" name="Submit" class=forminputtext>
		<input id="btCancel" onclick="Javascript:history.back();" type="button" value="Cancel" name="btCancel" class=forminputtext>
	</td>
</tr>
</table>
</form>
<?include_once("rca_view.php");?>
