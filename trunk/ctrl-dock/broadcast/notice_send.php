<? 

include("config.php");
include("header.php");

$email_to	=$_REQUEST["email_to"];
$subject	=$_REQUEST["subject"];
$body		=$_REQUEST["body"];
$temp_path	=$_REQUEST["target_path"];
$username	=$_SESSION['username'];
$subject1	=mysql_real_escape_string($subject);
$body1		=mysql_real_escape_string($body);

$broadcast_date=mktime();
$file_date=$broadcast_date."_";

if(strlen($temp_path)>0){
	$target_path=str_replace("temp_","$file_date",$temp_path);	
	rename($temp_path,$target_path);
}

$return=ezmail($email_to,$email_to,$subject,$body,$target_path,true);

if ($return==1){
	echo "<center><br><font face=Arial size=2 color=black>The notification has been sent successfully.</font>";
	
	$sql="insert into broadcast (broadcast_to,broadcast_subject,broadcast_msg,broadcast_date,username,attachment_path) values ('$email_to','$subject1','$body1','$broadcast_date','$username','$target_path')";
	$result = mysql_query($sql);
	
}else{
	echo "<center><br><font face=Arial size=2 color=black>The notification could not be sent.<br>Kindly verify your credentials or try and resend this notification later.</font>";

}


?>