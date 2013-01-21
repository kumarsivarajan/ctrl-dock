<?
include_once("../include/config.php");
include_once("../include/db.php");
include_once("../include/system_config.php");
include_once("../include/load_xml.php");

function decryptpass ($stringArray) { 
	$key="8V7YQ2150IC2BW30";
	$s = unserialize(rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode(strtr($stringArray, '-_,', '+/=')), MCRYPT_MODE_CBC, md5(md5($key))), "\0")); 
	return $s;
}
	
function disable_account($username){
	$sub_sql="update user_master set account_status='Obsolete' where username='$username'";
	$sub_result = mysql_query($sub_sql);
					
	$sub_sql="update isost_staff set isactive='0' where username='$username'";
	$sub_result = mysql_query($sub_sql);
				
	print "Disabling the account $username\n";					
}


// Update against Master RIM Server
if($ezRIM==1){
	
// Fetch the details of all users who have been provisioned to access this RIMBOX	
$url=$MASTER_URL."/api/rim_access.php?key=".$MASTER_API_KEY."&agency=".$AGENCY_ID;	
if ($query = load_xml($url)){
	for($i=0;$i<count($query);$i++){
		$first_name				=$query->user[$i]->first_name;
		$last_name				=$query->user[$i]->last_name;
		$email					=$query->user[$i]->email;
		$expiry					=$query->user[$i]->expiry;		
		$superadmin				=$query->user[$i]->superadmin;
		$username				=$query->user[$i]->username;

		if ($username!="administrator"){$username=$email;}
		
		$group_id=2;$ost_admin=0;if($superadmin==1){$group_id=1;$ost_admin=1;}
		
		$pass 					=$query->user[$i]->pass;
		$pass					=decryptpass($pass);
		if ($MD5_ENABLE==1){ $pass=md5($pass); }	
		
		// Check if User exists in local instance
		$sql	="select username,password from user_master where username='$username'";
		$result = mysql_query($sql);
		$exists	= mysql_num_rows($result);
		
		// If the account does not exist, add to the user_master table and the administrator profile
		if ($exists==0){
			print "The account $email does not exist, creating now ..\n";

			$sql="insert into user_master  (username,password,staff_number,first_name,last_name,contact_phone_office,contact_phone_residence,contact_phone_mobile,contact_address,permanent_address,office_index,official_email,personal_email,account_type,account_status,account_expiry,account_created_on,account_created_by,agency_index,business_group_index) values ('$username','$enc_pass','ADMIN','$first_name','$last_name',NULL,NULL,NULL,NULL,NULL,1,'$email',NULL,'service_account','Active','',NULL,NULL,1,1)";
			$result = mysql_query($sql);
				
			$sql="insert into `rim_user_group` (`group_id`,`username`) values ('$group_id','$username');";
			$result = mysql_query($sql);		
			
		}
		
		// If the account exists, update the credentials
		if($exists>0){
			print "The account $email exists, updating the credentials..\n";
			$sql="update user_master set official_email='$email',password='$pass',account_status='Active',account_expiry='$expiry' where username='$username'";
			$result = mysql_query($sql);
		}
	}	
	
	//Disable the accounts that are not listed in the master_list
	
	// Fetch the list of accounts in the local instance which are active
	$sql="select username from user_master where account_status='Active' and account_type='service_account' and username!='administrator' order by username";
	$result = mysql_query($sql);

	while ($row = mysql_fetch_row($result)){
		$username=$row[0];
		$match=0;
		for($i=0;$i<count($query);$i++){
			$email=$query->user[$i]->email;			
			if($username==$email){$match=1;}
		}
		
		if($match==0){
			disable_account($username);
		}
	}
}
}
	
	
// Disable accounts which have expired

$sql="select username,account_expiry from user_master where account_status='Active' and (account_expiry IS NOT NULL and account_expiry>0) order by username";
$result = mysql_query($sql);

while ($row = mysql_fetch_row($result)){
	$username		=$row[0];
	$account_expiry	=$row[1];
	$today			=mktime();
	
	if($today > $account_expiry){
		disable_account($username);
	}
}

// Update Ticketing System Groups & Departments
$sql="select business_group_index,business_group from business_groups where business_group_index not in (select bg_id from isost_department)";
$result = mysql_query($sql);
while ($row = mysql_fetch_row($result)){
	$bg_id=$row[0];
	$bg=$row[1];
	
	$sub_sql="insert  into `isost_department`(`tpl_id`,`email_id`,`autoresp_email_id`,`manager_id`,`dept_name`,`dept_signature`,`ispublic`,`ticket_auto_response`,`message_auto_response`,`can_append_signature`,`bg_id`) values (0,1,1,0,'$bg','$bg',1,1,1,1,'$bg_id')";
	$sub_result = mysql_query($sub_sql);
	
	// Fetch new department ID
	$sub_sql="select dept_id from isost_department where bg_id='$bg_id'";
	$sub_result = mysql_query($sub_sql);
	$sub_row 	= mysql_fetch_row($sub_result);
	$dept_id	=$sub_row[0];
	
	$group_name=$bg." - Staff";
	
	$sub_sql="insert  into `isost_groups`(`group_enabled`,`group_name`,`dept_access`,`can_create_tickets`,`can_edit_tickets`,`can_delete_tickets`,`can_close_tickets`,`can_transfer_tickets`,`can_ban_emails`,`can_manage_kb`,`bg_id`) values (1,'$group_name','$dept_id',1,1,0,1,1,0,1,'$bg_id')";
	$sub_result = mysql_query($sub_sql);
}


// Update Ticketing System Credentials
// Check for Feature ID 34
$sql="select distinct c.username,c.password,c.first_name,c.last_name,c.official_email,c.business_group_index from rim_group_feature a,rim_user_group b,user_master c";
$sql.=" where a.group_id=b.group_id and b.username=c.username and a.feature_id='34' and c.account_status='Active'";
$result = mysql_query($sql);

while ($row = mysql_fetch_row($result)){
	$sub_sql	="select dept_id from isost_department where bg_id='$row[5]'";
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	$dept_id=$sub_row[0];
	
	$sub_sql	="select group_id from isost_groups where bg_id='$row[5]'";
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	$group_id=$sub_row[0];

	$sub_sql	="select * from isost_staff where username='$row[0]'";
	$sub_result = mysql_query($sub_sql);
	$num_rows	= mysql_num_rows($sub_result);
	
	if($num_rows==0){
		// Create a ticketing system account if it doesn't exist
		echo "Creating account in Ticketing System $row[0]\n";
		if($MD5_ENABLE==0){$enc_password=md5($row[1]);}else{$enc_password=$row[1];}
		$sub_sql="insert into `isost_staff` (`group_id`, `dept_id`, `username`, `firstname`, `lastname`, `passwd`, `email`, `phone`, `phone_ext`, `mobile`, `signature`, `isactive`, `isadmin`, `isvisible`, `onvacation`, `daylight_saving`, `append_signature`, `change_passwd`, `timezone_offset`, `max_page_size`, `auto_refresh_rate`)";
		$sub_sql.=" values('$group_id','$dept_id','$row[0]','$row[2]','$row[3]','$enc_password','$row[4]','','','','','1','0','0','0','0','0','0','5.5','0','0')";
		$sub_result = mysql_query($sub_sql);
	}
	if($num_rows>0){
		// If the user account exists, update the credentials
		echo "Account $row[0] exists in Ticketing System, updating credentials\n";
		if($MD5_ENABLE==0){$enc_password=md5($row[1]);}else{$enc_password=$row[1];}
		$sub_sql="update `isost_staff` set passwd='$enc_password',isactive='1',email='$row[4]',isadmin='0' where  username='$row[0]'";
		$sub_result = mysql_query($sub_sql);
	}
}


// Update Ticketing System Credentials
// Check for Feature ID 45
$sql="select distinct c.username from rim_group_feature a,rim_user_group b,user_master c";
$sql.=" where a.group_id=b.group_id and b.username=c.username and a.feature_id='45' and c.account_status='Active'";
$result = mysql_query($sql);

while ($row = mysql_fetch_row($result)){
		echo "Account $row[0] exists being updated with Admin Privileges\n";
		if($MD5_ENABLE==0){$enc_password=md5($row[1]);}else{$enc_password=$row[1];}
		$sub_sql="update `isost_staff` set isadmin='1' where  username='$row[0]'";
		$sub_result = mysql_query($sub_sql);
}



// Update Documentation Area Credentials
// Create necessary .htaccess file to protect documents area
// Check for Feature ID 33 & 42
$file="../documents/.htaccess";
$htaccess = fopen($file, 'w+');
fwrite($htaccess, "AuthType Basic\n");
fwrite($htaccess, "AuthName PROTECTED\n");
fwrite($htaccess, "AuthMySQLEnable on\n");
fwrite($htaccess, "AuthMySQLHost $DATABASE_SERVER\n");
fwrite($htaccess, "AuthMySQLUser $DATABASE_USERNAME\n");
fwrite($htaccess, "AuthMySQLPassword $DATABASE_PASSWORD\n");
fwrite($htaccess, "AuthMySQLDB $DATABASE_NAME\n");
fwrite($htaccess, "AuthMySQLUserTable user_master\n");
fwrite($htaccess, "AuthMySQLNameField username\n");
fwrite($htaccess, "AuthMySQLPasswordField  password\n");
fwrite($htaccess, "AuthMySQLPwEncryption none\n");


$sql="select distinct c.username,c.password,c.first_name,c.last_name,c.official_email from rim_group_feature a,rim_user_group b,user_master c ";
$sql.=" where a.group_id=b.group_id and b.username=c.username and (a.feature_id='33' or a.feature_id='42' or a.feature_id='46') and c.account_status='Active'";
$result = mysql_query($sql);

while ($row = mysql_fetch_row($result)){
	fwrite($htaccess, "require user $row[0]\n");
}
fclose($htaccess);

?>

