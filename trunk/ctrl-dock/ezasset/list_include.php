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

if ($page == "add_pc")
{
	$use_pass = "n";
	$_SESSION["username"] = "Anonymous";
	$_SESSION["role"] = "none";
}
else
{
	if (GetVarOrDefaultValue($use_https) == "y")
	{
		if ($_SERVER["SERVER_PORT"]!=443){RedirectToUrl("https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);}
	}
  if (GetVarOrDefaultValue($use_ldap_login) == 'y') {include "include_ldap_login.php";}
}
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
      function IEHoverPseudo() {
        var navItems = document.getElementById("primary-nav").getElementsByTagName("li");
        for (var i=0; i<navItems.length; i++) {
          if(navItems[i].className == "menuparent") {
            navItems[i].onmouseover=function() { this.className += " over"; }
            navItems[i].onmouseout=function() {window.status=this.className; this.className = "menuparent";}
          }
        }
      }

      window.onload = IEHoverPseudo;

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
<center>
<table width="98%">
  <tr>


     
