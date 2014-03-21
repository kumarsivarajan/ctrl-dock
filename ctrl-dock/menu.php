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

<table border="0" cellpadding="0" cellspacing=0  width="1024" height="42" bgcolor="<?=$MENU_BGCOLOR;?>">
<tr>
	<td rowspan=2 valign=middle width=120 height=40 >
	<? if ($DASH==1){?>
		<a href=dash.php>
	<?}?>
	<img border=0 width=120px height=40px src=images/logo.png></img>
	<? if ($DASH==1){?>
		</a>
	<?}?>
	</td>
	
	<td style="text-align:right;width:100%;"><b>
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
	<a class=menulink target="rimmain" href="reports/index.php">Reports</a>
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
		<a class=menulink  target="rimmain"  href="settings/settings.php">Settings</a>
		&nbsp;	
	<?}?>
	
	<a target="rimmain" class=menulink href="http://www.ctrl-dock.org/help" target=_blank>Help</a>
	&nbsp;	
	</tr>
	<tr>
	<td style="text-align:right;line-height:12px;">
		<font style="font-family: Arial;font-size:9px;color:#EEEEEE;">logged in as <?=$User_Full_Name;?></font>
		&nbsp;
		<a style="text-decoration:none;font-family: Arial;font-size:9px;color:#FFFFFF;" target="_top" href="logout.php"><b>LOGOUT</b></a>
		&nbsp;	
	</td>
  </tr>
</table>
</html>
