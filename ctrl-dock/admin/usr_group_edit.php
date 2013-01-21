<?include("config.php");
if (!check_feature(4)){feature_error();exit;} 

$account=$_REQUEST["account"];
$action=$_REQUEST["action"];
$group_id=$_REQUEST["group_id"];

$sql = "select first_name,last_name,username from user_master where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$SELECTED="GROUP MEMBERSHIP : ".$row[0]." ".$row[1] ." (".$row[2].")";
include("header.php");

if($action=="add"){
	$sql="insert into user_group values ('$group_id','$account')";
	$result = mysql_query($sql);
}
if($action=="del"){
	$sql="delete from user_group where group_id='$group_id' and username='$account'";
	$result = mysql_query($sql);
}
?>


<form method=POST action='usr_group_edit.php?action=add&account=<?=$account?>'>
<table border=0 cellpadding=0 cellspacing=0 width=600>
<tr bgcolor=#CCCCCC>
	<td><font color=#4D4D4D face=Arial size=1><b>&nbsp;GROUPS</font></b></td>
		    <td align=right>
                <select size=1 name=group_id class=formselect>
					<?
                        $sql = "select group_id,group_name from groups where group_id not in ";
						$sql.="(select group_id from user_group where username='$account') order by group_name ";
                        $result = mysql_query($sql);
								
                        while ($row = mysql_fetch_row($result)) {
                            echo "<option value='$row[0]'>$row[1]</option>";
                        }
                    ?>
                </select>
      </td>
	  
	  <td align=right><input type=submit value="Allocate" name="Submit" style="font-size: 8pt; font-family: Arial"></td>
</tr>
</table>
</form>



<?
$sql = "select b.group_name,b.group_id from user_group a,groups b where a.group_id=b.group_id and a.username='$account'";
$result = mysql_query($sql);	  
?>




<table border=0 width=600 cellpadding=5 cellspacing=2 bgcolor=#F7F7F7>
<tr><td class=reportdata><b>Currently Member of the following groups</b></td></tr>
<?
while ($row = mysql_fetch_row($result)){
?>
		<tr>
			<td class=reportdata><?=$row[0];?></td>
			<td class=reportdata width=16><a href="usr_group_edit.php?action=del&group_id=<?=$row[1]?>&account=<?=$account?>"><img border=0 src=images/delete.gif></img></a></td>
		</tr>
<?}?>
</table>