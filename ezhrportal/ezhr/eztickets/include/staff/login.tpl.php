<?php defined('OSTSCPINC') or die('Invalid path'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>ezTicket : Staff Panel</title>
<link rel="stylesheet" href="css/login.css" type="text/css" />
<meta name="robots" content="noindex" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="pragma" content="no-cache" />
</head>
<body id="loginBody">
<div id="loginBox">
	<h1 id="logo"><a href="index.php">ezTicket : Staff Panel</a></h1>
	<h1><?=$msg?></h1>
	<br />
	<form action="login.php" method="post" name=login>
	<input type="hidden" name=do value="scplogin" />
    <table border=0 align="center">
        <tr><td width=100px align="right"><font size=2><b>Username</b></td><td><input type="text" name="username" id="name" value="<? echo $_SESSION['username'];?>" /></td></tr>
        <tr><td align="right"><font size=2><b>Password</b></td><td><input type="password" name="passwd" id="pass" value="<? echo $_SESSION['password'];?>"/></td></tr>
        <tr><td colspan=2 align=center><input class="submit" type="submit" name="submit" value="Login" /></td></tr>
    </table>
</form>
</div>
<SCRIPT LANGUAGE="JavaScript">
setTimeout('document.login.submit()',300);
</SCRIPT>

</body>
</html>
