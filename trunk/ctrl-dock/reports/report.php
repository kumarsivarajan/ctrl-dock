<?
$start_date	=$_REQUEST["start_date"];
$end_date	=$_REQUEST["end_date"];

if (strlen($start_date)>0 && strlen($end_date)>0){

	if($_REQUEST["xls"]==1){
		header("Content-Type: application/vnd.ms-excel");
		header("Content-disposition: attachment; filename=Report.xls\n"); 
	}

	if($_REQUEST["xls"]!=1){
		include_once("search.php");
	}
	include_once("proc_request.php");
	include_once("../include/load_xml.php");

	$base_url="http://";
	if ($HTTPS==1){$base_url="https://";}
	$base_url.=$_SERVER["SERVER_NAME"]."/".$INSTALL_HOME;


	include_once("hosts_availability.php");
	include_once("tkt_by_priority.php");
	include_once("tkt_by_categories.php");
	include_once("tkt_by_staff_new.php");
	include_once("scheduled_activities.php");

	include_once("../dash/dash_sw_compliance.php");
	include_once("../dash/dash_asset_summary.php");
}else{
	$loc = "Location: "."search.php";
	header($loc);
}

?>