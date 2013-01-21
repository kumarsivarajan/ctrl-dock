<script language="javascript">
	function assignment(assigned_to){
	
		if (assigned_to == "employee"){
			document.getElementById("employee").style.visibility='visible';
			document.getElementById("assigned_agency").style.visibility='hidden';	
			document.getElementById("assigned_bg").style.visibility='hidden';
		}
		
		if (assigned_to == "agency"){
			document.getElementById("employee").style.visibility='hidden';
			document.getElementById("assigned_agency").style.visibility='visible';	
			document.getElementById("assigned_bg").style.visibility='hidden';
		}
		
		if (assigned_to == "business_group"){
			document.getElementById("employee").style.visibility='hidden';
			document.getElementById("assigned_agency").style.visibility='hidden';	
			document.getElementById("assigned_bg").style.visibility='visible';
		}
		
	}
</script>

<?
include_once("config.php"); 

include_once("searchasset.php");
if (!check_feature(37)){feature_error();exit;}


$assetid=$_REQUEST["assetid"];
$id=str_pad($assetid, 5, "0", STR_PAD_LEFT);



// rental details added in this sql query
$sql="select assetcategoryid,model,serialno,agencyid,invoicedate,invoiceno,invoiceamount,statusid,employee,";
$sql.="hostname,comments,office_index,location_desc,rentalreference,rentalstartdate,rentalenddate,rentalvalue,rentalinfo,";
$sql.="assetidentifier,ipaddress,auditstatus,assigned_type,assigned_agency,assigned_bg,parent_assetid from asset where assetid='$assetid'";

$result = mysql_query($sql);
while ($current= mysql_fetch_row($result)) {
        $assetcategoryid=$current[0];
        $model				=$current[1];
        $serialno			=$current[2];
        $agencyid			=$current[3];
		$invoicedate		=$current[4];
        $invoiceno			=$current[5];
        $invoiceamount		=$current[6];       
        $statusid			=$current[7];
        $employee			=$current[8];
        $hostname			=$current[9];
        $comments			=$current[10];
		$office_index		=$current[11];
		$location_desc		=$current[12];
		$rentalreference	=$current[13];
		$rentalstartdate	=$current[14];
		$rentalenddate		=$current[15];
		$rentalvalue		=$current[16];
		$rentalinfo			=$current[17];
		$assetidentifier	=$current[18];
		$ipaddress			=$current[19];
		$auditstatus		=$current[20];

		$assigned_type		=$current[21];
		$assigned_agency	=$current[22];
		$assigned_bg		=$current[23];
		$parent_assetid		=$current[24];
}
?>
<center>
<br>
<body onload="assignment('<?=$assigned_type;?>')">
<table border=0 width=100% cellpadding="2" cellspacing="0" bgcolor=#E5E5E5>
  <tr>
    <td width="90%" style="border-style: none; border-width: medium" align=left colspan=1>
	<font face=Arial size=2 color=#CC0000><b>EDIT ASSET : <?=$ASSET_PREFIX."-".$id;?></b></font>
	</td>
	<td width=10% align=right>
	<a href=javascript:history.back()><font face=Arial size=1>BACK</font></a>
	</td>
	</tr>
</table>

<form name=addasset method="POST" action="edit_asset_2.php">
<input name="assetid" value='<?=$assetid?>' type=hidden></td>
<table border=0 cellpadding=2 cellspacing=0 width=100%>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>Asset Details</b></td></tr>
<tr>
	<td class='tdformlabel'>Asset TAG</td>
	<td align=right><input name="assetidentifier" size="40" class='forminputtext' value="<?=htmlentities($assetidentifier)?>"></td>
	
</tr>
<tr>
	<td class='tdformlabel'>Parent Asset ID</td>
	<td align=right>	
		<select class="formselect" size=1 name=parent_assetid >
		<option value=></option>
		<?
			$sql = "select assetid from asset where assetid!='$assetid' order by assetid"; 	
			$result = mysql_query($sql);
			while ($row = mysql_fetch_row($result)) {
					if ($parent_assetid==$row[0]){$selected="selected";}else{$selected="";}
					$parentid=str_pad($row[0], 5, "0", STR_PAD_LEFT);
					echo "<option value=$row[0] $selected>$ASSET_PREFIX - $parentid</option>";
			}
		?>
		</select>
	</td>
</tr>
<tr>
	<td class='tdformlabel'>Asset Category</td>
	<td align=right>	
		<select class="formselect" size=1 name=assetcategoryid >
		<option value=></option>
		<?
			$sql = "select * from assetcategory order by assetcategory"; 	
			$result = mysql_query($sql);
			while ($row = mysql_fetch_row($result)) {
					if ($assetcategoryid==$row[0]){$selected="selected";}else{$selected="";}
					echo "<option value=$row[0] $selected>$row[1]</option>";
			}
		?>
		</select>
	</td>
</tr>
<tr>
	<td class='tdformlabel'>Make & Model *</td>
	<td align=right><input name="model" size="40" class='forminputtext' value="<?=htmlentities($model)?>"></td>
</tr>
<tr>
	<td class='tdformlabel'>Serial / Identification No.</td>
	<td align=right><input name="serialno" size="40" class='forminputtext' value='<?=$serialno?>'></td>
</tr>
<tr>
	<td class='tdformlabel'>Hostname</td>
	<td align=right><input name="hostname" size="40" class='forminputtext' value='<?=$hostname?>'></td>
</tr>
<tr>
	<td class='tdformlabel'>IP Address</td>
	<td align=right><input name="ipaddress" size="40" class='forminputtext' value='<?=$ipaddress?>'></td>
</tr>


<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>Rental / Lease Information</b></td></tr>
<td class='tdformlabel'>Rental / Lease</td>
	<td align=right>
			<select class="formselect" size=1 name=rentalinfo >
				<?echo "<option value=$rentalinfo>$rentalinfo</option>";?>
				<option value="No" selected>No</option>
				<option value="Rental">Rental</option>
				<option value="Lease">Lease</option>
			</select>
	</td>
	<tr>
		<td class='tdformlabel'>Contract Ref No.</td>
		<td align=right><input name="rentalreference" size="40" class='forminputtext' value="<?=$rentalreference;?>"></td>
	</tr>
	<tr>
		<td class='tdformlabel'>Contract Start Date</td>
		<td align=right><input size=20 class=forminputtext name=rentalstartdate id="startdate" readonly onclick="fPopCalendar('startdate')" value="<?=$rentalstartdate;?>"></td>
	</tr>
	<tr>
		<td class='tdformlabel'>Contract End Date</td>
		<td align=right><input size=20 class=forminputtext name=rentalenddate id="enddate" readonly onclick="fPopCalendar('enddate')" value="<?=$rentalenddate;?>"></td>
	</tr>
	<tr>
		<td class='tdformlabel'>Contract Value</td>
		<td align=right><input size=40 class=forminputtext name=rentalvalue value="<?=$rentalvalue;?>"></td>
	</tr>

	
	
	<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>Invoice / Procurement / Sourcing Details</b></td></tr>

	<tr>
		<td class='tdformlabel'>Vendor / Agency</td>
		<td align=right>	
		<select class="formselect" size=1 name=agencyid >	
		<?
				echo "<option value=1></option>";				
				$sql = "select agency_index,name from agency order by name"; 	
				$result = mysql_query($sql);
				while ($row = mysql_fetch_row($result)) {
						if ($agencyid==$row[0]){$selected="selected";}else{$selected="";}
						echo "<option value=$row[0] $selected>$row[1]</option>";
				}
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td class='tdformlabel'>Date</td>
		<td align=right><input value='<?=$invoicedate;?>' class=forminputtext name=invoicedate id="data" readonly onclick="fPopCalendar('data')"></td>
	</tr>
	<tr>
		<td class='tdformlabel'>Invoice No.</td>
		<td align=right><input size=40 class=forminputtext name=invoiceno value='<?=$invoiceno;?>'></td>
	</tr>
	<tr>
		<td class='tdformlabel'>Value</td>
		<td align=right><input size=40 class=forminputtext name=invoiceamount value='<?=$invoiceamount;?>'></td>
	</tr>

	
	
	
	<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>Allocation Information</b></td></tr>

	<tr>
		<td class='tdformlabel'>Status</td>
		<td align=right>	
			<select class="formselect" size=1 name=statusid>	
			<?
				$sql = "select * from assetstatus order by statusid"; 	
				$result = mysql_query($sql);
				while ($row = mysql_fetch_row($result)) {
						if ($statusid==$row[0]){$selected="selected";}else{$selected="";}
						echo "<option value=$row[0] $selected>$row[1]</option>";
				}
			?>
			</select>
		</td>
	</tr>
	
	<tr>
		<td class='tdformlabel'>Assigned Type</td>
		<td align=right>	
			<select class="formselect" size=1 name=assigned_type  onchange="assignment(this.value)">		
			<?
				if ($assigned_type=="employee"){$selected="selected";}else{$selected="";}
				echo "<option value='employee' $selected>Individual</option>";
				if ($assigned_type=="agency"){$selected="selected";}else{$selected="";}
				echo "<option value='agency' $selected>Agency</option>";
				if ($assigned_type=="business_group"){$selected="selected";}else{$selected="";}
				echo "<option value='business_group' $selected>Department / Business Group</option>";
			?>
			</select>
		</td>
	</tr>
	
	<tr>
		<td class='tdformlabel'>Assigned To - Individual</td>
		<td align=right>
			<div id="employee">
			<select class="formselect" size=1 name=employee>		
			<?
				$sql = "select username,first_name,last_name from user_master order by first_name"; 	
				$result = mysql_query($sql);
				while ($row = mysql_fetch_row($result)) {
						if ($employee==$row[0]){$selected="selected";}else{$selected="";}
						echo "<option value='$row[0]' $selected>$row[1] $row[2]</option>";
				}
			?>
			</select>
			</div>
		</td>
	</tr>

	<tr>
		<td class='tdformlabel'>Assigned To - Agency</td>
		<td align=right>
		<div id="assigned_agency">
		<select class="formselect" size=1 name=assigned_agency >	
		<?
				echo "<option value=1>Internal</option>";				
                $sql = "select * from agency where agency_index>1 order by name";
				$result = mysql_query($sql);
				while ($row = mysql_fetch_row($result)) {
						if ($assigned_agency==$row[0]){$selected="selected";}else{$selected="";}
						echo "<option value=$row[0] $selected>$row[1]</option>";
				}
		?>
		</select>
		</div>
		</td>
	</tr>

	<tr>
	<td class='tdformlabel'>Assigned To - Business Group / Department</td>
	<td align=right>
	<div id="assigned_bg">
		<select size=1 name=assigned_bg class='formselect'>
			<?php
			    $sql = "select * from business_groups";	
				$result = mysql_query($sql);
				while ($row = mysql_fetch_row($result)) {
						if ($assigned_bg==$row[0]){$selected="selected";}else{$selected="";}
		        		echo "<option value='$row[0]'>$row[1]</option>";
				}
			?>
		</select>
		</div>
	</td>
	</tr>


<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>Location Information</b></td></tr>

	<tr>
		<td class='tdformlabel'>Location</td>
		<td align=right>	
			<select class="formselect" size=1 name=office_index >		
				<?php
					$sql = "select office_index,country from office_locations";	
					$result = mysql_query($sql);
					while ($row = mysql_fetch_row($result)) {
							if ($office_index==$row[0]){$selected="selected";}else{$selected="";}
							echo "<option value='$row[0]' $selected>$row[1]</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td class='tdformlabel'>Location Description</td>
		<td align=right><textarea style="width: 300; height: 50px;" class=formtextarea name=location_desc><?=$location_desc;?></textarea></td>
	</tr>
	<tr>
		<td class='tdformlabel'>Comments</td>
		<td align=right><textarea style="width: 300; height: 50px;" class=formtextarea name=comments><?=$comments;?></textarea></td>
	</tr>
	<tr>
		<td class='tdformlabel'>Audit this asset?</td>
		<td align=right><input type='radio' name='auditstatus' value='1' <?php if($auditstatus == 1) { ?>checked<?php } ?>><font class='auditselect'>Yes</font></input><input type='radio' name='auditstatus' value='0' <?php if($auditstatus == 0) { ?>checked<?php } ?>><font class='auditselect' >No</font></input></td>
	</tr>

	<tr><td colspan=2 align=center><input type="submit" value="Submit" name="Submit" class="forminputbutton"></td></tr>

</form>