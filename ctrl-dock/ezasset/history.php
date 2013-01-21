<?
include("config.php"); 
include_once("searchasset.php");

$assetid=$_REQUEST["assetid"];
$id=str_pad($assetid, 5, "0", STR_PAD_LEFT);
?>
<br>
<table border=0 width=100% cellpadding="2" cellspacing="0" bgcolor=#E5E5E5>
  <tr>
    <td width="100%" style="border-style: none; border-width: medium" align=left colspan=1>
	<font face=Arial size=2 color=#CC0000><b>ASSET HISTORY: <?=$ASSET_PREFIX."-".$id;?></b></font>
	</td>
	</tr>
</table>
<?
$assetid=$_REQUEST["assetid"];

$sql = "select assetid,assetcategory,model,serialno from asset a,assetcategory b where a.assetcategoryid=b.assetcategoryid and a.assetid='$assetid'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
?>
<?
$sql_rent = "select rentalinfo from asset where assetid='$assetid'";
$result_rent = mysql_query($sql_rent);
$row_rent = mysql_fetch_row($result_rent);
?>
<center>
	<table width=100% border="0" cellpadding="2" cellspacing="0" bgcolor=#E5E5E5>
	<tr>
	<td class=reportdata>
	<b> Rental / Lease : </b><?=$row_rent[0]?>
	&nbsp;&nbsp;&nbsp;
	<b> Model : </b><?="$row[1] - $row[2]"?>
	&nbsp;&nbsp;&nbsp;
	<b> Serial No : <?=$row[3]?>
	</td>
	</tr>
	</table>

<?
$sql = "select modification_by,modification_date,modification_time,employee,statusid,hostname,comments,assigned_type,assigned_agency,assigned_bg,parent_assetid from assetlogs where assetid='$assetid'"; 	
$result = mysql_query($sql);
?>

<br>

<table width=100% border="0" cellpadding="2" cellspacing="1" >
  <tr>
    <td class="reportheader">Modified By</font></b></td>
    <td class="reportheader">Date / Time</font></b></td>
    <td class="reportheader">Assigned To</font></b></td>
    <td class="reportheader">Status</font></b></td>
    <td class="reportheader">Hostname</font></b></td>
    <td class="reportheader">Comments</font></b></td>

</tr>

<?php

while ($row = mysql_fetch_row($result)) {
        echo "<tr>";
		
		$sub_sql = "select first_name,last_name from user_master where username='$row[0]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		
        echo "<td class=reportdata> $sub_row[0] $sub_row[1]</td>";
        
		echo "<td class=reportdata> $row[1] $row[2]</td>";
		
		if($row[7]=="employee"){
		   	$subsql = "select first_name,last_name from user_master where username='$row[3]'"; 	
			$subresult = mysql_query($subsql);
			$subrow = mysql_fetch_row($subresult);
			echo "<td class=reportdata> $subrow[0] $subrow[1]</td>";
		}

		if($row[7]=="agency"){
		   $sub_sql="select name from agency where agency_index='$row[8]'";	
		   $sub_result = mysql_query($sub_sql);
		   $sub_row = mysql_fetch_row($sub_result);
		   
		   echo "<td class=reportdata> $sub_row[0]</td>";
		}

		if($row[7]=="business_group"){
		   $sub_sql="select business_group from business_groups where business_group_index='$row[9]'";	
		   $sub_result = mysql_query($sub_sql);
		   $sub_row = mysql_fetch_row($sub_result);
		   
		   echo "<td class=reportdata> $sub_row[0]</td>";
		}
		
		
		$subsql = "select * from assetstatus where statusid='$row[4]'"; 	
		$subresult = mysql_query($subsql);
		$subrow = mysql_fetch_row($subresult);
        echo "<td class=reportdata> $subrow[1]</td>";

        echo "<td class=reportdata> $row[5]</td>";
	
		$row[10]=str_replace("\n","<br>",$row[10]);
        echo "<td class=reportdata> $row[6]</td>";
        echo "</tr>";
}
?>




