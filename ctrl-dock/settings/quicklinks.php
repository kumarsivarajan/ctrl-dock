<?
include("config.php"); 
if (!check_feature(28)){feature_error();exit;} 

$SELECTED="QUICK LINKS";
include("header.php");
?>

<?
$link=mysql_real_escape_string($_REQUEST["link"]);
$link_name=mysql_real_escape_string($_REQUEST["link_name"]);
$link_priority=$_REQUEST["link_priority"];
$id=$_REQUEST["id"];
$action=$_REQUEST["action"];
if ($action==''){$action="add";}

if ($link!='' && $link_name!='' && $link_priority!='' && $action=="add"){
  if (!check_feature(29)){feature_error();exit;} 
  $sql = "insert into quick_links (link,link_name,link_priority) values('$link','$link_name','$link_priority')";
  $result = mysql_query($sql);	  
}

if ($link!='' && $link_name!='' && $link_priority!='' && $action=="edit"){
  if (!check_feature(30)){feature_error();exit;} 
  $sql = "update quick_links set link='$link', link_name='$link_name', link_priority='$link_priority' where link_id=$id";
  $result = mysql_query($sql);	  
}

if ($action=="delete"){
if (!check_feature(31)){feature_error();exit;} 
  $sql = "delete from quick_links where link_id=$id";
  $result = mysql_query($sql);	  
}

if ($action=='edit'){
  $sql = "select * from quick_links where link_id=$id";
  $result = mysql_query($sql);	  
  $row = mysql_fetch_row($result);
  $link=$row[1];
  $link_name=$row[2];
  $link_priority=$row[3];
}
?>
	<form method="POST" action="quicklinks.php?action=<?echo $action;?>">
	<center>
	<table border=0 width=100% cellpadding=0 cellspacing=1 bgcolor=#F7F7F7> 
	<tr>
	<td class='tdformlabel'><b>&nbsp;Name of the Link</font></b></td>
		<td align=right><input name="link_name" size="40" class='forminputtext' value="<?echo htmlentities($link_name);?>"></td>
	</tr>
	<tr>
		<td class='tdformlabel'><b>&nbsp;URL</font></b></td>
		<td align=right><input name="link" size="40" class='forminputtext' value="<?echo htmlentities($link);?>"></td>
	</tr>
	<tr>
		<td class='tdformlabel'><b>&nbsp;Order of Appearance</font></b></td>
		<td align=right><input name="link_priority" size="2" class='forminputtext' value=<?echo $link_priority;?>></td>
	</tr>
	<tr>
	<td colspan=2 align=center>
		<?if($action=='edit'){echo "<input type=hidden name=id value='$id'>";}?>
		<br><input type=submit value="Add / Update Link" name="Submit"  class='forminputbutton'>
	</td>
	</tr>
	</form>
	</table>
	<br>
	
<?

	$sql = "select * from quick_links order by link_priority,link_name";
	$result = mysql_query($sql);
	$num_rows=mysql_num_rows($result);
	if ($num_rows>0){
	?>
	<table class="reporttable" width=100%>
	<tr>	
	<td class="reportheader">Name</td>
	<td class="reportheader">URL</td>
	<td class="reportheader">Order</td>
	<td class="reportheader">Edit</td>
	<td class="reportheader">Delete</td>
	</tr>
	<?
	}
	while ($row = mysql_fetch_row($result)){
			echo "<tr>";			
			echo "<td class=reportdata width=200>$row[2]</td>";
			echo "<td class=reportdata >$row[1]</td>";
			echo "<td class=reportdata width=40 style='text-align: center;'>$row[3]</td>";
			echo "<td class=reportdata width=40 style='text-align: center;'><a href=quicklinks.php?action=edit&id=$row[0]><img src=images/edit.gif border=0></img></td>";
			echo "<td class=reportdata width=40 style='text-align: center;'><a href=quicklinks.php?action=delete&id=$row[0]><img src=images/delete.gif border=0></img></a></td>";
			echo "</tr>";		
	}	
	echo "</table>";
 


?>