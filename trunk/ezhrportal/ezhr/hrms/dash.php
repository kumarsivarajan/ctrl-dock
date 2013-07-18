<?php 
include("config.php"); 

$today=mktime();
?>
<table border=0 cellspacing=0 cellpadding=10 width=100% height=100%>
<tr>
	<td bgcolor=#E5E5E5 width=25% valign=top>
<?

$sql = "SELECT COUNT(*) FROM user_master WHERE account_status='Active'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$head_count=$row[0];

$sql = "SELECT COUNT(*) FROM user_master WHERE account_status='Active' AND account_type='employee'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$employee_count=$row[0];

$sql = "SELECT COUNT(*) FROM user_master WHERE account_status='Active' AND account_type='contingent_staff'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$contingent_staff_count=$row[0];

$sql= "SELECT COUNT(DISTINCT country) FROM office_locations";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$office_locations=$row[0];


$sql= "SELECT COUNT(agency_index) FROM agency where type='client'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$clients=$row[0];

$sql= "SELECT COUNT(agency_index) FROM agency where type='vendor' and agency_index!=1";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$vendors=$row[0];

echo "<font face=Verdana size=1 color=#003366><b>&nbsp;SUMMARY<b></font><br><br>";
	
	echo "<table border=0 cellspacing=0 cellpadding=3 width=90%>";
	
	echo "<tr><td>
		  <font face=Verdana size=1 color=black><b>Office Locations  </b></font>
		  </td><td>
		  <font face=Verdana size=1 color=black>$office_locations</font>
		  </td></tr>";
	echo "<tr><td colspan=2>&nbsp;</td></tr>";
	echo "<tr><td>
		  <font face=Verdana size=1 color=black><b>Head Count  </b></font>
		  </td><td>
		  <font face=Verdana size=1 color=black>$head_count</font>
		  </td></tr>";
	echo "<tr><td>
		  <font face=Verdana size=1 color=black><b>Employees  </b></font>
		  </td><td>
		  <font face=Verdana size=1 color=black>$employee_count</font>
		  </td></tr>";
		  
	echo "<tr><td>
		  <font face=Verdana size=1 color=black><b>Contingent Staff  </b></font>
		  </td><td>
		  <font face=Verdana size=1 color=black>$contingent_staff_count</font>
		  </td></tr>";
	echo "<tr><td colspan=2>&nbsp;</td></tr>";
	echo "<tr><td>
		  <font face=Verdana size=1 color=black><b>Clients </b></font>
		  </td><td>
		  <font face=Verdana size=1 color=black>$clients</font>
		  </td></tr>";		
	echo "<tr><td>
		  <font face=Verdana size=1 color=black><b>Vendors </b></font>
		  </td><td>
		  <font face=Verdana size=1 color=black>$vendors</font>
		  </td></tr>";
	echo "</table>";
?>
</td>
<td bgcolor=#C0C0C0 width=75% align=left valign=top>
<font face=Verdana size=1 color=#003366><b>UPCOMING LEAVE<b></font>
<br>
<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
	<td bgcolor=#3366CC align=center width=150><font color=white  face=Verdana size=1><b>Staff </font></b> </td>
	<td bgcolor=#3366CC align=center ><font color=white  face=Verdana size=1><b>Title / Business Group </font></b></td>	
	<td bgcolor=#3366CC align=center ><font color=white  face=Verdana size=1><b>Leave From</font></b></td>	
	<td bgcolor=#3366CC align=center ><font color=white  face=Verdana size=1><b>Leave To</font></b></td>		
	<td bgcolor=#3366CC align=center ><font color=white  face=Verdana size=1><b>Days</font></b></td>
	<td bgcolor=#3366CC align=center ><font color=white  face=Verdana size=1><b>Type      </font></b></td>
	<td bgcolor=#3366CC align=center ><font color=white  face=Verdana size=1><b>Status    </font></b></td>
</tr>
<?
	$sql="SELECT a.username,b.first_name,b.last_name,a.from_date,a.to_date,a.leave_category_id,a.leave_status FROM leave_form a, user_master b WHERE from_date>='$today' and a.username=b.username and (leave_status='0' or leave_status='1') order by from_date";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_row($result)){
		if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
		
		$agencies="";
		$sub_sql="SELECT title from user_organization where username='$row[0]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		$title=$sub_row[0];
		
		$sub_sql="SELECT b.business_group from user_master a, business_groups b where a.business_group_index=b.business_group_index and a.username='$row[0]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		
		$business_group=$sub_row[0];
		
		$sub_sql="SELECT b.business_group from user_master a, business_groups b where a.business_group_index=b.business_group_index and a.username='$row[0]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		
		
		if($row[6]==0){$status="Pending Approval";}
		if($row[6]==1){$status="Approved";}
		if($row[6]==2){$status="Rejected";}
		if($row[6]==3){$status="Cancelled";}
		
		$sub_sql="SELECT leave_category from leave_type where leave_category_id='$row[5]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		$leave_type=$sub_row[0];
		
		$no_days=($row[4]-$row[3])/84600;
		if($no_days<0){$no_days=0;}
		$no_days=$no_days+1;
		$no_days=round($no_days,0);
		
?>
		<tr bgcolor=<?echo $row_color; ?>>		
		<td align=left><font color=#003366 face=Verdana size=1>&nbsp;<? echo "$row[1] $row[2]";?></font></td>
		<td align=left><font color=#003366 face=Verdana size=1>&nbsp;<? echo "$title<br>&nbsp;$business_group";?></font></td>
		
		<td align=center><font color=#003366 face=Verdana size=1><? echo date("d M Y",$row[3]);?></font></td>		
		<td align=center><font color=#003366 face=Verdana size=1><? echo date("d M Y",$row[4]);?></font></td>		
		<td align=center><font color=#003366 face=Verdana size=1>&nbsp;<? echo "$no_days";?></font></td>
		<td align=left><font color=#003366 face=Verdana size=1>&nbsp;<? echo $leave_type;?></font></td>
		<td align=left><font color=#003366 face=Verdana size=1>&nbsp;<? echo $status;?></font></td>

		</tr>
		
<?

		$i++;
	}

?>
</table>
	
	

</tr>

	</td>
	</tr>
</table>