<script src="javascript/jquery-1.6.1.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script src="javascript/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		$("area[rel^='prettyPhoto']").prettyPhoto();		
		$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: false});
	});
</script>
<center>
<?php 

include("config.php");
include("searchasset.php");

$assetid=$_REQUEST["assetid"];if (strlen($assetid)==0){$assetid="%";}
$assetcategoryid=$_REQUEST["assetcategoryid"];if (strlen($assetcategoryid)==0){$assetcategoryid="%";}
$statusid=$_REQUEST["statusid"];if (strlen($statusid)==0){$statusid="1";}
$employee=$_REQUEST["employee"];if (strlen($employee)==0){$employee="%";}
$hostname=$_REQUEST["hostname"];if (strlen($hostname)==0){$hostname="%";}
$serialno=$_REQUEST["serialno"];if (strlen($serialno)==0){$serialno="%";}
$rentalinfo=$_REQUEST["rentalinfo"];if (strlen($rentalinfo)==0){$rentalinfo="%";}

$date=getdate();
$report_date =$date[mday];
$report_date .="-";
$report_date .=$date[month];
$report_date .="-";
$report_date .=$date[year];
$report_date .=" ";
$report_date .=$date[hours];
$report_date .=":";
$report_date .=$date[minutes];
?>

<br>
<?php
$sql="select assetcategory from assetcategory where assetcategoryid='$assetcategoryid'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

if (strlen($row[0])<=0){$header_category="All";}else{$header_category="$row[0]";}
if ($employee=="%"){$header_assigned="All";}else{$header_assigned="$employee";}
?>

<div class='gallery clearfix'>
<table border="0" cellpadding="0" cellspacing="0" width=100%>
<tr>
	<td bgcolor=#F5F5F5 width=100><label><img border=0 src=images/xls.png> <a target=_new href='listassetxls.php?assetid=<?=$assetid?>&assetcategoryid=<?=$assetcategoryid?>&statusid=<?=$statusid?>&employee=<?=$employee?>&hostname=<?=$hostname?>'><font face=Arial size=2><b>EXPORT</a></label></td>
	<td bgcolor=#F3F3F3 width=120><label>Asset Category : </label></td>
	<td bgcolor=#F3F3F3 width=120><label><? echo $header_category;?></label></td>
	<td bgcolor=#E1E1E1 width=100><label>Assigned To : </label></td>
	<td bgcolor=#E1E1E1 width=140><label><? echo $header_assigned; ?></label></td>
	<td bgcolor=#CCCCCC width=100><label>Report as of : </label></td>
	<td bgcolor=#CCCCCC width=200><label><? echo $report_date;?></label></td>	
	<td bgcolor=#CCCCCC>&nbsp;</td>	
</tr>
</table>


<br>

<table class="reporttable" width=100% cellpadding=2>
  <tr>
	<td colspan=14 class=reportdata style='text-align:right'>A : Active &nbsp;&nbsp;IA : In-Active &nbsp;&nbsp; R : Rental&nbsp;&nbsp;L : Lease&nbsp;&nbsp;O : Owned&nbsp;</td>
  </tr>
  <tr>
    <td class="reportheader" align=center width=60>ID</td>
	<td class="reportheader" align=center width=60>Tag</td>
	<td class="reportheader" align=center width=60>Parent ID</td>
    <td class="reportheader" align=center width=100>Category</td>
	<td class="reportheader" align=center >Sl. No.</td> 	
	<td class="reportheader" align=center width=100>Hostname / IP Address</td> 	
	<td class="reportheader" align=center>Location</td>
    <td class="reportheader" align=center width=150>Assigned To</td>    
    <td class="reportheader" align=center colspan=7><b>Information</td>
	
</tr>

<?php
// sql query edited a.rentalinfo added //
$sql = "select a.assetid,a.invoicedate,a.invoiceno,b.assetcategory,model,serialno,c.name,a.invoiceamount,d.status,";
$sql.= "e.first_name,e.last_name,a.comments,a.hostname,a.office_index,a.rentalinfo,a.ipaddress,a.assetidentifier,";
$sql.= "a.assigned_type,a.assigned_agency,a.assigned_bg,a.parent_assetid";
$sql.= " from asset a,assetcategory b,agency c,assetstatus d, user_master e";
$sql.= " where a.assetcategoryid=b.assetcategoryid and a.agencyid=c.agency_index and a.statusid=d.statusid and a.employee=e.username";

$sql.=" and a.assetid like '$assetid' and serialno like '$serialno'";
$sql.=" and b.assetcategoryid like '$assetcategoryid' and d.statusid like '$statusid'";
$sql.=" and a.employee like '$employee'";
$sql.=" and a.hostname like '$hostname'";
$sql.=" and a.rentalinfo like '$rentalinfo'";

$sql.=" order by a.assetid";


$result = mysql_query($sql);

$i=1;
$row_color="#FFFFFF";
while ($row = mysql_fetch_row($result)) {
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
	
    echo "<tr bgcolor=$row_color>";

	$id=str_pad($row[0], 5, "0", STR_PAD_LEFT);

	echo "<td class=reportdata align=center><a href='assetbugs.php?asset_id=$row[0]&amp;iframe=true&amp;' rel=\"prettyPhoto[iframe]\">$ASSET_PREFIX-$id</a></td>";
	echo "<td class=reportdata align=center><a href='assetbugs.php?asset_id=$row[0]&amp;iframe=true&amp;' rel=\"prettyPhoto[iframe]\">$row[16]</a></td>";
	
	if($row[20]>0){
		$parentid=str_pad($row[20], 5, "0", STR_PAD_LEFT);
		echo "<td class=reportdata align=center>$ASSET_PREFIX-$parentid</td>";
	}else{
		echo "<td class=reportdata align=center> </td>";
	}
	
    echo "<td class=reportdata align=center>$row[3]</td>";

	echo "<td class=reportdata>$row[5]</td>";
	echo "<td class=reportdata>$row[12] <br> $row[15]</td>";
	
	$sub_sql="select country from office_locations where office_index='$row[13]'";	
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	
	echo "<td class=reportdata>$sub_row[0]</td>";
	
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

	
	$status="IA";
	if($row[8]=="Active"){$status="A";}
    echo "<td class=reportdata style='text-align:center'><b>$status</b></td>";
	
	$status="O";
	if($row[14]=="Rental"){$status="R";}
	if($row[14]=="Lease"){$status="L";}
	echo "<td class=reportdata style='text-align:center'><b>$status</b></td>";
	echo "<td class=reportdata style='text-align:center'>";
	if (strlen($row[11])>0){
		echo "<a Title='$row[11]'><img border=0 src=images/comments.gif></a>"; 
	}
	echo "</td>";	

	echo "<td class=reportdata style='text-align:center'><a href='ez_sys_info.php?system_name=$row[12]' Title='System Information' target='_blank'><img border=0 src=images/sys_info.gif></a></td>";
	echo "<td class=reportdata style='text-align:center'><a href='history.php?assetid=$row[0]' Title='History'><img border=0 src=images/history.gif></a></td>";
	echo "<td class=reportdata style='text-align:center'><a href='edit_asset_1.php?assetid=$row[0]' Title='Edit Information'><img border=0 src=images/edit.gif></a></td>";
	echo "</tr>";
	$i++;

}
?>
</table>
</div>
