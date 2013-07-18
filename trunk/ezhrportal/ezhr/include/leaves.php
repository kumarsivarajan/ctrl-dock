<?

function leave_summary ($employee){

	$sql="select policy_id from lm_user_leave_policy where username='$employee'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$policy_id	= $row[0];
	
	$sql="select a.leave_type_id,b.leave_type from lm_leave_policy_details a,lm_leave_type_master b";
	$sql.="	where a.leave_type_id=b.leave_type_id and a.policy_id='$policy_id'";
	$result = mysql_query($sql);
	
	$balance=array();
	$i=0;
	
	while ($row = mysql_fetch_row($result)){
		
		$balance[$i][0]=$row[0];
		$balance[$i][1]=$row[1];
		

		// Compute Balance
		
		$sub_sql="select sum(value) from lm_leave_register where transaction='credit' and leave_type_id='$row[0]' and username='$employee'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		$credit	= $sub_row[0];
		
		
		
		
		$sub_sql="select sum(value) from lm_leave_register where transaction='debit' and leave_type_id='$row[0]' and username='$employee'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		$debit	= $sub_row[0];
		
		$total	= $credit - $debit;
			
		if(strlen($credit)==0){$credit=0;}
		if(strlen($debit)==0){$debit=0;}
		if(strlen($total)==0){$total=0;}
		
		$balance[$i][2]=$credit;
		$balance[$i][3]=$debit;
		$balance[$i][4]=$total;
		
		$i=$i+1;

	}
	
	return($balance);
	
}

function get_leave_policyid($employee){
	$sql="select policy_id from lm_user_leave_policy where username='$employee'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$policy_id	= $row[0];
	
	
	return($policy_id);
}

?>