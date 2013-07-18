<html>
<body>
<? include("config.php"); 

  $name=$_REQUEST["search_name"];

  $return=0;
  $sql = "select first_name,last_name,contact_phone_office,contact_phone_mobile,contact_phone_residence,official_email,username from user_master a, office_locations b where account_status='Active' and a.office_index=b.office_index and (a.first_name like '$name%' or last_name like '$name%') order by username";

  $result = mysql_query($sql);
  while ($row = mysql_fetch_row($result)) {
	$return=$return + 1;
  }
  if ($return==0) {
    echo "<font face=Arial size=2 color=blue>No Records Found<br><br>Click <a href=index.php>here</a> to search again.";
  }
  if ($return > 0) {
?>
<h2>Search Results</h2>
<a href="javascript:history.back();"><font face=Arial size=1 color=#003399>BACK</a>
<br><br>
<table border=0 width=100% cellspacing=1 cellpadding=4>
  <tr>
   <td class="reportheader">Sl.No.</td>
   <td class="reportheader">Name</td>
   <td class="reportheader"></td>
   <td class="reportheader">Work</td>
   <td class="reportheader">Cell</td>
   <td class="reportheader">Res *</td>
  </tr>
<?php
  $ctr=0;
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
    //echo "<td class=reportdata><a href=mailto:$row[5]>$row[5]</a></td>";
    echo "</tr>";
        $i++;
 }
?>
</table>
<h3>* In case of EMERGENCY</h3>

</body>
</html>
<?php } ?>
