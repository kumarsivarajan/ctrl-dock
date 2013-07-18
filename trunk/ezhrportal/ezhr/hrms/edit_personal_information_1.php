<?php 
include("config.php"); 
if (!check_feature(2)){feature_error();exit;}
include("calendar.php");

$account=$_REQUEST["account"];

$sql = "select first_name,last_name,account_status,staff_number from user_master where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$first_name		=$row[0];
$last_name		=$row[1];
$account_status	=$row[2];
$staff_number	=$row[3];

$sql = "select policy_id from lm_user_leave_policy where username='$account'";
$result		= mysql_query($sql);
$row	 	= mysql_fetch_row($result);
$policy_id	= $row[0];


$sql = "select * from user_personal_information where username='$account'";
$result		= mysql_query($sql);
$row		= mysql_fetch_row($result);
	
	

?>
<center>
<table border=0 cellpadding=2 cellspacing=0 width=100%>
<tr>
	<td align=left>
		<b><font face="Arial" color="#CC0000" size="2">Edit Personal Information for : <?=$first_name?> <?=$last_name;?></font></b>
	</td>
	<td align=right>
		<a href="user_home.php?account=<?=$account?>"><font face="Arial" color="#336699" size="1"><b>BACK</b></font></a>
	</td>
</tr>
</table>
<br>
<?
if ($account_status=="Obsolete"){
	echo "<br><center><font face=Arial size=2 color=#CC0000><b>The account is obsolete. Obsolete accounts should be updated under authorization only.</font></b>";
}
?>

<form method=POST action=edit_personal_information_2.php>

<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr>
	<td class=tdformlabel>First Name</font></b></td>
	<td align=right><input name="first_name"  value="<? echo $first_name; ?>" size="40" style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Last Name</font></b></td>
	<td align=right><input name="last_name"  value="<? echo $last_name; ?>" size="40" style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Staff Number</font></b></td>
	<td align=right><input name="staff_number"  value="<? echo $staff_number; ?>" size="6" style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Date of Joining</font></b></td>
	<td  align=right><input value="<? if ($row[3]!="") echo date("d-m-Y",$row[3]); ?>" style="font-size: 8pt; font-family: Arial; width: 75px;" name=date_of_joining id="date_of_joining" readonly onclick="fPopCalendar('date_of_joining')"></td>
</tr>
<tr>
	<td class=tdformlabel>Date of Leaving</font></b></td>
	<td  align=right><input value="<? if ($row[11]!="") echo date("d-m-Y",$row[11]); ?>" style="font-size: 8pt; font-family: Arial; width: 75px;" name=date_of_leaving id="date_of_leaving" readonly onclick="fPopCalendar('date_of_leaving')"></td>
</tr>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Policies</b></td></tr>
<tr>
	<td class=tdformlabel>Leave Policy</font></b></td>
	<td align=right>
		<select size=1 name=leave_policy_id style="font-size: 8pt; font-family: Arial">
			<?php	
			        $sub_sql = "select policy_id,policy_desc from lm_policy_master";					
					$sub_result = mysql_query($sub_sql);
					while ($sub_row = mysql_fetch_row($sub_result)) {
						if ($policy_id==$sub_row[0]){$selected="selected";}else{$selected="";}
			       		echo "<option value='$sub_row[0]' $selected>$sub_row[1]</option>";
					}
			?>
		</select>
	</td>
</tr>


<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Personal Information</b></td></tr>
<tr>
	<td class=tdformlabel>Gender</font></b></td>
        <td align=right>
                <select size=1 name=gender style="font-size: 8pt; font-family: Arial">
                        <?php

                                echo "<option value='$row[1]'>$row[1]</option>";
                                echo "<option value='Female'>Female</option>";
                                echo "<option value='Male'>Male</option>";
                         ?>
                </select>
        </td>
</tr>


<tr>
	<td class=tdformlabel>Blood Group</font></b></td>
	<td align=right><input name="blood_group"  value="<? echo $row[4]; ?>" size="6" style="font-size: 8pt; font-family: Arial"></td>
</tr>

<tr>
	<td class=tdformlabel>Date of Birth</font></b></td>
	<td  align=right><input value="<? if ($row[2]!="") echo date("d-m-Y",$row[2]); ?>" style="font-size: 8pt; font-family: Arial; width: 75px;" name=date_of_birth id="date_of_birth" readonly onclick="fPopCalendar('date_of_birth')"></td>
</tr>


<tr>
	<td class=tdformlabel>Married</font></b></td>
        <td align=right>
                <select size=1 name=marital_status style="font-size: 8pt; font-family: Arial">
                        <?php

                                echo "<option value='$row[5]'>$row[5]</option>";
                                echo "<option value='Married'>Married</option>";
                                echo "<option value='Un-Married'>Un-Married</option>";
                        ?>
                </select>
        </td>
</tr>

<tr>
	<td class=tdformlabel>Date of Marriage</font></b></td>
	<td  align=right><input value="<? if ($row[6]!="") echo date("d-m-Y",$row[6]); ?>" style="font-size: 8pt; font-family: Arial; width: 75px;" name=date_of_marriage id="date_of_marriage" readonly onclick="fPopCalendar('date_of_marriage')"></td>
</tr>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Passport Information</b></td></tr>

<tr>
	<td class=tdformlabel>Passport Number</font></b></td>
	<td align=right><input name="passport_number"  value="<? echo $row[7]; ?>" size="42" style="font-size: 8pt; font-family: Arial"></td>
</tr>


<tr>
	<td class=tdformlabel>Issue Location</font></b></td>
	<td align=right><input name="passport_issue_location"  value="<? echo $row[8]; ?>" size="42" style="font-size: 8pt; font-family: Arial"></td>
</tr>

<tr>
	<td class=tdformlabel>Issue Date</font></b></td>
	<td  align=right><input value="<? if ($row[9]!="") echo date("d-m-Y",$row[9]); ?>" style="font-size: 8pt; font-family: Arial; width: 75px;" name=passport_issue_date id="passport_issue_date" readonly onclick="fPopCalendar('passport_issue_date')"></td>
</tr>

<tr>
	<td class=tdformlabel>Valid Till</font></b></td>
	<td  align=right><input value="<? if ($row[10]!="") echo date("d-m-Y",$row[10]); ?>" style="font-size: 8pt; font-family: Arial; width: 75px;" name=passport_valid_till id="passport_valid_till" readonly onclick="fPopCalendar('passport_valid_till')"></td>
</tr>
<input name="account" size=40 type=hidden value="<? echo $account; ?>">

<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Update Information" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>

<br><br>
<?php
$account=$_REQUEST['account'];
?>
<center>
<b><font face="Arial" color="#FF6600" size="3">Upload profile photograph</font></b>
<br>
<form enctype="multipart/form-data" method="POST" action="upload_photo.php?account=<?echo $account;?>">
<fieldset style="width: 980px;">
<input type="hidden" name="MAX_FILE_SIZE" value="10000000000">
<input type="hidden" name="account" value="<?echo $account;?>">
<font face=Arial size=1><b>Choose photograph (.JPG) to upload (w:135px, h:176px)<input class=forminputtext name="uploadedfile" type="file" /><br>
<input class="forminputtext" type="submit" value="Upload" name="Submit">
</form>
</fieldset>
<br><br>
</td>
</table>
