<?
	$link = mysql_connect($DATABASE_SERVER, $DATABASE_USERNAME, $DATABASE_PASSWORD);
	if (!$link) {
		echo 'Error connecting!';
	}
	$DATABASE_NAME=$DATABASE_NAME."_oa";
	$db_selected = mysql_select_db($DATABASE_NAME, $link);
	if (!$db_selected) {
		echo 'Error connecting';
	}
?>