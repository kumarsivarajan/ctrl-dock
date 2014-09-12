<center>
<? if (strlen($SELECTED)>0){?>
<table border=0 width=100% cellpadding="5" cellspacing="0">
  <tr bgcolor=#E5E5E5>
    <td width="75%" style="border-style: none; border-width: medium" align=left colspan=1>
		<a href="index.php" style="text-decoration: none;"><font face=Arial size=2 color=#CC0000><b>HOME > </b></font></a>
		<font face=Arial size=2 color=#CC0000><b><?=$SELECTED?></b></font>
	</td>
	<td width=25% class='reportdata' style='text-align:right;'>
		<a href="configure.php">CONFIGURE</a>
		&nbsp;&nbsp;
		<a href="javascript:history.back();">BACK</a>
	</td>
  </tr>
</table>
<?}?>
<br>
