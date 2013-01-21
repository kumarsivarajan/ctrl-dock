<? 
	include_once("include/version.php");

    $label="username";
?>

<title>control dock login</title>
<body bgcolor="#FFFFFF">
<br><br>
<div align="center">
		
<form method=post action=frames.php>
	<table border="0" width="370"  height=47 cellspacing="0" cellpadding="1" background="images/bnr1_bg.png">
		<tr>
			<td align=left>			
				<img src="images/dock.png"></img>
			</td>
			<td align=right>
				
			</td>
		</tr>
	</table>

	<table bgcolor=#336699 border="1" width="370"  cellspacing="0" cellpadding="5" style="border-width: 0px;border-color: #CCCCCC;">
		<tr>
			<td style="border-style:none; border-width:medium; " height="15">			
				<font face="Arial" size="2" color="#FFFFFF"><b><?echo $label;?></font></b>
			</td>
		</tr>
		<tr>
			<td style="border-style:none; border-width:medium; " height="15">
				<input type="text" style="width: 350px;" name="username" tabindex="1" style="font-family: Arial; font-size: 9pt;">
			</td>
		</tr>
		<tr>
			<td style="border-style:none; border-width:medium; " height="15">
				<font face="Arial" color="#FFFFFF" size="2"><b>password </font></b>
			</td>
		</tr>
		<tr>
			<td style="border-style:none; border-width:medium; " height="15">
				<input type="password" style="width: 350px;" name="password" tabindex="2" >
			</td>
		</tr>

		<tr>
			<td style="border-style:none; border-width:medium; " align=center colspan="3">
			<input type=submit value="  LOGIN  " name="Login" tabindex="4" style="font-family: Arial; font-size: 8pt; color: #333333; font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type=reset value="  CLEAR  " name="Clear" tabindex="5" style="font-size: 8pt; font-family: Arial; color: #333333; font-weight: bold"></td>
		</tr>
		</table>
	</form>
</div>
<center>
<p>
<font face="Arial" size="1" color="#BBBBBB">
<a href="http://www.ctrl-dock.org" style="text-decoration: none">
<span>
<font face="Arial" size="1" color="#BBBBBB">powered by ctrl-dock ver. <?=$VERSION;?></font></a>
<font face="Arial" size="1" color="#BBBBBB">
</center>