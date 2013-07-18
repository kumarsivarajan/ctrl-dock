<?php
	require_once("../include/config.php");
	require_once("../include/db.php");

    Header("Content-type: text/xml");
    // get query string params
	$filter = $_GET['filter'];

    // build xml content for client JavaScript

	$xml = '';
	$sql = " select bizgroup_grade_mapping.grade_id as grade_id, business_groups.prefix as prefix";
	$sql.= " from bizgroup_grade_mapping bizgroup_grade_mapping, business_groups business_groups ";
	$sql.= " where bizgroup_grade_mapping.business_group_index=$filter and business_groups.business_group_index=$filter";
	
	if ($result = mysql_query($sql)){
		$xml = '<business_group>';
		while ($row = mysql_fetch_assoc($result)){
			$xml = $xml . '<grade id="' . $row['grade_id'] . '">' . $row['prefix'] . ' --- ' . $row['grade_id'] . '</grade>';
		}
		$xml = $xml . '</business_group>';
	}
	echo $xml;
	exit();
?>