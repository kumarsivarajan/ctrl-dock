<?include_once("../auth.php");
include_once("../include/config.php");
include_once("../include/system_config.php");
include_once("../include/css/default.css");
include_once("../include/load_xml.php");

$BASE_URL="http://" . $_SERVER['SERVER_NAME'] . ":" . $TERMINALPORT . "/anyterm.html?";

$username		=$_SESSION['username'];
$serviceuser	=$_REQUEST['serviceuser'];
$hostname		=$_REQUEST['hostname'];
$service		=$_REQUEST['service'];

$URL=$BASE_URL."$serviceuser@$hostname $service $username";
?>
<head>
<style type="text/css">
iframe.hidden
{
display:none
}
</style>
</head>
<iframe src ="<?=$URL;?>" width="100%" height="100%" frameborder="0"> </iframe> 


