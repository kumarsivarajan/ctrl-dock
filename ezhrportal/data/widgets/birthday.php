<?
$today=mktime();
$d=date('d',$today);
$m=date('m',$today);

$event_list=array();
$i=0;
$sql="select b.first_name,a.date_of_birth,b.username from user_personal_information a,user_master b where a.username=b.username and b.account_status='Active' order by b.first_name";
$result = mysql_query($sql);
while ($row = mysql_fetch_row($result)){
	$first_name		=$row[0];
	$dob			=$row[1];
	$account		=$row[2];
	if (strpos($dob,"-")){
		$dob_d=substr($dob,0,2);
		$dob_m=substr($dob,3,2);
	}else{
		$dob_d=date('d',$dob);
		$dob_m=date('m',$dob);
	}
	if($dob_d==$d && $dob_m==$m){
		$event_list[$i]="Happy Birthday <a href=../ezportal/directory/profile.php?account=$account>$first_name</a> !!\n"; 
		$i++;
	}
}

if(count($event_list)>0){
	?><table width="100%" cellpadding="1" class=eventstable><?
	for($i=0;$i<count($event_list);$i++){
?>
<tr>
	<td class=eventicon><img border=0 src="widgets/images/bday.png"></img></td>
	<td class=eventitem><?=$event_list[$i];?></td>
</tr>
<?
	}
	?></table><?
}	
?>