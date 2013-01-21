<?include("config.php"); ?>
<?include("header.php");?>

<center>
	<form method="POST" action="notice_2.php">
	<table border=0 cellpadding=3 cellspacing=0 width=100% bgcolor=#EEEEEE>
			<tr>
				<td class='tdformlabel'><b>To Address</font></b></td>
				<td align=right><input size=100 class=forminputtext name="email_to"></td>
			</tr>
			<tr>
				<td class='tdformlabel'><b>Communication Type</font></b></td>
				<td align=right>
					<select size=1 class=formselect name="comm_type">
						<option value='Alert'>Alert</option>
						<option value='Reminder 1'>Reminder 1</option>
						<option value='Reminder 2'>Reminder 2</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td class='tdformlabel'><b>Activity Type</font></b></td>
				<td align=right>
					<select size=1 class=formselect name="activity_type">
						<option value='Scheduled'>Scheduled</option>
						<option value='Unscheduled'>Unscheduled</option>
					</select>					
				</td>
			</tr>
			<tr>
				<td class='tdformlabel'><b>Activity / Incident</font></b></td>
				<td align=right>
					<select size=1 class=formselect name="activity">
						<option value='Failure'>Failure</option>
						<option value='Changes'>Changes</option>
						<option value='Upgrade'>Upgrade</option>						
						<option value='Maintenance'>Maintenance</option>
						<option value='Termination'>Termination</option>						
					</select>
				</td>
			</tr>
			
			<tr>
				<td class='tdformlabel'><b>From Date / Time</font></b></td>
				<td align=right>
					<input style="width: 80px;" class=forminputtext name=from_date id="from_date" onclick="fPopCalendar('from_date')">
					<select size=1 class=formselect name="from_time_hh">
					<?
						for($i=0;$i<24;$i++){
							if ($i<10){$i="0".$i;}
							echo "<option value='$i'>$i</option>";
						}
					?>
					</select>
					<select size=1 class=formselect name="from_time_mm">
					<?
						for($i=0;$i<60;$i++){
							if ($i<10){$i="0".$i;}
							echo "<option value='$i'>$i</option>";
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td class='tdformlabel'><b>To Date / Time</font></b></td>
				<td align=right>
					<input style="width: 80px;" class=forminputtext name=to_date id="to_date" onclick="fPopCalendar('to_date')">
					<select size=1 class=formselect name="to_time_hh">
					<?
						for($i=0;$i<24;$i++){
							if ($i<10){$i="0".$i;}
							echo "<option value='$i'>$i</option>";
						}
					?>
					</select>
					<select size=1 class=formselect name="to_time_mm">
					<?
						for($i=0;$i<60;$i++){
							if ($i<10){$i="0".$i;}
							echo "<option value='$i'>$i</option>";
						}
					?>
					</select>
				</td>
			</tr>
			
			
			<tr>
				<td class='tdformlabel'><b>Type of Service</font></b></td>
				<td align=right>
					<select size=1 class=formselect name="service_type">
						<option value='Application Services'>Application Services</option>
						<option value='Internet Services'>Internet Services</option>
						<option value='Network Services'>Network Services</option>
						<option value='Power'>Power</option>
						<option value='Printing Services'>Printing Services</option>
						<option value='Communication Services'>Communication Services</option>
						<option value='Others'>Others</option>
					</select>					
				</td>
			</tr>
			<tr>
				<td class='tdformlabel' colspan=2><b>Description (if any)</font></b></td>
			</tr>
			<tr>
				<td colspan=2 align=right>
					<textarea style="width: 100%;" class=formtextarea rows="4" id="service_desc" name="service_desc"></textarea>	
					<script>make_wyzz('service_desc');</script>					
				</td>
			</tr>
			

			<tr>
				<td class='tdformlabel'><b>Level of Disruption (if any)</font></b></td>
				<td align=right>
					<select size=1 class=formselect name="disruption">
						<option value='None'>None</option>
						<option value='Intermittent'>Intermittent</option>
						<option value='Partial'>Partial</option>
						<option value='Total'>Total</option>
					</select>					
				</td>
			</tr>
			
			<tr>
				<td class='tdformlabel' colspan=2><b>Reason / Comments</font></b></td>
			</tr>
			<tr>
				<td colspan=2 align=right>
					<textarea style="width: 100%;" class=formtextarea rows="4" id="comments" name="comments"></textarea>
					<script>make_wyzz('comments');</script>		
				</td>
			</tr>
			
			<tr>
				<td class='tdformlabel'><b>Contact Email for clarifications</font></b></td>
				<td align=right>
					<input style="width: 100%;" class=forminputtext name="contact_email">
				</td>
			</tr>
			
			<tr>
				<td class='tdformlabel'><b>Contact No. for clarifications</font></b></td>
				<td align=right>
					<input style="width: 100%;" class=forminputtext name="contact_phone">
				</td>
			</tr>
			<tr>
				<td align="center" colspan=2>
					<input class="forminputbutton" type="submit" value="Send Notification" name="Submit">
				</td>
			</tr>
		</table>
	</form>

