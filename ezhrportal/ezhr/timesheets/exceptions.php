<?php 
include_once("config.php");
include_once("header.php");
?>
<center>
<br>
<form method=POST action='exceptions_add.php'>
<table border=0 cellpadding=0 cellspacing=0 width=100%>
<tr bgcolor=#CCCCCC>
	<td><font color=#4D4D4D face=Arial size=1><b>&nbsp;Choose Staff Member</font></b></td>
		    <td align=right>
                <select size=1 name=account class=formselect>
                        <?php
                                $sql = "select username,first_name,last_name from user_master where account_status='Active' and username not in (select username from timesheet_exception) order by first_name";
                                $result = mysql_query($sql);
								
                                while ($row = mysql_fetch_row($result)) {
                                        echo "<option value='$row[0]'>$row[1] $row[2]</option>";
                                }
                        ?>
                </select>
      </td>
	  
	  <td align=right><input type=submit value="Add as Exception" name="Submit" style="font-size: 8pt; font-family: Arial"></td>
</tr>
</table>
</form>

<br>

<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
	<td class=reportheader><b>Resource</font></b></td>
	<td class=reportheader><b>Title</font></b></td>
	<td class=reportheader><b>Business Group</font></b></td>
	<td class=reportheader width=10%><b>Remove</font></b></td>
</tr>
<?php
$sql    ="SELECT b.first_name,b.last_name,a.username FROM timesheet_exception a,user_master b WHERE a.username=b.username order by b.first_name";
$result = mysql_query($sql);
$i=1;
$row_color="#FFFFFF";
while ($row = mysql_fetch_row($result)){
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
	
	$sub_sql="SELECT title from user_organization where username='$row[2]'";
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	$title=$sub_row[0];
	
	$sub_sql="SELECT b.business_group from user_master a, business_groups b where a.business_group_index=b.business_group_index and a.username='$row[2]'";
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	
	$business_group=$sub_row[0];
	
?>
	<tr bgcolor=<?echo $row_color; ?>>		
		<td class=reportdata align=left>&nbsp;<? echo "$row[0] $row[1]";?></font></td>
		<td class=reportdata align=left>&nbsp;<? echo "$title"; 	   ?></font></td>
		<td class=reportdata align=left>&nbsp;<? echo "$business_group" 	   ?></font></td>
		<td class=reportdata style='text-align:center'><a href="exceptions_remove.php?account=<?=$row[2];?>"><img border=0 src="images/delete.gif"></a></font></td>
	</tr>
	<?	
	$i++;
 }  
?>
</table>
</body>
</html>
