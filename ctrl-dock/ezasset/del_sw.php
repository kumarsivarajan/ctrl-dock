<?
include_once("config.php");

include_once("searchasset.php");
if (!check_feature(37)){feature_error();exit;}

$asset_db            =$DATABASE_NAME."_oa";

$package	=$_REQUEST["package"];
$package_id	=$_REQUEST["id"];
$pass		=$_REQUEST["pass"];

?>

<body>
<br>
<table border=0 width=100% cellpadding="2" cellspacing="0" bgcolor=#E5E5E5>
  <tr>
    <td width="90%" style="border-style: none; border-width: medium" align=left colspan=1>
	<font face=Arial size=2 color=#CC0000><b>DELETE SOFTWARE LICENSE</b></font>
	</td>
	<td width=10% align=right>
	<a href=javascript:history.back()><font face=Arial size=1>BACK</font></a>
	</td>
	</tr>
</table>


<?

if($pass==1){
?>
	
	<h3>Do you want to delete the Software License Information for the Package <br><br><?=$package;?></h3>
	<br><br>
	<a href='del_sw.php?pass=2&id=<?=$package_id;?>&package=<?=$package;?>'><font face=Arial size=2>Yes</a>
	&nbsp;&nbsp;&nbsp;
	<a href=add_sw_1.php><font face=Arial size=2>No</a>
<?
}

if($pass==2){
	mysql_select_db($asset_db, $link);
	$sql = "delete from sw_licenses where package_id='$package_id'"; 	
	$result = mysql_query($sql);
	?><meta http-equiv="Refresh" content="0; URL=add_sw_1.php"><?
}
?>
