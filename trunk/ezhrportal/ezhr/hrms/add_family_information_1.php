<?php 
include("config.php"); 
include("calendar.php"); 

$account=$_REQUEST["account"];

$sql = "select * from user_master where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
if ($row[14]=="Obsolete"){
	echo "<center><font face=Arial size=2 color=#003366>The account <b>$row[0]</b> is obsolete.<br><br>Obsolete accounts cannot be updated";
} else {

?>

<form method=POST action=add_family_information_2.php>

<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Add a Family Member</b></td></tr>
<tr>
	<td class=tdformlabel>Name</td>
	<td align=right><input name="member_name"  size="40" style="font-size: 8pt; font-family: Arial"></td>
</tr>

<tr>
	<td class=tdformlabel>Relationship</td>
	<td align=right><input name="relationship"  size="40" style="font-size: 8pt; font-family: Arial"></td>
</tr>

<tr>
	<td class=tdformlabel>Date of Birth</td>
	<td  align=right><input style="font-size: 8pt; font-family: Arial; width: 75px;" name=member_date_of_birth id="member_date_of_birth" onclick="fPopCalendar('member_date_of_birth')"></td>
</tr>


<tr>
	<td class=tdformlabel>Blood Group</td>
	<td align=right><input name="member_blood_group"  size="6" style="font-size: 8pt; font-family: Arial"></td>
</tr>


<tr>
	<td class=tdformlabel>Dependent</td>
        <td align=right>
                <select size=1 name=dependent style="font-size: 8pt; font-family: Arial">
                        <?php
 
                                echo "<option value='Yes'>Yes</option>";
                                echo "<option value='No'>No</option>";
                        ?>
                </select>
        </td>
</tr>
<tr>
	<td class=tdformlabel>Comments</td>
	<td align=right><textarea rows="3" name="comments" cols="42" style="font-size: 8pt; font-family: Arial"></textarea></td>
</tr>

<input name="account" size=40 type=hidden value="<? echo $account; ?>">

<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Add Family Member" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>
<? } ?>
