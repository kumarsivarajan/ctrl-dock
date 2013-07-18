<head>
<script type="text/javascript">
function newPopup(url,w,h) {
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
	popupWindow = window.open(url,'popUpWindow','resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=no,width='+w+', height='+h+', top='+top+', left='+left);
}
</script>
 </head>

<?
include_once("config.php"); 
include_once("header.php");


?>
	<br>
	<table border=0 width=100% cellpadding="0" cellspacing="0" >
	<tr>
		<td align=left><h2>MANAGE LEAVE POLICIES</h2></td>
		<td align=right>
			<a style="text-decoration: none" <a href=JavaScript:newPopup('leave_policies_add.php','500','200'); style='text-decoration: none;color:#336699'>
			<font color="#336699" face="Arial" size="2"><b>Add Leave Policy</font></a>
		</td>
	</tr>
	</table>
	
	<center>
	<br>
<?
	$sql = "select policy_id,policy_desc from lm_policy_master order by policy_desc";
	$result = mysql_query($sql);
	$num_rows=mysql_num_rows($result);
	if ($num_rows>0){
		?>		
		<table class="reporttable" cellspacing=1 cellpadding=5 width=100%>
		<tr>	
		<td class="reportheader">Leave Policy</td>
		<td class="reportheader" width=60>Edit</td>
		<td class="reportheader" width=60>Details</td>
		<td class="reportheader" width=60>Delete</td>
		</tr>
		<?
	
	$i=1;
	$row_color="#FFFFFF";
	while ($row = mysql_fetch_row($result)){
			if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
			echo "<tr bgcolor=$row_color>";			
			echo "<td class=reportdata >$row[1]</td>";
			echo "<td class=reportdata width=60 style='text-align: center;'><a href=JavaScript:newPopup('leave_policies_edit.php?id=$row[0]&action=edit','500','200');><img src=images/edit.gif border=0></img></td>";
			echo "<td class=reportdata width=60 style='text-align: center;'><a href=JavaScript:newPopup('leave_policies_details.php?id=$row[0]','600','400');><img src=images/details.gif border=0></img></td>";
			echo "<td class=reportdata width=60 style='text-align: center;'><a href=JavaScript:newPopup('leave_policies_del.php?id=$row[0]&action=del','500','200');><img src=images/delete.gif border=0></img></a></td>";
			echo "</tr>";
			$i++;
	}
	echo "</table>";
	}

?>