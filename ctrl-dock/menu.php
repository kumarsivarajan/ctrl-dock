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

<body topmargin="0" leftmargin="0" bgcolor=#336699>

<table width=1024 height=46 border=0 cellspacing=0 cellpadding=0 style="border-collapse: collapse" background="images/bnr1_bg.png">
<tr>
	<td width=5 >&nbsp;</td>
	<td width=100  valign=middle align=left><img src=images/dock.png border=0></img></td>
	<td align=left valign=bottom><font face="Arial" size=1 color=#1F4A76><?=$VERSION;?>&nbsp;</td>
	<td width=100  valign=middle align=right><img src=images/logo.png border=0></img></td>
	<td width=5 >&nbsp;</td>
</tr>
</table>

<table border="0" cellpadding="0" cellspacing=0  width="100%" height="30">
<tr>
	<td class=mainmenu style="width:78%">
	&nbsp;
	
	<? if ($DASH==1){?>
	<a class=menulink target="rimmain" href="dash.php">Home</a>
	&nbsp;
	<?}?>

	<? if (check_feature(1)){?>	
	<a class=menulink target="rimmain" href="admin/account_query.php">Users</a>
	&nbsp;
	<?}?>

	<? if (check_feature(4)){?>	
	<a class=menulink target="rimmain" href="admin/groups.php">Groups</a>
	&nbsp;
	<?}?>

	<? if (check_feature(35)){?>	
	<a class=menulink target="rimmain" href="ezasset/searchasset.php">Assets</a>
	&nbsp;
	<?}?>

	<? if (check_feature(34)){?>	
	<a class=menulink target="rimmain" href="eztickets/scp/ezlogin.php">Tickets</a>
	&nbsp;
	<?}?>

	<? if (check_feature(38)){?>	
	<a class=menulink target="rimmain" href="admin/agency_list.php">Agencies</a>
	&nbsp;
	<?}?>
	
	<? if (check_feature(8)){?>	
	<a class=menulink target="rimmain" href="settings/office_locations.php">Offices</a>
	&nbsp;
	<?}?>

	<? if (check_feature(28)){?>
	<a class=menulink target="rimmain" href="broadcast/index.php">Broadcast</a>
	&nbsp;
	<?}?>
	<? if (check_feature(44)){?>
	<a class=menulink target="rimmain" href="reports/search.php">Reports</a>
	&nbsp;
	<?}?>
	<? if (check_feature(46)){?>
	<a class=menulink target="rimmain" href="documents/sopbox.php">Sopbox</a>
	&nbsp;
	<?}?>	
	
	<? if (check_feature(33)){?>
	<a class=menulink target="rimmain" href="documents/index.php">Documents</a>
	&nbsp;
	<?}?>
	
	<? if (check_feature(47) || check_feature(48) || check_feature(51)){?>
	<a class=menulink target="rimmain" href="rca/index.php">RCA</a>
	&nbsp;
	<?}?>
	
	<? if (check_feature(49) || check_feature(50) || check_feature(52)){?>
	<a class=menulink target="rimmain" href="pa/index.php">PA</a>
	&nbsp;
	<?}?>

	<? if (check_feature(41)){?>
	<a class=menulink target="rimmain" href="settings/settings.php">Settings</a>
	&nbsp;	
	<?}?>
	<a target="rimmain" class=menulink href="http://www.ctrl-dock.org/help" target=_blank>Help</a>
	</td>
	<td class=mainmenu style="text-align:right;width:22%">
		<font face=Arial size=1 color="#F3F3F3">logged in as <?echo $User_Full_Name;?></font>
		&nbsp;
		<a style="text-decoration: none" target="_top" href="logout.php">
		<font color="#F3F3F3" face="Arial" size="1"><b>Logout&nbsp;</font></a>
	</td>
  </tr>
</table>
</html>
