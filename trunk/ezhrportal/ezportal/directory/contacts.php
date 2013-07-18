<? include("config.php"); ?>
<center><b><font face=Arial size="2" color="#CC0000">Global Contact List</font></b>
<br><br>

<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
  <tr>
    <td class="reportheader"><b>Sl.No.</font></b></td>
    <td class="reportheader"><b>Name</font></b></td>
    <td class="reportheader"><b>Country</font></b></td>
    <td class="reportheader"><b>Profile</font></b></td>
    <td class="reportheader"><b>Work</font></b></td>
    <td class="reportheader"><b>Cell</font></b></td>
    <td class="reportheader"><b>Res *</font></b></td>
    <td class="reportheader"><b>E-Mail</font></b></td>
  </tr>
<?php
$sql = "select first_name,last_name,contact_phone_office,contact_phone_mobile,contact_phone_residence,official_email,username,country from user_master a, office_locations b where account_status='Active' and a.office_index=b.office_index order by username";
$result = mysql_query($sql);
  $ctr=0;

  $i=1;
  $row_color="#FFFFFF";
  while ($row = mysql_fetch_row($result)) {
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}

	$ctr++;
	echo "<tr bgcolor=$row_color>";
        echo "<td class=reportdata style='text-align:center;'>$ctr</td>";
		echo "<td class=reportdata> $row[0] $row[1] </td>";
		echo "<td class=reportdata> $row[7]</td>";
		echo "<td class=reportdata style='text-align:center;'><a href=profile.php?username=$row[6]><img src=images/profile.gif border=0></a></td>";
        echo "<td class=reportdata> $row[2]</td>";
        echo "<td class=reportdata> $row[3]</td>";
        echo "<td class=reportdata> $row[4]</td>";
        echo "<td class=reportdata><a href=mailto:$row[5]>$row[5]</a></td>";
        echo "</tr>";
	$i++;
 }

?>
</table></center>
<font face=Arial size="1" color=red>* In case of EMERGENCY</font>
</body>
</html>


