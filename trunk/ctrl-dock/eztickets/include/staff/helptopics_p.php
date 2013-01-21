<?php
if(!defined('OSTADMININC') || !$thisuser->isadmin()) die('Access Denied');
//List all help topics
$sql='SELECT topic_id,isactive,topic.noautoresp,topic.dept_id,topic,dept_name,priority_desc,topic.created,topic.updated,parent_topic_id FROM '.TOPIC_TABLE.' topic '.
	 ' LEFT JOIN '.DEPT_TABLE.' dept ON dept.dept_id=topic.dept_id '.
     ' LEFT JOIN '.TICKET_PRIORITY_TABLE.' pri ON pri.priority_id=topic.priority_id '.
	 ' where parent_topic_id=0 and ticket_type_id=2';
$services=db_query($sql.' ORDER BY topic.topic'); 
$prefix="P - ";
$tt=2;

?>
<div class="msg">Problems</div>

<table width="100%" border="0" cellspacing=1 cellpadding=2>
   <form action="admin.php?t=settings" method="POST" name="topic" onSubmit="return checkbox_checker(document.forms['topic'],1,0);">
   <input type='hidden' name='t' value='topics'>
   <input type=hidden name='do' value='mass_process'>
   <tr><td>
    <table border="0" cellspacing=0 cellpadding=2 class="dtable" align="center" width="100%">
        <tr>
	        <th width="7px">&nbsp;</th>
	        <th>Topic</th>
            <th>Status</th>
            <th>AutoResp.</th>
            <th>Department</th>
            <th>Priority</th>
        </tr>
        <?
        $class = 'row1';
        $total=0;
        $ids=($errors && is_array($_POST['tids']))?$_POST['tids']:null;
        if($services && db_num_rows($services)):
            while ($row = db_fetch_array($services)) {
                $sel=false;
                if(($ids && in_array($row['topic_id'],$ids)) or ($row['topic_id']==$topicID)){
                    $class="$class highlight";
                    $sel=true;
                }
                ?>
				<tr class="<?=$class?>" id="<?=$row['topic_id']?>">
                <td width=7px>
                <input type="checkbox" name="tids[]" value="<?=$row['topic_id']?>" <?=$sel?'checked':''?>  onClick="highLight(this.value,this.checked);">
                <td><a href="admin.php?t=topics&id=<?=$row['topic_id']?>&tt=<?=$tt;?>&prefix=<?=$prefix?>"><?=Format::htmlchars(Format::truncate($row['topic'],60))?></a></td>
                <td><?=$row['isactive']?'Active':'<b>Disabled</b>'?></td>
                <td>&nbsp;&nbsp;<?=$row['noautoresp']?'No':'<b>Yes</b>'?></td>
                <td><a href="admin.php?t=dept&id=<?=$row['dept_id']?>"><?=$row['dept_name']?></a></td>
                <td><?=$row['priority_desc']?></td>
				</tr>
				
				<?
					// start sub topic listing
					 $parent_topic_id=$row['topic_id'];
					 $sub_sql='SELECT topic_id,isactive,topic.noautoresp,topic.dept_id,topic,dept_name,priority_desc,topic.created,topic.updated,parent_topic_id FROM '.TOPIC_TABLE.' topic '.
					 ' LEFT JOIN '.DEPT_TABLE.' dept ON dept.dept_id=topic.dept_id '.
					 ' LEFT JOIN '.TICKET_PRIORITY_TABLE.' pri ON pri.priority_id=topic.priority_id '.
					 ' where parent_topic_id='.$parent_topic_id;

					 $sub_services=db_query($sub_sql.' ORDER BY topic.topic');
					 if($sub_services && db_num_rows($sub_services)){
						while ($sub_row = db_fetch_array($sub_services)) {
						?>
						    <tr class="<?=$class?>" id="<?=$sub_row['topic_id']?>">
							<td width=7px>
							<input type="checkbox" name="tids[]" value="<?=$sub_row['topic_id']?>" <?=$sel?'checked':''?>  onClick="highLight(this.value,this.checked);">
							</td>							
							<td>&nbsp;&nbsp;&nbsp;&nbsp;|--&nbsp;<a href="admin.php?t=topics&id=<?=$sub_row['topic_id']?>&tt=<?=$tt;?>&prefix=<?=$prefix?>"><?=Format::htmlchars(Format::truncate($sub_row['topic'],60))?></a></td>
							<td><?=$sub_row['isactive']?'Active':'<b>Disabled</b>'?></td>
							<td>&nbsp;&nbsp;<?=$sub_row['noautoresp']?'No':'<b>Yes</b>'?></td>
							<td><a href="admin.php?t=dept&id=<?=$sub_row['dept_id']?>"><?=$sub_row['dept_name']?></a></td>
							<td><?=$sub_row['priority_desc']?></td>
							</tr>
						<?
						// start sub sub topic listing
						$parent_topic_id=$sub_row['topic_id'];
						$sub2_sql='SELECT topic_id,isactive,topic.noautoresp,topic.dept_id,topic,dept_name,priority_desc,topic.created,topic.updated,parent_topic_id FROM '.TOPIC_TABLE.' topic '.
						 ' LEFT JOIN '.DEPT_TABLE.' dept ON dept.dept_id=topic.dept_id '.
						 ' LEFT JOIN '.TICKET_PRIORITY_TABLE.' pri ON pri.priority_id=topic.priority_id '.
						 ' where parent_topic_id='.$parent_topic_id;
						$sub2_services=db_query($sub2_sql.' ORDER BY topic.topic');
					    if($sub2_services && db_num_rows($sub2_services)){
							while ($sub2_row = db_fetch_array($sub2_services)) {
							?>
						    <tr class="<?=$class?>" id="<?=$sub2_row['topic_id']?>">
							<td width=7px>
							<input type="checkbox" name="tids[]" value="<?=$sub2_row['topic_id']?>" <?=$sel?'checked':''?>  onClick="highLight(this.value,this.checked);">
							</td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|--&nbsp;<a href="admin.php?t=topics&id=<?=$sub2_row['topic_id']?>&tt=<?=$tt;?>&prefix=<?=$prefix?>"><?=Format::htmlchars(Format::truncate($sub2_row['topic'],60))?></a></td>
							<td><?=$sub2_row['isactive']?'Active':'<b>Disabled</b>'?></td>
							<td>&nbsp;&nbsp;<?=$sub2_row['noautoresp']?'No':'<b>Yes</b>'?></td>
							<td><a href="admin.php?t=dept&id=<?=$sub2_row['dept_id']?>"><?=$sub2_row['dept_name']?></a></td>
							<td><?=$sub2_row['priority_desc']?></td>
							</tr>
							<?
							}
						}
						// end of sub sub topic listing
						
						
						}
					}
					// end sub topic listing
				?>

            <?
            $class = ($class =='row2') ?'row1':'row2';
            } //end of while.
        else: //notthing! ?> 
            <tr class="<?=$class?>"><td colspan=8><b>Query returned 0 results</b></td></tr>
        <?
        endif; ?>
    </table>
    </td></tr>
    <?
    if(db_num_rows($services)>0): //Show options..
     ?>
    <tr>
        <td style="padding-left:20px">
            Select:&nbsp;
            <a href="#" onclick="return select_all(document.forms['topic'],true)">All</a>&nbsp;&nbsp;
            <a href="#" onclick="return reset_all(document.forms['topic'])">None</a>&nbsp;&nbsp;
            <a href="#" onclick="return toogle_all(document.forms['topic'],true)">Toggle</a>&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td align="center">
            <input class="button" type="submit" name="enable" value="Enable"
                onClick=' return confirm("Are you sure you want to make selected services active?");'>
            <input class="button" type="submit" name="disable" value="Disable" 
                onClick=' return confirm("Are you sure you want to DISABLE selected services?");'>
            <input class="button" type="submit" name="delete" value="Delete" 
                onClick=' return confirm("Are you sure you want to DELETE selected services?");'>
        </td>
    </tr>
    <?
    endif;
    ?>
    </form>
</table>
