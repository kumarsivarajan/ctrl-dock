<?include("auth.php"); ?>
<title>CONTROL DOCK</title>
</head>
<body topmargin="0" leftmargin="0" bgcolor=#FFFFFF>
<center>
	<table border="0" width="100%" height="100%" cellspacing="0" cellpadding="0" bgcolor=#FFFFFF>
		<tr>
			<td width=180 valign=top>
				<iframe name="rim_menu" src="menu.php" height=100% width=100% scrolling="no" border="0" frameborder="0" target="rimmain"></iframe>
			</td>
			<?if($DASH==1){?>
				<td>
				<iframe name="rimmain" src="dash.php" height=100% width=100% border="0" frameborder="0"></iframe>
				</td>
			<?}?>
			<?if($DASH==0){?>
				<td>
				<iframe name="rimmain" src="admin/account_list.php?office_index=%&account_status=Active&account_type=%" height=100% width=100% border="0" frameborder="0"></iframe>
				</td>
			<?}?>

		</tr>
	</table>
</body>
</html>




