<?include_once("auth.php");?>
<center>
<body leftmargin=0 topmargin=0 bgcolor=#F3F3F3>
<table border=0 width=100% cellspacing=0 cellpadding=2>
<tr>
	<td width=100% valign=top align=center>
		<br>
		<?include("dash/dash_quick_links.php");?>
		<br>
		
<tr>
	<td>
	<?if($EZTICKET==1){?>
		<?include("dash/dash_open_tickets.php");?>
		<br>
	<?}?>	
	</td>
</tr>

<tr>
	<td>
		<?include("dash/dash_pending_rca.php");?>
		<br>
		<?include("dash/dash_pending_pa.php");?>
		<br>
	</td>
</tr>

<tr>
	<td>
	<?if($NETWORK==1){?>
		<?include("dash/dash_nw_status.php");?>
		<br>
	<?}?>
	</td>
</tr>
<tr>	
	<td>
	<?if($EZASSET==1){?>
			<?include("dash/dash_sw_compliance.php");?>
			<?include("dash/dash_asset_summary.php");?>
	<?}?>
	</td>
</tr>
	
</table>
<meta http-equiv="refresh" content="300"> 
</body>
