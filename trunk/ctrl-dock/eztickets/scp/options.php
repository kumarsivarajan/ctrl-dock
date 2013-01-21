<STYLE TYPE="text/css">
<?	include_once("css/style.css");?>
<?	include_once("css/main.css");?>
</STYLE>
<?
require('staff.inc.php');
require_once(INCLUDE_DIR.'class.ticket.php');
require_once(INCLUDE_DIR.'class.dept.php');
require_once(INCLUDE_DIR.'class.banlist.php');
$nav->setTabActive('options');
require_once(STAFFINC_DIR.'header.inc.php');

$staff	=$_SESSION['_staff']['userID'];

$new_tkt_not=$_REQUEST['new_tkt_not'];
$close_tkt_not=$_REQUEST['close_tkt_not'];

if(strlen($new_tkt_not)>0){
	$sub_sql="update isost_staff set new_tkt_not=$new_tkt_not,close_tkt_not=$close_tkt_not where username='$staff'";
	$sub_result = mysql_query($sub_sql);
	echo "Your settings have been saved";
}
$sub_sql="select new_tkt_not,close_tkt_not from isost_staff where username='$staff'";
$sub_result = mysql_query($sub_sql);
$sub_row	= mysql_fetch_row($sub_result);
$o_new_tkt_not=$sub_row[0];
$o_close_tkt_not=$sub_row[1];
?>
<br><br>
  <form action="options.php" method="post">
<table width="100%" border="0" cellspacing=1 cellpadding=2 bgcolor=#EEEEEE>
<tr>
	<td width=25%>&nbsp;New Ticket E-Mail Notifications</td>
	<td align=left>
	<select name=new_tkt_not>
		<option value='0' <?=$o_new_tkt_not==0?'selected':'';?>>Disabled</option>
		<option value='1' <?=$o_new_tkt_not==1?'selected':'';?>>Enabled</option>
	</select>
	</td>
</tr>
<tr>
	<td width=25%>&nbsp;Close Ticket E-Mail Notifications</td>
	<td align=left>
	<select name=close_tkt_not>
		<option value='0' <?=$o_close_tkt_not==0?'selected':'';?>>Disabled</option>
		<option value='1' <?=$o_close_tkt_not==1?'selected':'';?>>Enabled</option>
	</select>
	</td>
</tr>

    <tr>
        <td colspan=2 align=center>
            <input class="button" type="submit" name="submit_x" value="Update">
           
        </td>
    </tr>
</table>
</form>
<?

require_once(STAFFINC_DIR.$inc);
require_once(STAFFINC_DIR.'footer.inc.php');
?>
