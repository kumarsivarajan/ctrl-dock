<head>
<script type="text/javascript">
function newPopup(url,w,h) {
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
	popupWindow = window.open(url,'popUpWindow','resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=no,width='+w+', height='+h+', top='+top+', left='+left);
}
</script>
 </head>

<?
include_once("config.php"); 
$policy_id	=$_REQUEST["id"];
$action		=$_REQUEST["action"];

if ($action=="new"){

	$leave_type_id	=$_REQUEST["leave_type_id"];
	$credit_value	=$_REQUEST["credit_value"];
	$credit_day		=$_REQUEST["credit_day"];

	$sql="insert into lm_leave_policy_details values ('$policy_id','$leave_type_id','$credit_value','$credit_day')";
	$result = mysql_query($sql);
}


if ($action=="del"){

	$leave_type_id	=$_REQUEST["leave_type_id"];
	
	$sql="delete from lm_leave_policy_details where policy_id='$policy_id' and leave_type_id='$leave_type_id'";
	$result = mysql_query($sql);

}

$sql="select policy_desc from lm_policy_master where policy_id='$policy_id'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
$policy_desc=$row[0];

?>
	<br>
	<form method="POST" action="leave_policies_details.php?action=new">
	<input name="id" value="<?=$policy_id;?>" type=hidden>
	<table border=0 width=100% cellpadding="5" cellspacing="0" >
	<tr>
		<td align=left colspan=4><h2>Leave Policy Information : <?=$policy_desc;?></h2></td>
	</tr>
	<tr>
		<td class=reportheader>Choose a Leave Type</td>
		<td class=reportheader>Credit value each month</td>
		<td class=reportheader>Day of month to credit</td>
		<td class=reportheader></td>
	</tr>
	
	<tr>
		<td style="text-align:center">
			<select size=1 name="leave_type_id" class=formselect>
			<?php
					$sql = "select leave_type_id,leave_type from lm_leave_type_master order by leave_type"; 	
					$result = mysql_query($sql);
					while ($row = mysql_fetch_row($result)) {
						echo "<option value=$row[0]>$row[1]</option>";
				}
			?>
			</select>
		</td>
		<td style="text-align:center"><input name="credit_value" style="width:40px" class=forminputtext></td>
		<td style="text-align:center"><input name="credit_day" style="width:40px" class=forminputtext></td>
		<td style="text-align:center"><input type=submit value="Add" name="Submit" class=forminputbutton></td>
	</tr>
	</table>
	</form>
	
	<center>
	<br>
<?

	$sql = "select b.leave_type,a.credit_value,a.credit_day,a.leave_type_id from lm_leave_policy_details a,lm_leave_type_master b";
	$sql.=" where a.leave_type_id=b.leave_type_id and a.policy_id='$policy_id'";
	$result = mysql_query($sql);
	$num_rows=mysql_num_rows($result);
	if ($num_rows>0){
		?>		
		<table class="reporttable" cellspacing=1 cellpadding=5 width=100%>
		<tr>	
		<td class="reportheader">Leave Type</td>
		<td class="reportheader" width=100>Credit Value</td>
		<td class="reportheader" width=100>Credit Day</td>
		<td class="reportheader" width=60>Manage</td>
		</tr>
		<?
	
	$i=1;
	$row_color="#FFFFFF";
	while ($row = mysql_fetch_row($result)){
			if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
			echo "<tr bgcolor=$row_color>";			
			echo "<td class=reportdata >$row[0]</td>";
			echo "<td class=reportdata >$row[1]</td>";
			echo "<td class=reportdata >$row[2]</td>";
			echo "<td class=reportdata width=60 style='text-align: center;'><a href='leave_policies_details.php?id=$policy_id&leave_type_id=$row[3]&action=del'><img src=images/delete.gif border=0></img></a></td>";
			echo "</tr>";
			$i++;
	}
	echo "</table>";
	}

?>