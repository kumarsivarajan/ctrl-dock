<html>
<body>
<?php 
include("config.php");
$account=$_REQUEST["account"];

?>
<center><a href=javascript:history.back()><font face="Arial" color=#003399 size="1"><b>BACK</b></a>
<br><br>
<table align=center width=100% border=0 cellspacing=0 cellpadding=5>
<tr>
	<td colspan=3 bgcolor=#336699 align=center>
	<font face="Arial" color=#FFFFFF size="2" ><b>User Profile</b></a>
	</td>
	
</tr>
	<?php
	  $sql = "select * from user_master where username='$account'";
	  $result = mysql_query($sql);
	  $row = mysql_fetch_row($result);

	  $sub_sql_1 = "select * from office_locations where office_index='$row[10]'";
	  $sub_result_1 = mysql_query($sub_sql_1);
	  $sub_row_1 = mysql_fetch_row($sub_result_1);
	  
	  $sub_sql_2 = "select * from user_organization where username='$account'";
	  $sub_result_2 = mysql_query($sub_sql_2);
	  $sub_row_2 = mysql_fetch_row($sub_result_2);
	  
  	  $sub_sql_3= "select first_name,last_name from user_master where username='$sub_row_2[2]'";  	  
	  $sub_result_3 = mysql_query($sub_sql_3);
	  $sub_row_3 = mysql_fetch_row($sub_result_3);
	  $direct_report=$sub_row_3[0]." ".$sub_row_3[1];
	  
	  $sub_sql_3= "select first_name,last_name from user_master where username='$sub_row_2[3]'";
	  $sub_result_3 = mysql_query($sub_sql_3);
	  $sub_row_3 = mysql_fetch_row($sub_result_3);
	  $dot_report=$sub_row_3[0]." ".$sub_row_3[1]

	?>
	  <tr>
	  <td valign=middle align=center bgcolor=#CCCCCC>
			<?
			if (file_exists("../../data/user_photos/$account.jpg")) {
				?><img border=3 src="../../data/user_photos/<?=$account;?>.jpg" width=135 height=176><br><br><?
			} else {
				?><img border=3 src="../../data/user_photos/notavail.jpg"  width=135 height=176><br><br><?
			}
			?>
	   </td>
		
	   <td valign=top bgcolor=#FFFFFF>
			<table border=0>
			<tr>
				<td width=110><font face=Arial size=2 color=#333333>Full Name</td>
				<td width=190><font face=Arial size=2 color=#003399><b><? echo "$row[3] $row[4]";?></b></td>
			</tr>
			<tr>
				<td><font face=Arial size=2 color=#333333>Username</td>
				<td><font face=Arial size=2 color=#003399><b><? echo "$row[0]";?></b></td>
			</tr>

			
			<tr><td colspan="2">&nbsp;</td></tr>		
			
			<tr>
				<td colspan=2><font face=Arial size=2 color=#003399><b>Contact Information</td>
			</tr>
			<tr>
				<td><font face=Arial size=2 color=#333333>Tel - Office</td>
				<td><font face=Arial size=2 color=#003399><? echo "$row[5]";?></td>
			</tr>
			<tr>
				<td><font face=Arial size=2 color=#333333>Cell</td>
				<td><font face=Arial size=2 color=#003399><? echo "$row[7]";?></td>
			</tr>
			<tr>
				<td><font face=Arial size=2 color=#333333>Tel - Res.</td>
				<td><font face=Arial size=2 color=#003399><? echo "$row[6]";?></td>
			</tr>
			<tr>
				<td><font face=Arial size=2 color=#333333>E-Mail</td>
				<td><font face=Arial size=2 color=#003399><? echo "$row[11]";?></td>
			</tr>
			<tr>
			<td valign="top"><font face=Arial size=2 color=#333333 >Mailing Address</td>
				<?
					$address=$sub_row_1[1];
					$address=str_replace("\n","<br>",$address);
				?>
			<td><font face=Arial size=2 color=#003399><? echo "$address";?></td>
			</tr>
			</table>
	</td>
	<td valign=top bgcolor=#FFFFFF>
			<table border=0>
			<tr>
				<td><font face=Arial size=2 color=#333333>Staff ID</td>
				<td><font face=Arial size=2 color=#003399><b><? echo "$row[2]";?></b></td>
			</tr>
			<tr>
				<td width=120><font face=Arial size=2 color=#333333>Designation</td>
				<td width=190><font face=Arial size=2 color=#003399><? echo "$sub_row_2[1]";?></td>
			</tr>
						
			<tr><td colspan="2">&nbsp;</td></tr>	
			
			<tr>
				<td width=120><font face=Arial size=2 color=#333333>Supervisor</td>				
				<td><font face=Arial size=2 color=#003399><? echo "$direct_report";?></td>
			</tr>

			<tr>
				<td width=120><font face=Arial size=2 color=#333333>Dotted Line</td>
				<td><font face=Arial size=2 color=#003399><? echo "$dot_report";?></td>
			</tr>
	</td>
	</tr>
</table>
</table>
<?
include("org.php");
?>

</body>
</html>
