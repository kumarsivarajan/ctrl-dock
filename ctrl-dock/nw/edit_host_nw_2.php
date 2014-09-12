<?php 

include("config.php"); 
if (!check_feature(31)){feature_error();exit;}


$host_id	=$_REQUEST["host_id"];

$count		=$_REQUEST["count"];	if(strlen($count)==0){$count=4;}
$timeout	=$_REQUEST["timeout"];	if(strlen($timeout)==0){$timeout=4;}
$enabled	=$_REQUEST["enabled"];
$alarm_threshold	=$_REQUEST["alarm_threshold"];
$flap_timeout=$_REQUEST["flap_timeout"];
$flap_threshold=$_REQUEST["flap_threshold"];

if ($host_id!=""){
  $sql = "delete from hosts_nw where host_id='$host_id'";
  mysql_query($sql);
  
  $sql = "insert into hosts_nw (host_id,count,timeout,enabled,alarm_threshold,flap_timeout,flap_threshold) values ('$host_id','$count','$timeout','$enabled','$alarm_threshold','$flap_timeout','$flap_threshold')";
  mysql_query($sql);

?>
  <i><b><font color="#003366" face="Arial" size=2>Your changes to the Host were saved.</font></b></i>
  <meta http-equiv="Refresh" content="1; URL=index.php">
<?
  }
?>

