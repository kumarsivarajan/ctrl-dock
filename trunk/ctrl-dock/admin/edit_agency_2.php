<?php 
include("config.php");
if (!check_feature(40)){feature_error();exit;}

$agency_index=$_REQUEST["agency_index"];

echo "<center><table border=0 width=100%>";

$name=$_REQUEST["name"];if (strlen($name)<= 0){$error=1;}
if ($error==1){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The name of the agency was left blank </font></b></td></tr>";
}

$type=$_REQUEST["type"];
$address=mysql_real_escape_string($_REQUEST["address"]);

$contact_phone=$_REQUEST["contact_phone"];
$contact_fax=$_REQUEST["contact_fax"];
$contact_email=$_REQUEST["contact_email"];

$prim_contact=$_REQUEST["prim_contact"];
$prim_phone=$_REQUEST["prim_phone"];
$prim_email=$_REQUEST["prim_email"];

$sec_contact=$_REQUEST["sec_contact"];
$sec_phone=$_REQUEST["sec_phone"];
$sec_email=$_REQUEST["sec_email"];

$comments=mysql_real_escape_string($_REQUEST["comments"]);
$payment_terms=mysql_real_escape_string($_REQUEST["payment_terms"]);
$bank_info=mysql_real_escape_string($_REQUEST["bank_info"]);


  
if ($error>0){
?>
	<tr><td><font face="Arial" size="2" color="#003399"><b><a href=javascript:history.back();>Click here to return to the previous screen to correct these errors</font></b></a></td></tr></table>
<?
}

//If all the validations are successfully completed, update the record
if ($error==0) {
        $sql = "update agency set name='$name', type='$type', address='$address', contact_phone='$contact_phone', contact_fax='$contact_fax', contact_email='$contact_email',";
		$sql.= " prim_contact='$prim_contact', prim_phone='$prim_phone', prim_email='$prim_email',";
		$sql.= " sec_contact='$sec_contact', sec_phone='$sec_phone', sec_email='$sec_email', comments='$comments',payment_terms='$payment_terms',bank_info='$bank_info'";
		$sql.= " where agency_index='$agency_index'";
        $result = mysql_query($sql);
	
?>
	<i><b><font color="#003366" face="Arial" size=2>The changes to the agency details were saved.</font></b></i>
	<meta http-equiv="Refresh" content="2; URL=agency_list.php">
	
  <?php
  }
?>
