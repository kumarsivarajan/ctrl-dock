<?include_once("auth.php");?>
<?include_once("include/features.php");?>

<center>
<body leftmargin=0 topmargin=0 bgcolor=#F3F3F3>
<table border=0 width=100% cellspacing=0 cellpadding=2>
<?if (check_feature(20)){?>
<tr>
	<td width=100% valign=top align=center>
		<br>
		<?include("dash/dash_quick_links.php");?>
		<br>
	</td>
</tr>
<?}?>

<?if($EZTICKET==1){?>
<tr>
	<td>
		<?include("dash/dash_open_tickets.php");?>
		<br>
	</td>
</tr>
<?}?>
	
<?if($NETWORK==1){?>
<tr>
	<td>
		<?include("dash/dash_nw_status.php");?>
		<br>
	</td>
</tr>
<?}?>

<?if (check_feature(51)){?>
<tr>
	<td>
		<?include("dash/dash_pending_rca.php");?>
		<br>
	</td>
</tr>
<?}?>

<?if (check_feature(52)){?>
<tr>
	<td>
		<?include("dash/dash_pending_pa.php");?>
		<br>
	</td>
</tr>
<?}?>


<?if($EZASSET==1){?>
<tr>	
	<td>
			<?include("dash/dash_sw_compliance.php");?>
			<?include("dash/dash_asset_summary.php");?>
	</td>
</tr>
<?}?>
	
</table>
<meta http-equiv="refresh" content="300"> 
</body>
