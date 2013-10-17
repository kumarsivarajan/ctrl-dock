<?
include_once("config.php");

include_once("searchasset.php");
if (!check_feature(36)){feature_error();exit;}

$asset_db            =$DATABASE_NAME."_oa";


?>
<body onLoad="assignment('<?=$assigned_type;?>')">
<br>
<table border=0 width=100% cellpadding="2" cellspacing="0" bgcolor=#E5E5E5>
  <tr>
    <td width="90%" style="border-style: none; border-width: medium" align=left colspan=1>
	<font face=Arial size=2 color=#CC0000><b>MANAGE SOFTWARE LICENSES</b></font>
	</td>
	<td width=10% align=right>
	<a href=javascript:history.back()><font face=Arial size=1>BACK</font></a>
	</td>
	</tr>
</table>

<form name=addasset method="POST" action="add_sw_2.php">
<table border=0 cellpadding=2 cellspacing=0 width=100%>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>Add a Software License</b></td></tr>
<tr>
	<td class='tdformlabel'>Software Package</td>
	<td align=right>	
		<select class="formselect" size=1 name=package_name>
		<?
			mysql_select_db($asset_db, $link);
			$sql = "select distinct key_name from sys_sw_software_key order by key_name"; 	
			$result = mysql_query($sql);
			while ($row = mysql_fetch_row($result)) {
					echo "<option value='$row[0]'>$row[0]</option>";
			}
		?>
		</select>
	</td>
</tr>
<tr>
	<td class='tdformlabel'>Procurement_Source</td>
	<td align=right>	
		<select class="formselect" size=1 name=procurement_source>
		<option value=Purchased>Purchased</option>
		<option value=Rental>Rental</option>
		<option value=Shared>Shared</option>
		</select>
	</td>
</tr>
<tr>
		<td class='tdformlabel'>Procurement Date</td>
		<td align=right><input class=forminputtext name=procurement_date id="procurement_date" style="font-size: 9pt; font-family: Arial; width:165px;" onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF></td>
</tr>
<tr>
	<td class='tdformlabel'>Procurement Vendor</td>
	<td align=right><input name="procurement_vendor" size="40" class='forminputtext'></td>
</tr>
<tr>
<td class='tdformlabel'>License Type</td>
	<td align=right>	
		<select class="formselect" size=1 name=license_type>
		<option value=OEM>OEM</option>
		<option value=Partner>Partner</option>
		<option value=Volume>Volume</option>
		<option value=Box>Box</option>
		<option value=Others>Others</option>

		</select>
	</td>
</tr>
<tr>
	<td class='tdformlabel'>Quantity</td>
	<td align=right><input name="quantity" size="40" class='forminputtext'></td>
</tr>
<tr>
		<td class='tdformlabel'>Comments</td>
		<td align=right><textarea style="width: 300; height: 50px;" class=formtextarea name=comments></textarea></td>
</tr>
<tr><td colspan=2 align=center><input type="submit" value="Submit" name="Submit" class="forminputbutton"></td></tr>
</table>
</form>
<br><br>
<table class="reporttable" width=100% cellpadding=2>
 <tr>
    <td class="reportheader">Package</td>
	<td class="reportheader">Procurement Source</td>
	<td class="reportheader">Procurement Date</td>
    <td class="reportheader">Vendor</td>
	<td class="reportheader">License Type</td> 	
	<td class="reportheader">Qty</td> 	
	<td class="reportheader">Comments</td>
	<td class="reportheader">Del</td>	
</tr>
<?
$sql="select * from sw_licenses order by package_name";
$result = mysql_query($sql);

$i=1;
$row_color="#FFFFFF";
while ($row = mysql_fetch_row($result)) {
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
	
    echo "<tr bgcolor=$row_color>";
	echo "<td class=reportdata>$row[1]</td>";
	echo "<td class=reportdata>$row[2]</td>";
	echo "<td class=reportdata>$row[3]</td>";
	echo "<td class=reportdata>$row[4]</td>";
	echo "<td class=reportdata>$row[6]</td>";
	echo "<td class=reportdata>$row[5]</td>";
	echo "<td class=reportdata>$row[7]</td>";
	echo "<td class=reportdata style='text-align:center'><a href='del_sw.php?id=$row[0]' Title='Delete Software License'><img border=0 src=images/delete.png></a></td>";
	echo "</tr>";
}
?>
</table>