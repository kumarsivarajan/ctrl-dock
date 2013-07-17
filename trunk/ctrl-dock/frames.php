<?include("auth.php"); ?>
<title>CONTROL DOCK</title>
</head>
<body topmargin="2" leftmargin="0" bgcolor=#FFFFFF>
<center>
	<table border="0" width="1024" height="100%" cellspacing="0" cellpadding="0" bgcolor=#FFFFFF>
		<tr>
			<td height="40"><iframe name="rim_menu" src="menu.php" height=100% width=100% scrolling="no" border="0" frameborder="0" target="rimmain"></iframe></td>
		</tr>
		<tr>
		<?if($DASH==1){?>
			<td><iframe name="rimmain" src="dash.php" height=100% width=1024 border="0" frameborder="0"></iframe></td>
		<?}?>
		<?if($DASH==0){?>
			<td><iframe name="rimmain" src="admin/account_list.php?office_index=%&account_status=Active&account_type=%" height=100% width=1024 border="0" frameborder="0"></iframe></td>
		<?}?>

		</tr>
	</table>
</body>
</html>




