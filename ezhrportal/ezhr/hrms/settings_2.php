<center>
<?
	include("config.php"); 

	$lcs	=$_REQUEST["lcs"];
	$clv	=$_REQUEST["clv"];
	
	$n_site_name			= $_REQUEST["n_site_name"];
	$n_site_logo_path		= $_REQUEST["n_site_logo_path"];
	$n_site_banner_path 	= $_REQUEST["n_site_banner_path"];		
	$n_site_banner_height 	= $_REQUEST["n_site_banner_height"];		

	$n_user_photo_dir 		= $_REQUEST["n_user_photo_dir"];		
	$n_portal_ezq_url		= $_REQUEST["n_portal_ezq_url"];

	$n_currency				= $_REQUEST["n_currency"];
	$n_expense_prefix		= $_REQUEST["n_expense_prefix"];	
	$n_company				= $_REQUEST["n_company"];
	$n_address				= $_REQUEST["n_address"];
	
	$n_ftr_leave			=$_REQUEST["n_ftr_leave"];
	$n_ftr_leave_balance	=$_REQUEST["n_ftr_leave_balance"];
	$n_ftr_leave_credit		=$_REQUEST["n_ftr_leave_credit"];
	$n_ftr_expenses			=$_REQUEST["n_ftr_expenses"];
	$n_ftr_timesheets		=$_REQUEST["n_ftr_timesheets"];
	$n_hr_notifications		=$_REQUEST["n_hr_notifications"];
	
	$sql = "update config_ezportal set 
	site_name='$n_site_name',
	site_logo_path='$n_site_logo_path',
	site_banner_path='$n_site_banner_path',
	site_banner_height='$n_site_banner_height',
	user_photo_path='$n_user_photo_dir',
	ezq_url='$n_portal_ezq_url',
	expense_currency='$n_currency',
	expense_prefix='$n_expense_prefix',
	company='$n_company',
	company_address='$n_address',
	ftr_leave='$n_ftr_leave',
	ftr_leave_balance='$n_ftr_leave_balance',
	ftr_leave_credit='$n_ftr_leave_credit',
	ftr_expenses='$n_ftr_expenses',
	ftr_timesheets='$n_ftr_timesheets',
	hr_notifications='$n_hr_notifications'
	";
	$result = mysql_query($sql);
	
?>		
	<font face=Arial size=2 color=blue><b><i> The Settings have been updated.</i></b>	
