<?
include("config.php"); 
if (!check_feature(17)){feature_error();exit;}


$group=mysql_real_escape_string($_REQUEST["group"]);
$group_desc=mysql_real_escape_string($_REQUEST["group_desc"]);
$id=$_REQUEST["id"];
$action=$_REQUEST["action"];
if ($action==''){$action="add";}

if ($group!='' && $action=="edit"){
  $sql = "update ezhr_groups set group_name='$group',group_description='$group_desc' where group_id=$id";
  $result = mysql_query($sql);
}

if ($action=="delete"){
 
  $sql = "delete from ezhr_groups where group_id='$id'";
  $result = mysql_query($sql);

  $sql = "delete from ezhr_user_group where group_id='$id'";
  $result = mysql_query($sql);  
  
  $sql = "delete from ezhr_group_feature where group_id='$id'";
  $result = mysql_query($sql);  
}

if ($action=='edit'){
  
  $sql = "select * from ezhr_groups where group_id=$id";
  $result = mysql_query($sql);	  
  $row = mysql_fetch_row($result);
  $group=$row[1];
  $group_desc=$row[2];
}
?>
	
	<table border=0 width=100% cellpadding="0" cellspacing="0" >
	<tr>
		<td align=left><h2>PROFILE MANAGEMENT</h2></td>
		<td align=right></td>
	</tr>
	</table>


	<?if($action=='edit'){
		?><form method="POST" action="groups.php?action=<?echo $action;?>&id=<? echo $id;?>"><?
	}?>
	
	<center>
	<table border=0 width=100% cellpadding=0 cellspacing=1 bgcolor=#F7F7F7>	
	<tr>
	<td class='tdformlabel'><b>&nbsp;Profile</font></b></td>
		<td align=right><input name="group" size="40" class='forminputtext' value="<?echo htmlentities($group);?>"></td>
	</tr>
		<td class='tdformlabel'><b>&nbsp;Description</font></b></td>
		<td align=right><input name="group_desc" size="40" class='forminputtext' value="<?echo htmlentities($group_desc);?>"></td>
	</tr>
	<tr>
	<td colspan=2 align=center>		
		<br><input type=submit value="Update Profile" name="Submit"  class='forminputbutton'>
	</td>
	</tr>
	</form>
	</table>
	<br>
<?

	$sql = "select * from ezhr_groups order by group_name";
	$result = mysql_query($sql);
	$num_rows=mysql_num_rows($result);
	if ($num_rows>0){
		?>		
		<table class="reporttable" cellspacing=1 cellpadding=1 width=100%>
		<tr>
			<td colspan=6 align=right>
				<a style="text-decoration: none" href="group_add.php">
			<font color="#99CC33" face="Arial" size="2"><b>Add Profile</font></a>
			</td>
		</tr>		
		<tr>	
		<td class="reportheader">Profile</td>
		<td class="reportheader">Description</td>
		<td class="reportheader" width=60>Members</td>
		<td class="reportheader" width=60>Features</td>
		<td class="reportheader" width=60>Edit</td>
		<td class="reportheader" width=60>Delete</td>
		</tr>
		<?
	}
	$i=1;
	$row_color="#FFFFFF";
	while ($row = mysql_fetch_row($result)){
			if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
			echo "<tr bgcolor=$row_color>";			
			echo "<td class=reportdata >$row[1]</td>";
			echo "<td class=reportdata >$row[2]</td>";
			echo "<td class=reportdata width=60 style='text-align: center;'><a href='group_members.php?id=$row[0]&group=$row[1]'><img src=images/members.gif border=0></img></td>";
			echo "<td class=reportdata width=60 style='text-align: center;'><a href='group_features.php?id=$row[0]&group=$row[1]'><img src=images/service.gif border=0></img></td>";
			echo "<td class=reportdata width=60 style='text-align: center;'><a href='groups.php?action=edit&id=$row[0]'><img src=images/edit.gif border=0></img></td>";
			echo "<td class=reportdata width=60 style='text-align: center;'><a href='groups.php?action=delete&id=$row[0]'><img src=images/delete.gif border=0></img></a></td>";
			echo "</tr>";
			$i++;
	}	
	echo "</table>";
 


?>