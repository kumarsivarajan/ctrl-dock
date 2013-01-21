<?php 
include_once("config.php");
if (!check_feature(50)){feature_error();exit;}

$base_url="http://";
if ($HTTPS==1){$base_url="https://";}
$base_url.=$_SERVER["SERVER_NAME"]."/".$INSTALL_HOME."pa";

$activity_id	=$_REQUEST["activity_id"];

$action					="PENDING APPROVAL";
$action_by				=$username;
$action_date			=mktime();

$sql="select record_index,approver_name,approver_email,approver_key,item_order,action from poa_approval_history where (action ='PENDING APPROVAL' OR action='REJECTED') and activity_id='$activity_id' order by record_index DESC LIMIT 1";
$result = mysql_query($sql);
echo $sql;

if(mysql_num_rows($result)>0){
	$row = mysql_fetch_row($result);
	
	$record_index		=$row[0];
	$approver_name		=$row[1];
	$approver_email		=$row[2];
	$approver_key		=$row[3];
	$item_order			=$row[4];
	$new_item_order		=$row[4]+1;
	$last_action		=$row[5];

	if ($last_action=="REJECTED"){
	
		$sub_sql="select record_index,item_order from poa_approval_history where item_order>'$item_order' and activity_id='$activity_id'";
		$sub_result = mysql_query($sub_sql);
		while ($sub_row= mysql_fetch_row($sub_result)){
			$col_1=$sub_row[0];
			$col_2=$sub_row[1]+1;
			$up_sql="update poa_approval_history set item_order='$col_2' where record_index='$col_1'";
			$up_result = mysql_query($up_sql);	
		}
		
		
		$sql="insert into poa_approval_history (activity_id,action,action_by,action_date,item_order,approver_name,approver_email,approver_key)";
		$sql.=" values ('$activity_id','$action','$action_by','$action_date','$new_item_order','$approver_name','$approver_email','$approver_key')";
		$result = mysql_query($sql);
	}
	
	$subject="PLANNED ACTIVITY APPROVAL REQUEST : REMINDER : $activity_id";
	$url=$base_url."/pa_view.php"."?check_email=".$approver_email."&check_key="."$approver_key";
	$body="\nA Planned Activity is pending your approval. Kindly click on the URL : $url to view and approve the request.\n\n\n";
	$body.="PLEASE NOTE THAT THE ABOVE URL IS FOR ONE TIME USE ONLY. \nPLEASE DO NOT REPLY TO THIS E-MAIL";
	
	ezmail($approver_email,$approver_name,$subject,$body,"");
}
?>
<meta http-equiv="REFRESH" content="20;URL=index.php">

