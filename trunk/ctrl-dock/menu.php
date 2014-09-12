<?
include("auth.php");
include("include/css/default.css"); 
include("include/features.php"); 
include("include/version.php"); 
?>
<html>

<head>
<base target="rimmain">
</head>

<body topmargin="0" leftmargin="0">

<table border="0" cellpadding="3" cellspacing=0  width="100%" height="80px" bgcolor=#DDDDDD>
<tr>
	<td align=center height=42px bgcolor="<?=$MENU_BGCOLOR;?>" colspan=2>
	<? if ($DASH==1){?>
		<a target="_parent" href="frames.php">
	<?}?>
	<img border=0 width=120px height=40px src=images/logo.png></img>
	<? if ($DASH==1){?>
		</a>
	<?}?>
	</td>
</tr>
	<tr>
	<td style="text-align:left;line-height:12px;background-color:#BBBBBB">
		<font style="font-family: Arial;font-size:10.5px;color:#222222;"><?=substr($User_Full_Name,0,25);?></font>
	</td>
	<td style="text-align:left;line-height:12px;background-color:#BBBBBB" width=30>
		<a style="text-decoration:none;font-family: Arial;font-size:10px;color:#EEEEEE;" target="_top" href="logout.php">logout</a>
	</td>
	</tr>
</table>


<table border="0" cellpadding="5" cellspacing=0  width="100%" height="100%" bgcolor=#DDDDDD>
	<? if ($DASH==1){?>
	<tr>
	<td width=24><img border=0 src="images/menu_home.png"></a></td>
	<td><a class=menulink target="_parent" href="frames.php">Home</a></td>
	</tr>
	<?}?>

	<? if (check_feature(1)){?>
	<tr>
	<td width=24><img border=0 src="images/menu_users.png"></a></td>
	<td><a class=menulink target="rimmain" href="admin/account_query.php">Users</a></td>
	</tr>
	<?}?>

	<? if (check_feature(4)){?>	
	<tr>
	<td width=24><img border=0 src="images/menu_groups.png"></a></td>
	<td><a class=menulink target="rimmain" href="admin/groups.php">Groups</a></td>
	</tr>
	<?}?>

	<? if (check_feature(35)){?>	
	<tr>
	<tr>
	<td width=24><img border=0 src="images/menu_assets.png"></a></td>
	<td><a class=menulink target="rimmain" href="ezasset/searchasset.php">Asset Management</a></td>
	</tr>
	<?}?>

	<? if (check_feature(34)){?>	
	<tr>
	<td width=24><img border=0 src="images/menu_tickets.png"></a></td>
	<td><a class=menulink target="rimmain" href="eztickets/scp/ezlogin.php">Ticket Management</a></td>
	</tr>
	<?}?>

	<? if (check_feature(38)){?>	
	<tr>
	<td width=24><img border=0 src="images/menu_agencies.png"></a></td>
	<td><a class=menulink target="rimmain" href="admin/agency_list.php">Vendors / Customers</a></td>
	</tr>
	<?}?>
	
	<? if (check_feature(28)){?>
	<tr>
	<td width=24><img border=0 src="images/menu_broadcast.png"></a></td>
	<td><a class=menulink target="rimmain" href="broadcast/index.php">Broadcast</a></td>
	</tr>
	<?}?>

	
	<? if (check_feature(46)){?>
	<tr>
	<td width=24><img border=0 src="images/menu_sopbox.png"></a></td>
	<td><a class=menulink target="rimmain" href="documents/sopbox.php">SOPbox</a></td>
	</tr>
	<?}?>	
	
	<? if (check_feature(33)){?>
	<tr>
	<td width=24><img border=0 src="images/menu_documents.png"></a></td>
	<td><a class=menulink target="rimmain" href="documents/index.php">Documents</a></td>
	</tr>
	<?}?>
	
	<? if (check_feature(47) || check_feature(48) || check_feature(51)){?>
	<tr>
	<td width=24><img border=0 src="images/menu_rca.png"></a></td>
	<td><a class=menulink target="rimmain" href="rca/index.php">Root Cause Analysis</a></td>
	</tr>
	<?}?>
	
	<? if (check_feature(49) || check_feature(50) || check_feature(52)){?>	
	<tr>
	<td width=24><img border=0 src="images/menu_pa.png"></a></td>
	<td><a class=menulink target="rimmain" href="pa/index.php">Planned Activities</a></td>
	</tr>
	<?}?>
	
	
	<? if (check_feature(8)){?>
	<tr>
	<td width=24><img border=0 src="images/menu_offices.png"></a></td>
	<td><a class=menulink target="rimmain" href="settings/office_locations.php">Office Locations</a></td>
	</tr>
	<?}?>
	
	<? if (check_feature(44)){?>
	<tr>
	<td width=24><img border=0 src="images/menu_report.png"></a></td>
	<td><a class=menulink target="rimmain" href="reports/index.php">Reports</a></td>
	</tr>
	<?}?>
	
	<? if (check_feature(41)){?>
		<tr>
		<td width=24><img border=0 src="images/menu_settings.png"></a></td>
		<td><a class=menulink  target="rimmain"  href="settings/settings.php">Settings</a></td>
		</tr>
	<?}?>
	
	<tr>
	<td width=24><img border=0 src="images/menu_help.png"></a></td>
	<td><a target="rimmain" class=menulink href="http://www.ctrl-dock.org/help" target=_blank>Help</a></td>
	</tr>
	
	<tr>
	<td width=24><img border=0 src="images/menu_password.png"></a></td>
	<td><a target="rimmain" class=menulink href="password_1.php" target=_blank>Change Password</a></td>
	</tr>
	
	
	<tr><td height=100%><b>&nbsp;</td>
	
</table>
</html>
