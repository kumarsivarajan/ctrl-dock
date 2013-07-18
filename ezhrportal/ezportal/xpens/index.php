<?
$check_service="XPENS";
include_once("../auth.php");
?>
<head>

<link rel="stylesheet" href="css/login.css" type="text/css" />
<SCRIPT LANGUAGE="JavaScript"> 
	setTimeout("document.getElementById('loginform').submit();",1000);
</SCRIPT>
</head>
<form method="post" action="search.php" id=loginform name="loginform">
	<input type="hidden" size="25" maxlength="20" name="username" value="<?=$_SESSION['username']?>">
	<input type="hidden" size="25" maxlength="32" name="password" value="<?=$check_pass?>">
</form>