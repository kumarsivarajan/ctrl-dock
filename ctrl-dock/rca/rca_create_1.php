<?
include_once("config.php");
if (!check_feature(47)){feature_error();exit;}

$ticket_id=$_REQUEST["ticket_id"];
?>
<form method=POST action=rca_create_2.php?ticket_id=<?=$ticket_id;?>>
<table border=0 cellpadding=5 cellspacing=0 width=100% bgcolor=#EEEEEE>
<tr>
	<td class=reportdata>Provide a descriptive name to identify this RCA internally
	<br><br>
	<input name="project" size="50" class=forminputtext>
	<br><br>
	<input type=submit value="Create new RCA" name="Submit" class=forminputbutton>
	&nbsp;
	<input type="button" value="Cancel" onclick="window.close()" class=forminputbutton>
	</td>
</tr>
</table>
</form>