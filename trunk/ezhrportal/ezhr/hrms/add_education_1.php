<?php 
include("config.php"); 
include("callcalendar.html"); 

$account=$_REQUEST["account"];
?>
<?
if ($account_status=="Obsolete"){
	echo "<br><center><font face=Arial size=2 color=#CC0000><b>The account is obsolete. Obsolete accounts should be updated under authorization only.";
}
?>
<form method=POST action=add_education_2.php>

<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Add Education Details</b></td></tr>
<tr>
	<td class=tdformlabel>Type of Course</td>
        <td align=right>
                <select size=1 name=type_of_course style="font-size: 8pt; font-family: Arial">
                        <?php
 
                                echo "<option value='Pre-University'>Pre-University</option>";
                                echo "<option value='Graduation'>Graduation</option>";
                                echo "<option value='Professional'>Professional</option>";
                                echo "<option value='Post Graduation'>Post Graduation</option>";
                                echo "<option value='Certificate Course'>Certificate Course</option>";

                        ?>
                </select>
        </td>
</tr>

<tr>
	<td class=tdformlabel>Name of the Course</td>
	<td align=right><input name="name_of_course"  size="40" style="font-size: 8pt; font-family: Arial"></td>
</tr>

<tr>
	<td class=tdformlabel>University / Institution</td>
	<td align=right><input name="university_institution"  size="40" style="font-size: 8pt; font-family: Arial"></td>
</tr>

<tr>
	<td class=tdformlabel>Year of Completion</td>
	<td align=right><input name="year_of_completion"  size="4" style="font-size: 8pt; font-family: Arial"></td>
</tr>

<input name="account" size=40 type=hidden value="<? echo $account; ?>">

<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Submit" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>
