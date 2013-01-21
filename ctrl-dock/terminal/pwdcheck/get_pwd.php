<?php
$script_path=$_SERVER['SCRIPT_FILENAME'];
$installation_path=substr($script_path,0,strpos($script_path,"/terminal/pwdcheck"));

include_once("$installation_path/include/config.php");
include_once("$installation_path/include/db.php");

$ra_split = explode('@', $argv[1]);
$username = $ra_split[0];

$servicename = $argv[2];
$portal_id = $argv[3];


$sql="select d.password, d.port, d.type from user_master a, user_group b, group_service c,service_properties d";
$sql.=" where a.username=b.username and b.group_id=c.group_id and c.service=d.service and";
$sql.=" c.service='$servicename' and a.username='$portal_id'";
$result = mysql_query($sql);
if(mysql_num_rows($result)){
	$row = mysql_fetch_row($result);
	$password=$row[0];
	$port=$row[1];
	if ($row[2]=='SSH'){
		if ($port == '' or $port == 0){
			$port = 22;
		}
	}
	$command="expect $installation_path/terminal/scripts/myssh.exp $argv[1] '$password' $username $port";
	passthru($command);
}
?>
