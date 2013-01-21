<?php

$activity_id    =$_REQUEST["activity_id"];

$filename=$_REQUEST['filename'];

$directory = "attachments/".$activity_id."/";
	
$filename=$directory.$filename;
unlink($filename);
?>
<meta http-equiv="REFRESH" content="0;URL=rca_edit_1.php?activity_id=<?=$activity_id;?>">

