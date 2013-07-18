<?
$check_service = "HRMS";
include("auth.php"); 
include("include/features.php"); 
?>

<html>

<head>
<base target="hrmsmain">
</head>

<body topmargin="0" leftmargin="0" bgcolor="#336699">

<table border="1" cellpadding="0" cellspacing=1 style="border-collapse: collapse; border-width: 0" bordercolor="#999999" width="100%" height="30" >
  <tr>
  
  	<td width="70%" style="border-style: none; border-width: medium" align="left">
	&nbsp;&nbsp;

	<a target="hrmsmain" style="text-decoration: none" href="hrms/summary.php">
	<font color="#F3F3F3" face="Arial" size="2"><b>Home</b></font></a>
	&nbsp;

	<? if (check_feature(1)){?>	
	<a target="hrmsmain" style="text-decoration: none" href="hrms/account_list.php?office_index=%&account_status=Active&account_type=%">
	<font color="#F3F3F3" face="Arial" size="2"><b>Staff Info</b></font></a>
	&nbsp;
	<?}?>

	<? if (check_feature(19)){?>	
	<a style="text-decoration: none" target="hrmsmain" href="eztickets/scp/ezlogin.php">
	<font color="#F3F3F3" face="Arial" size="2"><b>Tickets</b></font></a>
	&nbsp;
	<?}?>

	<? if (check_feature(14)){?>	
	<a style="text-decoration: none" target="hrmsmain" href="timesheets/index.php">
	<font color="#F3F3F3" face="Arial" size="2"><b>Timesheets</b></font></a>
	&nbsp;
	<?}?>

	<? if (check_feature(15)){?>	
	<a style="text-decoration: none" target="hrmsmain" href="xpens/dash.php">
	<font color="#F3F3F3" face="Arial" size="2"><b>Expenses</b></font></a>
	&nbsp;
	<?}?>

	<? if (check_feature(16)){?>	
	<a style="text-decoration: none" target="hrmsmain" href="reports/index.php">
	<font color="#F3F3F3" face="Arial" size="2"><b>Reports</b></font></a>
	&nbsp;
	<?}?>
	
	<? if (check_feature(17)){?>	
	<a style="text-decoration: none" target="hrmsmain" href="hrms/groups.php">
	<font color="#F3F3F3" face="Arial" size="2"><b>Profiles</b></font></a>
	&nbsp;
	<a style="text-decoration: none" target="hrmsmain" href="hrms/settings_1.php">
	<font color="#F3F3F3" face="Arial" size="2"><b>Settings</b></font></a>
	&nbsp;
	<?}?>
	</td>
	

	<td style="border-style: none; border-width: medium" align="right">
	<font face=Arial size=1 color="#F3F3F3"><i>Logged in as <?echo $User_Full_Name;?>&nbsp;&nbsp;</font>
	<a style="text-decoration: none" target="_top" href="logout.php">
	<font color="#F3F3F3" face="Arial" size="2"><i><b>Logout&nbsp;&nbsp;</b></font></a>

	</td>
  </tr>
</table>

  </body>

</html>
