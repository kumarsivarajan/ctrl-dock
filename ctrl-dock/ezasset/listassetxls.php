<?php 

include("config.php");
include_once("../include/css/default.css");

$assetid=$_REQUEST["assetid"];
$assetcategoryid=$_REQUEST["assetcategoryid"];
$statusid=$_REQUEST["statusid"];
$employee=$_REQUEST["employee"];
$hostname=$_REQUEST["hostname"];

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

$filename="Asset_Report_";
$filename.=$report_date;

header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=$filename.xls\n"); 

?>

<br>
<?php
$sql="select assetcategory from assetcategory where assetcategoryid='$assetcategoryid'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

if (strlen($row[0])<=0){$header_category="All";}else{$header_category=$row[0];}
if ($employee=="%"){$header_assigned="All";}else{$header_assigned=$employee;}
?>
</center>



<table border="0" cellpadding="0" cellspacing="0">
<tr>
	<td bgcolor=#F3F3F3 width=120><label>Asset Category : </label></td>
	<td bgcolor=#F3F3F3 width=120><label><? echo $header_category;?></label></td>
	<td bgcolor=#E1E1E1 width=120><label>Assigned To : </label></td>
	<td bgcolor=#E1E1E1 width=120><label><? echo $header_assigned; ?></label></td>
	<td bgcolor=#CCCCCC width=120><label>Report as of : </label></td>
	<td bgcolor=#CCCCCC width=120><label><? echo $report_date;?></label></td>
	
</tr>
</table>


<br>

<table border=1 width=98% cellspacing=0 cellpadding=1 style="border-collapse: collapse" bordercolor="#E5E5E5">
  <tr>
    <td class=reportheader align=center>Asset Tag</td>
	<td class="reportheader" align=center>Asset Identifier</td>
    <td class="reportheader" align=center>Parent Asset Tag</td>
	<td class="reportheader" align=center>Document Date</td>
    <td class="reportheader" align=center>Document No</td>
    <td class=reportheader align=center>Vendor / Agency</td>
    <td class=reportheader align=center>Value</td>
    <td class="reportheader" align=center>Asset Category</td>
    <td class="reportheader" align=center>Model</td>
    <td class="reportheader" align=center>Serial No.</td>
    <td class="reportheader" align=center>Status</td>
	<td class="reportheader" align=center>Location</td>
	<td class="reportheader" align=center>Location Description</td>
    <td class="reportheader" align=center>Assigned To</td>
    <td class="reportheader" align=center>Hostname</td>
	<td class="reportheader" align=center>Rental / Lease</td>
    <td class="reportheader" align=center>Comments</td>    
</tr>

<?php

$sql = "select a.assetid,a.invoicedate,a.invoiceno,b.assetcategory,model,serialno,c.name,a.invoiceamount,d.status,e.first_name,e.last_name,";
$sql.= "a.comments,a.hostname,a.office_index,a.location_desc,a.rentalinfo,a.assetidentifier,";
$sql.= "a.assigned_type,a.assigned_agency,a.assigned_bg,a.parent_assetid";
$sql.= " from asset a,assetcategory b,agency c,assetstatus d, user_master e";
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
   	$id=str_pad($row[0], 5, "0", STR_PAD_LEFT);

    echo "<td class=reportdata align=center>$ASSET_PREFIX-$id</td>";
	if (strlen($row[16])==''){$assetidentifier='NA';}else{$assetidentifier=$row[16];}
	echo "<td class=reportdata align=center>$assetidentifier</td>";
	
	$parentid=str_pad($row[20], 5, "0", STR_PAD_LEFT);
	
	echo "<td class=reportdata align=center>$parentid</td>";
	
    if (strlen($row[1])==0){$date='NA';}else{$date=$row[1];}
    echo "<td class=reportdata align=center>$date</td>";
    
	echo "<td class=reportdata align=center>$row[2]</td>";
    echo "<td class=reportdata align=center>$row[6]</td>";
    echo "<td class=reportdata align=center>$row[7]</td>";    
    echo "<td class=reportdata align=center>$row[3]</td>";
    echo "<td class=reportdata > $row[4]</td>";
    echo "<td class=reportdata > $row[5]</td>";
    echo "<td class=reportdata align=center> $row[8]</td>";
	
	$sub_sql="select country from office_locations where office_index='$row[13]'";	
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	
	echo "<td class=reportdata >$sub_row[0]-$row[13]</td>";
	echo "<td class=reportdata > $row[14]</td>";

	
	if($row[17]=="employee"){
	   echo "<td class=reportdata> $row[9] $row[10]</td>";
	}

	if($row[17]=="agency"){
	   $sub_sql="select name from agency where agency_index='$row[18]'";	
	   $sub_result = mysql_query($sub_sql);
	   $sub_row = mysql_fetch_row($sub_result);
	   
	   echo "<td class=reportdata> $sub_row[0]</td>";
	}

	if($row[17]=="business_group"){
	   $sub_sql="select business_group from business_groups where business_group_index='$row[19]'";	
	   $sub_result = mysql_query($sub_sql);
	   $sub_row = mysql_fetch_row($sub_result);
	   
	   echo "<td class=reportdata> $sub_row[0]</td>";
	}

    echo "<td class=reportdata > $row[12]</td>";
	echo "<td class=reportdata > $row[15]</td>";
    echo "<td class=reportdata > $row[11]</td>";
    echo "</tr>";
	$i++;
}
?>
</table>
