<?include("config.php"); ?>
<?$ACTION=" : Edit Expense Report"?>
<?include("ezq_expense_header.php"); ?>
<?
	$expense_id=$_REQUEST["expense_id"];
	$expense_desc=$_REQUEST["expense_desc"];
	$expense_date=$_REQUEST["expense_date"];
	$expense_date=date_to_int($expense_date);
	$bill_no=$_REQUEST["bill_no"];
	$expense_type_id=$_REQUEST["expense_type_id"];
	
	$qty=$_REQUEST["qty"];	
	$unit_price=$_REQUEST["unit_price"];	
	$total=$_REQUEST["total"];

	
	$sql = "select auth_reqd from expense_type where expense_type_id='$expense_type_id'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$auth_reqd=$row[0];
	
	if($auth_reqd==1){
		$sql = "SELECT auth_price FROM expense_authorization WHERE expense_type_id='$expense_type_id' AND username='$employee'";		
		$result = mysql_query($sql);
		$num_rows = mysql_num_rows($result);
		if($num_rows>0){
			$row = mysql_fetch_row($result);
			$auth_price=$row[0];
						
			if($total>$auth_price){
				$qty		=1;
				$unit_price	=$auth_price;					
				$total		=$auth_price;
			}
			
			$sql = "insert into expense_report_info (expense_id,expense_date,expense_type_id,description,qty,unit_price,total,bill_no) values";	
			$sql.= " ('$expense_id','$expense_date','$expense_type_id','$expense_desc','$qty','$unit_price','$total','$bill_no')";
			$result = mysql_query($sql);
			?><meta http-equiv="Refresh" content="0; URL=edit_expense.php?expense_id=<?echo $expense_id;?>"><?
		}else{			
			?>
			<h2>You are not authorized to claim this expense.<br><br>Kindly wait till you are returned to the previous screen.</h2>
			<meta http-equiv="Refresh" content="5; URL=edit_expense.php?expense_id=<?echo $expense_id;?>">
			<?
		}
	}else{
			$sql = "insert into expense_report_info (expense_id,expense_date,expense_type_id,description,qty,unit_price,total,bill_no) values";	
			$sql.= " ('$expense_id','$expense_date','$expense_type_id','$expense_desc','$qty','$unit_price','$total','$bill_no')";
			$result = mysql_query($sql);
			?><meta http-equiv="Refresh" content="0; URL=edit_expense.php?expense_id=<?echo $expense_id;?>"><?
	}
	
	


?>
