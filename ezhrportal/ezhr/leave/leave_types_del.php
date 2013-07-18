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

if ($leave_type_id > 0 && $action=="del"){ 

  $sql 			= "select leave_type from lm_leave_type_master where leave_type_id='$leave_type_id'";
  $result 		= mysql_query($sql);
  $row			= mysql_fetch_row($result);
  $leave_type	= $row[0];
?>
<center>
<form method="POST" action="leave_types_del.php?action=delconfirm">
<table border=0 cellpadding=3 cellspacing=1 width=100% bgcolor=#F7F7F7>
<tr>
	<td class='tdformlabel'><b>&nbsp;Delete Leave type : <?=$leave_type;?> </font></b>
	<input name="id" type=hidden value='<?=$leave_type_id;?>'>
	</td>
</tr>
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Confirm Deletion" name="Submit" class=forminputbutton>
	</td>
</tr>
</table>
</form>
</table>

<?php
}

if ($leave_type_id > 0 && $action=="delconfirm"){

	$sql = "select * from lm_leave_policy_details where leave_type_id='$leave_type_id'";
    $result = mysql_query($sql);
	$count=mysql_num_rows($result);
	  
	if ($count > 0 && $leave_type_id==4){?>
		<table border=0 cellpadding=3 cellspacing=1 width=100% bgcolor=#F7F7F7>
		<tr><td class=reportdata>The Leave type cannot be deleted. Its part of a Leave policy definition.</td></tr>
	  <?} else{
		$sql = "delete from lm_leave_type_master where leave_type_id='$leave_type_id'";
		$result = mysql_query($sql);
	}
}
?>

