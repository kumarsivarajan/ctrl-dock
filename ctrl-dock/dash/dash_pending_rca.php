<?
include_once("include/config.php");
include_once("include/css/default.css");

$base_url="http://";
if ($HTTPS==1){$base_url="https://";}
$base_url.=$_SERVER["SERVER_NAME"]."/".$INSTALL_HOME."rca";
?>

<table border=0 width=100% cellspacing=1 cellpadding=2 >
<tr>
	<td class='reportdata' width=100%><b>RCAs PENDING REVIEW</td>
</tr>
</table>

<?
$sql="select official_email from user_master where username='$username'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
$official_email=$row[0];


$sql="select a.activity_id,b.project,b.action,b.action_by,b.action_date,a.approver_key";
$sql.=" from rca_approval_history a, rca_master b";
$sql.=" where a.activity_id=b.activity_id and a.action='PENDING APPROVAL' and a.approver_email='$official_email' order by a.activity_id DESC";
$result = mysql_query($sql);
$record_count=mysql_num_rows($result);

if($record_count==0){
?>
	<table width=100% cellspacing=0 cellpadding=5 class=reporttable>
	<tr>
		<td><font face="Arial" color="#C0C0C0" size="1"><i><b>NONE</font></b></td>
	</tr>
	</table>
<?
}else{
?>
	<table border=0 width=100% cellspacing=0 cellpadding=5 class=reporttable>
	<tr>
		<td class=reportheader width=70 style='background-color:#999999'>Ticket ID</td>				
		<td class=reportheader style='background-color:#999999'>Summary</td>
		<td class=reportheader style='background-color:#999999' width=100>Opened On</td>
		<td class=reportheader style='background-color:#999999' width=150>Status</td>
		<td class=reportheader style='background-color:#999999' width=150>Manage</td>		
	</tr>
<?

$i=1;
$first_record=0;
$row_color="#FFFFFF";

while ($row = mysql_fetch_row($result)){
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
	echo "<tr bgcolor=$row_color>";
	
	$activity_id	=$row[0];
	$project		=$row[1];
	$action			=$row[2];
	$action_date	=date("d M Y H:i",$row[4]);
	$approver_key	=$row[5];
	

	$sub_sql="select first_name,last_name from user_master where username='$row[3]'";
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	$action_by=$sub_row[0]." ".$sub_row[1];
	
	
	$sub_sql="select open_date from rca_information where activity_id='$activity_id' order by record_index DESC limit 1";
	$sub_result = mysql_query($sub_sql);
	$sub_row 	= mysql_fetch_row($sub_result);
	
	if($sub_row[0]>0){
		$open_date			=date("d M Y H:i",$sub_row[0]);
	}

	
	$sub_sql="select action_date from rca_master where activity_id='$activity_id'";
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	$submit_date=$sub_row[0];
		
	$sub_sql="select approver_email from rca_approval_history where activity_id='$activity_id' and action in ('ADDED','DELETED') GROUP BY approver_email HAVING COUNT(approver_email) = 1 order by item_order";
	$sub_result = mysql_query($sub_sql);
	

	echo "<td class=reportdata style='text-align:center;'>$activity_id</td>";
	echo "<td class=reportdata>$project</td>";
	echo "<td class=reportdata>$open_date</td>";
	echo "<td class=reportdata>$action</td>";		
	echo "<td class=reportdata  style='text-align:center;' width=100><a target=_blank href='rca/rca_view.php?check_email=$official_email&check_key=$approver_key'><font color=#666699><b>VIEW / APPROVE</b></font></a></td>";
	echo "<tr>";
	$i++;
}
?></table>
<?}?>