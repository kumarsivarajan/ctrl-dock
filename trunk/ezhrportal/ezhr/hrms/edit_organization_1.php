<?php 
include("config.php");
if (!check_feature(4)){feature_error();exit;}

$account=$_REQUEST["account"];

$sql = "select first_name,last_name,account_status,business_group_index,grade_id from user_master where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$first_name		=$row[0];
$last_name		=$row[1];
$account_status	=$row[2];
$business_group_index=$row[3];
$grade_id		= $row[4];

$sql = "select title,direct_report_to,dot_report_to from user_organization where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$title 				= $row[0];
$direct_report_to 	= $row[1];
$dot_report_to		= $row[2];

	
?>
<script src="../js/AjaxCode.js"></script>
<center>
<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr>
	<td align=left>
		<b><font face="Arial" color="#CC0000" size="2">Edit Organizations Structure for : <?=$first_name?> <?=$last_name;?></font></b>
	</td>
	<td align=right>
		<a href="user_home.php?account=<?=$account?>"><font face="Arial" color="#336699" size="1"><b>BACK</b></font></a>
	</td>
</tr>
</table>
<br>

<?
if ($account_status=="Obsolete"){
	echo "<br><center><font face=Arial size=2 color=#CC0000><b>The account is obsolete. Obsolete accounts should be updated under authorization only.</font></b>";
}
?>

<form method=POST action=edit_organization_2.php>

<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr>
	<td class=tdformlabel>Business Group</font></b></td>
        <td align=right>
		    <select size=1 name=business_group_index id=business_group_index style="font-size: 8pt; font-family: Arial" onChange="return bizgroupListOnChange(this.value)">
                	        <?php
                        	        $sub_sql = "select * from business_groups";
                                	$sub_result = mysql_query($sub_sql);
	                                while ($sub_row = mysql_fetch_row($sub_result)) {
											if ($business_group_index==$sub_row[0]){$selected="selected";}else{$selected="";}
        	                                echo "<option value='$sub_row[0]' $selected>$sub_row[1]</option>";
                	                }
                        	?>
	        </select>
        </td>
</tr>
<tr>
	<td class=tdformlabel>Grade</font></b></td>
	<td align=right><select name=grade_id  id=grade_id size=1 style="font-size: 8pt; font-family: Arial" >
						<?php
							$grade_sql = "select bizgroup_grade_mapping.grade_id, business_groups.prefix from bizgroup_grade_mapping bizgroup_grade_mapping, business_groups business_groups where bizgroup_grade_mapping.business_group_index=$business_group_index and business_groups.business_group_index=$business_group_index";
							$grade_result = mysql_query($grade_sql);
							while ($grade_row = mysql_fetch_row($grade_result)){
								if ($grade_id == $grade_row['0']){
									$grade_selected="selected";
								}else{
									$grade_selected="";
								}
								echo "<option value='$grade_row[0]' $grade_selected>$grade_row[1] -- $grade_row[0]</option>";
							}
						?>
					</select></td>
</tr>

<tr>
	<td class=tdformlabel>Title / Designation</font></b></td>
	<td align=right><input name="designation"  value="<?=$title?>" size="30" style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Reporting</b></td></tr>
<tr>
	<td class=tdformlabel>Direct Reporting</font></b></td>
        <td align=right>
                <select size=1 name=direct_report_to style="font-size: 8pt; font-family: Arial">
                        <?php

                        		echo "<option value=''></option>";
                        		
                        		$sub_sql = "select username,first_name,last_name from user_master where username!='$account' and username!='IT' and username!=' ' order by first_name ";
								$sub_result = mysql_query($sub_sql);
															
								while ($sub_row = mysql_fetch_row($sub_result)){
									if ($direct_report_to==$sub_row[0]){$selected="selected";}else{$selected="";}
	                                echo "<option value='$sub_row[0]' $selected>$sub_row[1] $sub_row[2]</option>";
								}
                         ?>
                </select>
        </td>
</tr>

<tr>
	<td class=tdformlabel>Dotted Line Reporting</font></b></td>
        <td align=right>
                <select size=1 name=dot_report_to style="font-size: 8pt; font-family: Arial">
                        <?php
                        		echo "<option value=''></option>";
                        		
                        		$sub_sql = "select username,first_name,last_name from user_master where username!='$account' and username!='IT' and username!=' ' order by first_name ";
								$sub_result = mysql_query($sub_sql);
															
								while ($sub_row = mysql_fetch_row($sub_result)){
									if ($dot_report_to==$sub_row[0]){$selected="selected";}else{$selected="";}
	                                echo "<option value='$sub_row[0]' $selected>$sub_row[1] $sub_row[2]</option>";
								}

                         ?>
                </select>
        </td>
</tr>
<input name="account" size=40 type=hidden value="<? echo $account; ?>">

<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Update Information" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>

</td>
</table>
