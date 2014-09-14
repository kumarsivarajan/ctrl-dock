<?include("config.php");?>
<?include("header.php");?>
<link href="../include/css/pagination.css" rel="stylesheet" type="text/css" />
<link href="../include/css/grey.css" rel="stylesheet" type="text/css" />
<center>
<table class="reporttable" width=100%>
<tr>
	<td class="reportheader" width=20>ID</td>
	<td class="reportheader" width=120>Date / Time</td>
	<td class="reportheader">To</td>
	<td class="reportheader">Sent By</td>
	<td class="reportheader" width=400>Subject</td>
	<td class="reportheader">View</td>	
</tr>
<?
//get the function
    include("function.php");

    	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    	$limit = 20;
    	$startpoint = ($page * $limit) - $limit;
                
$sql = "select broadcast_id,broadcast_date,broadcast_to,broadcast_subject,username from broadcast order by broadcast_id DESC LIMIT ".$startpoint.",".$limit;
$result = mysql_query($sql);

$i=1;
$row_color="#FFFFFF";
while ($row = mysql_fetch_row($result)){
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
?>
	<tr bgcolor=<?echo $row_color; ?>>
	<td class='reportdata' style='text-align: center;'><? echo $row[0]; ?></td>
	<td class='reportdata'><? echo date("d M Y H:i",$row[1]); ?></td>
	<td class='reportdata'><? echo $row[2]; ?></td>
	<td class='reportdata'><? echo $row[4]; ?></td>
	<td class='reportdata'><? echo $row[3]; ?></td>
	<td class='reportdata' style='text-align: center;'><a target='_blank' href=view_message.php?id=<?echo $row[0];?>><img src='images/comments.gif' border=0></img></a></td>
	</tr>
<?
	$i++;
}
?>
</table>
<?php echo pagination($limit,$page); ?>