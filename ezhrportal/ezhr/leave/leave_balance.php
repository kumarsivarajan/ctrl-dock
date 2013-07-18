<?

function leave_summary ($employee){

//global $lc_start,$compensatory_leave_validity;
$lc_start=1;
$compensatory_leave_validity=30;


$today=mktime();
$comp_off_expiry=$today-($compensatory_leave_validity*86400);

// DISPLAY OF LEAVE SUMMARY FOR THE USER

	// Fetch joining date of the employee
	$sql = "select date_of_joining,date_of_leaving from user_personal_information where username='$employee'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$joining_date=$row[0];
	$leaving_date=$row[1];
	
	
	$joining_day=date("d",$joining_date);
	if($joining_day<15){
		$joining_date=($joining_date-(($joining_day)*86400))+86400;
		
	}else{
		$joining_date=$joining_date+((30-$joining_day)*86400);
	}
	
	
	//Check the status of the user
	$sql = "select account_status from user_master where username='$employee'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$account_status=$row[0];
	
	
	if ($account_status=="Obsolete"){
		$last_month=$leaving_date-(date("d",$leaving_date)*86400);
	}else{
		//Compute the unix time stamp as of the last day of previous month
		$last_month=mktime(0,0,0,date(m),date(d),date(y))-(date(d)*86400);
	}
	
	// Compute total annual leave
	$sql="select credit_value from leave_type where leave_category_id='1'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$diff=($last_month-$joining_date)/86400;
	$total_al=round($diff/30)*$row[0];
	
	if ($total_al<0){$total_al=0;}

        // Compute total casual leave
        $sql="select credit_value from leave_type where leave_category_id='2'";
        $result = mysql_query($sql);
        $row = mysql_fetch_row($result);


        //Compute Start of Year for computation of casual leave
        $fy_start=mktime(0,0,0,$lc_start,1,date(Y));

        if($joining_date>$fy_start){
                $total_cl=((($last_month-$joining_date)/86400)/30)*$row[0];
        }else{
                $total_cl=((($last_month-$fy_start)/86400)/30)*$row[0];
        }
		
		
	
	// Credit one month's casual leave at the beginning of the year for the last month of the previous year
	$lastyear = date("Y")-1;
	$clcredit_ly=mktime(0, 0, 0, 12, 1,$lastyear); 
	if (date(m)>=$lc_start && $joining_date<$clcredit_ly){
		$total_cl=$total_cl+$row[0];
	}
	
	// Fix for 2012
	if (date(Y)==2012 && $total_cl>=0){
		$total_cl=$total_cl+$row[0];
	}
    
	$cld = $total_cl - intval($total_cl);
	$cli = $total_cl - $cld;
	
	if($cld>0.2 && $cld<0.3){$cld=0.25;}
	if($cld>0.4 && $cld<0.5){$cld=0.5;}
	if($cld>0.7 && $cld<0.8){$cld=0.75;}
	if($cld>0.9 && $cld<1){$cld=1.0;}
	
	$total_cl=$cli+$cld;
	
	if ($total_cl<0){$total_cl=0;}
		
	// Compensatory Off Computation
	
	$total_col=0;
	$total_leave_days=0;$total_expiry=0;
	$expiry=0;
	$credit=0;
	$llfd=0;
	$balance_col=0;


	$sql="select work_date,off_no from leave_comp_off where status='1' and username='$employee' order by work_date";
	$result 	= mysql_query($sql);
	while($row  = mysql_fetch_row($result)){		
	$work_date=$row[0];$db_1=date("d M Y",$work_date);
	$off_no=$row[1];
	$credit=1;
	$total_col++;
		
		$comp_off_expiry=$work_date+($compensatory_leave_validity*86400);
			
		
		// Identify if corresponding leave has been taken
		$sub_sql="select from_date,to_date from leave_form where leave_category_id=4 and leave_status='1' and username='$employee' and ";
		$sub_sql.="from_date>'$work_date' and from_date<'$comp_off_expiry' and from_date>$llfd order by from_date limit 1";
		$sub_result 	= mysql_query($sub_sql);

		$sub_row  		= mysql_fetch_row($sub_result);
		$records		= mysql_num_rows($sub_result);
		
		$leave_days=0;
		if($records>0){
			$db_2=date("d M Y",$sub_row[0]);
			$llfd=$sub_row[0];

			$leave_days		=(($sub_row[1]-$sub_row[0])/86400)+1;
			$total_leave_days=$total_leave_days+$leave_days;

		}
		
		$expiry=0;
		if($records==0){

			$today=mktime();
			
			if($comp_off_expiry<=$today){$expiry=1;$total_expiry++;}

		}

		if($expiry==1 && $balance_col<0){
			$balance_col=$balance_col+$expiry;
		}else{
			$balance_col=($balance_col+$credit)-($leave_days+$expiry);
		}
		
		
		// Fetch next work_date
		$sub_sql		="select work_date from leave_comp_off where status='1' and username='$employee' and off_no>'$off_no' order by off_no limit 1";
		$sub_result 	= mysql_query($sub_sql);
		$sub_row  		= mysql_fetch_row($sub_result);
		$next_work_date	= $sub_row[0];$db_3=date("d M Y",$next_work_date);
		if(strlen($next_work_date)==0){$next_work_date=mktime();}
		
		
		// Identify if leave has been taken beyond expiry date and before next credit was available
		$acol=0;	
		$chk_sql="select from_date,to_date from leave_form where leave_category_id=4 and leave_status='1' and username='$employee' and ";
		$chk_sql.=" from_date<'$next_work_date' and from_date>=$comp_off_expiry and from_date>'$llfd' order by from_date";
		
		$chk_result 	= mysql_query($chk_sql);
		while($chk_row  = mysql_fetch_row($chk_result)){$acol=$acol+((($chk_row[1]-$chk_row[0])/86400)+1);}
		$balance_col=$balance_col-$acol;

	}
	if($balance_col<0){$balance_col=0;}
	
	
	
	
	// FETCH LEAVE RECORDS AND LIST

	$sql = "select * from leave_form where username='$employee' and leave_status!=3 order by from_date DESC";
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);
	$workflow=1;
	$al=0;
	$cl=0;
	$col=0;
	$lop=0;

	while ($row = mysql_fetch_row($result)) {
	
		$leave_days=(($row[3]-$row[2])/86400)+1;

		$sub_sql="select leave_category from leave_type where leave_category_id='$row[5]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		if($row[5]==1 && $row[6]=='1'){$al=$al+$leave_days;}
		if($row[5]==2 && $row[2]>=$fy_start && $row[6]=='1'){$cl=$cl+$leave_days;}
		if($row[5]==3 && $row[6]=='1'){$lop=$lop+$leave_days;}
		if($row[5]==4 && $row[6]=='1'){$col=$col+$leave_days;}
		
		if($row[6]==0){$status="Pending Approval";}
		if($row[6]==1){$status="Approved";}
		if($row[6]==2){$status="Rejected";}
		if($row[6]==3){$status="Cancelled";}

		$sub_sql="select first_name,last_name from user_master where username='$row[7]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		$fullname="$sub_row[0] $sub_row[1]";
		$approval_date=date("d M Y",$row[8]);
		if($row[6]==0){$fullname="";$approval_date="";}
}

	$balance_al=$total_al-$al;if($balance_al<0){$balance_al=0;}
	$balance_cl=$total_cl-$cl;if($balance_cl<0){$balance_cl=0;}

	$result=array($total_al,$total_cl,$total_col,$al,$cl,$lop,$balance_al,$balance_cl,$balance_col);
	return($result);
}
?>