<?include("config.php"); ?>

<center><h1>Add an Asset</h1><br><br>
<?
$error_code=0;
$assetcategoryid=$_REQUEST["assetcategoryid"];
$model=mysql_real_escape_string($_REQUEST["model"]);
$serialno=$_REQUEST["serialno"];

$sql	="select assetid,serialno from asset where serialno='$serialno'";
$result = mysql_query($sql);
$count	= mysql_num_rows($result);
$row 	= mysql_fetch_row($result);
$duplicateasset=$row[0];
$duplicateid=str_pad($row[0], 5, "0", STR_PAD_LEFT);

if ($count>0){$error_code="2";}


$assetidentifier=mysql_real_escape_string($_REQUEST["assetidentifier"]);

//changes made in here - added rental informations
$rentalinfo = $_REQUEST['rentalinfo'];
$rentalreference = $_REQUEST['rentalreference'];
$rentalstartdate = $_REQUEST['rentalstartdate'];
$rentalenddate = $_REQUEST['rentalenddate'];
$rentalvalue = $_REQUEST['rentalvalue'];
//

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
$location_desc=mysql_real_escape_string($_REQUEST["locaton_desc"]);
$auditstatus=$_REQUEST["auditstatus"];

$assigned_type=$_REQUEST['assigned_type'];
$assigned_agency=$_REQUEST['assigned_agency'];
$assigned_bg=$_REQUEST['assigned_bg'];
$parent_assetid=$_REQUEST['parent_assetid'];

$po_number	= $_REQUEST['ponum'];
$po_date	= $_REQUEST['txtpodate'];


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

if (strlen($assetcategoryid)>0 && strlen($model)>0 && strlen($statusid)>0 && $error_code==0){

// rental details added in sql query
	$sql ="insert into asset (assetcategoryid,statusid,agencyid,model,serialno,employee,po_date,po_num,invoiceno,invoicedate,invoiceamount,comments,hostname,office_index,location_desc,rentalinfo,rentalreference,rentalstartdate,rentalenddate,rentalvalue,assetidentifier,ipaddress,auditstatus,parent_assetid,assigned_type,assigned_agency,assigned_bg)";
	$sql.=" values ('$assetcategoryid','$statusid','$agencyid','$model','$serialno','$employee','$po_date','$po_number','$invoiceno','$invoicedate','$invoiceamount','$comments','$hostname','$office_index','$location_desc','$rentalinfo','$rentalreference','$rentalstartdate','$rentalenddate','$rentalvalue','$assetidentifier','$ipaddress','$auditstatus','$parent_assetid','$assigned_type','$assigned_agency','$assigned_bg')";
	$result = mysql_query($sql);
	
	echo "<h2>The Asset has been added.<br><br><a href=add_asset_1.php>Add another asset</a></h2>";
}else{
	echo "<h2>Few mandatory fields were not filled.<br><br></h2>";
}

if ($error_code==2){
	echo "<h2>An asset <a href=edit_asset_1.php?assetid=$duplicateasset>$ASSET_PREFIX-$duplicateid</a> with the serial number mentioned already exists in the system.<br><br></h2>";
}

if ($error_code >0){
	echo "<h2>Kindly click <a href=javascript:history.back()>here</a> to go back and correct the errors</h2>";
}

?>
