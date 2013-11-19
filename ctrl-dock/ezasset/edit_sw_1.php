<?
include_once("config.php");

include_once("searchasset.php");
if (!check_feature(36)){feature_error();exit;}

$asset_db            =$DATABASE_NAME."_oa";
mysql_select_db($asset_db, $link);

$id=$_REQUEST["id"];
$sql="select package_name,procurement_source,procurement_date,procurement_vendor,quantity,license_type,comments from sw_licenses where package_id='$id'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$package_name		=$row[0];
$procurement_source	=$row[1];
$procurement_date	=$row[2];
$procurement_vendor	=$row[3];
$quantity			=$row[4];
$license_type		=$row[5];
$comments			=$row[6];
?>
<body>
<br>
<table border=0 width=100% cellpadding="2" cellspacing="0" bgcolor=#E5E5E5>
  <tr>
    <td width="90%" style="border-style: none; border-width: medium" align=left colspan=1>
	<font face=Arial size=2 color=#CC0000><b>EDIT SOFTWARE LICENSE : <?=$package_name;?></b></font>
	</td>
	<td width=10% align=right>
	<a href=javascript:history.back()><font face=Arial size=1>BACK</font></a>
	</td>
	</tr>
</table>

<form name=addasset method="POST" action="edit_sw_2.php?id=<?=$id;?>">
<table border=0 cellpadding=2 cellspacing=0 width=100%>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>Add a Software License</b></td></tr>
<tr>
	<td class='tdformlabel'></td>
	<td class='tdformlabel' style='text-align:right' ><input type=hidden name=package_name value='<?=$package_name;?>'></td>
</tr>
<tr>
	<td class='tdformlabel'>Procurement Source</td>
	<td align=right>	
		<select class="formselect" size=1 name=procurement_source>
		<option value=Purchased <?if($procurement_source=="Purchased"){echo "selected";}?>>Purchased</option>
		<option value=Rental <?if($procurement_source=="Rental"){echo "selected";}?>>Rental</option>
		<option value=Shared <?if($procurement_source=="Shared"){echo "selected";}?>>Shared</option>
		</select>
	</td>
</tr>
<tr>
		<td class='tdformlabel'>Procurement Date</td>
		<td align=right><input class=forminputtext value='<?=$procurement_date;?>' name=procurement_date id="procurement_date" style="font-size: 9pt; font-family: Arial; width:165px;" onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF></td>
</tr>
<tr>
	<td class='tdformlabel'>Procurement Vendor</td>
	<td align=right><input name="procurement_vendor" size="40" class='forminputtext' value='<?=$procurement_vendor;?>'></td>
</tr>
<tr>
<td class='tdformlabel'>License Type</td>
	<td align=right>	
		<select class="formselect" size=1 name=license_type>
		<option value=OEM <?if($license_type=="OEM"){echo "selected";}?>>OEM</option>
		<option value=Partner <?if($license_type=="Partner"){echo "selected";}?>>Partner</option>
		<option value=Volume <?if($license_type=="Volume"){echo "selected";}?>>Volume</option>
		<option value=Box <?if($license_type=="Box"){echo "selected";}?>>Box</option>
		<option value=Others <?if($license_type=="Others"){echo "selected";}?>>Others</option>

		</select>
	</td>
</tr>
<tr>
	<td class='tdformlabel'>Quantity</td>
	<td align=right>
	<input name="quantity" size="5" class='forminputtext' value='<?=$quantity;?>'>
	<br>
	<font face=Arial size=1>Set to '0' to track usage without licenses<font>
	</td>
</tr>
<tr>
		<td class='tdformlabel'>Comments</td>
		<td align=right><textarea style="width: 300; height: 50px;" class=formtextarea name=comments><?=$comments?></textarea></td>
</tr>
<tr><td colspan=2 align=center><input type="submit" value="Submit" name="Submit" class="forminputbutton"></td></tr>
</table>
</form>