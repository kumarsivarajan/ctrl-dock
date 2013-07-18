<script  language="JavaScript">
window.onunload = function refreshParent(){
  window.opener.location.reload();
  window.close();
};
</script>

<?php 
include_once("config.php");

$leave_type_id=mysql_real_escape_string($_REQUEST["id"]);
$action=$_REQUEST["action"];


if ($leave_type_id > 0 && $action=="edit"){ 

  $sql 			= "select leave_type from lm_leave_type_master where leave_type_id='$leave_type_id'";
  $result 		= mysql_query($sql);
  $row			= mysql_fetch_row($result);
  $leave_type	= $row[0];
?>
<center>
<form method="POST" action="leave_types_edit.php?action=submit">
<table border=0 cellpadding=3 cellspacing=1 width=100% bgcolor=#F7F7F7>
<tr>
	<td class='tdformlabel'><b>&nbsp;Leave type</font></b>
	<br>
	<input name="leave_type" style="width:480px" class=forminputtext value='<?=$leave_type;?>'>
	<input name="id" type=hidden value='<?=$leave_type_id;?>'>
	</td>
</tr>
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Change Leave Type " name="Submit" class=forminputbutton>
	</td>
</tr>
</table>
</form>
</table>

<?php
}

if ($leave_type_id > 0 && strlen($_REQUEST["leave_type"])>0 && $action=="submit"){

	  $leave_type=$_REQUEST["leave_type"];
	  
	  $sql = "select * from lm_leave_type_master where leave_type='$leave_type'";
      $result = mysql_query($sql);
	  $count=mysql_num_rows($result);

	  if ($count==0){
			  $sql = "update lm_leave_type_master set leave_type='$leave_type' where leave_type_id='$leave_type_id'";
			  $result = mysql_query($sql);
	  }
}
?>

