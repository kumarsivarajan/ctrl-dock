<?php
/**********************************************************************************************************
Module:	include.php

Description:
	This module is included by "index.php". Verifies authentication to the system and HTML to display the application header 
	and menu.

Change Control:

	[Nick Brown]	02/03/2009
	Only a minor change - the "logout" link in the top right of the page now displays the user's role (admin/user) as well as their
	name.
	
	[Nick Brown]	17/04/2009
	Minor improvement to SQL query that retrieves audited system from DB
	
**********************************************************************************************************/
include_once "include_config.php";
include_once "include_lang.php";
include_once "include_functions.php";
include "include_dell_warranty_functions.php"; // Added by Andrew Hull to allow us to grab Dell Warranty details from the Dell website
include_once "include_col_scheme.php";

$page = GetVarOrDefaultValue($page);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> 
    <!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link media="screen" rel="stylesheet" type="text/css" href="default.css" />
    <link media="print" rel="stylesheet" type="text/css" href="defaultprint.css" />
		<!--[if lt IE 7]><link media="screen" rel="stylesheet" type="text/css" href="iefix.css" /><![endif]-->
		<!--[if lt IE 7]><link media="print" rel="stylesheet" type="text/css" href="iefix.css" /><![endif]-->
		
    <script type="text/javascript">
     /*<![CDATA[*/


			function switchUl(id){
        if(document.getElementById){
          a=document.getElementById(id);
          a.style.display=(a.style.display!="none")?"none":"block";
        }
      }
      /*]]>*/
    </script>

  </head>
  <body>
<?php

$pc = GetGETOrDefaultValue("pc", "");
$sub = GetGETOrDefaultValue("sub", "all");
$sort = GetGETOrDefaultValue("sort", "system_name");
$mac = $pc;

if ($page <> "setup"){
  $db = mysql_connect($mysql_server,$mysql_user,$mysql_password) or die('Could not connect: ' . mysql_error());
  mysql_select_db($mysql_database,$db);
  $SQL = "SELECT config_value FROM config WHERE config_name = 'version'";
  $result = mysql_query($SQL, $db);

  if ($myrow = mysql_fetch_array($result)){
    $version = $myrow["config_value"];
  } else {}
} else {
  $version = "0.1.00";
}
?>
<table width="100%">
  <tr>


<?php
if ($pc > "0") {
?>    <td style="width:250px;" rowspan="12" valign="top" id="nav"><?
	// This query has less joins and is syntactically simpler than previous - 17/04/2009	[Nick Brown]
	$sql = "SELECT system_uuid, system_timestamp, system_name, system.net_ip_address, net_domain
					FROM system 
					JOIN network_card ON net_uuid = system_uuid
					WHERE (
					net_mac_address ='$pc'
					OR system_uuid = '$pc'
					OR system_name = '$pc'
					)
					LIMIT 1";
					
  $result = mysql_query($sql, $db);
  $myrow = mysql_fetch_array($result);
  $timestamp = $myrow["system_timestamp"];
  $GLOBAL["system_timestamp"]=$timestamp;
  $pc = $myrow["system_uuid"];
  $ip = $myrow["net_ip_address"];
  $name = $myrow['system_name'];
  $domain = $myrow['net_domain'];

  //Menu-Entries for the selected PC
  
  require_once("include_menu_array.php");
  echo "<li class=\"menuparent\">".
        "<a href=\"system.php?pc=$pc&amp;view=summary\">".
        "<span>&gt;</span>".
        $name.
        "</a>\n";

   echo "<ul>\n";
    reset ($menue_array["machine"]);
    while (list ($key_1, $topic_item) = each ($menue_array["machine"])) {
        if (isset($topic_item["class"])) {
          echo "<li class=\"".$topic_item["class"];
        } else {
          echo "<li>";
        }

        echo "<a href=\"".$topic_item["link"]."\">";
        if(isset($topic_item["childs"]) AND is_array($topic_item["childs"])){
          echo "<span><img src=\"images/spacer.gif\" height=\"16\" width=\"0\" alt=\"\" />&gt;</span>";
        }
        echo "<img src=\"".$topic_item["image"]."\" style=\"border:0px;\" alt=\"\" />&nbsp;";
        echo __($topic_item["name"]);
        echo "</a>\n";

        if(isset($topic_item["childs"]) AND is_array($topic_item["childs"])){
          echo "<ul>\n";
          @reset ($topic_item["childs"]);
          while (list ($key_2, $child_item) = @each ($topic_item["childs"])) {
            echo "<li><a href=\"".$child_item["link"]."\"";
            if (isset($topic_item["title"])) {
              echo " title=\"".$topic_item["title"]."\"";
            }
            echo "><img src=\"".$child_item["image"]."\" style=\"border:0px;\" alt=\"\" />&nbsp;";
            echo __($child_item["name"]);
            echo "</a></li>\n";
          }
          echo "</ul>\n";
        }
        echo "</li>\n";
    
    }
    
   echo "</ul>\n";
  echo "</li>\n";
}
?>
     
