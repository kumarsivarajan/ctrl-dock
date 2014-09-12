<?php 
include("config.php"); 
if (!check_feature(40)){feature_error();exit;}
$SELECTED="EDIT VENDOR / CUSTOMER";
include("header.php");

$agency_index=$_REQUEST["agency_index"];

$sql = "select * from agency where agency_index='$agency_index'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
?>

<form method=POST action=edit_agency_2.php>

<table border=0 cellpadding=2 cellspacing=0 width=100%>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Agency Information</b></td></tr>
<tr>
	<td class='tdformlabel'><b>Agency Name</font></b></td>
	<td align=right><input name="name" size="40" value="<? echo $row[1]; ?>" class='forminputtext'></td>
</tr>
<tr>
<td class='tdformlabel'><b>Agency Type</font></b></td>
        <td align=right>
                <select size=1 name=type class='formselect'>
                        <?php
				echo "<option value='$row[2]'>$row[2]</option>";
                                $sub_sql = "select agency_type from agency_type";
                                $sub_result = mysql_query($sub_sql);
                                while ($sub_row = mysql_fetch_row($sub_result)) {
                                        echo "<option value='$sub_row[0]'>$sub_row[0]</option>";
                                }
                        ?>
                </select>
        </td>
</tr>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Contact Details </b></td></tr>
<tr>
	<td class='tdformlabel'><b>Address</font></b></td>
	<td align=right><textarea rows="3" name="address" cols="42" class='formtextarea'><? echo $row[3]; ?></textarea></td>
</tr>
<tr>
	<td class='tdformlabel'><b>Phone</font></b></td>
	<td align=right><input name="contact_phone" value="<? echo $row[4]; ?>" size="40" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>Fax</font></b></td>
	<td align=right><input name="contact_fax" size="40"  value="<? echo $row[5]; ?>" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>E-Mail</font></b></td>
	<td align=right><input name="contact_email" size="40"  value="<? echo $row[6]; ?>" class='forminputtext'></td>
</tr>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Primary Contact </b></td></tr>
<tr>
	<td class='tdformlabel'><b>Name</font></b></td>
	<td align=right><input name="prim_contact" size="40" value="<? echo $row[7]; ?>" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>Phone</font></b></td>
	<td align=right><input name="prim_phone" size="40" value="<? echo $row[8]; ?>" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>E-Mail</font></b></td>
	<td align=right><input name="prim_email" size="40" value="<? echo $row[9]; ?>" class='forminputtext'></td>
</tr>


<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Secondary Contact </b></td></tr>
<tr>
	<td class='tdformlabel'><b>Name</font></b></td>
	<td align=right><input name="sec_contact" size="40" value="<? echo $row[10]; ?>" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>Phone</font></b></td>
	<td align=right><input name="sec_phone" size="40" value="<? echo $row[11]; ?>" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>E-Mail</font></b></td>
	<td align=right><input name="sec_email" size="40" value="<? echo $row[12]; ?>" class='forminputtext'></td>
</tr>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Payment Terms </b></td></tr>
<tr>
	<td colspan=2 align=right><textarea rows="3" name="payment_terms" style="width: 100%" class='formtextarea'><? echo $row[14]; ?></textarea></td>
</tr>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Bank Information </b></td></tr>
<tr>
	<td colspan=2 align=right><textarea rows="3" name="bank_info" style="width: 100%" class='formtextarea'><? echo $row[15]; ?></textarea></td>
</tr>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Comments </b></td></tr>
<tr>
	<td colspan=2 align=right><textarea rows="3" name="comments" style="width: 100%" class='formtextarea'><? echo $row[13]; ?></textarea></td>
</tr>



<tr>
	<td colspan=2 align=center>
		<input name="agency_index" type=hidden value="<? echo $agency_index; ?>">
		<br><input type=submit value="Save Agency Information" name="Submit" class='forminputbutton'>
	</td>
</tr>
</form>
</table>
