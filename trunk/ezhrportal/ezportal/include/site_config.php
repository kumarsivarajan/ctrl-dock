<?
$sql="select site_name,site_logo_path,site_banner_path,site_banner_height,user_photo_path,ezq_url,ftr_leave,ftr_leave_balance,ftr_leave_credit,ftr_expenses,expense_currency,expense_prefix,company,company_address,leave_calendar_start,compensatory_leave_validity,ftr_timesheets,hr_notifications,lc_threshold from config_ezportal";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);


// SITE CONFIGURATION
$SITE_NAME				= $row[0];			
$SITE_LOGO_PATH			= $row[1];
$SITE_BANNER_PATH 		= $row[2];
$SITE_BANNER_HEIGHT		= $row[3];


# PATH TO USER PHOTOGRAPHS
$USER_PHOTO_DIR			=$row[4];
$portal_ezq_url			=$row[5];

# ENABLE FOLLOWING FEATURES IN MY PROFILE
$FEATURE_LEAVE=$row[6];
$FEATURE_LEAVE_BALANCE=$row[7];
$FEATURE_LEAVE_CREDIT=$row[8];
$FEATURE_EXPENSES=$row[9];
$FEATURE_TIMESHEETS=$row[16];
$hr_notifications=$row[17];

// EXPENSE CONFIGURATION
$CURRENCY=$row[10];
$EXPENSE_PREFIX=$row[11];
$COMPANY=$row[12];
$ADDRESS=$row[13];

// LEAVE MANAGEMENT
$lc_start=$row[14];
$compensatory_leave_validity=$row[15];
$lc_threshold=$row[18];

// GET ASSET PREFIX TO BE USED IN MY PROFILE
$sql="select asset_prefix,md5_enable from config";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$ASSET_PREFIX=$row[0];
$MD5_ENABLE=$row[1];

?>