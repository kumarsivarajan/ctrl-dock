<? 
	$CONFIG_PATH=$_SERVER[DOCUMENT_ROOT]."/config.php";
	include_once($CONFIG_PATH);

	include_once("../config.php");
	include_once("include/db.php");
	include_once("include/site_config.php");
	include_once("include/version.php");
?>
<title>ezhr login</title>
<body bgcolor="#FFFFFF">
<br><br>
<div align="center">
		
<form method=post action=frames.payroll.php>
	<table border="0" width="370"  height=47 cellspacing="0" cellpadding="1" background="images/bnr_bg.png">
		<tr>
			<td align=left colspan=2>
				<img src="images/logo.png"></img>&nbsp;
			</td>
		</tr>
	</table>

	<table bgcolor=#336699 border="1" width="370"  cellspacing="0" cellpadding="5" style="border-width: 0px;border-color: #CCCCCC;">
		<tr>
			<td style="border-style:none; border-width:medium; " height="15">
				<font face="Arial" color="#FFFFFF" size="2"><b><i>username </font></b>
			</td>
		</tr>
		<tr>
			<td style="border-style:none; border-width:medium; " height="15">
				<input type="text" style="width: 350px;" name="username" tabindex="1" style="font-family: Arial; font-size: 9pt;">
			</td>
		</tr>
		<tr>
			<td style="border-style:none; border-width:medium; " height="15">
				<font face="Arial" color="#FFFFFF" size="2"><b><i>password </font></b>
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
<font face="Arial Narrow" size="1" color="#BBBBBB">
Copyright &copy; <?=(Date("Y"))?> - 
<?=$COMPANY?></font>
<font face="Arial Narrow" size="1" color="#BBBBBB">Ver. <?=$VERSION;?>
</center>
