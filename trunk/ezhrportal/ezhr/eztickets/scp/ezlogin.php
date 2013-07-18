<?
include("../../auth.php"); 
include("../../include/features.php"); 
if (!check_feature(19)){feature_error();exit;}
?>


<head>
<link rel="stylesheet" href="css/login.css" type="text/css" />
<SCRIPT LANGUAGE="JavaScript"> 
	setTimeout("document.getElementById('loginform').submit();",1000);
</SCRIPT>
</head>

<body id="loginBody"">
<div id="loginBox">
	<h1><?=$msg?></h1>
	<br />
	
	<form action="login.php" method="post" id="loginform">	
	<input type="hidden" name=do value="scplogin" />
	<input type="hidden" name="username" id="name" value="<? echo $_SESSION['username'];?>" />
	<input type="hidden" name="passwd" id="pass" value="<? echo $_SESSION['password'];?>"/>
	<input class="submit" type="submit" value="Please Wait" />
	</form>
</div>

</body>
</html>
