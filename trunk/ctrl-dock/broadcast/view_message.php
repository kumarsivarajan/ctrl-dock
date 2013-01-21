<?
include("config.php");
$id=$_REQUEST["id"];
$sql = "select broadcast_date,broadcast_to,broadcast_subject,broadcast_msg,attachment_path from broadcast where broadcast_id='$id'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$broadcast_date		=date("d M Y H i",$row[0]);
$broadcast_to		=$row[1];
$broadcast_subject	=$row[2];
$broadcast_msg		=$row[3];
$attachment			=$row[4];
$file_name=substr($attachment,strpos($attachment,"/")+1);
?>

<center>
<fieldset style="width: 800px;">
		<table border="0" width=800>
		
			<tr>
				<td><label style="width: 150px;">Notification ID  : </label></td>
				<td><font face=Arial size=2><? echo $id; ?></font></td>
			</tr>
			<tr>
				<td><label style="width: 150px;">Sent On  : </label></td>
				<td><font face=Arial size=2><? echo $broadcast_date; ?></font></td>
			</tr>

			<tr>
				<td><label style="width: 150px;">To  : </label></td>
				<td><font face=Arial size=2><? echo $broadcast_to; ?></font></td>
			</tr>
			<tr>
				<td><label style="width: 150px;">Subject  : </label></td>
				<td><font face=Arial size=2><? echo $broadcast_subject; ?></font></td>
			</tr>
			<tr>
				<td><label style="width: 150px;">Attachment  : </label></td>
				<td><font face=Arial size=2><a href=<? echo $attachment; ?>><? echo $file_name; ?></a></font></td>
			</tr>

			<tr>
				<td colspan=2>
				<font face=Arial size=2><br><? echo $broadcast_msg; ?></font>
				</td>
			</tr>
		</table>
	</form>
</fieldset>