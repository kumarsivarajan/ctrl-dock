<?include_once("../auth.php");?>
<html>
<body>
<br><br>
<?

  $error=0;

  $username=$_SESSION['username'];
  $oldpassword=$_REQUEST["oldpassword"];

  $sql = "select count(*) from user_master where username='$username' and password='$oldpassword'";
  $result = mysql_query($sql);
  while ($count = mysql_fetch_row($result)) {
        if ($count[0] == 0){
	$error=1;	
        }
  }

  $password1=$_REQUEST["password1"];
  $password2=$_REQUEST["password2"];

  if ( (strlen($password1) != strlen($password2)) || ($password1 != $password2) || strlen($password1)< 8 || strlen($password2)< 8 || $error==1){
  ?>
	<font face=Arial size=2 color=red><b>Your password was not changed. This could be due to :</b><br><br>
	<font face=Arial size=2 color=blue>
	- The User Name that you provided might not exist.<br>
	- The Old Password that you provided might be incorrect.<br>
	- The New Password might be less than 8 characters.<br>
	- The New Password was not verified correctly.
  <?php	
  } else {
        if ($MD5_ENABLE==1){
                $enc_password = md5($password1);
        }else{
                $enc_password = $password1;
        }

  	$sql = "UPDATE user_master set password='$enc_password' where username='$username'";
	$result = mysql_query($sql);
	?>
	<center><font face=Arial size=2 color=blue><b><i> The password has been changed</i></b>	
	<br><br>
	It might take 1-2 Hours for the new password to take effect across all services.<br><br>
	You may continue to use the old password till such time.
	
	<?php
  }
?>
</body>
</html>

