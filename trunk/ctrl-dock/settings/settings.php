<?

include("config.php");

if (!check_feature(41)){feature_error();exit;} 
?>

<table border="0" cellpadding="5" cellspacing=0 width="100%">
  <tr bgcolor=#EEEEEE>
		<td class=reportdata width=100>
			<b>MASTER DATA</b>&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
		<td class=reportdata style='text-align:right;'>
		<?if (check_feature(12)){?>
		<a target="rimmain" style="text-decoration: none" href="../settings/business_groups.php">	
		<b>Departments</b></a>
		<font face=Arial size=1>&nbsp;|&nbsp;</font>
		<?}?>
		<?if (check_feature(16)){?>
		<a target="rimmain" style="text-decoration: none" href="../settings/service_list.php">	
		<b>Services</b></a>
		<font face=Arial size=1>&nbsp;|&nbsp;</font>
		<?}?>
		<?if (check_feature(20)){?>
		<a target="rimmain" style="text-decoration: none" href="../settings/quicklinks.php">	
		<b>Quick Links</b></a>
		<font face=Arial size=1>&nbsp;|&nbsp;</font>
		<?}?>
		<?if (check_feature(24)){?>
		<a target="rimmain" style="text-decoration: none" href="../settings/tasks.php">	
		<b>Tasks</b></a>
		<font face=Arial size=1>&nbsp;|&nbsp;</font>
		<?}?>
		<?if (check_feature(27)){?>
		<a target="rimmain" style="text-decoration: none" href="../settings/escalations_1.php">	
		<b>Escalation</b></a>
		<font face=Arial size=1>&nbsp;|&nbsp;</font>
		<?}?>
		<?if (check_feature(29)){?>
		<a target="rimmain" style="text-decoration: none" href="../nw/index.php">	
		<b>Network</b></a>
		<font face=Arial size=1>&nbsp;|&nbsp;</font>
		<?}?>
		<a target="rimmain" style="text-decoration: none" href="../ezasset/add.php?item=Status">	
		<b>Asset Status</b></a>
		<font face=Arial size=1>&nbsp;|&nbsp;</font>
			
		<a target="rimmain" style="text-decoration: none" href="../ezasset/add.php?item=Category">	
		<b>Asset Categories</b></a>
		<font face=Arial size=1>&nbsp;|&nbsp;</font>

		<a target="rimmain" style="text-decoration: none" href="../ezasset/software_register.php">	
		<b>Software Register</b></a>
		<font face=Arial size=1>&nbsp;|&nbsp;</font>
		
		<a target="rimmain" style="text-decoration: none" href="../ezasset/asset_blacklist.php">	
		<b>Black-listed Assets</b></a>
</td></tr>
<tr bgcolor=#EEEEEE>
	<td class=reportdata width=100>
		<b>CONFIGURATION</b>&nbsp;&nbsp;&nbsp;&nbsp;
	</td>
		<td class=reportdata style='text-align:right;'>
			<?if (check_feature(34)){?>
			<a target="rimmain" style="text-decoration: none" href="../eztickets/scp/admin.php?t=settings">	
			<b>Tickets</b></a>
			<font face=Arial size=1>&nbsp;|&nbsp;</font>
			<?}?>
			<?if (check_feature(29)){?>
			<a target="rimmain" style="text-decoration: none" href="../settings/profile.php">	
			<b>Profiles</b></a>
			<font face=Arial size=1>&nbsp;|&nbsp;</font>
			<?}?>
			<a target="rimmain" style="text-decoration: none" href="../settings/system_config_1.php">	
			<b>General</b></a>
		</td>
	</tr>
</table>