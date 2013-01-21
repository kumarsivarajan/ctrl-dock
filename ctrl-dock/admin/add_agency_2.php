<?php 
include("config.php");
if (!check_feature(39)){feature_error();exit;}

echo "<center><table border=0 width=50%>";

$name=$_REQUEST["name"];if (strlen($name)<= 0){$error=1;}


// Check if the Name /Code is left blank
if ($error==1){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The agency name was left blank </font></b></td></tr>";
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

//If all the validations are successfully completed, insert the record into the table
if ($error==0) {
        $sql = "insert into agency (name,type,address,contact_phone,contact_fax,contact_email,prim_contact,prim_phone,prim_email,sec_contact,sec_phone,sec_email,comments,payment_terms,bank_info) values ('$name','$type','$address','$contact_phone','$contact_fax','$contact_email','$prim_contact','$prim_phone','$prim_email','$sec_contact','$sec_phone','$sec_email','$comments','$payment_terms','$bank_info')";
        $result = mysql_query($sql);
?>
	<p align="center"><b><font color="#003366" face="Arial" size=2>The agency details were saved.</font></b></p>
<?
}	
?>

	
