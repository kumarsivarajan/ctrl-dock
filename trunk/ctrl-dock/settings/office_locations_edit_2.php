<?php 
include("config.php");
if (!check_feature(10)){feature_error();exit;}

$office_index=$_REQUEST["office_index"];

echo "<center><table border=0 width=50%>";
$address=mysql_real_escape_string($_REQUEST["address"]);if (strlen($address)<= 0){$error=1;}
if ($error==1){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The office address was left blank </font></b></td></tr>";
}

$country=mysql_real_escape_string($_REQUEST["country"]);if (strlen($country)<= 0){$error=2;}
if ($error==1){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The country was left blank </font></b></td></tr>";
}

$phone=$_REQUEST["phone"];
$fax=$_REQUEST["fax"];
$showhide=$_REQUEST["showhide"];

  
if ($error>0){
?>
	<tr><td><font face="Arial" size="2" color="#003399"><b><a href=javascript:history.back();>Click here to return to the previous screen to correct these errors</font></b></a></td></tr></table>
<?
}

//If all the validations are successfully completed, insert the record into the table
if ($error==0) {
        $sql = "update office_locations set address='$address',country='$country',phone='$phone',fax='$fax', showhide='$showhide' where office_index='$office_index'";
        $result = mysql_query($sql);
	
?>
	<i><b><font color="#003366" face="Arial" size=2>The office location details were saved.</font></b></i>
	<meta http-equiv="Refresh" content="2; URL=office_locations.php">
	
  <?php
  }
?>
