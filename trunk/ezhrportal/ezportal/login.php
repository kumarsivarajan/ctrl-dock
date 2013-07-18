<? 
	include_once("include/config.php");
	include_once("include/db.php");
	include_once("include/site_config.php");
	include_once("include/version.php");
?>
<title><?=$SITE_NAME;?></title>
<body bgcolor="#FFFFFF">
<p>&nbsp;</p>
<p>&nbsp;</p>

<?
if($_REQUEST['orig_url']){
	$post_url=$_REQUEST['orig_url'];
}else{
	$post_url="frames.php";
}
?>
<br><br>
<div align="center">
<img src="<?=$SITE_LOGO_PATH;?>"></img>
<br><br>
<form method=post action='<?=$post_url?>'>
	<table bgcolor=#EEEEEE border="0" width="330"  cellspacing="0" cellpadding="5">
		<tr>
			<td style="border-style:none; border-width:medium;width: 80px;">
				<font face="Arial" color="#666666" size="2"><b>username </font></b>
			</td>
			<td style="border-style:none; border-width:medium; ">
				<input type="text" style="width: 240px;" name="username" tabindex="1" style="font-family: Arial; font-size: 9pt;" value="<?=$_SERVER["PHP_AUTH_USER"];?>">
			</td>
		</tr>
		<tr>
			<td style="border-style:none; border-width:medium;width: 80px; ">
				<font face="Arial" color="#666666" size="2"><b>password </font></b>
			</td>
			<td style="border-style:none; border-width:medium; ">
				<input type="password" style="width: 240px;" name="password" tabindex="2" >
			</td>
		</tr>
		<tr>
			<td style="border-style:none; border-width:medium; " align=center colspan="2">
			<input type=submit value="  LOGIN  " name="Login" tabindex="4" style="font-family: Arial; font-size: 8pt; color: #333333; font-weight: bold;">
		</tr>
		</table>
	</form>
</div>
<center>
<p>
<font face="Arial Narrow" size="1" color="#BBBBBB">
Copyright &copy; <?=(Date("Y"))?> - 
<?=$COMPANY?></font>
<font face="Arial Narrow" size="1" color="#BBBBBB"> - All Rights Reserved.
&nbsp;&nbsp;<?=$VERSION;?>
</center>

