<script  language="JavaScript">
window.onunload = function refreshParent(){
  window.opener.location.reload();
  window.close();
};
</script>

<?php 
include_once("config.php");

$leave_type=mysql_real_escape_string($_REQUEST["leave_type"]);


if ($leave_type==""){ 
?>
<center>
<form method="POST" action="leave_types_add.php">
<table border=0 cellpadding=3 cellspacing=1 width=100% bgcolor=#F7F7F7>
<tr>
	<td class='tdformlabel'><b>&nbsp;Add Leave type</font></b>
	<br>
	<input name="leave_type" style="width:480px" class=forminputtext>
	</td>
</tr>
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Add Leave Type " name="Submit" class=forminputbutton>
	</td>
</tr>
</table>
</form>
</table>

<?php
}else {

  $sql = "select * from lm_leave_type_master where leave_type='$leave_type'";
  $result = mysql_query($sql);
  $count=mysql_num_rows($result);

  if ($count==0){
  	  $sql = "insert into lm_leave_type_master (leave_type) values ('$leave_type')";
	  $result =  mysql_query($sql);
	}
}
?>

