<?phpheader('Content-Type:text/xml');echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";// This API is used to list the list of hosts that are to be monitored.// hosts_svc_status.php?key=abcdfunction invalid(){	echo "<node>";		echo "<count>invalid</count>";	echo "</node>";	die(0);}function success($count){	echo "<node>";		echo "<count>".$count."</count>";	echo "</node>";	die(0);}function showxml($result, $num_rows, $username){if($num_rows>0){			echo "<node>";			while($row = mysql_fetch_array($result)){										echo "<ticketdetails>";					echo "<priority>".$row[0]."</priority>";					echo "<staffname>".$username."</staffname>";					echo "<name>".$row[1]."</name>";					echo "<subject><![CDATA[".$row[2]."]]></subject>";					echo "<helptopic><![CDATA[".$row[3]."]]></helptopic>";					echo "<source>".$row[4]."</source>";					echo "<status>".$row[5]."</status>";					echo "<created><![CDATA[".$row[6]."]]></created>";					echo "<lastresponse><![CDATA[".$row[7]."]]></lastresponse>";				echo "</ticketdetails>";								}			echo "</node>";		}else{			$nodata = 0;			success($nodata);		}}// include config file, also contains the API KEYrequire_once('../include/config.php');require_once('../include/db.php');$api_key		=$_REQUEST['key'];$ticketid		=$_REQUEST['ticketid'];$num_rows		= '';if($api_key!=$API_KEY || $api_key==''){	invalid();}else{				$sql1="select staff_id from isost_ticket where ticket_id='$ticketid'";		$result1=mysql_query($sql1);		$row1=mysql_fetch_array($result1);		$staffid=$row1[0];		if($staffid > 0)		{			$sql1="select firstname,lastname from isost_staff where staff_id='$staffid'";			$result1=mysql_query($sql1);			$row1=mysql_fetch_array($result1);			$username=$row1[0].' '.$row1[1];		}		else		{		$username="Unassigned";		}		$sql = "select itp.priority,t.name,t.subject,t.helptopic,t.source,t.status,t.created,t.lastresponse from isost_ticket t,isost_ticket_priority itp where t.priority_id=itp.priority_id and t.ticket_id='$ticketid'";		$result = mysql_query($sql);			$num_rows = mysql_num_rows($result);		showxml($result, $num_rows,$username);		}		?>