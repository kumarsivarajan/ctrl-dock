<?
include_once("../auth.php");

include_once("../include/config_ldap.php");
include_once("../include/load_xml.php");

include_once("../include/string.php");
include_once("../include/date.php");

include_once("../include/mail_helper.php");
include_once("../include/mail.php");

include_once("../include/features.php");
include_once("../include/calendar.php");
include_once("../include/css/default.css");

if (!check_feature(34)){feature_error();exit;}
?>
