<?php
$page = "";
$extra = "";
$software = "";
$count = -1;
if (isset($_GET['software'])) {$software = $_GET['software'];} else {}
if (isset($_GET['sort'])) {$sort = $_GET['sort'];} else {$sort= "system_name";}
include_once("list_include.php");


echo "<td valign=\"top\">\n";
echo "<div class=\"main_each\" style='float:left; width:100%;'>";
#$sql =  "SELECT software_reg_id, software_title, count(software.software_name) AS number_used, sum(license_purchase_number) as number_purchased FROM ";
#$sql .= "software_register, software, system, software_licenses WHERE ";
#$sql .= "software_reg_id = license_software_id AND ";
#$sql .= "software_title = software_name AND ";
#$sql .= "software_uuid = system_uuid AND ";
#$sql .= "software_timestamp = system_timestamp ";
#$sql .= "GROUP BY software_title";

$sql = "SELECT software_reg_id, software_title, count(software.software_name) AS number_used FROM ";
$sql .= "software_register, software, system WHERE ";
$sql .= "software_title = software_name AND ";
$sql .= "software_uuid = system_uuid AND ";
$sql .= "software_timestamp = system_timestamp ";
$sql .= "GROUP BY software_title";

$result = mysql_query($sql, $db);
if ($myrow = mysql_fetch_array($result)){
  echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
  echo "<tr>\n";
  echo "  <td class=\"contenthead\">SOFTWARE REGISTER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=software_register_add.php>Add Software</a><br />&nbsp;</td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "<td width=\"400\"><b>Package&nbsp;&nbsp;</b></td>\n";
  echo "<td align=\"center\" width=\"100\"><b>&nbsp;&nbsp;Total Purchased&nbsp;&nbsp;</b></td>\n";
  //echo "<td align=\"center\" width=\"100\"><b>&nbsp;&nbsp;Total Installed&nbsp;&nbsp;</b></td>\n";
  //echo "<td align=\"center\" width=\"100\"><b>&nbsp;&nbsp;Audit&nbsp;&nbsp;</b></td>\n";
  echo "<td align=\"center\" width=\"100\"><b>&nbsp;&nbsp;Remove&nbsp;&nbsp;</b></td>\n";
  echo "</tr>\n";
  do {    $sql2  = "SELECT sum(license_purchase_number) as number_purchased FROM ";
    $sql2 .= "software_licenses, software_register WHERE ";
    $sql2 .= "license_software_id = software_reg_id AND ";
    $sql2 .= "software_reg_id = '" . $myrow['software_reg_id'] . "'";
    $result2 = mysql_query($sql2, $db);
    $myrow2 = mysql_fetch_array($result2);
	    
    
    $number_purchased = $myrow2["number_purchased"];
    $number_used = $myrow["number_used"];
    settype($number_purchased, "integer");
    settype($number_used, "integer");
    $number_audit = $number_purchased - $number_used;
    $font = "<font>";
    if ($number_audit < "0") { $font = "<font color=\"red\">";}
    if ($number_audit == "0") { $font = "<font color=\"blue\">";}
    if ($number_audit > "0") { $font = "<font color=\"green\">";}
      
    $count = $count + 1;
    if ($bgcolor == "#F1F1F1") { $bgcolor = "#FFFFFF"; } else { $bgcolor = "#F1F1F1"; }
    echo "<tr bgcolor=\"" . $bgcolor . "\">";
    echo "<td align=left><a href=\"software_register_details.php?id=" . $myrow["software_reg_id"] . "\">" . $myrow["software_title"] . "</a>&nbsp;&nbsp;</td>";
    if ($number_purchased == -1) {
      echo "<td align=\"center\">Free</td>";
    } else {
      echo "<td align=\"center\">" . $number_purchased . "</td>";
    }
    //echo "<td align=\"center\">" . $number_used . "</td>";
    /*if ($number_purchased == -1) {
      echo "<td align=\"center\"></td>";
    } else {
      echo "<td align=\"center\">" . $font . $number_audit . "</font></td>";
    }*/
    echo "<td align=\"center\"><div id=\"s" . $myrow['software_reg_id'] . "\">\n";
    echo "<a href=\"#\" onclick=\"sendRequest('" . url_clean($myrow["software_reg_id"]) . "');\"><img border=\"0\" src=\"images/button_fail.png\" width=\"16\" height=\"16\" alt=\"\" /></a>";
    echo "</div></td>\n"; 
    echo "</tr>";
  } while ($myrow = mysql_fetch_array($result));
  echo "</table>";
} else {
  echo "<p class=\"content\"><span style='float:left;'>No Packages in database.</span><span style='float:right;'><a href=software_register_add.php><b>Add Software</b></a></span></p>"; 
}


echo "</div>\n";
echo "</td>\n";
?>
<script language="javascript" TYPE="text/javascript">

function createRequestObject() {
  var req;
  if(window.XMLHttpRequest){
    // Firefox, Safari, Opera...
    req = new XMLHttpRequest();
  } else if(window.ActiveXObject) {
    // Internet Explorer 5+
    req = new ActiveXObject("Microsoft.XMLHTTP");
    } else {
      // There is an error creating the object,
      // just as an old browser is being used.
      alert('Problem creating the XMLHttpRequest object');
    }
  return req;
}

// Make the XMLHttpRequest object
var http = createRequestObject();

function sendRequest(act) {
  // Open PHP script for requests
  http.open('get', 'software_register_remove_ajax.php?act='+act);
  http.onreadystatechange = handleResponse;
  http.send(null);
}
/*
function handleResponse() {
  if(http.readyState == 4 && http.status == 200){
    // Text returned FROM the PHP script
    var response = http.responseText;
    if(response) {
      // UPDATE ajaxTest content
      document.getElementById("ajaxTest").innerHTML = response;
    }
  }
}
*/

function handleResponse() {
  if(http.readyState == 4 && http.status == 200){
    // Text returned FROM the PHP script
    var response = http.responseText;
    if(response) {
      // UPDATE ajaxTest content
      document.getElementById(response).innerHTML = 'Removed';
    }
  }
}

</script>
<?php
echo "</body>\n";
echo "</html>\n";
?>
