<?php

header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";


// This API is used to fetch all relevant user information of users who are provisioned to manage a particular agency
// rim_access.php?key=abcd&agency=1


function invalid(){
	echo "<node>";
		echo "<count>invalid</count>";
	echo "</node>";
	die(0);
}

function success($count){
	echo "<node>";
		echo "<count>".$count."</count>";
	echo "</node>";
	die(0);
}

function encryptpass ($stringArray) {
	$key="8V7YQ2150IC2BW30";
	$s = strtr(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), serialize($stringArray), MCRYPT_MODE_CBC, md5(md5($key)))), '+/=', '-_,'); 
	return $s; 
}


function showxml($result, $num_rows, $agency){
if($num_rows>0){
			echo "<node>";
			while($row = mysql_fetch_array($result)){
				$pass=encryptpass($row[3]);
				
				$sasql = "select * from ops_user_group where group_id='1' and username='$row[5]'";
				$saresult 	= mysql_query($sasql);
				$sacount	= mysql_num_rows($saresult);
								
				$superadmin=0;
				if($sacount>0){$superadmin=1;}
				
				$sasql = "SELECT * from agency_manager where (prim_manager='$row[5]' or sec_manager='$row[5]') and agency_index='$agency'";
				$saresult 	= mysql_query($sasql);
				$sacount	= mysql_num_rows($saresult);
				if($superadmin==0 && $sacount>0){$superadmin=1;}
				
								
				echo "<user>";
					echo "<first_name>".$row[0]."</first_name>";
					echo "<last_name>".$row[1]."</last_name>";
					echo "<email>".$row[2]."</email>";
					echo "<pass>".$pass."</pass>";		
					echo "<expiry>".$row[4]."</expiry>";
					echo "<username>".$row[5]."</username>";
					echo "<superadmin>".$superadmin."</superadmin>";
				echo "</user>";
			}
			echo "</node>";
		}else{
			$nodata = 0;
			success($nodata);
		}
}
// include config file, also contains the API KEY
require_once('../include/config.php');
require_once('../include/db.php');

$api_key		= strip_tags($_REQUEST['key']);
$agency			= strip_tags($_REQUEST['agency']);
$users			=array();

$num_rows		= '';

// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
		$i=0;
		
		$sql = "SELECT username from agency_resource where agency_index='$agency'";
		$result = mysql_query($sql);

		while($row = mysql_fetch_array($result)){		
			$users[$i]=$row[0];
			$i++;
		}
			
		$sql = "SELECT prim_manager,sec_manager from agency_manager where agency_index='$agency'";
		$result = mysql_query($sql);		
		while($row = mysql_fetch_array($result)){		
			$users[$i]=$row[0];
			$i++;
			$users[$i]=$row[1];
			$i++;
		}
			
		$sql = "select b.username from agency_groups a,ops_user_group b where a.group_id=b.group_id and a.agency_index='$agency'";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){		
			$users[$i]=$row[0];
			$i++;
		}

		$sql = "select username from ops_user_group where group_id='1'";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){		
			$users[$i]=$row[0];
			$i++;
		}
		
		$users[$i]="administrator";

		
		$user_list=implode("','",$users);
		$sql = "SELECT first_name,last_name,official_email,password,account_expiry,username from user_master where account_status='Active' and username in ('$user_list')";
		$result = mysql_query($sql);
		$num_rows = mysql_num_rows($result);
		showxml($result, $num_rows, $agency);
}
?>
