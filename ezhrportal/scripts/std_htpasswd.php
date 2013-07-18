<?
include_once("../config.php");
include_once("../ezhr/include/db.php");

$file="../.htaccess";
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

$sql="select username from user_master where account_status='Active' order by username";
$result = mysql_query($sql);

while ($row = mysql_fetch_row($result)){
	$username=$row[0];	
	fwrite($htaccess, "require user $row[0]\n");
}
fclose($htaccess);
?>

