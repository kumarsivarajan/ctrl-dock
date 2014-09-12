<?php 
include("config.php");
include("query_agency.php");

$agency_index=$_REQUEST["agency_index"]; if (strlen($agency_index)==0){$agency_index="%";}
$name=$_REQUEST["name"]; if (strlen($name)==0){$name="%";}
$type=$_REQUEST["type"];

?>
<center>



<table class="reporttable" width=100%>
<tr>
	<td colspan=6 align=right>
		<a style="text-decoration: none" href="add_agency_1.php">
		<font color="#99CC33" face="Arial" size="2"><b>Add Vendor / Customer</font></a>
	</td>
</tr>
<tr>
	<td class="reportheader" width=400>Name</td>
	<td class="reportheader" width=50>Type</td>
	<td class="reportheader" width=150>Primary Contact</td>
	<td class="reportheader" width=150>Secondary Contact</td>
	<td class="reportheader">Comments</td>
	<td class="reportheader" width=50>Edit</td>
</tr>
<?php
$sql = "select * from agency";
$sql = $sql . " where agency_index like '$agency_index' and name like '$name%' and type like '$type%' and agency_index>1";
$sql = $sql . " order by name";
$result = mysql_query($sql);
$i=1;
$row_color="#FFFFFF";
while ($row = mysql_fetch_row($result)){
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
	
	if($row[2]=="client" || $row[2]=="Client")	{$type="Client";}
	if($row[2]=="freelance" || $row[2]=="Freelance" || $row[2]=="Consultant"){$type="Consultant";}
	if($row[2]=="vendor" ||  $row[2]=="Vendor")	{$type="Vendor";}
	
?>
	<tr bgcolor=<?echo $row_color; ?>>
		<td class='reportdata' Title="<? echo "$row[3]"; ?>&nbsp;Tel :<? echo "$row[4]"; ?>&nbsp;Fax : <? echo "$row[5]"; ?>&nbsp;E-Mail : <? echo "$row[6]"; ?>"><? echo "$row[1]"; ?></td>
		<td class='reportdata'><? echo "$type"; ?></td>		
		<td class='reportdata'><? echo "$row[7]<br>$row[8]<br>$row[9]"; ?></td>		

		<td class='reportdata'><? echo "$row[10]<br>$row[11]<br>$row[12]"; ?></td>		
		<td class='reportdata'><? echo "$row[13]"; ?></td>
		<td class='reportdata' style='text-align: center;'><a href="edit_agency_1.php?agency_index=<? echo $row[0]; ?>"><img border=0 src="images/edit.gif"></a></td>		
	</tr>
	<?	
	$i++;
 }  
?>
</table>
</body>
</html>