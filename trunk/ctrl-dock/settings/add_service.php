<?

include("config.php"); 
if (!check_feature(25)){feature_error();exit;}


$service= str_replace(' ','',$_REQUEST["service"]);
$comments=$_REQUEST["comments"];

$service_type=$_REQUEST["service_type"];
$service_url=$_REQUEST["service_url"];
$service_port=$_REQUEST["service_port"];
$service_user=$_REQUEST["service_user"];
$service_pass=$_REQUEST["service_pass"];
$service_domain=$_REQUEST["service_domain"];

if ($service=="" || $comments==""){ 

$SELECTED="ADD SERVICE";
include("header.php");
?>


<form method="POST" action="add_service.php">
<table border=0 cellpadding=1 cellspacing=1 width=100% bgcolor=#F7F7F7>

<tr>
	<td class='tdformlabel'><b>&nbsp;Service</font></b></td>
	<td align=right><input name="service" size="40" class=forminputtext></td>
</tr>
<tr>
	<td class='tdformlabel'><b>&nbsp;Service Display Name</font></b></td>
	<td align=right><input name="comments" size="40" class=forminputtext></td>
</tr>
<br>
<tr>
	<td class='tdformlabel'><b>&nbsp;Service Type</font></b></td>
	<td align=right>
			<select size=1 name=service_type class='formselect'>
			<?php
			    $sql = "select * from service_type";	
				$result = mysql_query($sql);
				while ($row = mysql_fetch_row($result)) {
		        		echo "<option value='$row[0]'>$row[0]</option>";
				}
			?>
		</select>
	</td>
</tr>
<tr>
	<td class='tdformlabel' width=250><b>&nbsp;Service URL / IP Address / Hostname</font></b></td>
	<td align=right><input name="service_url" size="40" class=forminputtext></td>
</tr>
<tr>
	<td class='tdformlabel'><b>&nbsp;Port (if applicable)</font></b></td>
	<td align=right><input name="service_port" size="40" class=forminputtext></td>
</tr>

<tr>
	<td class='tdformlabel'><b>&nbsp;Username</font></b></td>
	<td align=right><input name="service_user" size="40" class=forminputtext></td>
</tr>

<tr>
	<td class='tdformlabel'><b>&nbsp;Password</font></b></td>
	<td align=right><input type="password" name="service_pass" size="40" class=forminputtext></td>
</tr>
<tr>
	<td class='tdformlabel'><b>&nbsp;Domain</font></b></td>
	<td align=right><input name="service_domain" size="40" class=forminputtext></td>
</tr>
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Save" name="Submit" class=forminputbutton>
	</td>
</tr>
</table>
</form>

<?php
}else {
  $sql = "select count(*) from services where service='$service'";
  $result = mysql_query($sql);
  while ($count = mysql_fetch_row($result)) { 
	if ($count[0] > 0){
		$error=1;
	}
  }
 
  if ($error!=1){
 	$sql = "INSERT INTO services VALUES('$service','$comments')";
	mysql_query($sql);
	$sql = "INSERT INTO service_properties VALUES('$service','$service_type','$service_url','$service_port','$service_user','$service_pass','$service_domain')";
	mysql_query($sql);
?>
		<center><i><b><font color="#003366" face="Arial" size=2>The New Service has been successfully added.</font></b></i></center>
		<meta http-equiv="Refresh" content="1; URL=service_list.php">

		<?php
		$service="";
		$comments="";
  } else {
	?>	<b><font color="#003366" size=2 face="Arial"><br>The Service already exists</font> <?php
  }
}
?>

