<?include_once("config.php"); ?>

<?
$menuitem=$_REQUEST["item"];
if ($menuitem=="Status"){ $fieldlabel="ASSET STATUS"; $field="status"; $table="assetstatus";} 
if ($menuitem=="Category"){$fieldlabel="ASSET CATEGORY"; $field="assetcategory"; $table="assetcategory";}
?>
<center>

<table border=0 width=100% cellpadding="2" cellspacing="0" bgcolor=#E5E5E5>
  <tr>
    <td width="90%" style="border-style: none; border-width: medium" align=left colspan=1>&nbsp;
	<font face=Arial size=2 color=#CC0000><b>ADD <?=$fieldlabel;?></b></font>
	</td>
	<td width=10% align=right>
	</a>
	</td>
	</tr>
</table>
<?include_once("../settings/settings.php");?>
<br>
<?

if (strlen($menuitem)>0){
?>
	<form method="POST" action="add.php">
	<center>
	<table border=0 width=100% cellpadding="2" cellspacing="0" bgcolor=#E5E5E5>
	<tr>
		<td align=left><input class=forminputtext type=text size=60 name=fieldvalue></td>
		<input type=hidden size=60 name=fieldname value=<? echo $field;?>>
		<input type=hidden size=60 name=fieldtable value=<? echo $table;?>>
		<td align=right><input class=forminputbutton type="submit" value="ADD" name="Submit"></td>
	</tr>
	</table>
	
	</form>
<?php
	  echo "<center><table border=0 width=100% cellpadding=2 cellspacing=1 bgcolor=#E5E5E5>";
	  echo "<tr><td class=reportheader width=50>Sl. No.</td><td class=reportheader><b>$menuitem</td></tr>";
	  $sql = "select $field from $table order by $field";
	  $result = mysql_query($sql);	

	  $i=1;
	  $row_color="#FFFFFF";
	  while ($row = mysql_fetch_row($result)) {
		if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
		echo "<tr bgcolor=$row_color>";
		echo "<td class=reportdata style='text-align: center;'>&nbsp;&nbsp;$i</td>";
		echo "<td class=reportdata >&nbsp;&nbsp;$row[0]</td>";
		echo "</tr>";
		$i++;
	 }
	 echo "</table>";
}
 

$submit_field_value=$_REQUEST["fieldvalue"];
$submit_field_name=$_REQUEST["fieldname"];
$submit_field_table=$_REQUEST["fieldtable"];

if (strlen($submit_field_value)>0){
  $sql = "insert into $submit_field_table ($submit_field_name) values('$submit_field_value')";
  $result = mysql_query($sql);	
  echo "<center><h2>Your Record was successfully Added</h2>";

}

?>
