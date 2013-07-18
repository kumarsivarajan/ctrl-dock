<?php 
include("config.php");

$account		=$_REQUEST["account"];

$bank			=$_REQUEST["bank"];
$bank_branch	=$_REQUEST["bank_branch"];
$bank_ifsc_code	=$_REQUEST["bank_ifsc_code"];
$bank_account	=$_REQUEST["bank_account"];
$pf_no			=$_REQUEST["pf_no"];
$esi_no			=$_REQUEST["esi_no"];
$pan_no			=$_REQUEST["pan_no"];


//If all the validations are successfully completed, update the record 
$sql = "select count(*) from user_financial_information where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
if ($row[0]<=0){
	$sql = "insert into user_financial_information (bank,bank_branch,bank_ifsc_code,bank_account,pf_no,esi_no,pan_no,username)";
	$sql = $sql . " values('$bank','$bank_branch','$bank_ifsc_code','$bank_account','$pf_no','$esi_no','$pan_no','$account')";
	$result = mysql_query($sql);
} else {

	$sql = "update user_financial_information set bank='$bank',bank_branch='$bank_branch',bank_ifsc_code='$bank_ifsc_code',bank_account='$bank_account',";
	$sql.= "pf_no='$pf_no',esi_no='$esi_no',pan_no='$pan_no'";
	$sql = $sql . " where username='$account'";
	$result = mysql_query($sql);
}

?>
<meta http-equiv="Refresh" content="0; URL=user_home.php?account=<?=$account;?>">


