<?php

header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";


function success($count){
	echo "<node>";
		echo "<count>".$count."</count>";
	echo "</node>";
	die(0);
}

function showerror ($error){
	echo "<node>";
		echo "<Error>".$error."</Error>";
	echo "</node>";
	die(0);
}

 
function showxml($info, $num_rows){	
	echo "<node>";
	if($num_rows>0){		
		for ($i=0;$i<$num_rows;$i++){
				echo "<users>";					
					echo '<uid>'.$info[$i]["uid"][0].'</uid>';
					echo '<first_name>'.$info[$i]["givenname"][0].'</first_name>';
					echo '<last_name>'.$info[$i]["sn"][0].'</last_name>';
					echo '<email>'.$info[$i]["mail"][0].'</email>';
								
			    echo "</users>";
		}
		echo "</node>";
	}	
	else{
		$nodata = 0;
		success($nodata);
	}
}


// include config file, also contains the API KEY
include_once('../include/config.php');
include_once('../include/db.php');
include_once("../include/config_ldap.php");
include_once("../include/ldap.php");

$api_key		= strip_tags($_REQUEST['key']);

if($api_key!=$API_KEY || $api_key==''){
	showerror ("Invalid API Key"); 
}else{
	if ($ldap_conn){			
		$info	 	= ldap_search($ldap_conn, $BASE_DN, $LDAP_FILTER);
		$result		= ldap_get_entries($ldap_conn, $info);
		$count		= ldap_count_entries($ldap_conn, $info);

		showxml	($result, $count);
		
		ldap_close($ldap_conn);
		
	} else { 
		showerror ("Unable to connect to LDAP server"); 
	}
} 
?>