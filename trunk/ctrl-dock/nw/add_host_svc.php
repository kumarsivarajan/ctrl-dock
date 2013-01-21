<?php 

include("config.php"); 

$host_id	=$_REQUEST["host_id"];
$hostname	=$_REQUEST["hostname"];


$description		=$_REQUEST["description"];
$port				=$_REQUEST["port"];
$enabled			=$_REQUEST["enabled"];
$alarm_threshold	=$_REQUEST["alarm_threshold"];

if ($host_id!=""){

  $sql = "insert into hosts_service (host_id,description,port,enabled,alarm_threshold) values ('$host_id','$description','$port','$enabled','$alarm_threshold')";
  mysql_query($sql);

?>
  <i><b><font color="#003366" face="Arial" size=2>Your changes to the Host were saved.</font></b></i>
  <meta http-equiv="Refresh" content="1; URL=host_svc.php?host_id=<?echo $host_id;?>&hostname=<?echo $hostname;?>">
<?
  }
?>

