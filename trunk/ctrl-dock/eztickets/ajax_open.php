<?php
require('client.inc.php');
define('SOURCE','Web'); //Ticket source.
$inc='open.inc.php';    //default include.
$errors=array();
/*
if(isset($_REQUEST["ajx_dept_id"]) and ($_REQUEST["ajx_dept_id"] != "")){
         $result = "<select name='topicId'>";
        $sql_1=sprintf("SELECT topic_id,topic
                        FROM isost_help_topic
                        WHERE isactive=1 AND dept_id=%d
                        ORDER BY topic",$_REQUEST["ajx_dept_id"]);
        $result_1 = mysql_query($sql_1);
        $result .= "<option value='' selected >Select One</option>";
        while (list($topicId,$topic) = db_fetch_row($result_1)){
          $selected = ($info['topicId']==$topicId)?'selected':'';
          $result .= "<option value='$topicId' $selected>$topic</option>";
         }
        $result .= "</select>";
        print $result;
	exit;
}
*/
/*
if(isset($_REQUEST["ajx_dept_id"]) and ($_REQUEST["ajx_dept_id"] != "")){
	$sql_1="SELECT topic_id,topic 
		FROM isost_help_topic 
		WHERE isactive=1 and parent_topic_id=0 ORDER BY topic";
	$result_1 = mysql_query($sql_1);
	$result = "<select name='topicId'>";
	$result .= "<option value='' selected >Select One</option>";
	while (list($topicId,$topic) = db_fetch_row($result_1)){
		$sql_2= sprintf("SELECT topic_id,topic 
				 FROM isost_help_topic 
				 WHERE isactive=1 and parent_topic_id=$topicId 
				 AND dept_id=%d
				 ORDER BY topic",$_REQUEST["ajx_dept_id"]);
		$result_2 = mysql_query($sql_2);
		while (list($topicId2,$topic2) = db_fetch_row($result_2)){
			$selected = ($info['topicId']==$topicId2)?'selected':'';
			$result .= "<option value='$topicId2' $selected>".$topic." -> ".$topic2."</option>";
		}	
	}
	$result .= "</select>";
        print $result;
        exit;
}
*/
if(isset($_REQUEST["ajx_dept_id"]) and ($_REQUEST["ajx_dept_id"] != "")){
	$sql_1="SELECT topic_id,topic 
		FROM isost_help_topic
		WHERE isactive=1 and parent_topic_id=0 and dept_id=".$_REQUEST["ajx_dept_id"]." ORDER BY topic";
	$result_1 = mysql_query($sql_1);
	$result = "<select name='topicId'>";
	$result .= "<option value='' selected >Select One</option>";
	
	
	while (list($topicId,$topic) = db_fetch_row($result_1)){
		$selected = ($info['topicId']==$topicId)?'selected':'';
		$result .= "<option value='$topicId' $selected>".$topic."</option>";	
		$sql_2= sprintf("SELECT topic_id,topic 
				 FROM isost_help_topic 
				 WHERE isactive=1 and parent_topic_id=$topicId ORDER BY topic");
		$result_2 = mysql_query($sql_2);
		while (list($topicId2,$topic2) = db_fetch_row($result_2)){
			$selected = ($info['topicId']==$topicId2)?'selected':'';
			$result .= "<option value='$topicId2' $selected>".$topic." -> ".$topic2."</option>";
		}	
	}
	$result .= "</select>";
        print $result;
        exit;
}

if(isset($_REQUEST["ajx_dept_id_staff"]) and ($_REQUEST["ajx_dept_id_staff"] != "")){
        $result = "";
        $sql_1="SELECT topic_id,topic
                FROM isost_help_topic
                WHERE isactive=1 and parent_topic_id=0 and dept_id=".$_REQUEST["ajx_dept_id_staff"]." ORDER BY topic";
        $result_1 = mysql_query($sql_1);
        while (list($topicId,$topic) = db_fetch_row($result_1)){
                $selected = ($info['topicId']==$topicId)?'selected':'';
                $result .= "<option value='$topicId' $selected>".$topic."</option>";
                $sql_2= sprintf("SELECT topic_id,topic
                                 FROM isost_help_topic
                                 WHERE isactive=1 and parent_topic_id=$topicId ORDER BY topic");
                $result_2 = mysql_query($sql_2);
                while (list($topicId2,$topic2) = db_fetch_row($result_2)){
                        $selected = ($info['topicId']==$topicId2)?'selected':'';
                        $result .= "<option value='$topicId2' $selected>".$topic." -> ".$topic2."</option>";
                }
        }
        print $result;
        exit;
}
?>
