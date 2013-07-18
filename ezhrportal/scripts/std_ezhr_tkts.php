<?
include_once("../config.php");
include_once("../ezhr/include/db.php");
include_once("../ezhr/include/load_xml.php");


// UPDATE EZTICKET CREDENTIALS

print "\nUpdating ezticket credentials\n";
$sql="select distinct b.username,c.password,c.first_name,c.last_name,c.official_email from ezhr_group_feature a,ezhr_user_group b,user_master c where a.feature_id='19' and a.group_id=b.group_id and b.username=c.username and c.account_status='Active'";
$result = mysql_query($sql);

while ($row = mysql_fetch_row($result)){
	$sub_sql	="select * from hrost_staff where username='$row[0]'";
	$sub_result = mysql_query($sub_sql);
	$num_rows	= mysql_num_rows($sub_result);
	
	if($num_rows==0){
		echo "Creating Account $row[0]\n";
		if($MD5_ENABLE==0){$enc_password=md5($row[1]);}else{$enc_password=$row[1];}
		$sub_sql="insert into `hrost_staff` (`group_id`, `dept_id`, `username`, `firstname`, `lastname`, `passwd`, `email`, `phone`, `phone_ext`, `mobile`, `signature`, `isactive`, `isadmin`, `isvisible`, `onvacation`, `daylight_saving`, `append_signature`, `change_passwd`, `timezone_offset`, `max_page_size`, `auto_refresh_rate`)";
		$sub_sql.=" values('3','1','$row[0]','$row[2]','$row[3]','$enc_password','$row[4]','','','','','1','0','0','0','0','0','0','5.5','0','0')";
		$sub_result = mysql_query($sub_sql);
	}
	if($num_rows>0){
		echo "Account $row[0] exists, updating credentials\n";
		if($MD5_ENABLE==0){$enc_password=md5($row[1]);}else{$enc_password=$row[1];}
		$sub_sql="update `hrost_staff` set passwd='$enc_password' where  username='$row[0]'";
		$sub_result = mysql_query($sub_sql);
	}
}

$sql="select distinct b.username,c.password,c.first_name,c.last_name,c.official_email from ezhr_group_feature a,ezhr_user_group b,user_master c where a.feature_id='20' and a.group_id=b.group_id and b.username=c.username and c.account_status='Active'";
$result = mysql_query($sql);
while ($row = mysql_fetch_row($result)){
		$sub_sql="update `hrost_staff` set isadmin=1 where  username='$row[0]'";
		$sub_result = mysql_query($sub_sql);
}

?>
