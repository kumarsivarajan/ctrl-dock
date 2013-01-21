<?
$config_file="../include/config.php";
$file = fopen($config_file, 'r');
while(!feof($file)) {
	$line=fgets($file);
	if(strpos($line,"DATABASE_NAME")==1){
		$line=chop($line);
		$line=substr($line,16);
		$db_name=substr($line,0,strlen($line)-2);
		$db_name_oa=$db_name."_oa";
	}
}

// Backup the Database
`mysqldump $db_name > ../backup/$db_name.sql`;
`mysqldump $db_name_oa > ../backup/$db_name_oa.sql`;

`cp -rf ../include/config.php ../backup/`;
`cp -rf ../eztickets/attachments ../backup/`;
`cp -rf ../documents/files ../backup/`;

?>
