<? 
	include_once("include/version.php");
	include_once("include/config.php");
	include_once("include/db.php");
	include_once("include/system_config.php");

?>

<title>control dock login</title>
<body bgcolor="#FFFFFF">
<br><br><br><br>
<div align="center">
<form method=post action=frames.php>
	<table border="0" width="370"  height=40 cellspacing="0" cellpadding="0" bgcolor=<?=$MENU_BGCOLOR;?>>
		<tr>
			<td align=left>			
				<img border=0 width=100 src="images/logo.png"></img>
			</td>
			<td align=right>
			</td>
		</tr>
	</table>

	<table border="0" width="370"  cellspacing="0" cellpadding="5" bgcolor=#DDDDDD>
		<tr>
			<td style="border-style:none; border-width:medium; " height="14">			
				<font face="Arial" size="2" color="#000000">username</font>
			</td>
		</tr>
		<tr>
			<td style="border-style:none; border-width:medium; " height="15">
				<input type="text" style="width: 360px;" name="username" tabindex="1" style="font-family: Arial; font-size: 9pt;">
			</td>
		</tr>
		<tr>
			<td style="border-style:none; border-width:medium; " height="14">
				<font face="Arial" color="#000000" size="2">password </font>
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
<font face="Arial" size="1" color="#BBBBBB">control dock ver. <?=$VERSION;?></font></a>
<font face="Arial" size="1" color="#BBBBBB">
</center>