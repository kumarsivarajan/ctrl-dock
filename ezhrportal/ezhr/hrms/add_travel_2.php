<?php 
include("config.php");
echo "<center><table border=0 width=50%>";

$account=$_REQUEST["account"];

$country_visited=$_REQUEST["country_visited"];if (strlen($country_visited)<= 0){$error=1;}
if ($error==1){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The country Visited was left blank.</font></b></td></tr>";
}

$year_of_visit=$_REQUEST["year_of_visit"];if (strlen($year_of_visit)<= 0){$error=2;}
if ($error==2){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The year of visit was left blank.</font></b></td></tr>";
}



if ($error>0){
?>
	<tr><td><font face="Arial" size="2" color="#003399"><b><a href=javascript:history.back();>Click here to return to the previous screen to correct these errors</font></b></a></td></tr></table>
<?
} else {
	//If all the validations are successfully completed, insert the record into the table
	$sql = "insert into user_overseas_travel (username,country_visited,year_of_visit)";
	$sql = $sql . " values('$account','$country_visited','$year_of_visit')";
	$result = mysql_query($sql);
?>
	<i><b><font size=2 color="#003366" face="Arial">The travel records were successfully added.</font></b></i>
	<meta http-equiv="Refresh" content="2; URL=travel.php?account=<? echo $account; ?>">
<?
}
?>



