<?

if ($_REQUEST["csv"]==1) {

$report_type="Leave_Balance";
$date=date("dmy_His");
$file_name=$report_type."_".$date.".csv";


header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=$file_name");
header("Pragma: no-cache");
header("Expires: 0");


$check_service = "HRMS";
include_once("../auth.php");
include_once("../include/date.php");

$to_date	= $_REQUEST['to_date'];
$to_date	= date_to_int($to_date);

echo "\"Staff No\",\"Staff Name\",\"Type\",\"Joining Date\",";

// Fetch Leave Types and store in array for re-use
$leave_types=array();
$sql="select leave_type_id,leave_type from lm_leave_type_master";
$result = mysql_query($sql);
$i=0;
while ($row = mysql_fetch_row($result)) {
	$leave_types[$i][0]=$row[0];
	$leave_types[$i][1]=$row[1];
	$i++;
}

// Add Report Headers for Total
for ($i=0;$i<count($leave_types);$i++){
	$string=$leave_types[$i][1]." - Total Credit";
	echo "\"".$string."\",";
	
	$string=$leave_types[$i][1]." - Availed";
	echo "\"".$string."\",";
	
	$string=$leave_types[$i][1]." - Balance ";
	echo "\"".$string."\",";
}
echo "\n";

// Fetch the window
$to_day=date('j',$to_date);
$from_date=mktime(0,0,0,date(m),date(d),date(y))-($to_day*86400);



$master_sql= "SELECT a.username,a.first_name,a.last_name,a.staff_number,a.account_type,a.account_status,b.date_of_joining,b.date_of_leaving 
FROM user_master a, user_personal_information b 
WHERE a.username=b.username AND a.account_type='employee' and 
(a.account_status='Active' OR (b.date_of_leaving>='$from_date' and b.date_of_leaving<='$to_date')) 
ORDER BY first_name";

$master_result = mysql_query($master_sql);
while ($master_row = mysql_fetch_row($master_result)) {
	$username		=$master_row[0];
	$first_name		=$master_row[1];
	$last_name		=$master_row[2];
	$staff_number	=$master_row[3];
	$account_type	=$master_row[4];
	$account_status	=$master_row[5];
	$joining_date	=$master_row[6];
	$leaving_date	=$master_row[7];
	
	echo "\"$staff_number\",\"$first_name $last_name\",\"$account_type\",";
	echo "\"".date("m/d/Y",$joining_date)."\",";
	
	

	// Fetch credit / debits and compute balance
	for ($i=0;$i<count($leave_types);$i++){
		$leave_type_id=$leave_types[$i][0];
		
		$sub_sql="select SUM(value) from lm_leave_register where username='$username' and transaction='credit' and leave_type_id='$leave_type_id' and date < $to_date";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		$total=$sub_row[0];
		echo "\"".$total."\",";
		
		$sub_sql="select SUM(value) from lm_leave_register where username='$username' and transaction='debit' and leave_type_id='$leave_type_id' and date < $to_date";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		$availed=$sub_row[0];
		
		echo "\"".$availed."\",";
		
		$balance=$total-$availed;
		
		echo "\"".$balance."\",";
	}
	echo "\n";
  }
}else{

	include("config.php");
	include("../include/date.php"); 
	include("calendar.php");
	?>
	<center>
		<h2>Generate Leave Balance Report</h2>
		<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
		<form method=POST action=report_leave_balance.php?csv=1>
		<tr bgcolor="#CCCCCC">	
			<td><font face=Arial size=2>Choose the date upto which report has to be generated</td>
			<td><input style="font-size: 8pt; font-family: Arial; width: 75px;" name=to_date id="to_date" readonly onclick="fPopCalendar('to_date')"></td>
			<td>
			<input type=submit value="Generate" name="Submit" style="font-size: 8pt; font-family: Arial">
			</td>
		</tr>
		</form>
		</table>
<?}?>
