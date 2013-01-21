<?php 
include("config.php"); 
if (!check_feature(3)){feature_error();exit;}

$account=$_REQUEST["account"];

$sql = "select first_name,last_name,username from user_master where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$SELECTED="EDIT USER : ".$row[0]." ".$row[1] ." (".$row[2].")";;
include("header.php");

$sql = "select * from user_master where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

if ($row[14]=="Obsolete"){
	echo "<br><center><font face=Arial size=2 color=#CC0000><b>The account is obsolete. Obsolete accounts should be updated under authorization only.";
}
?>
<form method=POST action=edit_account_2.php>

<table border=0 cellpadding=2 cellspacing=0 width=100%>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Account Information</b></td></tr>
<tr>
	<td class='tdformlabel'>Account Type</td>
        <td align=right>
                <select size=1 name=account_type class='formselect'>
                        <?php
                                $sub_sql = "select description from account_type where account_type='$row[13]'";
                                $sub_result = mysql_query($sub_sql);
								$sub_row = mysql_fetch_row($sub_result);

                                echo "<option value='$row[13]'>$sub_row[0]</option>";
                                $sub_sql = "select * from account_type";
                                $sub_result = mysql_query($sub_sql);
                                while ($sub_row = mysql_fetch_row($sub_result)) {
                                        echo "<option value='$sub_row[0]'>$sub_row[1]</option>";
                                }
                        ?>
                </select>
        </td>

	<?	if ($row[13] != "employee"){	?>
	<tr>
        	<td class='tdformlabel'>Agency</td>
	        <td align=right>
        	        <select size=1 name=agency_index class='formselect'>
                	        <?php
                        	        $sub_sql = "select * from agency where agency_index='$row[18]'";
                                	$sub_result = mysql_query($sub_sql);
									$sub_row = mysql_fetch_row($sub_result);
                                	echo "<option value='$sub_row[0]'>$sub_row[1]</option>";

                        	        $sub_sql = "select * from agency order by name";
                                	$sub_result = mysql_query($sub_sql);
	                                while ($sub_row = mysql_fetch_row($sub_result)) {
        	                                echo "<option value='$sub_row[0]'>$sub_row[1]</option>";
                	                }
                        	?>
	                </select>
	        </td>
	</tr>
	<? } ?>

</tr>
<tr>
	<td class='tdformlabel'>Password</td>
	<td align=right><input name="password1" type=password size="40" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'>Verify Password</td>
	<td align=right><input name="password2" type=password size="40" class='forminputtext'></td>
</tr>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White></td></tr>



<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Staff Information</b></td></tr>
<tr>
	<td class='tdformlabel'>Staff No.</td>
	<td align=right><input name="staff_number"  value="<? echo $row[2]; ?>" size="10" class='forminputtext'></td>
</tr>

<tr>
	<td class='tdformlabel'>Business Group</td>
	        <td align=right>
        	        <select size=1 name=business_group_index class='formselect'>
                	        <?php
                        	        $sub_sql = "select * from business_groups where business_group_index='$row[19]'";
                                	$sub_result = mysql_query($sub_sql);
									$sub_row = mysql_fetch_row($sub_result);
                                	echo "<option value='$sub_row[0]'>$sub_row[1]</option>";

                        	        $sub_sql = "select * from business_groups";
                                	$sub_result = mysql_query($sub_sql);
	                                while ($sub_row = mysql_fetch_row($sub_result)) {
        	                                echo "<option value='$sub_row[0]'>$sub_row[1]</option>";
                	                }
                        	?>
	                </select>
	        </td>
</tr>

<tr>
	<td class='tdformlabel'>First Name</td>
	<td align=right><input name="first_name"  value="<? echo $row[3]; ?>" size="40" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'>Last Name</td>
	<td align=right><input name="last_name"  value="<? echo $row[4]; ?>" size="40" class='forminputtext'></td>
</tr>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White></td></tr>



<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Contact Details - Address</b></td></tr>
<tr>
	<td class='tdformlabel'>Office Location</td>
	<td align=right>
		<select size=1 name=office_index class='formselect'>
			<?php	
                    $sub_sql = "select country from office_locations where office_index='$row[10]'";
                    $sub_result = mysql_query($sub_sql);
					$sub_row = mysql_fetch_row($sub_result);
		        	echo "<option value='$row[10]'>$sub_row[0]-$row[10]</option>";
			        $sub_sql = "select * from office_locations";					
					$sub_result = mysql_query($sub_sql);
					while ($sub_row = mysql_fetch_row($sub_result)) {
			       		echo "<option value='$sub_row[0]'>$sub_row[2]-$sub_row[0]</option>";
					}
			?>
		</select>
	</td>
</tr>

<tr>
	<td class='tdformlabel'>Residential Address - Current</td>
	<td align=right><textarea rows="3" name="contact_address" cols="42" class='formtextarea'><? echo $row[8]; ?></textarea></td>
</tr>
<tr>
	<td class='tdformlabel'>Residential Address - Permanent</td>
	<td align=right><textarea rows="3" name="permanent_address" cols="42" class='formtextarea'><? echo $row[9]; ?></textarea></td>
</tr>

<tr>
	<td class='tdformlabel'>Official E-Mail</td>
	<td align=right><input name="official_email" value="<? echo $row[11]; ?>" size="40" class='forminputtext'></td>
</tr>

<tr>
	<td class='tdformlabel'>Personal E-Mail</td>
	<td align=right><input name="personal_email" value="<? echo $row[12]; ?>" size="40" class='forminputtext'></td>
</tr>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White></td></tr>



<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Contact Details - Phone</b></td></tr>
<tr>
	<td class='tdformlabel'>Office</td>
	<td align=right><input name="contact_phone_office" value="<? echo $row[5]; ?>" size="40" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'>Residence</td>
	<td align=right><input name="contact_phone_residence" value="<? echo $row[6]; ?>" size="40" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'>Mobile</td>
	<td align=right><input name="contact_phone_mobile" value="<? echo $row[7]; ?>" size="40" class='forminputtext'></td>
</tr>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White></td></tr>



<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Account Control</b></td></tr>
<tr>
	<td class='tdformlabel'>Status</td>
	<td align=right>
		<select size=1 name=account_status class='forminputtext'>
			<?php
			echo "<option value='$row[14]'>$row[14]</option>";
		        $sub_sql = "select * from account_status";	
			$sub_result = mysql_query($sub_sql);
			$i=1;
			while ($sub_row = mysql_fetch_row($sub_result)) {
				echo "<option value='$sub_row[0]'>$sub_row[0]</option>";
			}
			?>
		</select>
	</td>
<tr>
</tr>
	<td class='tdformlabel'>Valid Till</td>
	<? if (strlen($row[15])>0){$expiry=date("d-m-Y",$row[15]);}else{$expiry="";}?>
	<td  align=right><input value="<? echo $expiry; ?>" style="font-size: 8pt; font-family: Arial; width: 75px;" name=account_expiry id="account_expiry" onclick="fPopCalendar('account_expiry')"></td>
</tr>

<input name="account" size=40 type=hidden value="<? echo $row[0]; ?>">

<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Update Account" name="Submit" class='forminputbutton'>
	</td>
</tr>
</form>
</table>

