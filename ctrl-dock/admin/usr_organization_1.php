<?php 
include("config.php"); 
if (!check_feature(5)){feature_error();exit;} 

$account=$_REQUEST["account"];

$sql = "select first_name,last_name,username,account_status,business_group_index from user_master where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$SELECTED="ORGANIZATION OF : ".$row[0]." ".$row[1] ." (".$row[2].")";
include("header.php");

$account_status=$row[3];
$business_group_index=$row[4];

$sql = "select * from user_organization where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
	
if ($account_status=="Obsolete"){
	echo "<br><center><font face=Arial size=2 color=#CC0000><b>The account is obsolete. Obsolete accounts should be updated under authorization only.</font></b>";
}
?>

<form method=POST action=usr_organization_2.php>

<table border=0 cellpadding=0 cellspacing=2 width=40%>
<tr>
	<td class='tdformlabel'><b>Title / Designation</font></b></td>
	<td align=right><input name="designation"  value="<? echo $row[1]; ?>" size="30" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>Business Group</font></b></td>
        <td align=right>
		    <select size=1 name=business_group_index class='formselect'>
                	        <?php
                        	        $sub_sql = "select * from business_groups where business_group_index='$business_group_index'";
                                	$sub_result = mysql_query($sub_sql);
									$sub_row = mysql_fetch_row($sub_result);
                                	echo "<option value='$sub_row[0]'>$sub_row[1]</option>";

                        	        $sub_sql = "select * from business_groups";
                                	$sub_result = mysql_query($sub_sql);
	                                while ($sub_row = mysql_fetch_row($sub_result)) {
        	                                echo "<option value='$sub_row[0]'>$sub_row[1]</option>";
                	                }
                        	?>
	        </select>
        </td>
</tr>

<tr><td bgcolor=#669999 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Reporting</b></td></tr>
<tr>
	<td class='tdformlabel'><b>Direct Reporting</font></b></td>
        <td align=right>
                <select size=1 name=direct_report_to class='formselect'>
                        <?php
                        		$sub_sql = "select username,first_name,last_name from user_master where username='$row[2]'";
								$sub_result = mysql_query($sub_sql);
								$sub_row = mysql_fetch_row($sub_result);
                        		echo "<option value='$sub_row[0]'>$sub_row[1] $sub_row[2]</option>";
                        		echo "<option value=''></option>";
                        		
                        		$sub_sql = "select username,first_name,last_name from user_master where username!='$account' and username!='IT' and username!=' ' order by first_name ";
								$sub_result = mysql_query($sub_sql);
															
								while ($sub_row = mysql_fetch_row($sub_result)){
	                                echo "<option value='$sub_row[0]'>$sub_row[1] $sub_row[2]</option>";
								}
                         ?>
                </select>
        </td>
</tr>

<tr>
	<td class='tdformlabel'><b>Dotted Line Reporting</font></b></td>
        <td align=right>
                <select size=1 name=dot_report_to class='formselect'>
                        <?php
                        		$sub_sql = "select username,first_name,last_name from user_master where username='$row[3]'";
								$sub_result = mysql_query($sub_sql);
								$sub_row = mysql_fetch_row($sub_result);
                        		echo "<option value='$sub_row[0]'>$sub_row[1] $sub_row[2]</option>";
                        		echo "<option value=''></option>";
                        		
                        		$sub_sql = "select username,first_name,last_name from user_master where username!='$account' and username!='IT' and username!=' ' order by first_name ";
								$sub_result = mysql_query($sub_sql);
															
								while ($sub_row = mysql_fetch_row($sub_result)){
	                                echo "<option value='$sub_row[0]'>$sub_row[1] $sub_row[2]</option>";
								}

                         ?>
                </select>
        </td>
</tr>
<input name="account" size=40 type=hidden value="<? echo $account; ?>">

<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Update Account" name="Submit" class='forminputbutton'>
	</td>
</tr>
</form>
</table>

</td>
</table>
