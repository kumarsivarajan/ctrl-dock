<script  language="JavaScript">
window.onunload = function refreshParent(){
  window.opener.location.reload();
  window.close();
};
</script>

<?php 
include_once("config.php");

$policy_desc=mysql_real_escape_string($_REQUEST["policy_desc"]);


if ($policy_desc==""){ 
?>
<center>
<form method="POST" action="leave_policies_add.php">
<table border=0 cellpadding=3 cellspacing=1 width=100% bgcolor=#F7F7F7>
<tr>
	<td class='tdformlabel'><b>&nbsp;Add Leave Policy </font></b>
	<br>
	<input name="policy_desc" style="width:480px" class=forminputtext>
	</td>
</tr>
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Add Leave Policy" name="Submit" class=forminputbutton>
	</td>
</tr>
</table>
</form>
</table>

<?php
}else {

  $sql = "select * from lm_policy_master where policy_desc='$policy_desc'";
  $result = mysql_query($sql);
  $count=mysql_num_rows($result);

  if ($count==0){
  	  $sql = "insert into lm_policy_master (policy_desc) values ('$policy_desc')";
	  $result =  mysql_query($sql);
  }
}
?>