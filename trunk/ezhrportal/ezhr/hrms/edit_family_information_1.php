<?php 
include("config.php"); 
include("calendar.php");

$account=$_REQUEST["account"];
$sql = "select first_name,last_name,account_status from user_master where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$first_name		=$row[0];
$last_name		=$row[1];
$account_status	=$row[2];


$member_name=$_REQUEST["member_name"];

$sql = "select * from user_family_member where username='$account' and member_name='$member_name'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

?>
<center>
<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr>
	<td align=left>
		<b><font face="Arial" color="#CC0000" size="2">Edit Family Information for : <?=$first_name?> <?=$last_name;?> Member : <?=$member_name;?> 
	</td>
	<td align=right>
		<a href="user_home.php?account=<?=$account?>"><font face="Arial" color="#336699" size="1"><b>BACK</b></font></a>
	</td>
</tr>
</table>
<br>
<form method=POST action=edit_family_information_2.php>
<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr>
	<td class=tdformlabel>Name</td>
	<td align=right><input name="member_name"  value="<? echo $row[1]; ?>" size="40" style="font-size: 8pt; font-family: Arial"></td>
</tr>

<tr>
	<td class=tdformlabel>Relationship</td>
	<td align=right><input name="relationship" value="<? echo $row[3]; ?>" size="40" style="font-size: 8pt; font-family: Arial"></td>
</tr>

<tr>
	<td><font color=#4D4D4D  face=Verdana size=1><b>Date of Birth</font></b></td>
	<?
		if ($row[2]!="" && strpos($row[2],"-")>0){ 
			$dob=$row[2];
		} else { 
			$dob=date("d-m-Y",$row[2]);			
		}
	?>
	<td  align=right><input value="<? echo $dob; ?>" style="font-size: 8pt; font-family: Arial; width: 75px;" name=member_date_of_birth id="member_date_of_birth" readonly onclick="fPopCalendar('member_date_of_birth')"></td>
</tr>


<tr>
	<td class=tdformlabel>Blood Group</font></b></td>
	<td align=right><input name="member_blood_group" value="<? echo $row[4]; ?>" size="6" style="font-size: 8pt; font-family: Arial"></td>
</tr>


<tr>
	<td class=tdformlabel>Dependent</font></b></td>
        <td align=right>
                <select size=1 name=dependent style="font-size: 8pt; font-family: Arial">
                       echo "<option value="<? echo $row[6]; ?>"><? echo $row[6]; ?></option>";
                        <?php
 
                                echo "<option value='Yes'>Yes</option>";
                                echo "<option value='No'>No</option>";
                        ?>
                </select>
        </td>
</tr>
<tr>
	<td class=tdformlabel>Comments</font></b></td>
	<td align=right><textarea rows="3" name="comments" cols="42" style="font-size: 8pt; font-family: Arial"><? echo $row[5]; ?></textarea></td>
</tr>

<input name="account" size=40 type=hidden value="<? echo $account; ?>">
<input name="old_member_name" size=40 type=hidden value="<? echo $member_name; ?>">

<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Update Family Member" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>
