<?
	include("config.php"); 
	
	session_cache_limiter ('private, must-revalidate');    
    $cache_limiter = session_cache_limiter();
    session_cache_expire(120); // in minutes 
    
    // Start the session
	session_name('ezHRMS');
	session_start();
	
	if(isset($_REQUEST["pass"])){
		$pass=$_REQUEST['pass'];
    }
	if(isset($_SESSION['pass'])){
		$pass=$_SESSION['pass'];
    }
	
	$sql = "select password from hrms_lock where password='$pass'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);

	if(mysql_num_rows($result)>0){
		$_SESSION['pass']=$pass;
	}else{
			$thisurl=$portal_url.$_SERVER['REQUEST_URI'];
			$redirecturl="auth_hr_1.php"."?url=".$thisurl;
?>
			<script lanuguage="javascript">
				function refresh_parent(){
					 window.open("<?=$redirecturl;?>","_self");		
				}
				setTimeout('refresh_parent()',0000);
			</script>
<?
	}
?>
