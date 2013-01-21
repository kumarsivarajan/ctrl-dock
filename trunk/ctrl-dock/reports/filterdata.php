<?php
	 header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
     header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
     header ("Cache-Control: no-cache, must-revalidate");
     header ("Pragma: no-cache");
     
     header("content-type: application/x-javascript; charset=tis-620");
    
     $data=$_GET['data'];
     $agencyid=$_GET['aval'];
	 $staff=$_GET['sval'];
	      
include_once("config.php");
    if($data=='staff')
		{
			if($agencyid > 0)
			{
				$query = "and ar.agency_index = $agencyid";
			}
			else
			{
				$query = "";
			}
				$result=mysql_query("select distinct ar.username,um.first_name,um.last_name from agency_resource ar,user_master um where ar.username=um.username and um.account_status='Active' $query order by um.first_name");
				echo "<option value=''>Select Staff</option>";
				while($row=mysql_fetch_array($result))
				{
						echo "<option value=$row[0]>$row[1] $row[2]</option>";
				}
			
		}
	elseif($data=='agencyid')
		{
			if($staff != '')
			{
				$query = "and ars.username='$staff'";
			}
			else
			{
				$query = "";
			}
				$sql="select distinct a.agency_index,b.name";
				$sql.=" from rim_master a, agency b,agency_rim c,agency_status d,agency_resource ars where a.agency_index=b.agency_index and a.agency_index=c.agency_index and a.agency_index=d.agency_index and a.agency_index=ars.agency_index and d.status='Active' $query order by name";
				$result=mysql_query($sql);
				echo "<option value=''>Select Agency</option>";
				while($row=mysql_fetch_array($result))
				{
						echo "<option value=$row[0]>$row[1]</option>";
				}
		}
?>
				
				
		 
		 
		 
		 
       
?>