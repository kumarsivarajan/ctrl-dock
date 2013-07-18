<?include_once("../auth.php");?>
<center>
<table border=0 cellpadding=5 cellspacing=0 width=98% height=100>
	<tr>
		<td width=600 align=left valign=top><font face=Arial size=2><b><br><?echo $COMPANY;?></b><br><?echo $ADDRESS;?></td>
		<td align=right valign=top><img src=../<?=$SITE_LOGO_PATH;?> border=0></img></td>
	</tr>	
	<tr>
		<td width=600 bgcolor=#AAAAAA><font face=Arial size=3 color=white><b>EXPENSE REPORT</font></td>
		<td bgcolor=#AAAAAA align=right>
		<img src=images/print.gif></img>&nbsp;<a href=javascript:window.print();><font face=Arial size=1 color=white><b>PRINT</b></font></a></font>
		</td>
	</tr>
<br>
<?include_once("expense_summary.php");?>