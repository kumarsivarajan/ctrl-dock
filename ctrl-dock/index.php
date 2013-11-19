<? 
	include_once("include/version.php");
?>

<title>control dock login</title>
<body bgcolor="#FFFFFF">
<br><br><br><br>
<div align="center">
<form method=post action=frames.php>
	<table border="0" width="370"  height=40 cellspacing="0" cellpadding="0" bgcolor=#5C5C5C>
		<tr>
			<td align=left>			
				<img border=0 src="images/logo.png"></img>
			</td>
			<td align=right>
			</td>
		</tr>
	</table>

	<table bgcolor=#336699 border="0" width="370"  cellspacing="0" cellpadding="5">
		<tr>
			<td style="border-style:none; border-width:medium; " height="14">			
				<font face="Arial" size="2" color="#FFFFFF">username</font>
			</td>
		</tr>
		<tr>
			<td style="border-style:none; border-width:medium; " height="15">
				<input type="text" style="width: 360px;" name="username" tabindex="1" style="font-family: Arial; font-size: 9pt;">
			</td>
		</tr>
		<tr>
			<td style="border-style:none; border-width:medium; " height="14">
				<font face="Arial" color="#FFFFFF" size="2">password </font>
			</td>
		</tr>
		<tr>
			<td style="border-style:none; border-width:medium; " height="15">
				<input type="password" style="width: 360px;" name="password" tabindex="2" >
			</td>
		</tr>

		<tr>
			<td style="border-style:none; border-width:medium; " align=center colspan="2">
			<input type=submit value="  LOGIN  " name="Login" tabindex="3" style="font-family: Arial; font-size: 8pt; color: #333333; font-weight: bold;">
		</tr>
		</table>
	</form>
</div>
<center>
<p>
<font face="Arial" size="1" color="#BBBBBB">
<a href="http://www.ctrl-dock.org" style="text-decoration: none">
<span>
<font face="Arial" size="1" color="#BBBBBB">ctrl-dock ver. <?=$VERSION;?></font></a>
<font face="Arial" size="1" color="#BBBBBB">
</center>