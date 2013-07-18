<?include("config.php"); ?>
<?$ACTION=" : Submit Expense Report"?>
<?include("ezq_expense_header.php"); ?>
<?
	$expense_id=$_REQUEST["expense_id"];	
	$action=$_REQUEST["action"];	
?>
<br><br>
<center>

<form method=POST action=expense_action_2.php>
<input type=hidden name=expense_id value='<?echo $expense_id;?>'>
<input type=hidden name=action value='<?echo $action;?>'>
<table border=0 cellpadding=4 cellspacing=0 width=98% bgcolor=#EEEEEE>
<tr>
	<td colspan=2 align=center><font color=#4D4D4D face=Arial size=2><b>This request is being <? echo $action;?></font></b></td>
</tr>
<tr>	
	<td align=center><textarea rows="3" name="action_comments" cols="100" class=formtextarea></textarea></td>
</tr>
<tr>	
	<td bgcolor=#BBBBBB colspan=2 align=center><input type="submit" value="Submit" class='forminputbutton' style='width:400px'/>&nbsp;</td>	
</tr>


</tr>
</table>
</form>
<?include("expense_summary.php"); ?>
