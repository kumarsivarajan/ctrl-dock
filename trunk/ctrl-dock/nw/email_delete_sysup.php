<?
/*******************************************************************************************************
Auth: Aneesh
Creation Date: 18/05/2012
Function: Queruy to delete the specified email from DB
*******************************************************************************************************/
include("config.php");
if (!check_feature(19)){
	feature_error();
	exit;
}
$id=$_REQUEST["id"];
$delete_query = sprintf("DELETE FROM sys_uptime_email 
			 WHERE id=%d",$id);
$result = mysql_query($delete_query);
?>
<center><i><b><font color='#003366' face='Arial' size=2>The Email has been deleted successfully.</font></b></i></center>
<meta http-equiv="Refresh" content="1; URL=index.php">
