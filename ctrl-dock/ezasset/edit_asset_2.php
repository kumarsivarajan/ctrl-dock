<?
include("config.php"); 
if (!check_feature(37)){feature_error();exit;}

$error_code=0;

$assetid=$_REQUEST["assetid"];
$assetcategoryid=$_REQUEST["assetcategoryid"];
$model=mysql_real_escape_string($_REQUEST["model"]);
$serialno=$_REQUEST["serialno"];

$sql	="select serialno from asset where serialno='$serialno' and assetid!='$assetid'";
$result = mysql_query($sql);
$count	= mysql_num_rows($result);
if ($count>0){$error_code="2";}

$agencyid=$_REQUEST["agencyid"];
$invoicedate=$_REQUEST["invoicedate"];
$invoiceno=$_REQUEST["invoiceno"];
$invoiceamount=$_REQUEST["invoiceamount"];

$statusid=$_REQUEST["statusid"];
$employee=$_REQUEST["employee"];
$comments=mysql_real_escape_string($_REQUEST["comments"]);
$hostname=$_REQUEST["hostname"];
$ipaddress=$_REQUEST["ipaddress"];
$office_index=$_REQUEST["office_index"];
$location_desc=mysql_real_escape_string($_REQUEST["location_desc"]);
$auditstatus=$_REQUEST["auditstatus"];

// rental informations added 
$rentalinfo = $_REQUEST['rentalinfo'];
$rentalreference = $_REQUEST['rentalreference'];
$rentalstartdate = $_REQUEST['rentalstartdate'];
$rentalenddate = $_REQUEST['rentalenddate'];
$rentalvalue = $_REQUEST['rentalvalue'];
$assetidentifier = mysql_real_escape_string($_REQUEST['assetidentifier']);

$assigned_type=$_REQUEST['assigned_type'];
$assigned_agency=$_REQUEST['assigned_agency'];
$assigned_bg=$_REQUEST['assigned_bg'];
$parent_assetid=$_REQUEST['parent_assetid'];

$podatedet	= $_REQUEST['txtpodate'];
$ponumber	= $_REQUEST['ponum'];

$modification_by=$_SESSION['username'];

$date=getdate();
if ($date[mday]<10){$date[mday]="0".$date[mday];}
$modification_date =$date[mday];
$modification_date .=".";
if ($date[mon]<10){$date[mon]="0".$date[mon];}
$modification_date .=$date[mon];
$modification_date .=".";
$modification_date .=$date[year];

$modification_time .=$date[hours];
$modification_time .=":";
if ($date[minutes]<10){$date[minutes]="0".$date[minutes];}
$modification_time .=$date[minutes];

if (strlen($assetid)>0 && strlen($assetcategoryid)>0 && strlen($model)>0 && strlen($statusid)>0 && $error_code==0){
	
	$sql = "update asset set assetcategoryid='$assetcategoryid',statusid='$statusid',agencyid='$agencyid',model='$model',serialno='$serialno',";
	$sql.="employee='$employee',po_date='$podatedet',po_num='$ponumber',invoiceno='$invoiceno',invoicedate='$invoicedate',invoiceamount='$invoiceamount',comments='$comments',";
	$sql.="hostname='$hostname',office_index='$office_index',location_desc='$location_desc',rentalinfo='$rentalinfo',parent_assetid='$parent_assetid',";
	$sql.="rentalreference='$rentalreference',rentalstartdate='$rentalstartdate', rentalenddate='$rentalenddate',rentalvalue='$rentalvalue',";
	$sql.="assetidentifier='$assetidentifier',ipaddress='$ipaddress',auditstatus='$auditstatus',assigned_type='$assigned_type',assigned_agency='$assigned_agency',assigned_bg='$assigned_bg'";
	$sql.=" where assetid='$assetid'";

	$result = mysql_query($sql);

	$sql = "insert into assetlogs";
	$sql.=" (assetid,assetcategoryid,statusid,agencyid,model,serialno,employee,po_date,po_num,invoiceno,invoicedate,invoiceamount,comments,hostname,modification_date,modification_time,modification_by,rentalinfo, rentalreference, rentalstartdate, rentalenddate, rentalvalue,assetidentifier,ipaddress,auditstatus,parent_assetid,assigned_type,assigned_agency,assigned_bg)";
	$sql.=" values ('$assetid','$assetcategoryid','$statusid','$agencyid','$model','$serialno','$employee','$podatedet','$ponumber','$invoiceno','$invoicedate','$invoiceamount','$comments','$hostname','$modification_date','$modification_time','$modification_by','$rentalinfo','$rentalreference','$rentalstartdate','$rentalenddate','$rentalvalue','$assetidentifier','$ipaddress','$auditstatus','$parent_assetid','$assigned_type','$assigned_agency','$assigned_bg')";
	$result = mysql_query($sql);
	
	echo "<h2>The Asset has been updated successfully</h2>";
}else{
	echo "<h2>Few mandatory fields were not filled.<br><br> Kindly click <a href=javascript:history.back()>here</a> to go back and correct the errors</h2>";
}

if ($error_code==2){
	echo "<h2>An asset with the serial number already exists.<br><br> Kindly click <a href=javascript:history.back()>here</a> to go back and correct the errors</h2></h2>";
}
?>
