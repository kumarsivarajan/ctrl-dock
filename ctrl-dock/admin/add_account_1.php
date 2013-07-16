<?php 
include("config.php"); 
if (!check_feature(2)){feature_error();exit;}

$SELECTED="ADD A USER";
include("header.php");
?>


<form method=POST action=add_account_2.php>

<table border=0 cellpadding=2 cellspacing=0 width=100%>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Account Information</b></td></tr>
<tr>
	<td class='tdformlabel'>Type of Account</td>
	<td align=right>
		<select size=1 name=account_type class='formselect'>
			<?php
			    $sql = "select * from account_type";	
				$result = mysql_query($sql);
				while ($row = mysql_fetch_row($result)) {
		        		echo "<option value='$row[0]'>$row[1]</option>";
				}
			?>
		</select>
	</td>
</tr>

<tr>
	<td class='tdformlabel'>Official E-Mail<?if ($ACCOUNT_AS_EMAIL==1){echo "- <i> This will be Username to login";}?></td>
	<td align=right><input name="official_email" size="40" class='forminputtext'></td>
</tr>
<?if ($ACCOUNT_AS_EMAIL==0){?>
<tr>
	<td class='tdformlabel'>Username</td>
	<td align=right><input name="account" size="40" class='forminputtext'></td>
</tr>
<?}?>
<tr>
	<td class='tdformlabel'>Password</td>
	<td align=right><input name="password1" type=password size="40" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'>Verify Password</font></b></td>
	<td align=right><input name="password2" type=password size="40" class='forminputtext'></td>
</tr>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White></td></tr>



<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Additional Information</b></td></tr>
<tr>
        <td class='tdformlabel'>Name of Agency (if applicable)</td>
        <td align=right>
				
                <select size=1 name=agency_index class='formselect'>
				<option value='1'>Internal</option>
                        <?php
                                $sql = "select * from agency where agency_index>1 order by name";
                                $result = mysql_query($sql);
                                while ($row = mysql_fetch_row($result)) {
                                        echo "<option value='$row[0]'>$row[1]</option>";
                                }
                        ?>
                </select>
        </td>
</tr>

<tr>
	<td class='tdformlabel'>Staff No.</td>
	<td align=right><input name="staff_number" size="10" class='forminputtext'></td>
</tr>

<tr>
	<td class='tdformlabel'>Business Group / Department</td>
	<td align=right>
		<select size=1 name=business_group_index class='formselect'>
			<?php
			        $sql = "select * from business_groups";	
				$result = mysql_query($sql);
				while ($row = mysql_fetch_row($result)) {
		        		echo "<option value='$row[0]'>$row[1]</option>";
				}
			?>
		</select>
	</td>
</tr>

<tr>
	<td class='tdformlabel'>First Name</td>
	<td align=right><input name="first_name" size="40" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'>Last Name</td>
	<td align=right><input name="last_name" size="40" class='forminputtext'></td>
</tr>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White></td></tr>


<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Contact Details - Address</b></td></tr>
<tr>
	<td class='tdformlabel'>Office Location</td>
	<td align=right>
		<select size=1 name=office_index class='formselect'>
			<?php
			        $sql = "select * from office_locations";	
				$result = mysql_query($sql);
				while ($row = mysql_fetch_row($result)) {
		        		echo "<option value='$row[0]'>$row[2]-$row[0]</option>";
				}
			?>
		</select>
	</td>
</tr>

<tr>
	<td class='tdformlabel'>Residential Address - Current</td>
	<td align=right><textarea rows="3" name="contact_address" cols="42" class='formtextarea'></textarea></td>
</tr>
<tr>
	<td class='tdformlabel'>Residential Address - Permanent</td>
	<td align=right><textarea rows="3" name="permanent_address" cols="42" class='formtextarea'></textarea></td>
</tr>

<tr>
	<td class='tdformlabel'>Personal E-Mail</td>
	<td align=right><input name="personal_email" size="40" class='forminputtext'></td>
</tr>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White></td></tr>



<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Contact Details - Phone</b></td></tr>
<tr>
	<td class='tdformlabel'>Office</td>
	<td align=right><input name="contact_phone_office" size="40" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'>Mobile</td>
	<td align=right><input name="contact_phone_mobile" size="40" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'>Residence</td>
	<td align=right><input name="contact_phone_residence" size="40" class='forminputtext'></td>
</tr>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White></td></tr>



<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Account Control</b></td></tr>
<tr>
	<td class='tdformlabel'>Status</td>
	<td align=right>
		<select size=1 name=account_status class='formselect'>
			<?php
			        $sql = "select * from account_status";	
				$result = mysql_query($sql);
				$i=1;
				while ($row = mysql_fetch_row($result)) {
					if ($i<3){echo "<option value='$row[0]'>$row[0]</option>";}
					$i++;
				}
			?>
		</select>
	</td>
<tr>
</tr>
	<td class='tdformlabel'>Valid Till</td>
	<td  align=right><input class=formnputtext name=account_expiry id="account_expiry" style="font-size: 8pt; font-family: Arial; width:165px;" id="account_expiry" onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF></td>
</tr>


<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Add Account" name="Submit"  class='forminputbutton'>
	</td>
</tr>
</form>
</table>
