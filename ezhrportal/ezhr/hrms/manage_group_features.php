<?
include("config.php");
if (!check_feature(17)){feature_error();exit;}  

$id=$_REQUEST["id"];
$group=$_REQUEST["group"];
$member=$_REQUEST["member"];
$action=$_REQUEST["action"];

if ($action=="add"){
	for ($i=0;$i<count($member);$i++){
		$sql = "insert into ezhr_group_feature values ('$id','$member[$i]')";		
		$result = mysql_query($sql);
	}
}
if ($action=="del"){
	for ($i=0;$i<count($member);$i++){
		$sql = "delete from ezhr_group_feature where group_id='$id' and feature_id='$member[$i]'";
echo $sql;		
		$result = mysql_query($sql);
	}
}
?>
<meta http-equiv="refresh" content="0;url=group_features.php?id=<?echo $id;?>&group=<?echo $group;?>">