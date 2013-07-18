<html>
<body>
<? include("config.php"); ?>

<? $country=$_REQUEST["country"];?>

<table width=99% border=0 cellspacing=0 cellpadding=2>
<tr>
	<td width=50%><font face=Arial size=2 color=#CC0000><b><u> Contact Information - <?php echo $country ?></u></b>&nbsp;&nbsp;</font></td>
	<td align=right>

	<?php
		echo "<a href=index.php><font face=Arial size=1 color=#003399>HOME</a>";
		echo "&nbsp;";
		echo "&nbsp;";
	  $sql = "select country from office_locations  group by country order by country";
	  $result = mysql_query($sql);
	  while ($row = mysql_fetch_row($result)) {
		if ($row[0] != 'Not Defined'){
		echo "<a href=region.php?country=$row[0]><font face=Arial size=1 color=#003399>$row[0]</a>";
		echo "&nbsp;";
		echo "&nbsp;";
		}
	  }
	?>
</tr>
</table>
<br>
<center>
<table border=0 width=100% cellspacing=1 cellpadding=4>
  <tr>
   <td class="reportheader">Sl.No.</td>
   <td class="reportheader" colspan="2">Name</td>   
   <td class="reportheader">Work</td>
   <td class="reportheader">Cell</td>
   <td class="reportheader">Res *</td>
  </tr>
<?php
  $ctr=0;
  $sql = "select first_name,last_name,contact_phone_office,contact_phone_mobile,contact_phone_residence,official_email,username from user_master a, office_locations b where account_status='Active' and a.office_index=b.office_index and b.country='$country' order by first_name";
  $result = mysql_query($sql);

  $i=1;
  $row_color="#FFFFFF";
  while ($row = mysql_fetch_row($result)) {
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}

	$ctr++;
	echo "<tr bgcolor=$row_color>";
    echo "<td class=reportdata width=20 style='text-align:center'>$ctr</td>";
    echo "<td class=reportdata> $row[0] $row[1]</td>";
    echo "<td class=reportdata width=20 style='text-align:center'><a href=profile.php?account=$row[6]><img src=images/profile.png border=0></a></td>";
    echo "<td class=reportdata> $row[2]</td>";
    echo "<td class=reportdata> $row[3]</td>";
    echo "<td class=reportdata> $row[4]</td>";
    echo "</tr>";
	$i++;
 }
?>
</table>
<h3>* Call in case of EMERGENCY only</h3>
</body>
</html>