<?php
include("config.php");
if (!check_feature(27)){feature_error();exit;} 


$SELECTED="ESCALATIONS";
include("header.php");
?>

<p style="text-align:left"><font face=Arial size=2>Define the number of hours from the time of logging / opening the ticket, with-in which the issue should be resolved / closed. The due date will be updated accordingly at each level, and a notification will be sent out to the individuals in the email list defined here.</font></p>
<?
	$sql	= "select * from escalation_email";
	$result = mysql_query($sql);
	$row 	= mysql_fetch_row($result);
	$email	= $row[0];
?>
<form method=POST action=escalations_2.php>
<table border=0 cellpadding=1 cellspacing=1 width=100% bgcolor=#F7F7F7>
<tr>	
	<td class='tdformlabel' width=350>&nbsp;SEND ESCALATION EMAILS TO (comma separated)</td>
	<td align=right><input name="email" size="80" class='forminputtext' value=<?=$email;?>></td>
	<td align=center colspan=7><input type=submit value="Save" name="Submit" class='forminputbutton'></td>
</table>
</form>
<br>

<form method=POST action=escalations_2.php?ticket_type_id=3>
<table border=0 cellpadding=1 cellspacing=1 width=100% bgcolor=#F7F7F7>
<tr>	
	<td class="reportheader" width=150 colspan=2>&nbsp;CHANGE REQUEST</td>
	<td class="reportheader" width=100>EMRG</td>
	<td class="reportheader" width=100>HIGH</td>
	<td class="reportheader" width=100>NORMAL</td>
	<td class="reportheader" width=100>LOW</td>	
	<td class="reportheader" width=100>EXCP</td>	
	</tr>
<tr>
<?
	$sql	= "select emergency,high,medium,low,exception from escalations where esc_id='1' and ticket_type_id='3'";
	$result = mysql_query($sql);
	$row 	= mysql_fetch_row($result);
?>
	<td bgcolor=#FFD800 width=10px></td>
	<td align=center class=reportdata>&nbsp;<b>Escalation 1</td>
	<td align=center><input name="emg_1" size="3" class=forminputtext value='<?echo $row[0];?>'></td>
	<td align=center><input name="hgh_1" size="3" class=forminputtext value='<?echo $row[1];?>' ></td>
	<td align=center><input name="med_1" size="3" class=forminputtext value='<?echo $row[2];?>' ></td>
	<td align=center><input name="low_1" size="3" class=forminputtext value='<?echo $row[3];?>' ></td>
	<td align=center><input name="exc_1" size="3" class=forminputtext value='<?echo $row[4];?>' ></td>
</tr>


<tr>
<?
	$sql	= "select emergency,high,medium,low,exception from escalations where esc_id='2'  and ticket_type_id='3'";
	$result = mysql_query($sql);
	$row 	= mysql_fetch_row($result);
?>
	<td bgcolor=#FF6A00 width=10px></td>
	<td align=center class=reportdata>&nbsp;<b>Escalation 2</td>
	<td align=center><input name="emg_2" size="3" class=forminputtext value='<?echo $row[0];?>'></td>
	<td align=center><input name="hgh_2" size="3" class=forminputtext value='<?echo $row[1];?>' ></td>
	<td align=center><input name="med_2" size="3" class=forminputtext value='<?echo $row[2];?>' ></td>
	<td align=center><input name="low_2" size="3" class=forminputtext value='<?echo $row[3];?>' ></td>	
	<td align=center><input name="exc_2" size="3" class=forminputtext value='<?echo $row[4];?>' ></td>
</tr>




<tr>
<?
	$sql	= "select emergency,high,medium,low,exception from escalations where esc_id='3'  and ticket_type_id='3'";
	$result = mysql_query($sql);
	$row 	= mysql_fetch_row($result);
?>
	<td bgcolor=#FF0000 width=10px></td>
	<td align=center class=reportdata >&nbsp;<b>Escalation 3</td>
	<td align=center ><input name="emg_3" size="3" class=forminputtext value='<?echo $row[0];?>'></td>
	<td align=center ><input name="hgh_3" size="3" class=forminputtext value='<?echo $row[1];?>' ></td>
	<td align=center ><input name="med_3" size="3" class=forminputtext value='<?echo $row[2];?>' ></td>
	<td align=center ><input name="low_3" size="3" class=forminputtext value='<?echo $row[3];?>' ></td>	
	<td align=center ><input name="exc_3" size="3" class=forminputtext value='<?echo $row[4];?>' ></td>	
	</tr>

<td align=center colspan=7><input type=submit value="Save Escalation Settings" name="Submit" class='forminputbutton'></td>
</form>
</tr>
</table>



<br>




<form method=POST action=escalations_2.php?ticket_type_id=4>
<table border=0 cellpadding=1 cellspacing=1 width=100% bgcolor=#F7F7F7>
<tr>
	<td class="reportheader" width=150 colspan=2>&nbsp;SERVICE REQUEST</td>
	<td class="reportheader" width=100>EMRG</td>
	<td class="reportheader" width=100>HIGH</td>
	<td class="reportheader" width=100>NORMAL</td>
	<td class="reportheader" width=100>LOW</td>	
	<td class="reportheader" width=100>EXCP</td>	
</tr>
<tr>
<?
	$sql	= "select emergency,high,medium,low,exception from escalations where esc_id='1' and ticket_type_id='4'";
	$result = mysql_query($sql);
	$row 	= mysql_fetch_row($result);
?>
	
	<td bgcolor=#FFD800 width=10px></td>
	<td align=center class=reportdata>&nbsp;<b>Escalation 1</td>
	<td align=center><input name="emg_1" size="3" class=forminputtext value='<?echo $row[0];?>'></td>
	<td align=center><input name="hgh_1" size="3" class=forminputtext value='<?echo $row[1];?>' ></td>
	<td align=center><input name="med_1" size="3" class=forminputtext value='<?echo $row[2];?>' ></td>
	<td align=center><input name="low_1" size="3" class=forminputtext value='<?echo $row[3];?>' ></td>
	<td align=center><input name="exc_1" size="3" class=forminputtext value='<?echo $row[4];?>' ></td>
</tr>


<tr>
<?
	$sql	= "select emergency,high,medium,low,exception from escalations where esc_id='2'  and ticket_type_id='4'";
	$result = mysql_query($sql);
	$row 	= mysql_fetch_row($result);
?>
	<td bgcolor=#FF6A00 width=10px></td>
	<td align=center class=reportdata>&nbsp;<b>Escalation 2</td>
	<td align=center><input name="emg_2" size="3" class=forminputtext value='<?echo $row[0];?>'></td>
	<td align=center><input name="hgh_2" size="3" class=forminputtext value='<?echo $row[1];?>' ></td>
	<td align=center><input name="med_2" size="3" class=forminputtext value='<?echo $row[2];?>' ></td>
	<td align=center><input name="low_2" size="3" class=forminputtext value='<?echo $row[3];?>' ></td>	
	<td align=center><input name="exc_2" size="3" class=forminputtext value='<?echo $row[4];?>' ></td>

</tr>




<tr>
<?
	$sql	= "select emergency,high,medium,low,exception from escalations where esc_id='3'  and ticket_type_id='4'";
	$result = mysql_query($sql);
	$row 	= mysql_fetch_row($result);
?>
	<td bgcolor=#FF0000 width=10px></td>
	<td align=center class=reportdata >&nbsp;<b>Escalation 3</td>
	<td align=center ><input name="emg_3" size="3" class=forminputtext value='<?echo $row[0];?>'></td>
	<td align=center ><input name="hgh_3" size="3" class=forminputtext value='<?echo $row[1];?>' ></td>
	<td align=center ><input name="med_3" size="3" class=forminputtext value='<?echo $row[2];?>' ></td>
	<td align=center ><input name="low_3" size="3" class=forminputtext value='<?echo $row[3];?>' ></td>	
	<td align=center ><input name="exc_3" size="3" class=forminputtext value='<?echo $row[4];?>' ></td>	

</tr>
<td align=center colspan=7><input type=submit value="Save Escalation Settings" name="Submit" class='forminputbutton'></td>
</form>
</tr>
</table>


<br>
<form method=POST action=escalations_2.php?ticket_type_id=1>
<table border=0 cellpadding=1 cellspacing=1 width=100% bgcolor=#F7F7F7>
<tr>
	<td class="reportheader" width=150 colspan=2>FAULTS / INCIDENTS</td>
	<td class="reportheader" width=100>EMRG</td>
	<td class="reportheader" width=100>HIGH</td>
	<td class="reportheader" width=100>NORMAL</td>
	<td class="reportheader" width=100>LOW</td>	
	<td class="reportheader" width=100>EXCP</td>	
</tr>
<tr>
<?
	$sql	= "select emergency,high,medium,low,exception from escalations where esc_id='1' and ticket_type_id='1'";	
	$result = mysql_query($sql);
	$row 	= mysql_fetch_row($result);
?>
	<td bgcolor=#FFD800 width=10px></td>
	<td align=center class=reportdata>&nbsp;<b>Escalation 1</td>
	<td align=center><input name="emg_1" size="3" class=forminputtext value='<?echo $row[0];?>'></td>
	<td align=center><input name="hgh_1" size="3" class=forminputtext value='<?echo $row[1];?>' ></td>
	<td align=center><input name="med_1" size="3" class=forminputtext value='<?echo $row[2];?>' ></td>
	<td align=center><input name="low_1" size="3" class=forminputtext value='<?echo $row[3];?>' ></td>
	<td align=center><input name="exc_1" size="3" class=forminputtext value='<?echo $row[4];?>' ></td>

	</tr>


<tr>
<?
	$sql	= "select emergency,high,medium,low,exception from escalations where esc_id='2'  and ticket_type_id='1'";
	$result = mysql_query($sql);
	$row 	= mysql_fetch_row($result);
?>
	<td bgcolor=#FF6A00 width=10px></td>
	<td align=center class=reportdata>&nbsp;<b>Escalation 2</td>
	<td align=center><input name="emg_2" size="3" class=forminputtext value='<?echo $row[0];?>'></td>
	<td align=center><input name="hgh_2" size="3" class=forminputtext value='<?echo $row[1];?>' ></td>
	<td align=center><input name="med_2" size="3" class=forminputtext value='<?echo $row[2];?>' ></td>
	<td align=center><input name="low_2" size="3" class=forminputtext value='<?echo $row[3];?>' ></td>
	<td align=center><input name="exc_2" size="3" class=forminputtext value='<?echo $row[4];?>' ></td>

	</tr>




<tr>
<?
	$sql	= "select emergency,high,medium,low,exception from escalations where esc_id='3'  and ticket_type_id='1'";
	$result = mysql_query($sql);
	$row 	= mysql_fetch_row($result);
?>
	<td bgcolor=#FF0000 width=10px></td>
	<td class=reportdata >&nbsp;<b>Escalation 3</td>
	<td align=center ><input name="emg_3" size="3" class=forminputtext value='<?echo $row[0];?>'></td>
	<td align=center ><input name="hgh_3" size="3" class=forminputtext value='<?echo $row[1];?>' ></td>
	<td align=center ><input name="med_3" size="3" class=forminputtext value='<?echo $row[2];?>' ></td>
	<td align=center ><input name="low_3" size="3" class=forminputtext value='<?echo $row[3];?>' ></td>
	<td align=center ><input name="exc_3" size="3" class=forminputtext value='<?echo $row[4];?>' ></td>

	</tr>


<td align=center colspan=7><input type=submit value="Save Escalation Settings" name="Submit" class='forminputbutton'></td>
</form>
</tr>
</table>


