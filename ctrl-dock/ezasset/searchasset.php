<?php 
include_once("config.php");
include_once("header.php");
?>
<table border=0 width=100% cellpadding="2" cellspacing="0" bgcolor=#C0C0C0>
<tr>
			<form method="POST" action="listasset.php">
				<td width=100 align=right>
					<font face=Arial size=1 color=white><b>TAG</b>
				</td>
				<td>
					<input type=text name=assetid style="font-size: 8pt; font-family: Arial" size=6>
				</td>
				
				<td width=100 align=right><font face=Arial size=1 color=white><b>CATEGORY</b></td>
				<td>
				<select size=1 name=assetcategoryid style="font-size: 8pt; font-family: Arial">
				<?php
					echo "<option value=%></option>";
						$sql = "select * from assetcategory order by assetcategory"; 	
					$result = mysql_query($sql);
					while ($row = mysql_fetch_row($result)) {
							echo "<option value=$row[0]>$row[1]</option>";
					}
				?>
				</select>
				</td>
				
				<td width=100 align=right><font face=Arial size=1 color=white><b>STATUS</b></td>
				<td>				
				<select size=1 name=statusid style="font-size: 8pt; font-family: Arial">
				<?php
					echo "<option value='1'>Active</option>";
					$sql = "select * from assetstatus where statusid!='1' order by status"; 						
					$result = mysql_query($sql);
					while ($row = mysql_fetch_row($result)) {
						echo "<option value=$row[0]>$row[1]</option>";
					}
					echo "<option value=%>ALL</option>";
					
				?>
				</select>
				<td colspan=10></td>
				</td>
</tr>
<tr>
				<td width=100 align=right ><font face=Arial size=1 color=white><b>ASSIGNED TO</b></td>
				<td>
				<select size=1 name=employee style="font-size: 8pt; font-family: Arial">
				<?php
					echo "<option value=%></option>";
						$sql = "select username,first_name,last_name from user_master order by first_name"; 	
					$result = mysql_query($sql);
					while ($row = mysql_fetch_row($result)) {
							echo "<option value='$row[0]'>$row[1] $row[2]</option>";
					}
				?>
				</select>
				<td align=right width=100><font face=Arial size=1 color=white><b>HOSTNAME</b></td>
				<td>
				<select size=1 name=hostname style="font-size: 8pt; font-family: Arial">
				<?php		
					echo "<option value=%></option>";
						$sql = "select hostname from asset group by hostname"; 	
					$result = mysql_query($sql);
					while ($row = mysql_fetch_row($result)) {
							echo "<option value='$row[0]'>$row[0]</option>";
					}
				?>
				</select>
				</td>
				<!-- new select box added Rent/Lease -->
				<td align=right><font face=Arial size=1 color=white><b>RENTAL / LEASE</b></td>
				<td>
				<select size=1 name=rentalinfo style="font-size: 8pt; font-family: Arial">
					<option value=""></option>
					<option value="No">No</option>
					<option value="Rental">Rental</option>
					<option value="Lease">Lease</option>
				</select>
				</td>
</tr>
<tr>
			<td width=100 align=right>
				<font face=Arial size=1 color=white><b>SERIAL NO</b>
			</td>
			<td>
				<input type=text name=serialno style="font-size: 8pt; font-family: Arial" size=30>
			</td>
			<td colspan=2>&nbsp;</td>
			<td colspan=2 align=center>
				<input type="submit" value="Search Asset(s) " name="Submit" style="font-family: Arial; font-size: 8pt; font-weight: bold; width:110px;">
			</td>
</tr>
			</form>				
</table>
