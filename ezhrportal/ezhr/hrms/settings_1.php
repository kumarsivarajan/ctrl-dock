<?include("config.php"); ?>
<center>
<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr>
	<td align=left>
		<b><font face="Arial" color="#CC0000" size="2">SETTINGS
	</td>
</tr>
</table>
<br>

<form method=POST action=settings_2.php>
<table border=0 cellpadding=3 cellspacing=0 width=100%>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Site Information</b></td></tr>

<tr>
	<td class=tdformlabel>Site Name</td>
	<td align=right><input type=text name="n_site_name" size="50" value='<?=$SITE_NAME;?>' style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Site Logo Absolute URL</td>
	<td align=right><input type=text name="n_site_logo_path" size="50" value='<?=$SITE_LOGO_PATH;?>' style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Site Banner Absolute URL</td>
	<td align=right><input type=text name="n_site_banner_path" size="50" value='<?=$SITE_BANNER_PATH;?>' style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Site Banner Height (in pixels)</td>
	<td align=right><input type=text name="n_site_banner_height" size="5" value='<?=$SITE_BANNER_HEIGHT;?>' style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>ezQ Absolute URL</td>
	<td align=right><input type=text name="n_portal_ezq_url" size="50" value='<?=$portal_ezq_url;?>' style="font-size: 8pt; font-family: Arial"></td>
</tr>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Expense Workflow</b></td></tr>
<tr>
	<td class=tdformlabel>Status</td>
	<td align=right>
	<select size=1 name=n_ftr_expenses style="font-size: 8pt; font-family: Arial">
		<option value="1" <?if($FEATURE_EXPENSES==1){ echo "selected";}?>>Enabled</option>
		<option value="0" <?if($FEATURE_EXPENSES==0){ echo "selected";}?>>Disabled</option>
	</select>
	</td>
</tr>
<tr>
	<td class=tdformlabel>Currency</td>
	<td align=right><input type=text name="n_currency" size="5" value='<?=$CURRENCY;?>' style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Prefix</td>
	<td align=right><input type=text name="n_expense_prefix" size="5" value='<?=$EXPENSE_PREFIX;?>' style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Company name</td>
	<td align=right><input type=text name="n_company" size="50" value='<?=$COMPANY;?>' style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Address</td>
	<td align=right><input type=text name="n_address" size="50" value='<?=$ADDRESS;?>' style="font-size: 8pt; font-family: Arial"></td>
</tr>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Notifications</b></td></tr>
<tr>
	<td class=tdformlabel>Send notifications to </td>
	<td align=right><input type=text name="n_hr_notifications" size="50" value='<?=$hr_notifications;?>' style="font-size: 8pt; font-family: Arial"></td>
</tr>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Leave / Absence Management</b></td></tr>

<tr>
	<td class=tdformlabel>Status (	<a href=../leave/ style="font-size: 8pt; font-family: Arial">Settings</a> )</td>
	<td align=right>
	<select size=1 name=n_ftr_leave style="font-size: 8pt; font-family: Arial">
		<option value="1" <?if($FEATURE_LEAVE==1){ echo "selected";}?>>Enabled</option>
		<option value="0" <?if($FEATURE_LEAVE==0){ echo "selected";}?>>Disabled</option>
	</select>
	</td>
</tr>
<tr>
	<td class=tdformlabel>Display Leave Balance</td>
	<td align=right>
	<select size=1 name=n_ftr_leave_balance style="font-size: 8pt; font-family: Arial">
		<option value="1" <?if($FEATURE_LEAVE_BALANCE==1){ echo "selected";}?>>Enabled</option>
		<option value="0" <?if($FEATURE_LEAVE_BALANCE==0){ echo "selected";}?>>Disabled</option>
	</select>
	</td>
</tr>
<tr>
	<td class=tdformlabel>Compensatory Leave / Absence Credit</td>
	<td align=right>
	<select size=1 name=n_ftr_leave_credit style="font-size: 8pt; font-family: Arial">
		<option value="1" <?if($FEATURE_LEAVE_CREDIT==1){ echo "selected";}?>>Enabled</option>
		<option value="0" <?if($FEATURE_LEAVE_CREDIT==0){ echo "selected";}?>>Disabled</option>
	</select>
	</td>
</tr>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Timesheet</b></td></tr>
<tr>
	<td class=tdformlabel>Status</td>
	<td align=right>
	<select size=1 name=n_ftr_timesheets style="font-size: 8pt; font-family: Arial">
		<option value="1" <?if($FEATURE_TIMESHEETS==1){ echo "selected";}?>>Enabled</option>
		<option value="0" <?if($FEATURE_TIMESHEETS==0){ echo "selected";}?>>Disabled</option>
	</select>
	</td>
</tr>

<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Save" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>
