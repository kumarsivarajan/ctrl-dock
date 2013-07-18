<? 
	include_once("auth.php");
	include_once("include/site_config.php");
?>
<body background="../data/images/home_bg.png">
<head>
<title><?=$SITE_NAME;?></title>
</head>

<center>
<table border="0" width="1024" height="100%" cellspacing=0 cellpadding=0 style="border-collapse: collapse">
<tr>
	<td bgcolor=white width=100% height=<?=$SITE_BANNER_HEIGHT;?> valign=top>
		<iframe target="_parent" name=portal_banner border="0" frameborder="0" scrolling="no" width=100% height=<?=$SITE_BANNER_HEIGHT;?> src="<?=$SITE_BANNER_PATH;?>"></iframe>
	</td>
</tr>
<tr>
	<td bgcolor=white width=100% height=30>
		<iframe name=portal_menu border="0" frameborder="0" scrolling="auto" width=100% height=100% src="topmenu.php"></iframe>
	</td>
</tr>
<tr>
	<td bgcolor=white width=100% height=100%>
		<iframe name=portal_main border="0" frameborder="0" scrolling="auto" width=100% height=100% src="../data/home.php"></iframe>
	</td>
</tr>
</table>