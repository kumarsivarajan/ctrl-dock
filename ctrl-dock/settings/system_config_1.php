<?php 
include("config.php");
if (!check_feature(41)){feature_error();exit;} 

$sql = "select * from config";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$SELECTED="GENERAL SETTINGS";
include("header.php");
?>
<h3>Please do not modify these settings, if you are not sure what they are. These may make the system un-stable and un-usable</h3>
<form method=POST action=system_config_2.php>

<table border=0 cellpadding=2 cellspacing=0 width=100%>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Accounts</b></td></tr>
<tr>
	<td class='tdformlabel'><b>Account as E-Mail</font></b></td>
        <td align=right>
                <select size=1 name=account_as_email class='formselect'>
                        <?php
								$value=$row[0];
								$status="Yes";
								if($value==0){$status="No";}
                                echo "<option value='$value'>$status</option>";
                                echo "<option value='0'>No</option>";
								echo "<option value='1'>Yes</option>";
                        ?>
                </select>
        </td>
</tr>
<tr>		
		<td class='tdformlabel'><b>MD5 Enabled Passwords</font></b></td>
        <td align=right>
                <select size=1 name=md5_enable class='formselect'>
                        <?php
								$value=$row[1];
								$status="Yes";
								if($value==0){$status="No";}
                                echo "<option value='$value'>$status</option>";
                                echo "<option value='0'>No</option>";
								echo "<option value='1'>Yes</option>";
                        ?>
                </select>
        </td>
</tr>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Asset</b></td></tr>
<tr>		
		<td class='tdformlabel'><b>Prefix</font></b></td>
		<td align=right><input name="asset_prefix"  value="<? echo $row[2]; ?>" size="10" class='forminputtext'></td>
        
</tr>
<tr>		
		<td class='tdformlabel'><b>Audit Expiry</font></b></td>
		<td align=right><input name="audit_expiry"  value="<? echo $row[3]; ?>" size="3" class='forminputtext'><font class=tdformlabel>Days</font></td>
        
</tr>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;RIM Master</b></td></tr>

<tr>		
		<td class='tdformlabel'><b>Master RIM</font></b></td>
        <td align=right>
                <select size=1 name=ezrim class='formselect'>
                        <?php
								$value=$row[4];
								$status="Yes";
								if($value==0){$status="No";}
                                echo "<option value='$value'>$status</option>";
                                echo "<option value='0'>No</option>";
								echo "<option value='1'>Yes</option>";
                        ?>
                </select>
        </td>
</tr>
<tr>		
		<td class='tdformlabel'><b>Master URL</font></b></td>
		<td align=right><input name="master_url"  value="<? echo $row[5]; ?>" size="40" class='forminputtext'></td>
</tr>
<tr>		
		<td class='tdformlabel'><b>Master API Key</font></b></td>
		<td align=right><input name="master_api_key"  value="<? echo $row[6]; ?>" size="40" class='forminputtext'></td>
</tr>
<tr>		
		<td class='tdformlabel'><b>Agency ID</font></b></td>
		<td align=right><input name="agency_id"  value="<? echo $row[7]; ?>" size="4" class='forminputtext'></td>
</tr>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Features</b></td></tr>

<tr>		
		<td class='tdformlabel'><b>Dashboard</font></b></td>
        <td align=right>
                <select size=1 name=service_dash class='formselect'>
                        <?php
								$value=$row[8];
								$status="Enabled";
								if($value==0){$status="Disabled";}
                                echo "<option value='$value'>$status</option>";
                                echo "<option value='0'>Disabled</option>";
								echo "<option value='1'>Enabled</option>";
                        ?>
                </select>
        </td>
</tr>
<tr>		
		<td class='tdformlabel'><b>Assets</font></b></td>
        <td align=right>
                <select size=1 name=service_ezasset class='formselect'>
                        <?php
								$value=$row[9];
								$status="Enabled";
								if($value==0){$status="Disabled";}
                                echo "<option value='$value'>$status</option>";
                                echo "<option value='0'>Disabled</option>";
								echo "<option value='1'>Enabled</option>";
                        ?>
                </select>
        </td>
</tr>
<tr>		
		<td class='tdformlabel'><b>Tickets</font></b></td>
        <td align=right>
                <select size=1 name=service_ezticket class='formselect'>
                        <?php
								$value=$row[10];
								$status="Enabled";
								if($value==0){$status="Disabled";}
                                echo "<option value='$value'>$status</option>";
                                echo "<option value='0'>Disabled</option>";
								echo "<option value='1'>Enabled</option>";
                        ?>
                </select>
        </td>
</tr>
<tr>		
		<td class='tdformlabel'><b>Network</font></b></td>
        <td align=right>
                <select size=1 name=service_network class='formselect'>
                        <?php
								$value=$row[11];
								$status="Enabled";
								if($value==0){$status="Disabled";}
                                echo "<option value='$value'>$status</option>";
                                echo "<option value='0'>Disabled</option>";
								echo "<option value='1'>Enabled</option>";
                        ?>
                </select>
        </td>
</tr>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;SNMP</b></td></tr>
<tr>		
		<td class='tdformlabel'><b>SNMP Enabled</font></b></td>
        <td align=right>
                <select size=1 name=snmp class='formselect'>
                        <?php
								$value=$row[13];
								$status="Enabled";
								if($value==0){$status="Disabled";}
                                echo "<option value='$value'>$status</option>";
                                echo "<option value='0'>Disabled</option>";
								echo "<option value='1'>Enabled</option>";
                        ?>
                </select>
        </td>
</tr>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Terminal</b></td></tr>
<tr>		
		<td class='tdformlabel'><b>Terminal Enabled</font></b></td>
        <td align=right>
                <select size=1 name=terminal class='formselect'>
                        <?php
								$value=$row[14];
								$status="Enabled";
								if($value==0){$status="Disabled";}
                                echo "<option value='$value'>$status</option>";
                                echo "<option value='0'>Disabled</option>";
								echo "<option value='1'>Enabled</option>";
                        ?>
                </select>
        </td>
</tr>
<tr>		
		<td class='tdformlabel'><b>Terminal Port</font></b></td>
		<td align=right><input name="terminalport"  value="<? echo $row[15]; ?>" size="40" class='forminputtext'></td>
</tr>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Miscellaeneous</b></td></tr>
<tr>		
		<td class='tdformlabel'><b>HTTPS Enabled</font></b></td>
        <td align=right>
                <select size=1 name=https class='formselect'>
                        <?php
								$value=$row[12];
								$status="Enabled";
								if($value==0){$status="Disabled";}
                                echo "<option value='$value'>$status</option>";
                                echo "<option value='0'>Disabled</option>";
								echo "<option value='1'>Enabled</option>";
                        ?>
                </select>
        </td>
</tr>

<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Update Account" name="Submit" class='forminputbutton'>
	</td>
</tr>
</form>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Branding : Upload Logo</b></td></tr>
<tr>
		<td class='tdformlabel'>Use a logo with a transparent background (.png) format only (ideal width : 100px, height:42px)</td>
		<td align=right>
		<form enctype="multipart/form-data" method="POST" action="upload_logo.php">
			<input type="hidden" name="MAX_FILE_SIZE" value="10000000000">
			<input class=forminputtext name="uploadedfile" type="file" />
			<input type="submit" style="height:18px;font-style:normal;font-size: 11px;" value="Upload" name="Submit">
		</form>
	</td>
</tr>

</table>

