<?php 

include("config.php");
$employee=$account;

?>
<center>


<table border=0 width=100% cellspacing=0 cellpadding=0 align=center>
<tr height=20>
	<td colspan=2 bgcolor=#336699 align=center >
		<font face="Arial" color=#FFFFFF size="2" ><b>Organization</b></a>
	</td>
</tr>
<tr>
	<td class=reportdata valign="top" width=50%>
		<table border=1 width=100% cellspacing=1 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
		<?
			$sql="select a.username,b.first_name,b.last_name,a.title from user_organization a,user_master b where direct_report_to='$employee' and a.username=b.username and b.account_status!='Obsolete'  order by b.first_name";
			$result = mysql_query($sql);	
			$direct_record_count=mysql_num_rows($result);
			if ($direct_record_count){
				?>
				<tr height=40 bgcolor=#CCCCCC>
					<td colspan=4 align="center">
						<font face=Arial size=2><b>Direct Reports</b></font>
					</td>
				</tr>
				<tr>
						<td class=reportheader>Sl.No.</td>
						<td class=reportheader>Staff Name</td>
						<td class=reportheader>Title</td>
						<td class=reportheader width=50>Profile</td>
						
				</tr>
				<?
				$i=1;
				while ($row=mysql_fetch_row($result)){
					echo "<tr><td class=reportdata style='text-align:center'>$i</td>";
					echo "<td class=reportdata>$row[1] $row[2]</td>";
					echo "<td class=reportdata>$row[3] </td>";
					echo "<td style='text-align:center'><a href=profile.php?account=$row[0]><img src=images/profile.png border=0></a></td>";
				$i++;
				}		
			}
		?>
		</table>		
	</td>
	<td class=reportdata valign="top" width=50%>
		<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
	
		<?
			$sql="select a.username,b.first_name,b.last_name,a.title from user_organization a,user_master b where dot_report_to='$employee' and a.username=b.username  and b.account_status!='Obsolete' order by b.first_name";
			$result = mysql_query($sql);	
			$dotted_record_count=mysql_num_rows($result);
			if ($dotted_record_count){
				?>
				<tr height=40 bgcolor=#CCCCCC>
					<td colspan=4 align="center">
						<font face=Arial size=2><b>Dotted Line Reports</b></font>
					</td>
				</tr>
				<tr>
						<td class=reportheader>Sl.No.</td>
						<td class=reportheader>Staff Name</td>
						<td class=reportheader>Title</td>
						<td class=reportheader width=50>Profile</td>
						
				</tr>
				<?
			
				$i=1;
				while ($row=mysql_fetch_row($result)){
					echo "<tr><td class=reportdata style='text-align:center'>$i</td>";
					echo "<td class=reportdata>$row[1] $row[2]</td>";
					echo "<td class=reportdata>$row[3] </td>";
					echo "<td align=center style='text-align:center'><a href=profile.php?account=$row[0]><img src=images/profile.png border=0></a></td>";
				$i++;
				}		
			}
		?>
		</table>
	</td>
	</tr>
</table>
<center>
<?
if ($direct_record_count<=0 && $dotted_record_count<=0){
	echo "<h3>There are no direct / dotted line reports.</h3>";
}
?>
