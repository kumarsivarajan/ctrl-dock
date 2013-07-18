<?

	if(strlen($check_service)==0){
		$check_service="PORTAL";
	}
	
	$CONFIG_PATH=$_SERVER[DOCUMENT_ROOT]."/".$APPLICATION_PATH."config.php";
	include_once($CONFIG_PATH);
	include_once("include/db.php");
	
	//ini_set('display_errors', '0');
	session_name('EZPORTAL');
	session_start();
	

	$valid_till="";
	$orig_url=$_SERVER["REQUEST_URI"];
	if($_REQUEST){
			$username=$_REQUEST["username"];
			$password=$_REQUEST["password"];
	}
	
	if(isset($username)&&isset($password)){
			$_SESSION['username']=$username;
  			$_SESSION['password']=$password;
			$_SESSION['orig_url']	=$orig_url;  		
	}


	if ($MD5_ENABLE==1){
		$check_pass=md5($_SESSION['password']);
	}else{
		$check_pass=$_SESSION['password'];
	}
	
	
	$sql="select first_name,last_name,account_expiry,staff_number from user_master a, user_group b, group_service c where a.username=b.username and b.group_id=c.group_id and c.service='$check_service' and a.account_status='Active' and a.username='" . $_SESSION['username'] . "' AND a.password='$check_pass'";
	$result = mysql_query( $sql );
	$row = mysql_fetch_row($result);
	$record_count=mysql_num_rows($result);
	
			
	$valid_till=$row[2];
	$current=mktime(0,0,0);
	if ($valid_till==""){$valid_till=$current+86400;}
	
	if ($record_count<1 || $valid_till<$current) {
		if (file_exists("login.php")){$login="login.php";}
		if (file_exists("../login.php")){$login="../login.php";}
		$loc = "Location: ".$login."?orig_url=".$orig_url;
		header($loc);
		exit;
	}elseif($record_count>0 && $valid_till>=$current){		
	    $User_Full_Name=$row[0] . " " . $row[1];
		$User_Staff_No=$row[3];
	    $username=$_SESSION['username'];
		$employee=$username;
	}
?>