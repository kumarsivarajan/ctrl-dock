<?php 

include("config.php"); 

$host_id=$_REQUEST["host_id"];

$hostname=mysql_real_escape_string($_REQUEST["hostname"]);
$platform=$_REQUEST["platform"];
$status=$_REQUEST["status"];
$description=mysql_real_escape_string($_REQUEST["description"]);

if ($hostname!=""){ 
  $sql = "update hosts_master set hostname='$hostname', platform='$platform', status='$status',description='$description' where host_id='$host_id'";
  mysql_query($sql);
?>
  <i><b><font color="#003366" face="Arial" size=2>Your changes to the Host were saved.</font></b></i>
  <meta http-equiv="Refresh" content="1; URL=index.php">
<?
  }
?>

