<?

	$CONFIG_PATH=$_SERVER[DOCUMENT_ROOT]."/".$APPLICATION_PATH."config.php";
	include_once($CONFIG_PATH);
	include_once("include/db.php");


	ini_set('display_errors', '0');
	session_name('HRMS');
	session_start();

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
	
	$sql="select distinct first_name,last_name,account_expiry,agency_index from user_master a,user_group b,group_service c where a.account_status='Active' and a.username='" . $_SESSION['username'] . "' AND a.password='$check_pass' and a.username=b.username and b.group_id=c.group_id and c.service='HRMS'";
	$result = mysql_query( $sql );
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
		$user_agency=$row[3];
	    $username=$_SESSION['username'];
		include_once("includes.php");
	}
?>
