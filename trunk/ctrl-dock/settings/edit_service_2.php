<?php 

include("config.php");
if (!check_feature(18)){feature_error();exit;}

$service=$_REQUEST["service"];
$comments=$_REQUEST["comments"];

$service_type=$_REQUEST["service_type"];
$service_url=$_REQUEST["service_url"];
$service_port=$_REQUEST["service_port"];
$service_user=$_REQUEST["service_user"];
$service_pass=$_REQUEST["service_pass"];
if($service_pass=='')
{
$service_pass=$_REQUEST["oldpass"];
}
$service_domain=$_REQUEST["service_domain"];


if ($service!="" || $comments!=""){ 
  $sql = "update services set service='$service', comments='$comments' where service='$service'";
  mysql_query($sql);
  
  $sql = "update service_properties set type='$service_type', url='$service_url', port='$service_port',username='$service_user',password='$service_pass',domain='$service_domain' where service='$service'";
  mysql_query($sql);


  ?>
  <i><b><font color="#003366" face="Arial" size=2>Your changes to the Service details were saved.</font></b></i>
  <meta http-equiv="Refresh" content="1; URL=service_list.php">
<?
  }
?>

