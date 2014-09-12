<?php 
include("config.php"); 
if (!check_feature(39)){feature_error();exit;}
$SELECTED="ADD VENDOR / CUSTOMER";
include("header.php");
?>
<form method=POST action=add_agency_2.php>

<table border=0 cellpadding=2 cellspacing=0 width=100%>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>General Information</b></td></tr>
<tr>
	<td class='tdformlabel'><b>Name</font></b></td>
	<td align=right><input name="name" size="40" class='forminputtext'></td>
</tr>
<tr>
<td class='tdformlabel'><b>Type</font></b></td>
        <td align=right>
                <select size=1 name=type class='formselect'>
                        <?php
                                $sql = "select agency_type from agency_type";
                                $result = mysql_query($sql);
                                while ($row = mysql_fetch_row($result)) {
                                        echo "<option value='$row[0]'>$row[0]</option>";
                                }
                        ?>
                </select>
        </td>
</tr>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>Contact Details </b></td></tr>
<tr>
	<td class='tdformlabel'><b>Address</font></b></td>
	<td align=right><textarea rows="3" name="address" cols="42" class='formtextarea'></textarea></td>
</tr>
<tr>
	<td class='tdformlabel'><b>Phone</font></b></td>
	<td align=right><input name="contact_phone" size="40" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>Fax</font></b></td>
	<td align=right><input name="contact_fax" size="40" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>E-Mail</font></b></td>
	<td align=right><input name="contact_email" size="40" class='forminputtext'></td>
</tr>


<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>Primary Contact </b></td></tr>
<tr>
	<td class='tdformlabel'><b>Name</font></b></td>
	<td align=right><input name="prim_contact" size="40" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>Phone</font></b></td>
	<td align=right><input name="prim_phone" size="40" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>E-Mail</font></b></td>
	<td align=right><input name="prim_email" size="40" class='forminputtext'></td>
</tr>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>Secondary Contact </b></td></tr>
<tr>
	<td class='tdformlabel'><b>Name</font></b></td>
	<td align=right><input name="sec_contact" size="40" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>Phone</font></b></td>
	<td align=right><input name="sec_phone" size="40" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>E-Mail</font></b></td>
	<td align=right><input name="sec_email" size="40" class='forminputtext'></td>
</tr>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Payment Terms </b></td></tr>
<tr>
	<td colspan=2 align=right><textarea rows="3" name="payment_terms" style="width: 100%" class='formtextarea'></textarea></td>
</tr>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Bank Information </b></td></tr>
<tr>
	<td colspan=2 align=right><textarea rows="3" name="bank_info" style="width: 100%" class='formtextarea'></textarea></td>
</tr>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Comments </b></td></tr>
<tr>
	<td colspan=2 align=right><textarea rows="3" name="comments" style="width: 100%" class='formtextarea'></textarea></td>
</tr>
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Save" name="Submit" class='forminputbutton'>
	</td>
</tr>
</form>
</table>
