<?php 

include("config.php"); 
include("account_query.php");

$account=$_REQUEST["username"]; if (strlen($account)==0){$account="%";}
$staff_number=$_REQUEST["staff_number"]; if (strlen($staff_number)==0){$staff_number="%";}
$alphabet=$_REQUEST["alphabet"];

$country=$_REQUEST['country'];if (strlen($country)==0){$country="%";}
$account_status=$_REQUEST['account_status']; if (strlen($account_status)==0){$account_status="Active";}
$account_type=$_REQUEST['account_type'];

echo "<a href=account_list.php?country=$country&office_index=$office_index&account_status=$account_status&account_type=$account_type><font face=verdana size=1><b>All</a>&nbsp;&nbsp;";

$sql = 'select DISTINCT LEFT(username,1) FROM user_master';
$result = mysql_query($sql);
while ($row = mysql_fetch_row($result)){
	echo "<a href=account_list.php?alphabet=$row[0]&country=$country&office_index=$office_index&account_status=$account_status&account_type=$account_type><font face=verdana size=1><b> ";
	$link=strtoupper($row[0]);
	echo "$link";
	echo "</a>&nbsp;&nbsp;";
}
echo "<br><br>";

$sql = "select a.first_name,a.last_name,a.staff_number,a.account_type,a.account_status,c.business_group,b.country,a.username from user_master a, office_locations b, business_groups c where a.office_index=b.office_index and a.business_group_index=c.business_group_index";
$sql = $sql . " and b.country like '$country' and a.account_status like '$account_status' and a.account_type like '%$account_type%' and a.staff_number like '%$staff_number%' and a.username like '$alphabet%' and a.username like '%$account%' and account_type not in ('external_user','service_account')";
$sql = $sql . " order by a.first_name";
$result = mysql_query($sql);

?>
<center>
<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
	<td class=reportheader>Name</td>
	<td class=reportheader>Staff No.</td>
	<td class=reportheader>Account Type</td>
	<td class=reportheader>Account Status</td>
	<td class=reportheader>Business Group</td>
	<td class=reportheader>Region</td>	
	<td class=reportheader>Information</td>
</tr>

<?
$i=1;
$row_color="#FFFFFF";
while ($row = mysql_fetch_row($result)){
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
	$first_name	=$row[0];
	$last_name	=$row[1];
	$staff_number=$row[2];
	$account_type=$row[3];
	$account_status=$row[4];
	$business_group=$row[5];
	$region=$row[6];
	$account=$row[7];
?>
<tr bgcolor=<?echo $row_color; ?>>
	<td class=reportdata><?=$first_name." ".$last_name;?></font></td>
	<td class=reportdata style='text-align:center;'><?=$staff_number?></font></td>
	<td class=reportdata style='text-align:center;'><?=$account_type?></font></td>
	<?$font_color="#336600"; if ($account_status!="Active"){$font_color="#CC0000";}?>
	<td class=reportdata style='text-align:center;color:<?=$font_color;?>;'><?=$account_status?></font></td>
	<td class=reportdata style='text-align:center;color:<?=$font_color;?>;'><?=$business_group?></font></td>
	<td class=reportdata style='text-align:center;color:<?=$font_color;?>;'><?=$region?></font></td>

	<td class=reportdata style='text-align:center;'><a href="user_home.php?account=<?=$account?>"><img border=0 src="images/user_info.gif"></a></td>
</tr>
<?
	$i++;
}
?>
</table>
