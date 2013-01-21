<?php
include_once("config.php");

$assetid=$_REQUEST["asset_id"];
$id=str_pad($assetid, 5, "0", STR_PAD_LEFT);

$sql_ticket = "select name,created,closed from isost_ticket where asset_id=$assetid";

$asset_result= mysql_query($sql_ticket);
$raised = mysql_num_rows($asset_result);

while ($current= mysql_fetch_row($asset_result)) {
	$name[]=$current[0];
	$created[]=strtotime($current[1]);
	$closed[]=strtotime($current[2]);
}
?>
<table border="0" cellpadding="0" align=center cellspacing="0">

<tr>
	<td bgcolor=#F3F3F3 width=190><label>Asset ID: <?php echo $ASSET_PREFIX."-".$id ?>  </label></td>
	<td bgcolor=#CCCCCC width=190><label> Total Tickets Raised: <?php echo $raised ?></label></td>	
</tr>
</table>


<br />

<table width="100%" align="center">
<tr>
	<th class="reportheader">Sl No</th>
	<th class="reportheader">Raised By</th>
	<th class="reportheader">Opened</th>
	<th class="reportheader">Closed</th>
</tr>
<?php $j=1;?>
<?php for($i=0; $i<$raised; $i++) {
$created_date[]=date("d-m-y",$created[$i]);
$closed_date[]=date("d-m-y",$closed[$i]);
if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
	echo "<tr bgcolor=$row_color>";
?>
	<td class=reportdata><?php echo $j?></td>
	<td class=reportdata><?php echo $name[$i];?> </td>
	<td class=reportdata><?php echo $created_date[$i]; ?></td>
	<td class=reportdata><?php echo $created_date[$i]; ?></td>
</tr>
<?php 
	$j++;
}
?>
</table>