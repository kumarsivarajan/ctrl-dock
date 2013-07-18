<?include("config.php"); ?>
<?include("calendar.php"); ?>
<?$ACTION=" : Edit Expense Report"?>
<?include("ezq_expense_header.php"); ?>
<?
	$expense_id=$_REQUEST["expense_id"];
	$expense_desc=$_REQUEST["expense_desc"];
	$bill_no=$_REQUEST["bill_no"];
	$expense_type_id=$_REQUEST["expense_type_id"];
	
	$expense_edit=1;
?>
<script language="JavaScript" type="text/javascript">
function onsubmitform(){
   document.expense_info.action ="expense_submit.php";
   return true;
}

function compute_total(){
	var unit_price = document.getElementById("unit_price");
	var qty		   = document.getElementById("qty");	
	var total	   = unit_price.value*qty.value;
	document.getElementById("total").value= total;	
}
</script>

<br><br>
<center>

<form name="expense_info" id=expense_info onsubmit="return onsubmitform();">
<input type=hidden name=expense_id value='<?echo $expense_id;?>'>
<?
	$sql = "select expense_desc from expense_report where expense_id='$expense_id'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$expense_label=$row[0];
?>

<table border=0 cellpadding=4 cellspacing=0 width=98% bgcolor=#EEEEEE>
<tr>
	<td colspan=2 bgcolor=#BBBBBB><font color=white face=Arial size=2><b>&nbsp;<?echo $expense_label;?> : Add a New Expense Record</font></b></td>
</tr>
<tr>
	<td><font color=#4D4D4D face=Arial size=2><b>Type of Expense </font></b></td>
	<td align=right>
			<select size=0 name=expense_type_id class=formselect id=expense_type_id onchange=document.forms["expense_info"].submit();>
			
			<?php				
				if($expense_type_id>0){
					$sql = "select expense_type_id,expense_type from expense_type where expense_type_id='$expense_type_id'";
					$result = mysql_query($sql);
					$row = mysql_fetch_row($result);
					echo "<option value='$row[0]'>$row[1]</option>";
				}
				echo "<option value=''></option>";
			    $sql = "select expense_type_id,expense_type from expense_type order by expense_type";
				$result = mysql_query($sql);
				while ($row = mysql_fetch_row($result)) {
		        		echo "<option value='$row[0]'>$row[1]</option>";
				}
			?>
		</select>
	</td>
</tr>
<tr>
	<td><font color=#4D4D4D  face=Arial size=2><b>Expense Date</font></b></td>
	<td  align=right><input class=forminputtext style="width:100" name=expense_date readonly id="expense_date" onclick="fPopCalendar('expense_date')"></td>
</tr>
<tr>
	<td><font color=#4D4D4D  face=Arial size=2><b>Bill No</font></b></td>
	<td  align=right><input class=forminputtext style="width:100" name='bill_no' value='<?echo $bill_no;?>'></td>	
</tr>
</tr>
	<td><font color=#4D4D4D  face=Arial size=2><b>Description</font></b></td>
	<td  align=right><input class=forminputtext style="width:250" name='expense_desc' value='<?echo $expense_desc;?>'></td>	
</tr>

<?
	$sql = "select uom,unit_price from expense_type where expense_type_id='$expense_type_id'";	
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$uom=$row[0];
	$unit_price=$row[1];	
?>

<tr>
	<td><font color=#4D4D4D  face=Arial size=2><b>Quantity</font></b></td>
	<td  align=right><input class=forminputtext style="width:50" name=qty id=qty onchange="compute_total()"></td>
</tr>
<tr>
	<td><font color=#4D4D4D  face=Arial size=2><b>Unit Price(<?=$CURRENCY;?>)</font></b></td>
	<td  align=right><input class=forminputtext style="width:50" name=unit_price id=unit_price value='<?echo $unit_price;?>' <?if($unit_price!="0"){echo "readonly";}?> onchange=compute_total()></td>	
</tr>
<tr>
	<td><font color=#4D4D4D  face=Arial size=2><b>Total (<?=$CURRENCY;?>)</font></b></td>
	<td  align=right><input class=forminputtext style="width:50" name=total id=total readonly></td>	
</tr>
<tr><td bgcolor=white colspan=2><font face=Arial size=2 color=White></td></tr>
<tr>
	<td colspan=2 align=center><input type="submit" name="operation" onclick="document.pressed=this.value" value="Save Expense" class='forminputbutton' /></td>	
</tr>
</table>

</form>

<?include("expense_summary.php"); ?>
