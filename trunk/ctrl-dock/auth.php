<?
	//putenv('TZ = GMT');
	//ini_set('display_errors', '0');
	//error_reporting(E_ALL);
	// Set Session Timeout to 8 Hours
    ini_set('session.gc_maxlifetime', 28800);    
	session_name('RIM_ADMIN');
	session_start();

	include_once("include/config.php");	
	include_once("include/db.php");
	include_once("include/system_config.php");
	
	$valid_till="";
	
	if($_REQUEST){
			$username=$_REQUEST["username"];
			$password=$_REQUEST["password"];
	}
	
	if(isset($username)&&isset($password)){
			$_SESSION['username']=$username;
  			$_SESSION['password']=$password;
	}

	if ($MD5_ENABLE==1){
		$check_pass=md5($_SESSION['password']);
	}else{
		$check_pass=$_SESSION['password'];
	}
	
	$sql = sprintf("SELECT first_name,last_name,account_expiry 
	       		FROM user_master a 
			WHERE a.username='%s' AND a.password='%s' 
			AND a.account_status='Active'",mysql_real_escape_string($_SESSION['username']),mysql_real_escape_string($check_pass));
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$record_count=mysql_num_rows($result);
			
	$valid_till=$row[2];
	$current=mktime(0,0,0);
	if ($valid_till==""){$valid_till=$current+86400;}
	
	if ($record_count<1 || $valid_till<$current) {
		$loc = "Location: "."index.php";
		header($loc);
		exit;
	}elseif($record_count>0 && $valid_till>=$current){		  					            	
	    $User_Full_Name=$row[0] . " " . $row[1];
	    $username=$_SESSION['username'];
	}
?>
