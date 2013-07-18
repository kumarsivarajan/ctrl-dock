<?php
function check_feature ($feature){
	
	global $username;
		
	$sql="SELECT * FROM ezhr_group_feature a,ezhr_user_group b,user_master c WHERE a.feature_id='$feature' AND a.group_id=b.group_id AND b.username=c.username and c.account_status='Active' and b.username='$username'";
	$result = mysql_query( $sql );	
	$row = mysql_fetch_row($result);
	$record_count=mysql_num_rows($result);
	if($record_count>0){
		return TRUE;
	}else{
		return FALSE;
	}
}

function feature_error(){
	echo "<h2><i>This feature is not enabled for your profile</i></h2>";	
}
?>
