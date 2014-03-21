<?
include("config.php"); 
if (!check_feature(12)){feature_error();exit;}
?>

<?
$business_group_name=mysql_real_escape_string($_REQUEST["business_group_name"]);
$id=$_REQUEST["id"];
$action=$_REQUEST["action"];
if ($action==''){$action="add";}

if ($business_group_name!='' && $action=="add"){
  if (!check_feature(13)){feature_error();exit;}
  $sql = "insert into business_groups (business_group) values('$business_group_name')";
  $result = mysql_query($sql);	  
}

if ($business_group_name!='' && $action=="edit"){
  if (!check_feature(14)){feature_error();exit;}
  $sql = "update business_groups set business_group='$business_group_name' where business_group_index=$id";
  $result = mysql_query($sql);
}

if ($id!=1 && $action=="delete"){
  if (!check_feature(15)){feature_error();exit;}
  $sql = "delete from business_groups where business_group_index='$id'";
  $result = mysql_query($sql);

  $sql = "update user_master set business_group_index='1' where business_group_index='$id'";
  $result = mysql_query($sql);
  ?>
  <meta http-equiv="Refresh" content="1; URL=business_groups.php">
  <?
}

if ($action=='edit'){
  $sql = "select * from business_groups where business_group_index=$id";
  $result = mysql_query($sql);	  
  $row = mysql_fetch_row($result);
  $business_group_name=$row[1];  
}
?>
<?
$SELECTED="DEPARTMENTS";
include("header.php");
?>
<script type="text/javascript">

function change(){

var text=document.forms["form"]["business_group_name"].value;
var len = text.length;

var s = text;

for(i=0; i<len; i++)
{
    s = s.replace(/[\u2018|\u2019|\u201A]/g, "\'");
    // smart double quotes
    s = s.replace(/[\u201C|\u201D|\u201E]/g, "\"");
    // ellipsis
    s = s.replace(/\u2026/g, "...");
    // dashes
    s = s.replace(/[\u2013|\u2014]/g, "-");
    // circumflex
    s = s.replace(/\u02C6/g, "^");
    // open angle bracket
    s = s.replace(/\u2039/g, "<");
    // close angle bracket
    s = s.replace(/\u203A/g, ">");
    // spaces
    s = s.replace(/[\u02DC|\u00A0]/g, " ");
}
 
 document.forms["form"]["business_group_name"].value = s;
}
</script>
	<form method="POST" action="business_groups.php?action=<?echo $action;?>" name="form">
	<center>
	<table border=0 width=100% cellpadding=0 cellspacing=1 bgcolor=#F7F7F7> 
	<tr>
	<td class='tdformlabel'><b>Department</font></b></td>
		<td align=right><?if($action=='edit'){ ?><input name="business_group_name" size="70" class='forminputtext' value="<?echo htmlentities($business_group_name);?>"><? } else { ?><input name="business_group_name" size="40" class='forminputtext'><? } ?></td>
	</tr>	
	<tr>
	<td colspan=2 align=center>
		<?if($action=='edit'){echo "<input type=hidden name=id value='$id'>";}?>
		<br><input type=submit value="Add / Update Department" name="Submit"  class='forminputbutton' onclick="change()">
	</td>
	</tr>
	</form>
	</table>
	<br>
<?

	$sql = "select * from business_groups order by business_group";
	$result = mysql_query($sql);
	$num_rows=mysql_num_rows($result);
	if ($num_rows>0){
	?>
	<table class="reporttable" width=100%>
	<tr>	
	<td class="reportheader">Business Group</td>
	<td class="reportheader">Edit</td>
	<td class="reportheader">Delete</td>
	</tr>
	<?
	}
	$i=1;
	$row_color="#FFFFFF";
	while ($row = mysql_fetch_row($result)){
			if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
			echo "<tr bgcolor=$row_color>";
			echo "<td class=reportdata >$row[1]</td>";
			echo "<td class=reportdata width=40 style='text-align: center;'><a href=business_groups.php?action=edit&id=$row[0]><img src=images/edit.gif border=0></img></td>";
			echo "<td class=reportdata width=40 style='text-align: center;'><a href=business_groups.php?action=delete&id=$row[0]><img src=images/delete.gif border=0></img></a></td>";
			echo "</tr>";
		$i++;
	}	
	echo "</table>";
 


?>
