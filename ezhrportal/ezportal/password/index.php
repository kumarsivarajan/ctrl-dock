<?include_once("../auth.php");?>
<html>
<body>
  <center>
	<form name=addform method="post" action="chng_passwd.php">
    <p><b><font face="Arial" color="#CC0000" size="2">Change Password</font></b></p>
    <table border="1" cellpadding="0"  width="500" height="149" style="border-width:0px; border-collapse: collapse; " bordercolor="#FFFFFF" bgcolor=#DDDDDD id="table2">
      <tr>
        <td width="184" height="29" style="border-style:none; border-width:medium; " bordercolor="#FFFFFF">
		<p style="margin-top: 0; margin-bottom: 0"><b>
		<font face="Arial" size="2">&nbsp;Old Password</font></b></td>
        <td width="329" height="29" align="right" style="border-style:none; border-width:medium; " bordercolor="#FFFFFF">
		<font face="Arial" size="1">
        <input type="password" name="oldpassword" size="30" tabindex="2"></font>&nbsp;</td>
      </tr>
      <tr>
        <td width="549" height="31" colspan="2" style="border-style:none; border-width:medium; " bordercolor="#FFFFFF">
        <p align="center" style="margin-top: 0; margin-bottom: 0">
		<b>
		<font face="Arial" color="#3366CC" size="1">New 
        password to be atleast 8 characters in length</font></b></td>
      </tr>
      <tr>
        <td width="184" height="26" style="border-style:none; border-width:medium; " bordercolor="#FFFFFF">
		<p style="margin-top: 0; margin-bottom: 0"><b>
		<font face="Arial" size="2" color="#003366">&nbsp;New Password</font></b></td>
        <td width="329" height="26" align="right" style="border-style:none; border-width:medium; " bordercolor="#FFFFFF">
		<p style="margin-top: 0; margin-bottom: 0"><font face="Arial" size="1">
        <input type="password" name="password1" size="30" tabindex="3"></font>&nbsp;</td>
      </tr>
      <tr>
        <td width="184" height="32" style="border-style:none; border-width:medium; " bordercolor="#FFFFFF">
		<p style="margin-top: 0; margin-bottom: 0"><b>
		<font face="Arial" size="2" color="#003366">&nbsp;Verify New Password</font></b></td>
        <td width="329" height="32" align="right" style="border-style:none; border-width:medium; " bordercolor="#FFFFFF">
		<p style="margin-top: 0; margin-bottom: 0"><font face="Arial" size="1">
        <input type="password" name="password2" size="30" tabindex="4"></font>&nbsp;</td>
      </tr>
</table>
  	<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
  </center>

    <center>
       <BR>
        <input type="submit" name="submit" value="Change Password" tabindex="5" style="color: #003366; font-family: Arial; font-size: 8pt; font-weight: bold">
        </p>
        </center>
</form>
</body>
</html>
