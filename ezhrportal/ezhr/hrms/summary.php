<?php 
include("config.php"); 

$today=mktime();
?>
<table border=0 width=100% cellspacing=5 cellpadding=0>
	<tr>
		<td align=left valign=top>		
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

				$sql= "SELECT COUNT(DISTINCT country) FROM office_locations where showhide='1'";
				$result = mysql_query($sql);
				$row = mysql_fetch_row($result);

				$office_locations=$row[0];


				$sql= "SELECT COUNT(a.agency_index) FROM agency a, agency_status b where a.agency_index=b.agency_index and a.type='client' and a.agency_index!=1 and b.status='Active'";
				$result = mysql_query($sql);
				$row = mysql_fetch_row($result);

				$clients=$row[0];

				$sql= "SELECT COUNT(a.agency_index) FROM agency a where a.type='vendor' and a.agency_index!=1";
				$result = mysql_query($sql);
				$row = mysql_fetch_row($result);

				$vendors=$row[0];

		?>
			<table class=reporttable border=0 width=100% height=90 cellspacing=1 cellpadding=5>
			<tr>
				<td bgcolor=#666666 align=center width=16%><font face=Arial size=1 color=white>LOCATIONS<br><br><font face=Arial size=5 color=#BFDFFF><b><?=$office_locations;?></td>
				<td bgcolor=#666666 align=center width=16%><font face=Arial size=1 color=white>HEAD COUNT<br><br><font face=Arial size=5 color=#BFDFFF><b><?=$head_count;?></td>
				<td bgcolor=#666666 align=center width=17%><font face=Arial size=1 color=white>EMPLOYEES<br><br><font face=Arial size=5 color=#BFDFFF><b><?=$employee_count;?></td>
				<td bgcolor=#666666 align=center width=17%><font face=Arial size=1 color=white>CONTINGENT STAFF<br><br><font face=Arial size=5 color=#BFDFFF><b><?=$contingent_staff_count;?></td>
				<td bgcolor=#666666 align=center width=17%><font face=Arial size=1 color=white>CLIENTS<br><br><font face=Arial size=5 color=#BFDFFF><b><?=$clients;?></td>
				<td bgcolor=#666666 align=center width=17%><font face=Arial size=1 color=white>VENDORS<br><br><font face=Arial size=5 color=#BFDFFF><b><?=$vendors;?></td>
			</tr>
			</table>
			</td>
	</tr>
	<tr>
		<td align=left colspan=2 valign=top>
		
			<table class=reporttable border=0 width=100% cellspacing=0 cellpadding=0>
			<tr>
				<td height=20 colspan=1 bgcolor=#0066CC align=left><font face=Arial size=2 color=white><b>&nbsp;UPCOMING LEAVE</b></td>
				<td height=20 colspan=6 bgcolor=#0066CC align=right><font face=Arial size=1 color=white><i>Click on the Staff Name to show / hide the agencies being managed&nbsp;</i></td>
			</tr>
			</table>

			<table class=reporttable border=0 width=100% cellspacing=0 cellpadding=2>
			<tr>
				<td class=reportheader width=150><b>Staff </b> </td>
				<td class=reportheader width=150><b>Title</b></td>
				<td class=reportheader width=120><b>Location </b></td>
				<td class=reportheader width=70><b>Applied</b></td>	
				<td class=reportheader width=70><b>From</b></td>	
				<td class=reportheader width=70><b>To</b></td>	
				<td class=reportheader width=40><b>Days</b></td>
				<td class=reportheader width=70><b>Approved</b></td>			
				<td class=reportheader width=40><b>Status </b></td>
			</tr>
	<?
		$sql="SELECT a.username,b.first_name,b.last_name,a.from_date,a.to_date,a.leave_category_id,a.leave_status,b.office_index,a.application_date,a.approval_date FROM leave_form a, user_master b WHERE to_date>='$today' and a.username=b.username and (leave_status='0' or leave_status='1') order by from_date";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_row($result)){
			if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
			
			$agencies="";
			$sub_sql="SELECT title from user_organization where username='$row[0]'";
			$sub_result = mysql_query($sub_sql);
			$sub_row = mysql_fetch_row($sub_result);
			$title=$sub_row[0];
			
			$sub_sql="SELECT b.name from agency_resource a,agency b where a.agency_index=b.agency_index and username='$row[0]'";
			$sub_result = mysql_query($sub_sql);
			while ($sub_row = mysql_fetch_row($sub_result)){
					$agencies=$agencies."\\n".$sub_row[0];
			}
			
			$sub_sql="SELECT b.name FROM agency_manager a,agency b WHERE a.agency_index=b.agency_index AND a.prim_manager='$row[0]' ORDER BY b.name";
			$sub_result = mysql_query($sub_sql);
			while ($sub_row = mysql_fetch_row($sub_result)){
					$agencies=$agencies."\\n".$sub_row[0];
			}

			$sub_sql="SELECT b.business_group from user_master a, business_groups b where a.business_group_index=b.business_group_index and a.username='$row[0]'";
			$sub_result = mysql_query($sub_sql);
			$sub_row = mysql_fetch_row($sub_result);
			
			$business_group=$sub_row[0];


			
			$sub_sql="SELECT country from office_locations where office_index='$row[7]'";
			$sub_result = mysql_query($sub_sql);
			$sub_row = mysql_fetch_row($sub_result);
			
			$location=$sub_row[0];
			
			$sub_sql="SELECT b.business_group from user_master a, business_groups b where a.business_group_index=b.business_group_index and a.username='$row[0]'";
			$sub_result = mysql_query($sub_sql);
			$sub_row = mysql_fetch_row($sub_result);
			
			
			if($row[6]==0){$status="PA";}
			if($row[6]==1){$status="A";}
			if($row[6]==2){$status="R";}
			if($row[6]==3){$status="C";}
			
			$sub_sql="SELECT leave_category from leave_type where leave_category_id='$row[5]'";
			$sub_result = mysql_query($sub_sql);
			$sub_row = mysql_fetch_row($sub_result);
			$leave_type=$sub_row[0];
			
			$no_days=($row[4]-$row[3])/84600;
			if($no_days<0){$no_days=0;}
			$no_days=$no_days+1;
			$no_days=round($no_days,0);
			
			$agencies="Agencies Managed\\n\\n".$agencies;
			
	?>
			<tr bgcolor=<?echo $row_color; ?>>		
			<td class=reportdata ONCLICK="javascript:alert('<?echo $agencies;?>');"><? echo "$row[1] $row[2]";?></td>
			<td class=reportdata ><?=$title;?><br><?=$business_group;?></td>	
			<td class=reportdata ><?=$location;?></td>
			<td class=reportdata style='text-align:center'><?if (strlen($row[8])>0){echo date("d M y",$row[8]);}?></td>		
			<td class=reportdata style='text-align:center'><?=date("d M y",$row[3]);?></td>		
			<td class=reportdata style='text-align:center'><?=date("d M y",$row[4]);?></td>
			<td class=reportdata style='text-align:center'><?=$no_days;?></td>
			<td class=reportdata style='text-align:center'><?if (strlen($row[9])>0){echo date("d M y",$row[9]);}?></td>		
			<td class=reportdata style='text-align:center'><b><?=$status;?></b></td>
			</tr>	
	<?
			$i++;
		}
	?>
			<tr>
				<td class=reportdata style='text-align:right' colspan=9>PA : Pending Approval&nbsp;&nbsp;A : Approved&nbsp;&nbsp;R : Rejected&nbsp;&nbsp;C : Cancelled
				</td>
			</tr>
			</table>
		</td>
	</tr>
</table>