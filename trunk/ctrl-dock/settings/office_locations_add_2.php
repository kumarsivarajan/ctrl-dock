<?php 
include("config.php");
if (!check_feature(13)){feature_error();exit;} 

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


  
if ($error>0){
?>
	<tr><td><font face="Arial" size="2" color="#003399"><b><a href=javascript:history.back();>Click here to return to the previous screen to correct these errors</font></b></a></td></tr></table>
<?
}

//If all the validations are successfully completed, insert the record into the table
if ($error==0) {
        $sql = "insert into office_locations (address,country,phone,fax) values ('$address','$country','$phone','$fax')";
        $result = mysql_query($sql);
	
?>
	<center><i><b><font color="#003366" face="Arial" size=2>The office location details were saved.</font></b></i></center>
	
  <?php
  }
?>
