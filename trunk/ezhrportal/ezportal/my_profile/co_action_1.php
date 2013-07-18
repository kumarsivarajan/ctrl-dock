<?

include("config.php");

$action=$_REQUEST['action'];
$no=$_REQUEST['no'];
$staff=$_REQUEST['staff'];
$approval_date=mktime();
$action=$_REQUEST['action'];
if ($action==1){$status="Approved";}
if ($action==2){$status="Rejected";}

?>

<center>
<br>
<b><font face="Arial" color="#FF6600" size="2">Compensatory Off Credit Application for : <?echo $staff;?> </font></b>
<br><br><br>
<form method=POST action=co_action_2.php>
<input type=hidden name=action value='<?echo $action;?>'>
<input type=hidden name=no value='<?echo $no;?>'>
<input type=hidden name=staff value='<?echo $staff;?>'>

<table border=0 cellpadding=0 cellspacing=0 width=450>
<tr>
	<td colspan=2 align=center><font color=#4D4D4D face=Arial size=2><b>This request is being <? echo $status;?></font></b></td>
</tr>
<tr><td bgcolor=white colspan=2><font face=Arial size=2 color=White>&nbsp;</td></tr>
<tr>
	<td><font color=#4D4D4D face=Arial size=2><b>Comments</font></b></td>
	<td align=right><textarea rows="3" name="comments" cols="42" style="font-size: 8pt; font-family: Arial"></textarea></td>
</tr>
<tr><td bgcolor=white colspan=2><font face=Arial size=2 color=White>&nbsp;</td></tr>
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Submit" name="Submit" class=forminputbutton>
	</td>
</tr>
</form>
</table>