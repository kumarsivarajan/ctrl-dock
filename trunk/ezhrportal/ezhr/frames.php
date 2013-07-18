<?
include("auth.php"); 
include("default.css"); 
?>
<html>

<head>
<title>ezHR</title>
</head>

<body bgcolor=#EFEFEF leftmargin=0 topmargin=0>

<center>
	<table border="0" width="1024" height="100%" cellspacing="0" cellpadding="0" bgcolor=#FFFFFF>
		<tr>
			<td height="46"><iframe name="hrmsbanner" src="banner.php" height=46 width=100% scrolling="no" border="0" frameborder="0"></iframe></td>
		</tr>
		<tr>
			<td height="30"><iframe name="hrmsmenu" src="menu.php" height=30 width=100% scrolling="no" border="0" frameborder="0" target="hrmsmain"></iframe></td>
		</tr>
		<tr>
			<td><iframe name="hrmsmain" src="hrms/summary.php" height=100% width=100% border="0" frameborder="0"></iframe></td>
		</tr>
	</table>


</body>

</html>