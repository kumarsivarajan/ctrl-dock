<?include("config.php"); ?>
<?include("header.php");?>

<?
$sql="select email from asset_template";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
$message=$row[0];

?>
<center>
<a href=asset_notify_1.php><h3>SEND ASSET VERIFICATION NOTE</h3></a>
<br><br>
	<form method="POST" action="asset_2.php">
		<table border=0 cellpadding=3 cellspacing=0 width=100% bgcolor=#EEEEEE>
			<tr>
				<td class='tdformlabel'><b>Message Template</font></b></td>
			</tr>
			<tr>
				<td align=right>				
					<textarea class=formtextarea rows="25" id="body" name="body"><?=$message;?></textarea>					
					<script>make_wyzz('body');</script>
				</td>
			</tr>

			<tr>				
				<td align="center">
					<input class="forminputbutton" type="submit" value="Save Template" name="Submit">
				</td>		
			</tr>
		</table>
	</form>



