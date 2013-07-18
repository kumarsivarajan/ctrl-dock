<?php 
include("config.php");
include_once("header.php");

$project=mysql_real_escape_string($_REQUEST["project"]);


if ($project==""){ 
?>
<center>
<form method="POST" action="project_add.php">
<table border=0 cellpadding=3 cellspacing=1 width=100% bgcolor=#F7F7F7>
<tr>
	<td class='tdformlabel'><b>&nbsp;Provide a name for the new project</font></b></td>
	<td align=right><input name="project" size="40" class=forminputtext></td>
</tr>
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Save" name="Submit" class=forminputbutton>
	</td>
</tr>
</table>
</form>
</table>

<?php
}else {
  $sql = "select count(*) from timesheet_project where project_description='$project'";
  $result = mysql_query($sql);
  while ($count = mysql_fetch_row($result)) { 
	if ($count[0] > 0){
		$error=1;
	}
  }
 
  if ($error!=1){
 	  $sql = "insert into timesheet_project (project_description,project_status) values ('$project','Active')";
	  mysql_query($sql);
		?>
		<center><b><font color="#003366" face="Arial" size=2>The New Project has been successfully added.</font></b></center>
		<meta http-equiv="Refresh" content="1; URL=projects.php">

		<?php
		$service="";
		$comments="";
  } else {
	?>	
	<b><font color="#003366" size=2 face="Arial"><br>A Project with this name already exists. Please wait and try again..</font> 
	<meta http-equiv="Refresh" content="2; URL=projects.php">
	<?php
  }
}
?>

