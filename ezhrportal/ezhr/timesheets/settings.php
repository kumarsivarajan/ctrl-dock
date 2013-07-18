<?php 
include_once("config.php");
include_once("header.php");
?>
<center>
<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
	<td class=reportheader><b>Business Group</font></b></td>
	<td class=reportheader colspan=2><b>Minimum Hrs</font></b></td>
</tr>
<?
$sql    ="select business_group_index,business_group from business_groups order by business_group";
$result = mysql_query($sql);
$i=1;
$row_color="#FFFFFF";
while ($row = mysql_fetch_row($result)){
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
	
	$business_group_index	=$row[0];
	$business_group			=$row[1];
	
	$sub_sql="SELECT min_hrs from timesheet_minhrs where business_group_index='$business_group_index'";
	$sub_result = mysql_query($sub_sql);
	if(mysql_num_rows($sub_result)>0){
		$sub_row 	= mysql_fetch_row($sub_result);
		$min_hrs	= $sub_row[0];
	}else{
		$min_hrs	= "160";
		$sub_sql="insert into timesheet_minhrs values ('$business_group_index','$min_hrs')";
		$sub_result = mysql_query($sub_sql);
	}
?>
	<tr>
		<td class=reportdata><?=$business_group;?></td>
		<form method=POST action='settings_confirm.php?index=<?=$business_group_index?>'>
		<td align=right width=40><input name="min_hrs"  value="<?=$min_hrs;?>" size="5" style="font-size: 8pt; font-family: Arial"></td>
		<td align=right width=40><input type=submit value="Commit" name="Submit" style="font-size: 8pt; font-family: Arial"></td>
		</form>
	</tr>
<?
}
