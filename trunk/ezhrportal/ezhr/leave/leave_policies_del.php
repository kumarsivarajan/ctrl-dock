<script  language="JavaScript">
window.onunload = function refreshParent(){
  window.opener.location.reload();
  window.close();
};
</script>

<?php 
include_once("config.php");

$policy_id=mysql_real_escape_string($_REQUEST["id"]);
$action=$_REQUEST["action"];

if ($policy_id > 0 && $action=="del"){ 

  $sql 			= "select policy_desc from lm_policy_master where policy_id='$policy_id'";
  $result 		= mysql_query($sql);
  $row			= mysql_fetch_row($result);
  $policy_desc	= $row[0];
?>
<center>
<form method="POST" action="leave_policies_del.php?action=delconfirm">
<table border=0 cellpadding=3 cellspacing=1 width=100% bgcolor=#F7F7F7>
<tr>
	<td class='tdformlabel'><b>&nbsp;Delete Leave policy : <?=$policy_desc;?> </font></b>
	<input name="id" type=hidden value='<?=$policy_id;?>'>
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

	$sql = "select * from lm_user_leave_policy where policy_id='$policy_id'";
    $result = mysql_query($sql);
	$count=mysql_num_rows($result);
	  
	if ($count > 0){?>
		<table border=0 cellpadding=3 cellspacing=1 width=100% bgcolor=#F7F7F7>
		<tr><td class=reportdata>The Leave policy cannot be deleted. It is currently assigned to users.</td></tr>
	  <?} else{
		$sql = "delete from lm_policy_master where policy_id='$policy_id'";
		$result = mysql_query($sql);
	}
}
?>