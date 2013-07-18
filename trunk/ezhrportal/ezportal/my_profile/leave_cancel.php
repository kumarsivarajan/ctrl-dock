<?

include("config.php");


$no=$_REQUEST['no'];

$sql = "update leave_form set leave_status='3' where leave_no='$no'";
$result = mysql_query($sql);
?>

<br><font face="Arial" size="2" color="#4D4D4D"><b>Your leave request has been cancelled</font></b>
<meta http-equiv="Refresh" content="3; URL=ezq.php">