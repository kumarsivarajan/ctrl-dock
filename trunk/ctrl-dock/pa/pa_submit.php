<?php 
include_once("config.php");
if (!check_feature(50)){feature_error();exit;}

$base_url="http://";
if ($HTTPS==1){$base_url="https://";}
$base_url.=$_SERVER["SERVER_NAME"]."/".$INSTALL_HOME."pa";

$activity_id			=$_REQUEST["activity_id"];

$action					="PENDING APPROVAL";
$action_by				=$username;
$action_date			=mktime();

$sql="select record_index,approver_name,approver_email,approver_key";
$sql.=" from poa_approval_history where activity_id='$activity_id' and action in ('ADDED','REJECTED') order by item_order asc limit 1";
$result = mysql_query($sql);

while ($row= mysql_fetch_row($result)){
	$record_index		=$row[0];
	$approver_name		=$row[1];
	$approver_email		=$row[2];
	$approver_key		=random_key();
	

	$sub_sql="update poa_approval_history set approver_key='$approver_key',action='$action' where record_index='$record_index'";
    $sub_result = mysql_query($sub_sql);
	
	$subject="PLANNED ACTIVITY APPROVAL REQUEST : $activity_id";
	$url=$base_url."/pa_view.php"."?check_email=".$approver_email."&check_key="."$approver_key";
	$body="\nA Planned Activity is pending your approval. Kindly click on the URL : $url to view and approve the request.\n\n\n";
	$body.="PLEASE NOTE THAT THE ABOVE URL IS FOR ONE TIME USE ONLY. \nPLEASE DO NOT REPLY TO THIS E-MAIL";
	
	ezmail($approver_email,$approver_name,$subject,$body,"");
	
	$sub_sql="update poa_master set action='$action' where activity_id='$activity_id'";
	$sub_result = mysql_query($sub_sql);
}
?>
<meta http-equiv="REFRESH" content="0;URL=index.php">