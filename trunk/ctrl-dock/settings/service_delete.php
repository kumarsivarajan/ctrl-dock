<?include("config.php");if (!check_feature(27)){feature_error();exit;}$service=$_REQUEST["service"];$sql = "delete from services where service='$service'";$result = mysql_query($sql);$sql = "delete from service_properties where service='$service'";$result = mysql_query($sql);    $sql = "delete from group_service where service='$service'";$result = mysql_query($sql);  ?><meta http-equiv="Refresh" content="1; URL=service_list.php">