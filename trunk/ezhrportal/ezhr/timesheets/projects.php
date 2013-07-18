<?
include("config.php"); 
include_once("header.php");

$project=mysql_real_escape_string($_REQUEST["project"]);
$project_status=mysql_real_escape_string($_REQUEST["project_status"]);

$id=$_REQUEST["id"];
$action=$_REQUEST["action"];
if ($action==''){$action="add";}

if ($project!='' && $action=="edit"){
  $sql = "update timesheet_project set project_description='$project',project_status='$project_status' where project_index=$id";
  $result = mysql_query($sql);
}

if ($action=="delete"){
  $sql = "delete from timesheet_project where project_index='$id'";
  $result = mysql_query($sql);
}

if ($action=='edit'){
  $sql = "select * from timesheet_project where project_index=$id";
  $result = mysql_query($sql);	  
  $row = mysql_fetch_row($result);
  $project=$row[1];
  $project_status=$row[2];
}
?>
	<br>
	<table border=0 width=100% cellpadding="0" cellspacing="0" >
	<tr>
		<td align=left><h2>ADD / EDIT PROJECTS</h2></td>
		<td align=right>
			<a style="text-decoration: none" href="project_add.php">
			<font color="#336699" face="Arial" size="2"><b>Add Project</font></a>
		</td>
	</tr>
	</table>


	<?if($action=='edit'){
		?><form method="POST" action="projects.php?action=<?echo $action;?>&id=<? echo $id;?>"><?
	}?>
	
	<center>
	<table border=0 width=100% cellpadding=0 cellspacing=1 bgcolor=#F7F7F7>	
	<tr>
	<td class='tdformlabel'><b>&nbsp;Project Name</font></b></td>
		<td align=right><input name="project" size="40" class='forminputtext' value="<?echo htmlentities($project);?>"></td>
	<tr>
	<tr>
	<td class='tdformlabel'><b>&nbsp;Project Status</font></b></td>
		<td align=right>
		<select size=1 name=project_status style="font-size: 8pt; font-family: Arial">
			<?$selected="";if($project_status=="Active"){$selected="selected";}?>
			<option value='Active' <?=$selected;?>>Active</option>
			<?$selected="";if($project_status=="Inactive"){$selected="selected";}?>
			<option value='Inactive' <?=$selected;?>>In-Active</option>
        </select>
		</td>
	<tr>
	<td colspan=2 align=center>		
		<br><input type=submit value="Update Project" name="Submit"  class='forminputbutton'>
	</td>
	</tr>
	</form>
	</table>
	<br>
<?

	$sql = "select * from timesheet_project order by project_description";
	$result = mysql_query($sql);
	$num_rows=mysql_num_rows($result);
	if ($num_rows>0){
		?>		
		<table class="reporttable" cellspacing=1 cellpadding=5 width=100%>
		<tr>	
		<td class="reportheader">Project</td>
		<td class="reportheader">Status</td>
		<td class="reportheader" width=60>Edit</td>
		<!--<td class="reportheader" width=60>Delete</td>-->
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
			echo "<td class=reportdata width=60 style='text-align: center;'><a href='projects.php?action=edit&id=$row[0]'><img src=images/edit.gif border=0></img></td>";
			//echo "<td class=reportdata width=60 style='text-align: center;'><a href='projects.php?action=delete&id=$row[0]'><img src=images/delete.gif border=0></img></a></td>";
			echo "</tr>";
			$i++;
	}	
	echo "</table>";

?>