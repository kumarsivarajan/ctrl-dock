<?php
include("config.php"); 
include("account_query.php");
$account=$_REQUEST["account"]; if (strlen($account)==0){$account="%";}
$staff_number=$_REQUEST["staff_number"]; if (strlen($staff_number)==0){$staff_number="%";}
$alphabet=$_REQUEST["alphabet"];

$country=$_REQUEST['country'];if (strlen($country)==0){$country="%";}
$account_status=$_REQUEST['account_status'];
$account_type=$_REQUEST['account_type'];
?>
<link href="../include/css/pagination.css" rel="stylesheet" type="text/css" />
<link href="../include/css/grey.css" rel="stylesheet" type="text/css" />
<center>
<table class="reporttable" width=100%>
<tr>
			<td colspan=8 align=left>&nbsp;
<?
		echo "<a href=account_list.php?country=$country&account_status=$account_status&account_type=$account_type><font face=Arial size=1 color=#AAAAAA><b>All</a>&nbsp;&nbsp;";

		$sql = "select DISTINCT LEFT(username,1) FROM user_master";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_row($result)){
			echo "<a href=account_list.php?alphabet=$row[0]&country=$country&account_status=$account_status&account_type=$account_type><font face=Arial size=1 color=#AAAAAA><b>";
			$link=strtoupper($row[0]);
			echo "$link";
			echo "</a>&nbsp;&nbsp;";
		}
?>
			</td>
</tr>
<?
//get the function
		include("function.php");	
    	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    	$limit = 20;
    	$startpoint = ($page * $limit) - $limit;
	
		$sql = "select first_name,last_name,staff_number,account_type,account_status,c.business_group,b.country,a.account_expiry,a.username from user_master a,office_locations b, business_groups c where a.office_index=b.office_index and a.business_group_index=c.business_group_index";
		if(strlen($account_type) > 0){
				$sql.=" and a.account_type like '$account_type%'";
		}
		if(strlen($account_status) > 0){
				$sql.=" and a.account_status like '$account_status%'";
		}

		$sql.=" and b.country like '$country' and a.staff_number like '$staff_number' and a.username like '$alphabet%' and a.username like '%$account%'";
		$sql.=" order by a.first_name";
#		$sql.=" order by a.first_name LIMIT ".$startpoint.",".$limit;
		
		$result = mysql_query($sql);
		$record_count=mysql_num_rows($result);
?>
		

<tr>
	<td class="reportheader">Name</td>
	<td class="reportheader">Staff No.</td>
	<td class="reportheader">Account Type</td>
	<td class="reportheader">Status</td>
	<td class="reportheader">Department</td>
	<td class="reportheader">Region</td>
	<td class="reportheader">Valid Till</td>
	<td class="reportheader" width=45>Edit</td>
	<td class="reportheader" width=45>Groups</td>
	<td class="reportheader" width=45>Org</td>	
</tr>

<?
$i=1;
$row_color="#FFFFFF";
while ($row = mysql_fetch_row($result)){
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
?>
<tr bgcolor=<?echo $row_color; ?>>
        <td class='reportdata'><? echo "$row[0] $row[1]"; ?></td>
        <td class='reportdata'><? echo $row[2]; ?></td>
        <td class='reportdata'><? echo $row[3]; ?></td>
        <?$font_color="#336600"; if ($row[4]!="Active"){$font_color="#CC0000";}?>
        <td class='reportdata' style='color:<? echo $font_color; ?>'><? echo $row[4]; ?></td>
        <td class='reportdata' style='color:<? echo $font_color; ?>'><? echo $row[5]; ?></td>
        <td class='reportdata' style='color:<? echo $font_color; ?>'><? echo $row[6]; ?></td>
<?
        if ($row[7]==""){
                $valid="";
        }else{
                $valid=date("d-M-Y",$row[7]);
        }
?>
        <td class='reportdata'><? echo $valid; ?></td>
        <td class='reportdata' style='text-align: center;'><a href="edit_account_1.php?account=<? echo $row[8]; ?>"><img border=0 src="images/edit.gif"></a></td>
		<td class='reportdata' style='text-align: center;'><a href="usr_group_edit.php?account=<? echo $row[8]; ?>"><img border=0 src="images/group_edit.gif"></a></td>
        <td class='reportdata' style='text-align: center;'><a href="usr_organization_1.php?account=<? echo $row[8]; ?>"><img border=0 src="images/organization.gif"></a></td>
 
</tr>
<?
	$i++;
}
?>
<tr><td class='reportdata' colspan=9><b><i><?=$record_count?> records found</i></b></td></tr>
</table>
<?php echo pagination($limit,$page,$country,$account_status,$account_type,$staff_number,$account,$alphabet); ?>
