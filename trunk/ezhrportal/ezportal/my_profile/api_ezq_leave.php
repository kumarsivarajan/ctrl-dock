<?
header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

include("../include/config.php");
include("../include/db.php");
$employee=$_REQUEST["employee"];


	$sql = "select * from leave_form where leave_status=0 and username in (SELECT username FROM user_organization WHERE direct_report_to='$employee' OR dot_report_to='$employee')";	
	$result = mysql_query($sql);
	echo "<node>";
	while ($row = mysql_fetch_row($result)) {

		echo "<pending_my_approval>";
			echo "<application_id>".$row[0]."</application_id>";
			echo "<staff>".$row[1]."</staff>";
			
			$sub_sql="select first_name,last_name from user_master where username='$row[1]'";
			$sub_result = mysql_query($sub_sql);
			$sub_row = mysql_fetch_row($sub_result);
			echo "<first_name>".$sub_row[0]."</first_name>";
			echo "<last_name>".$sub_row[1]."</last_name>";
			
			echo "<from_date>".date("d M Y",$row[2])."</from_date>";
			echo "<to_date>".date("d M Y",$row[3])."</to_date>";
		

			$sub_sql="select leave_category from leave_type where leave_category_id='$row[5]'";
			$sub_result = mysql_query($sub_sql);
			$sub_row = mysql_fetch_row($sub_result);
			
			echo "<leave_type>".$sub_row[0]."</leave_type>";
			echo "<leave_reason>".$row[4]."</leave_reason>";

			echo "</pending_my_approval>";

	}
				echo "</node>";
?>