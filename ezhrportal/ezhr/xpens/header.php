<?
include_once("../auth.php");
include_once("../include/css/default.css"); 
include("calendar.php");
include("date_to_int.php");
include_once("../include/features.php");
if (!check_feature(15)){feature_error();exit;}
?>
<center>

<table border=0 width=100% height=30 cellspacing=0 cellpadding=3>
<tr>
	<td colspan=8 align=left bgcolor=#A0A0A0><font color=#FFFFFF face=Arial size=2><b>Expense Management <?=$header_name;?></td>
	<td colspan=8 align=right bgcolor=#A0A0A0>
		<a href=dash.php style='text-decoration:none'><font color=#FFFFFF face=Arial size=2><b>Summary</a>
		&nbsp;
		<a href=verification.php style='text-decoration:none'><font color=#FFFFFF face=Arial size=2><b>Pending Verification</a>
		&nbsp;
		<a href=clearance.php style='text-decoration:none'><font color=#FFFFFF face=Arial size=2><b>Pending Clearance</a>
		&nbsp;
		<a href=authorization.php style='text-decoration:none'><font color=#FFFFFF face=Arial size=2><b>Authorization</a>
	</td>
</tr>
</table>
<?
include_once("search.php");
?>
