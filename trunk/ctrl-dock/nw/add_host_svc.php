<?php 

include("config.php"); 

$host_id	=$_REQUEST["host_id"];
$hostname	=$_REQUEST["hostname"];


$description		=$_REQUEST["description"];
$port				=$_REQUEST["port"];if(strlen($port)==0){$port="00";}
$enabled			=$_REQUEST["enabled"];
$alarm_threshold	=$_REQUEST["alarm_threshold"];

$pattern			=trim($_REQUEST["pattern"]);
$url_timeout		=trim($_REQUEST["url_timeout"]);
$url				=trim($_REQUEST["url"]);


if ($host_id!=""){

  $sql = "insert into hosts_service (host_id,description,port,enabled,alarm_threshold,pattern,timeout,url) values ('$host_id','$description','$port','$enabled','$alarm_threshold','$pattern','$url_timeout','$url')";
  mysql_query($sql);

?>
  <i><b><font color="#003366" face="Arial" size=2>Your changes to the Host were saved.</font></b></i>
  <meta http-equiv="Refresh" content="1; URL=host_svc.php?host_id=<?echo $host_id;?>&hostname=<?echo $hostname;?>">
<?
  }
?>

