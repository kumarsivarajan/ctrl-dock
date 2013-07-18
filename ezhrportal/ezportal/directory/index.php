<html>
<body>
<?php include("config.php"); ?>

<form method=post action=name.php>
<center>
<table border=0 width=99% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
        <td bgcolor=#F5F5F5><font face=Arial size=2 color=#333333><b>Search by Name</td>
        <td bgcolor=#F5F5F5><input type=text name=search_name size=25 class=formnputtext></td>
        <td bgcolor=#F5F5F5 align=right><input type=submit value=Search class='forminputbutton'></td>
</tr>
</table>
</form>

<br>

<?php
        $sql = "select country from office_locations  group by country";
?>

<table border=1 width=99% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
        <td bgcolor=#F5F5F5><font face=Arial size=2 color=#333333><b>Search by Region</td>
</tr>
<tr>
        <td bgcolor=#E9E9E9>
          <?php
                  $result = mysql_query($sql);
          while ($row = mysql_fetch_row($result)) {
                echo "<a href='region.php?country=$row[0]'><font face=Arial size=1 color=#003399>$row[0]</a>&nbsp;&nbsp;";
          }
        ?>
        <a href=contacts.php><font face=Arial size=1 color=#003399><b>ALL</a><br>
        </td>
</tr>
</table>
<br>
<table border=1 width=99% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
        <td bgcolor=#F5F5F5><font face=Arial size=2 color=#333333><b>Download Address Book (.csv)</td>
</tr>
<tr>
        <td bgcolor=#E9E9E9>
          <?php
                  $result = mysql_query($sql);
          while ($row = mysql_fetch_row($result)) {
                echo "<a href=address.php?country=$row[0]><font face=Arial size=1 color=#003399>$row[0]</a>&nbsp;&nbsp;";
          }
        ?>
        <a href=address.php><font face=Arial size=1 color=#003399><b>ALL</a><br>
        </td>
</tr>
</table>
<br>
<table border=1 width=99% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
        <td colspan=5 bgcolor=#F5F5F5><font face=Arial size=2 color=#333333><b>Office Locations</td>
</tr>
<tr>
		<td class=reportheader width=40><font color=white  face=Verdana size=1><b>Office</font></b></td>
		<td class=reportheader ><font color=white  face=Verdana size=1><b>Address</font></b></td>
		<td class=reportheader ><font color=white  face=Verdana size=1><b>Region</font></b></td>
		<td class=reportheader width=100><font color=white  face=Verdana size=1><b>Phone</font></b></td>
		<td class=reportheader width=100><font color=white  face=Verdana size=1><b>Fax</font></b></td>
</tr>
<?php


$sql = "select * from office_locations where showhide=1";
$sql = $sql . " order by office_index,country";

$result = mysql_query($sql);
$i=1;
$row_color="#FFFFFF";
while ($row = mysql_fetch_row($result)){
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
?>
	<tr bgcolor=<?echo $row_color; ?>>
		<td class=reportdata style='text-align: center;'><?=$row[0];?></font></td>
		<td class=reportdata ><?=nl2br($row[1]);?></font></td>
		<td class=reportdata align=center><?=$row[2];?></font></td>
		<td class=reportdata align=center><?=$row[3];?></font></td>
		<td class=reportdata align=center><?=$row[4];?></font></td>
	</tr>
	<?	
	$i++;
 }
  
  
?>
</table>


