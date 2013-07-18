<?include("config.php"); ?>



<center>
<h2>Service Profile for user : <?=$employee?></h2>

<table border=0 cellspacing=1 cellpadding=5 width=500>
<tr>
		<td class=reportheader width=300>Service</td>
		<td class=reportheader >Status</td>		
</tr>

<?
$sql = "select * from services order by service";
$result = mysql_query($sql);

$i=1;
$row_color="#FFFFFF";
while ($row = mysql_fetch_row($result)){
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
?>
	<tr bgcolor=<?echo $row_color; ?>>
		<td class=reportdata>&nbsp;<? echo $row[1]; ?></font></td>
		<td class=reportdata style='text-align:center;'>
<?
		$sub_sql="select count(*) from user_group a,groups b,group_service c where a.group_id=b.group_id and b.group_id=c.group_id and a.username='$employee' and c.service='$row[0]'";

		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		$status="Active";
		$font_color="#336600";
		if ($sub_row[0]==0){$status="Disabled";	$font_color="#CC0000";}
		echo "<font color=$font_color>&nbsp;&nbsp;$status</font>";
?>
		</td>
	</tr>
	<?	
	$i++;
 }
  
  
?>
</table>


