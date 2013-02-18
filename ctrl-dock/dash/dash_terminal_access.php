<?include_once("../auth.php");
include_once("../include/config.php");
include_once("../include/system_config.php");
include_once("../include/css/default.css");
include_once("../include/load_xml.php");

$base_url="http://";
if ($HTTPS==1){$base_url="https://";}
$base_url.=$_SERVER["SERVER_NAME"]."/".$INSTALL_HOME;
$username=$_SESSION['username'];
?>
<script>
function PopupCenter(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}
</script>

<center>

<table border=0 width=100% cellpadding="2" cellspacing="0" bgcolor=#E5E5E5 >
  <tr>
    <td width="100%" style="border-style: none; border-width: medium" align=left colspan=1>
	<font face=Arial size=2 color=#CC0000><b>TERMINAL ACCESS</b></font>
	</td>
	</tr>
</table>
<br>
<table class="reporttable" width=100% cellpadding="4" cellspacing="1">
<tr>	
	<td class="reportheader" >Service</td>
	<td class="reportheader" >IP Address / Hostname</td>
	<td class="reportheader" >Service Type</td>
	<td class="reportheader" >Terminal</td>
</tr>
<?
$url=$base_url."/api/terminal_access.php?key=$API_KEY&username=$username";
$terminal_list = load_xml($url);

if(count($terminal_list)>0){
	$j=1;
	for($i=0;$i<count($terminal_list);$i++){	
		if (($j%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
			$hostname=$terminal_list->terminal[$i]->url;
			$service=$terminal_list->terminal[$i]->servicename;
			$serviceuser=$terminal_list->terminal[$i]->serviceusername;
			$servicetype=$terminal_list->terminal[$i]->servicetype;
			if(strlen($hostname)>0){
			echo "<tr bgcolor=$row_color>";
			echo "<td class='reportdata'>".$service."</td>";
			echo "<td class='reportdata'>".$hostname."</td>";
			echo "<td class='reportdata' width=90>".$servicetype."</td>";
			
			if($service!=''){
				echo "<td class='reportdata' style='text-align:center;' width=20><a href='javascript:void(0);' onclick=\"PopupCenter('http://".$_SERVER['SERVER_NAME'].":".$TERMINALPORT."/anyterm.html?$serviceuser@$hostname $service $username', 'terminal',1080,768);\"><div class='myimg'><img border=0 src=../images/terminal.png /></div></a></td>";
			}else{
				echo "<td class='reportdata' style='text-align: center;'>NA</td>";
			}
			echo "</tr>";
		}
		$j++; 
	}
	
	$sql="delete from terminal_login where username='$username'";
	$result = mysql_query($sql);
	
	$sql="insert into terminal_login values ('$username')";
	$result = mysql_query($sql);
}
?>
</table>
<meta http-equiv="refresh" content="20">

