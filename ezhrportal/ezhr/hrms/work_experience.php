<?php 
include("config.php"); 
if (!check_feature(8)){feature_error();exit;}

$account=$_REQUEST["account"];

$sql = "select first_name,last_name,account_status from user_master where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$first_name		=$row[0];
$last_name		=$row[1];
$account_status	=$row[2];
?>

<center>
<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr>
	<td align=left>
		<b><font face="Arial" color="#CC0000" size="2">Work Experience for : <?=$first_name?> <?=$last_name;?>
	</td>
	<td align=right>
		<a href="user_home.php?account=<?=$account?>"><font face="Arial" color="#336699" size="1"><b>BACK</b></font></a>
	</td>
</tr>
</table>
<br>
<table border=0 width=100% cellspacing=0 cellpadding=3 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
		<td class=reportheader>Organization</td>
		<td class=reportheader width=100>From</td>
		<td class=reportheader width=100>To</td>
		<td class=reportheader width=100>Experience (Yrs.Mths)</td>
		<td class=reportheader width=20></td>
</tr>
<?php
$total_experience=0;
$sql = "select * from user_experience where username='$account' order by (from_date+0) asc";
$result = mysql_query($sql);
$i=1;
$row_color="#FFFFFF";
while ($row = mysql_fetch_row($result)){
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
?>
	<tr bgcolor=<?echo $row_color; ?>>
		<td class=reportdata><? echo $row[1]; ?></td>
                <td class=reportdata style='text-align:center;'><? if (true==strstr($row[2],'-')){echo $row[2];} else { echo date("d-m-Y",$row[2]);} ?></td>
                <td class=reportdata style='text-align:center;'><? if (true==strstr($row[3],'-')){echo $row[3];} else { echo date("d-m-Y",$row[3]);} ?></td>
		<?
			$experience=substr((($row[3]-$row[2])/86400)/365,0,4);	
			$total_experience=$total_experience+$experience;
		?>
		
		<td class=reportdata style='text-align:center;'><? echo $experience; ?></td>
<td class=reportdata width=20><a href="delete_work_experience.php?account=<? echo $account; ?>&organization=<? echo $row[1]; ?>&from_date=<? echo $row[2] ?>&to_date=<? echo $row[3]; ?>"><img border=0 src="images/delete.gif"></a></font></td>
	</tr>
	<?	
	$i++;
}

$sql = "select date_of_joining,date_of_leaving from user_personal_information where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
if (strlen($row[0])>0){$start_date=$row[0];}else{$start_date=time();}
if (strlen($row[1])>0){$end_date=$row[1];}else{$end_date=time();}
?>
<tr>
<td class=reportdata><font color=white face=Arial size=1><b>Our Organization</font></td>
<td class=reportdata style='text-align:center;'><? if (strlen($row[0])>0){if (true==strstr($row[0],'-')){echo $row[0];} else { echo date("d-m-Y",$row[0]);}} ?></td>
<td class=reportdata style='text-align:center;'><? if (strlen($row[0])>0){ echo "Till Date"; }?></td>
<?

	$experience=substr((($end_date-$start_date)/86400)/365,0,4);
	$total_experience=$total_experience + $experience;
?>
		
<td class=reportdata style='text-align:center;'><? echo $experience; ?></td>
<td class=reportdata></td>
</tr>
<tr bgcolor=#FFFFFF>
<td class=reportheader colspan=5 style='text-align:center;'>Total Work Experience : <? echo $total_experience; ?></td>
</tr>
</table>
<br>
<?
include("add_work_experience_1.php"); 
?>
