<?
include("include/config.php");
include("include/db.php");	

// To display list of user defined quick links
?>
<table width=100% cellspacing=1 cellpadding=2 border=0>
<tr>
	<td class='reportdata' colspan=2 style='text-align: right;'>
	<b>QUICKLINKS</b>&nbsp;&nbsp;
<?
	$sql = "select * from quick_links order by link_priority,link_name";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_row($result)){
		$label=strtolower($row[2]);
		echo "<a href=$row[1] target=_blank style='text-decoration:none;color:#000000;'>$label</a>";
		echo "<font color=#0033CC size=2>&nbsp;|&nbsp;</font>";
	}
	
?>
	<?php if($TERMINAL == 1) { ?>
	<a href="dash/dash_terminal_access.php" style='text-decoration:none;color:#333333;'>terminal access</a>
	<?php } ?>
	</td>		
</tr>
</table>