<? 

include("config.php"); 
include("header.php");

$body       =$_REQUEST["body"];

$sql="truncate asset_template";
$result = mysql_query($sql);

$sql="insert into asset_template values ('$body')";
$result = mysql_query($sql);
?>
<center><b><font size=2 color="#003366" face="Arial">The asset notification template was updated.</font></b>
<meta http-equiv="Refresh" content="2; URL=index.php">


