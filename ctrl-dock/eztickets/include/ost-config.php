<?php
/*********************************************************************
    ost-config.php

    Static osTicket configuration file. Mainly useful for mysql login info.
    Created during installation process and shouldn't change even on upgrades.
   
    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2010 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
    $Id: $
**********************************************************************/

#Disable direct access.
if(!strcasecmp(basename($_SERVER['SCRIPT_NAME']),basename(__FILE__)) || !defined('ROOT_PATH')) die('kwaheri rafiki!');

#Default admin email. Used only on db connection issues and related alerts.
define('ADMIN_EMAIL','administrator@demo.com');

if (file_exists("../../include/config.php")){include("../../include/config.php");}
if (file_exists("../include/config.php")){include("../include/config.php");}
#Mysql Login info
define('DBTYPE','mysql');
define('DBHOST',$DATABASE_SERVER);
define('DBPORT',$DATABASE_PORT);
define('DBNAME',$DATABASE_NAME);
define('DBUSER',$DATABASE_USERNAME);
define('DBPASS',$DATABASE_PASSWORD);


#Table prefix
define('TABLE_PREFIX','isost_');

?>
