<?include("config.php"); ?>
<?include("header.php");?>
<center>
	<form method="POST" action="general_2.php">
		<table border=0 cellpadding=3 cellspacing=0 width=100% bgcolor=#EEEEEE>
			<tr>
				<td class='tdformlabel'><b>To Address</font></b></td>
				<td align=right>
					<input size=100 class=forminputtext name="email_to">
				</td>
			</tr>
			<tr>
				<td class='tdformlabel'><b>Subject</font></b></td>
				<td align=right>
				<input size=100 class=forminputtext name="subject">
				</td>
			</tr>
			<tr>
				<td class='tdformlabel' colspan=2><b>Message</font></b></td>
			</tr>
			<tr>
				<td align=right colspan=2>				
					<textarea class=formtextarea rows="25" id="body" name="body"></textarea>					
					<script>make_wyzz('body');</script>
				</td>
			</tr>

			<tr>				
				<td align="center" colspan=2>
					<input class="forminputbutton" type="submit" value="Send Message" name="Submit">
				</td>		
			</tr>
		</table>
	</form>


