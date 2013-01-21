<?php 
include_once("config.php");
if (!check_feature(48)){feature_error();exit;}

$base_url="http://";
if ($HTTPS==1){$base_url="https://";}
$base_url.=$_SERVER["SERVER_NAME"]."/".$INSTALL_HOME."rca";


$activity_id	=$_REQUEST["activity_id"];


$action					="PENDING APPROVAL";
$action_by				=$username;
$action_date			=mktime();
$email					=$_REQUEST["email"];


$sql="select record_index,approver_name,approver_email,approver_key,item_order";
$sql.=" from rca_approval_history where activity_id='$activity_id' and approver_email='$email' order by record_index asc limit 1";
$result = mysql_query($sql);


while ($row= mysql_fetch_row($result)){
	$record_index		=$row[0];
	$approver_name		=$row[1];
	$approver_email		=$row[2];
	$approver_key		=random_key();
	$sql="update rca_approval_history set approver_key='$approver_key' where record_index='$record_index'";
	$result = mysql_query($sql);
	$item_order			=$row[4];
	
	$subject="RCA APPROVAL REQUEST : $activity_id";
	$url=$base_url."/rca_view.php"."?check_email=".$approver_email."&check_key="."$approver_key";
	$body="\nA Root Cause Analysis (RCA) is pending your approval. Kindly click on the URL : $url to view and approve the request.\n\n\n";
	$body.="PLEASE NOTE THAT THE ABOVE URL IS FOR ONE TIME USE ONLY. \nPLEASE DO NOT REPLY TO THIS E-MAIL";
	
	ezmail($approver_email,$approver_name,$subject,$body,"");

	
}
?>
<meta http-equiv="REFRESH" content="0;URL=index.php">

