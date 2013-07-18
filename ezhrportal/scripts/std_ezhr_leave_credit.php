<?
// Master Database Connection Settings
include_once("../config.php");
include_once("../ezhr/include/db.php");

include_once("../ezhr/include/leaves.php");
include_once("../ezhr/include/site_config.php");

$credit_date=mktime();
$today=date(j);


if(date(m)==2 && $today==date(t)){$today=30;}

// Fetch list of active users as per the user master

$sql="select a.username,b.date_of_joining from user_master a, user_personal_information b ";
$sql.=" where a.username=b.username and account_status='Active' and account_type='employee' order by first_name";
$result = mysql_query($sql);

while ($row = mysql_fetch_row($result)){
	$username		=$row[0];
	$joining_date	=$row[1];
	$joining_day	=date('j',$joining_date);
	
	$policy_id		=get_leave_policyid($username);
	
	
	// Get applicable credit values for the staff
	
	$sub_sql="select leave_type_id,credit_value from lm_leave_policy_details";
	$sub_sql.=	" where policy_id='$policy_id' and credit_value>0 and credit_day=$today";
	$sub_result = mysql_query($sub_sql);

	while ($sub_row = mysql_fetch_row($sub_result)){
		$leave_type_id	= $sub_row[0];
		$credit_value	= $sub_row[1];
				
		$credit=1;
		$month_start=$credit_date - (date('d',$credit_date)*86400);
		if($joining_date>=$month_start && $joining_day>$lc_threshold){
			$credit=0;
			echo "No leave type credited $leave_type_id for $username since the joining date is beyond the leave credit threshold\n";
		}
		
		// Credit Leave
		if ($credit==1){
			$crsql="insert into lm_leave_register values";
			$crsql.="('$username','$leave_type_id','$credit_date','credit','System Credit as per policy','$credit_value','0')";
			mysql_query($crsql);
		}
	}
}


// For users who have left the company in the previous month

if ($today==1){
	$from_date=$credit_date-(30*86400);
	
	$sql="SELECT a.username,b.date_of_joining,b.date_of_leaving 
	FROM user_master a, user_personal_information b 
	WHERE a.username=b.username AND a.account_type='employee' AND (b.date_of_leaving>='$from_date' and b.date_of_leaving<='$credit_date')
	ORDER BY first_name";
	$result = mysql_query($sql);
	
	while ($row = mysql_fetch_row($result)){
		$username		=$row[0];
		$joining_date	=$row[1];
		$leaving_date	=$row[2];
		$leaving_day	=date('j',$leaving_date);
		
		$policy_id		=get_leave_policyid($username);
			
		// Get applicable credit values for the staff
	
		$sub_sql="select leave_type_id,credit_value from lm_leave_policy_details";
		$sub_sql.=	" where policy_id='$policy_id' and credit_value>0";
		$sub_result = mysql_query($sub_sql);

		while ($sub_row = mysql_fetch_row($sub_result)){
			$leave_type_id	= $sub_row[0];
			$credit_value	= $sub_row[1];
			
			// Credit Leave only if the employee has worked as per the Leave Credit Threshold Value
			if ($leaving_day>=$lc_threshold){
				// Credit Leave
				$crsql="insert into lm_leave_register values";
				$crsql.="('$username','$leave_type_id','$credit_date','credit','System Credit as per policy','$credit_value','0')";
				mysql_query($crsql);
			}
		}
	}
}


?>