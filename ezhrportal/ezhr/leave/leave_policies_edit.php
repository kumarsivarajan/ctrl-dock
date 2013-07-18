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


if ($policy_id > 0 && $action=="edit"){ 

  $sql 			= "select policy_desc from lm_policy_master where policy_id='$policy_id'";
  $result 		= mysql_query($sql);
  $row			= mysql_fetch_row($result);
  $policy_desc	= $row[0];
?>
<center>
<form method="POST" action="leave_policies_edit.php?action=submit">
<table border=0 cellpadding=3 cellspacing=1 width=100% bgcolor=#F7F7F7>
<tr>
	<td class='tdformlabel'><b>&nbsp;Leave Policy</font></b>
	<br>
	<input name="policy_desc" style="width:480px" class=forminputtext value='<?=$policy_desc;?>'>
	<input name="id" type=hidden value='<?=$policy_id;?>'>
	</td>
</tr>
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Change Leave Policy" name="Submit" class=forminputbutton>
	</td>
</tr>
</table>
</form>
</table>

<?php
}

if ($policy_id > 0 && strlen($_REQUEST["policy_desc"])>0 && $action=="submit"){

	  $policy_desc=$_REQUEST["policy_desc"];
	  
	  $sql = "select * from lm_policy_master where policy_desc='$policy_desc'";
      $result = mysql_query($sql);
	  $count=mysql_num_rows($result);

	  if ($count==0){
			  $sql = "update lm_policy_master set policy_desc='$policy_desc' where policy_id='$policy_id'";
			  $result = mysql_query($sql);
	  }
}
?>

