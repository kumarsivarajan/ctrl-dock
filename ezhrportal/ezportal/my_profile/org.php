<?
include("config.php");
?>
<table border=0 width=98% height=30 cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
	<td bgcolor=#999966><font face=Arial size=2 color=white><b><i>&nbsp;&nbsp;Organization</b></td>
	<td bgcolor=#999966 width=60% align=right>
		<a href=staff_time_sheet.php><font face=Arial size=1 color=white><b>ALL TIME SHEETS</b></a></font>
	</td>
	
</table>
<center>
<table border=0 width=98%>
<tr height=30 bgcolor=#CCCCCC>
	<td width=50% align="center">
	<font face=Arial size=2><b>
	Direct Reports
	</b>
	</td>
	<td width=50% align="center">
	<font face=Arial size=2><b>
	Dotted Line Reports
	</b>
	</td>
</tr>
<tr>
	<td class=reportdata valign="top">
		<table border=1 width=100% cellspacing=0 cellpadding=1 style="border-collapse: collapse" bordercolor="#E5E5E5">
		<tr>
			<td class=reportheader width=40>Sl.No.</td>
			<td class=reportheader>Staff Name</td>
			<td class=reportheader>Title</td>
			<td class=reportheader width=50>Profile</td>
			<td class=reportheader width=50>Timesheets</td>			
		</tr>
		<?
			$sql="select a.username,b.first_name,b.last_name,a.title  from user_organization a,user_master b where direct_report_to='$employee' and a.username=b.username and b.account_status!='Obsolete' order by b.first_name";
			$result = mysql_query($sql);	
			$direct_record_count=mysql_num_rows($result);
			if ($direct_record_count){		
				$i=1;
				while ($row=mysql_fetch_row($result)){
					echo "<tr><td class=reportdata style='text-align:center'>$i</td>";
					echo "<td class=reportdata>$row[1] $row[2]</td>";
					echo "<td class=reportdata>$row[3] </td>";
					echo "<td class=reportdata style='text-align:center'><a href=../directory/profile.php?account=$row[0]><img height=16 width=16 src=images/profile.png border=0></a></td>";
					echo "<td class=reportdata style='text-align:center'><a href='../my_profile/staff_time_sheet.php?account=$row[0]'><img height=16 width=16 src=images/timesheets.png border=0></a></td>";
				$i++;
				}		
			}
		?>
		</table>		
	</td>
	<td class=reportdata valign="top">
		<table border=1 width=100% cellspacing=0 cellpadding=1 style="border-collapse: collapse" bordercolor="#E5E5E5">
		<tr>
			<td class=reportheader>Sl.No.</td>
			<td class=reportheader>Staff Name</td>
			<td class=reportheader>Title</td>
			<td class=reportheader width=50>Profile</td>	
			<td class=reportheader width=50>Timesheets</td>			
		</tr>
		
		<?
			$sql="select a.username,b.first_name,b.last_name,a.title from user_organization a,user_master b where dot_report_to='$employee' and a.username=b.username and b.account_status!='Obsolete' order by b.first_name";
			$result = mysql_query($sql);	
			$dotted_record_count=mysql_num_rows($result);
			if ($dotted_record_count){		
				$i=1;
				while ($row=mysql_fetch_row($result)){
					echo "<tr><td class=reportdata style='text-align:center'>$i</td>";
					echo "<td class=reportdata>$row[1] $row[2]</td>";
					echo "<td class=reportdata>$row[3] </td>";
					echo "<td class=reportdata style='text-align:center'><a href=../directory/profile.php?account=$row[0]><img height=16 width=16 src=images/profile.png border=0></a></td>";
					echo "<td class=reportdata style='text-align:center'><a href='../my_profile/staff_time_sheet.php?account=$row[0]'><img height=16 width=16 src=images/timesheets.png border=0></a></td>";
					$i++;
				}
			}
		?>
		</table>
	</td>
	</tr>
</table>
<center>
<iframe name="bottom" src="" scrolling="auto" align="center" border="1" frameborder="0" width=98% height=600>
</iframe>
<?
if ($direct_record_count<=0 && $dotted_record_count<=0){
	echo "<h3>You have no staff reporting into you.</h3>";
}
?>
