<?
include("config.php");
if (!check_feature(6)){feature_error();exit;}  

$id=$_REQUEST["id"];
$group=$_REQUEST["group"];
$member=$_REQUEST["member"];
$action=$_REQUEST["action"];

if ($action=="add"){
	for ($i=0;$i<count($member);$i++){
		$sql = "insert into group_service values ('$id','$member[$i]')";		
		$result = mysql_query($sql);
	}
}
if ($action=="del"){
	for ($i=0;$i<count($member);$i++){
		$sql = "delete from group_service where group_id='$id' and service='$member[$i]'";				
		$result = mysql_query($sql);
	}
}
?>
<meta http-equiv="refresh" content="0;url=group_services.php?id=<?echo $id;?>&group=<?echo $group;?>">