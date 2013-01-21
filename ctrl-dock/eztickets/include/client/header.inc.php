<?php
$title=($cfg && is_object($cfg))?$cfg->getTitle():'osTicket :: Support Ticket System';
header("Content-Type: text/html; charset=UTF-8\r\n");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title><?=Format::htmlchars($title)?></title>
    <link rel="stylesheet" href="./styles/main.css" media="screen">
    <link rel="stylesheet" href="./styles/colors.css" media="screen">
</head>
<body>
<br><br>
<div id="container">
    <ul id="nav">
         <?                    
         if($thisclient && is_object($thisclient) && $thisclient->isValid()) {?>
			<li><a class="log_out" href="logout.php">Log Out</a></li>
			<li><a class="my_tickets" href="tickets.php">My Tickets</a></li>
         <?}else {?>
				<li><a class="ticket_status" href="tickets.php">Ticket Status</a></li>
         <?}?>
         <li><a class="new_ticket" href="open.php">New Ticket</a></li>
         <li><a class="home" href="index.php">Home</a></li>		 
    </ul>
    <div id="content">
