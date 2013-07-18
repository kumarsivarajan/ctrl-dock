<?php 
include("config.php"); 
include("calendar.php");

$account=$_REQUEST["account"];

$sql = "select first_name,last_name,account_status,staff_number from user_master where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$first_name		=$row[0];
$last_name		=$row[1];
$account_status	=$row[2];
$staff_number	=$row[3];

$sql = "select title,direct_report_to,dot_report_to from user_organization where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$title 				= $row[0];
$direct_report_to 	= $row[1];
$dot_report_to		= $row[2];

?>

<center>
<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr>
	<td align=center>
		<b><font face="Arial" color="#CC0000" size="2">Manage User : <?=$first_name?> <?=$last_name;?>
	</td>
</tr>
</table>
<br>
<?
if ($account_status=="Obsolete"){
	echo "<br><center><font face=Arial size=2 color=#CC0000><b>The account is obsolete. Obsolete accounts should be updated under authorization only.</font></b>";
}
?>
<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr>
<td width=400 align=center valign=top bgcolor=#D9D9FF>
			<br>
			<?
			if (file_exists("../../data/user_photos/$account.jpg")) {
				?><img border=1 src="../../data/user_photos/<?=$account;?>.jpg" width=135 height=176><br><br><?
			} else {
				?><img border=1 src="../../data/user_photos/notavail.jpg"  width=135 height=176><br><br><?
			}
			?>
			<font face=Arial size=2 color=#666666>
			<table border=0 width=200>
			<tr><td class=reportdata>Username : </td><td class=reportdata><?=$account;?></td></tr>
			<tr><td class=reportdata>Staff No. : </td><td class=reportdata><?=$staff_number;?></td></tr>
			<tr><td class=reportdata colspan=2>&nbsp;</td></tr>
			<tr><td class=reportdata>Title : </td><td class=reportdata><?=$title;?></td></tr>
			<tr><td class=reportdata>Reporting To : </td><td class=reportdata><?=$direct_report_to;?></td></tr>
			<tr><td class=reportdata>Dotted Line To : </td><td class=reportdata><?=$dot_report_to;?></td></tr>
			</table>		
			</font>
</td>
<td width=600 align=center valign=top bgcolor=#E1E1E1>
		<table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor=#F9F9F9>

			<tr height=54>
				<td width=200 align=center><a href="edit_personal_information_1.php?account=<? echo $account; ?>"><img border=0 src=images/general_info.png></img></a></td>
				<td width=200 align=center><a href="edit_account_1.php?account=<? echo $account; ?>"><img border=0 src=images/contact.png></img></a></td>
				<td width=200 align=center><a href="edit_organization_1.php?account=<? echo $account; ?>"><img border=0 src=images/org.png></img></a></td>
			</tr>
			<tr>
				<td width=200 align=center><font face="Arial" size="2" color="#003366">General Info</td>
				<td width=200 align=center><font face="Arial" size="2" color="#003366">Contact</td>
				<td width=200 align=center><font face="Arial" size="2" color="#003366">Organization</td>
			</tr>
			<tr><td colspan=3>&nbsp;</td></tr>
			<tr height=54>
				<td width=200 align=center><a href="edit_financial_information_1.php?account=<? echo $account; ?>"><img border=0 src=images/finances.png></img></a></td>
				<td width=200 align=center><a href="vehicle.php?account=<? echo $account; ?>"><img border=0 src=images/vehicle.png></img></a></td>
				<td width=200 align=center><a href="travel.php?account=<? echo $account; ?>"><img border=0 src=images/travel.png></img></a></td>
			</tr>
			<tr>
				<td width=200 align=center><font face="Arial" size="2" color="#003366">Financial</td>
				<td width=200 align=center><font face="Arial" size="2" color="#003366">Vehicle</td>
				<td width=200 align=center><font face="Arial" size="2" color="#003366">Travel</td>
			</tr>
			<tr><td colspan=3>&nbsp;</td></tr>
			
			<tr height=54>
				<td width=200 align=center><a href="education.php?account=<? echo $account; ?>"><img border=0 src=images/education.png></img></a></td>
				<td width=200 align=center><a href="work_experience.php?account=<? echo $account; ?>"><img border=0 src=images/work_exp.png></img></a></td>
				<td width=200 align=center><a href="awards.php?account=<? echo $account; ?>"><img border=0 src=images/award.png></img></a></td>
			</tr>
			<tr>
				<td width=200 align=center><font face="Arial" size="2" color="#003366">Education</td>
				<td width=200 align=center><font face="Arial" size="2" color="#003366">Work Experience</td>
				<td width=200 align=center><font face="Arial" size="2" color="#003366">Awards</td>
			</tr>
			<tr><td colspan=3>&nbsp;</td></tr>
			
			<tr height=54>
				<td width=200 align=center><a href="leave.php?account=<? echo $account; ?>"><img border=0 src=images/leave.png></img></a></td>
				<td width=200 align=center><a href="../documents.php?account=<? echo $account; ?>"><img border=0 src=images/attachments.png></img></a></td>
				<td width=200 align=center><a href="family_list.php?account=<? echo $account; ?>"><img border=0 src=images/family.png></img></a></td>
			</tr>	
			<tr>
				<td width=200 align=center><font face="Arial" size="2" color="#003366">Leave</td>
				<td width=200 align=center><font face="Arial" size="2" color="#003366">Documents</td>
				<td width=200 align=center><font face="Arial" size="2" color="#003366">Family</td>
			</tr>
			<tr><td colspan=3>&nbsp;</td></tr>	
			
			<tr height=54>
				<td width=200 align=center><a href="staff_time_sheet.php?account=<? echo $account; ?>"><img border=0 src=images/timesheet.png></img></a></td>
				<td width=200 align=center>&nbsp;</td>
				<td width=200 align=center>&nbsp;</td>
			</tr>	
			<tr>
				<td width=200 align=center><font face="Arial" size="2" color="#003366">Timesheets</td>
				<td width=200 align=center><font face="Arial" size="2" color="#003366"></td>
				<td width=200 align=center><font face="Arial" size="2" color="#003366"></td>
			</tr>
			<tr><td colspan=3>&nbsp;</td></tr>	
		</table>
</td>
</tr>
</table>
