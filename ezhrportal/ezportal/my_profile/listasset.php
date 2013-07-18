<?php 

include("config.php");

$assetid=$_REQUEST["assetid"];if (strlen($assetid)==0){$assetid="%";}
$assetcategoryid=$_REQUEST["assetcategoryid"];if (strlen($assetcategoryid)==0){$assetcategoryid="%";}
$statusid=$_REQUEST["statusid"];if (strlen($statusid)==0){$statusid="%";}
$hostname=$_REQUEST["hostname"];if (strlen($hostname)==0){$hostname="%";}

$date=getdate();
$report_date =$date[mday];
$report_date .="-";
$report_date .=$date[month];
$report_date .="-";
$report_date .=$date[year];
$report_date .=" ";
$report_date .=$date[hours];
$report_date .=".";
$report_date .=$date[minutes];
?>

<?php
$sql="select assetcategory from assetcategory where assetcategoryid='$assetcategoryid'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

if (strlen($row[0])<=0){$header_category="All";}else{$header_category="$row[0]";}
if ($employee=="%"){$header_assigned="All";}else{$header_assigned="$employee";}
?>
<center>

<h2>Asset Profile for user : <?=$employee?></h2>

<table border=1 width=99% cellspacing=0 cellpadding=1 style="border-collapse: collapse" bordercolor="#E5E5E5">
  <tr>
    <td class="reportheader" align=center width=85>Asset Tag</td>    
    <td class="reportheader" align=center>Asset Category</td>
    <td class="reportheader" align=center>Model</td>
    <td class="reportheader" align=center>Serial No.</td>
    <td class="reportheader" align=center>Label / Hostname</td>
	<td class="reportheader" align=center>Comments</td>
</tr>

<?php

$sql = "select assetid,invoicedate,invoiceno,assetcategory,model,serialno,c.name,invoiceamount,status,first_name,last_name,a.comments,hostname  from asset a,assetcategory b,agency c,assetstatus d, user_master e";
$sql.= " where a.assetcategoryid=b.assetcategoryid and a.agencyid=c.agency_index and a.statusid=d.statusid and a.employee=e.username";

$sql.=" and a.assetid like '$assetid'";
$sql.=" and b.assetcategoryid like '$assetcategoryid' and d.statusid like '$statusid'";
$sql.=" and a.employee like '$employee'";
$sql.=" and a.hostname like '$hostname'";

$sql.=" order by a.assetid";
$result = mysql_query($sql);

$i=1;
$row_color="#FFFFFF";
while ($row = mysql_fetch_row($result)) {
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
	
    echo "<tr bgcolor=$row_color>";

    if (strlen($row[0])==1){$id="0000".$row[0];}
    if (strlen($row[0])==2){$id="000".$row[0];}
    if (strlen($row[0])==3){$id="00".$row[0];}
    if (strlen($row[0])==4){$id="0".$row[0];}
    if (strlen($row[0])==5){$id="".$row[0];}

    echo "<td class=reportdata align=center>$ASSET_PREFIX-$id</td>";


    if (strlen($row[1])==0){$date='NA';}else{$date=$row[1];}    
    echo "<td class=reportdata align=center>$row[3]</td>";
    echo "<td class=reportdata > $row[4]</td>";
    echo "<td class=reportdata > $row[5]</td>";
    echo "<td class=reportdata > $row[12]</td>";
	echo "<td class=reportdata style='font-size:9;'> $row[11]</td>";
    echo "</tr>";
	$i++;
}
?>
</table>
