<?php
if(!defined('OSTSCPINC') || !is_object($ticket) || !is_object($thisuser) || !$thisuser->isStaff()) die('Access Denied');

if(!($thisuser->canEditTickets() || ($thisuser->isManager() && $ticket->getDeptId()==$thisuser->getDeptId()))) die('Access Denied. Perm error.');

if($_POST && $errors){
    $info=Format::input($_POST);
}else{
    $info=array('email'=>$ticket->getEmail(),
                'name' =>$ticket->getName(),
                'phone'=>$ticket->getPhone(),
                'phone_ext'=>$ticket->getPhoneExt(),
                'pri'=>$ticket->getPriorityId(),
                'topicId'=>$ticket->getTopicId(),
                'topic'=>$ticket->getHelpTopic(),
                'subject' =>Format::htmlchars($ticket->getSubject()),
				'assetid' =>$ticket->getAssetId(),
				'tickettypeid' =>$ticket->getTicketTypeId(),
                'duedate' =>$ticket->getDueDate()?(Format::userdate('m/d/Y',Misc::db2gmtime($ticket->getDueDate()))):'',
                'time'=>$ticket->getDueDate()?(Format::userdate('G:i',Misc::db2gmtime($ticket->getDueDate()))):'',
                );
    /*Note: Please don't make me explain how dates work - it is torture. Trust me! */
}

?>
<script type="text/javascript">

function change(){

var text=document.forms["form"]["subject"].value;
var len = text.length;

var s = text;

for(i=0; i<len; i++)
{
    s = s.replace(/[\u2018|\u2019|\u201A]/g, "\'");
    // smart double quotes
    s = s.replace(/[\u201C|\u201D|\u201E]/g, "\"");
    // ellipsis
    s = s.replace(/\u2026/g, "...");
    // dashes
    s = s.replace(/[\u2013|\u2014]/g, "-");
    // circumflex
    s = s.replace(/\u02C6/g, "^");
    // open angle bracket
    s = s.replace(/\u2039/g, "<");
    // close angle bracket
    s = s.replace(/\u203A/g, ">");
    // spaces
    s = s.replace(/[\u02DC|\u00A0]/g, " ");
}
 
 document.forms["form"]["subject"].value = s;
}
</script>
<div width="100%">
    <?if($errors['err']) {?>
        <p align="center" id="errormessage"><?=$errors['err']?></p>
    <?}elseif($msg) {?>
        <p align="center" class="infomessage"><?=$msg?></p>
    <?}elseif($warn) {?>
        <p class="warnmessage"><?=$warn?></p>
    <?}?>
</div>
<table width="100%" border="0" cellspacing=1 cellpadding=2>
  <form action="tickets.php?id=<?=$ticket->getId()?>" method="post" name="form">
    <input type='hidden' name='id' value='<?=$ticket->getId()?>'>
    <input type='hidden' name='a' value='update'>
    <tr><td align="left" colspan=2 class="msg">
        Update Ticket #<?=$ticket->getExtId()?>&nbsp;&nbsp;(<a href="tickets.php?id=<?=$ticket->getId()?>" style="color:black;">View Ticket</a>)<br></td></tr>
    <tr>
        <td align="left" nowrap width="120"><b>Email Address:</b></td>
        <td>
            <input type="text" id="email" name="email" size="25" value="<?=$info['email']?>">
            &nbsp;<font class="error"><b>*</b>&nbsp;<?=$errors['email']?></font>
        </td>
    </tr>
    <tr>
        <td align="left" ><b>Full Name:</b></td>
        <td>
            <input type="text" id="name" name="name" size="25" value="<?=$info['name']?>">
            &nbsp;<font class="error"><b>*</b>&nbsp;<?=$errors['name']?></font>
        </td>
    </tr>
    <tr>
        <td align="left"><b>Subject:</b></td>
        <td>
            <input type="text" name="subject" size="35" value="<?=$info['subject']?>">
            &nbsp;<font class="error">*&nbsp;<?=$errors['subject']?></font>
        </td>
    </tr>
	<?php
	//getting asset_id value from db
    $assetIDs= db_query('SELECT assetid,hostname,ipaddress FROM asset ORDER BY assetid asc');
    if($assetIDs && db_num_rows($assetIDs)){ ?>
    <tr>
	<!-- Asset Column Added --> 
        <td align="left" valign="top">Asset ID:</td>
        <td>
			<?php
			$sql_asset_prefix = db_query('SELECT asset_prefix from config LIMIT 1');
			$asset_prefix = db_fetch_row($sql_asset_prefix);
			$asset_prefix = $asset_prefix[0];
			?>
            <select name="assetId">    
                <option value="" selected >None</option>
                <?php
				while (list($assetId,$hostname,$ipaddress) = db_fetch_row($assetIDs)){
					$selected = ($info['assetid']==$assetId)?'selected':'';
					$id=str_pad($assetId, 5, "0", STR_PAD_LEFT);
					$asset=$asset_prefix.'-'.$id;
					
					
					if(strlen($hostname)>0){
						$hostname=" - ".$hostname;
					}
					
				?>
				<option value="<?=$assetId?>"<?=$selected?>><?=$asset?><?=$hostname?></option>
				<?
				}?>
            </select>
        </td>
    </tr>
    <?
    }?>
	
	<tr>
	
        <td align="left" valign="top">Ticket Type:</td>
        <td>
			<select name="tickettype">    
                <?					
				$tickettype= db_query('SELECT ticket_type_id,ticket_type FROM isost_ticket_type');
				while (list($typeid,$type) = db_fetch_row($tickettype)){
				$selected = ($info['tickettypeid']==$typeid)?'selected':'';
					 ?>
					<option value="<?=$typeid?>"<?=$selected?>><?=$type?></option>
				<?
				}?>
            </select>
        </td>
    </tr>
    <tr>
        <td align="left">Telephone:</td>
        <td><input type="text" name="phone" size="25" value="<?=$info['phone']?>">
             &nbsp;Ext&nbsp;<input type="text" name="phone_ext" size="6" value="<?=$info['phone_ext']?>">
            &nbsp;<font class="error">&nbsp;<?=$errors['phone']?></font></td>
    </tr>
    <tr height=1px><td align="left" colspan=2 >&nbsp;</td></tr>
    <tr>
        <td align="left" valign="top">Due Date:</td>
        <td>
            <i>Time is based on your time zone (GM <?=$thisuser->getTZoffset()?>)</i>&nbsp;<font class="error">&nbsp;<?=$errors['time']?></font><br>
            <input id="duedate" name="duedate" value="<?=Format::htmlchars($info['duedate'])?>"
                onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF>
            <a href="#" onclick="event.cancelBubble=true;calendar(getObj('duedate')); return false;"><img src='images/cal.png'border=0 alt=""></a>
            &nbsp;&nbsp;
            <?php
             $min=$hr=null;
             if($info['time'])
                list($hr,$min)=explode(':',$info['time']);
                echo Misc::timeDropdown($hr,$min,'time');
            ?>
            &nbsp;<font class="error">&nbsp;<?=$errors['duedate']?></font>
        </td>
    </tr>
    <?
      $sql='SELECT priority_id,priority_desc FROM '.TICKET_PRIORITY_TABLE.' ORDER BY priority_urgency DESC';
      if(($priorities=db_query($sql)) && db_num_rows($priorities)){ ?>
      <tr>
        <td align="left">Priority:</td>
        <td>
            <select name="pri">
              <?
                while($row=db_fetch_array($priorities)){ ?>
                    <option value="<?=$row['priority_id']?>" <?=$info['pri']==$row['priority_id']?'selected':''?> ><?=$row['priority_desc']?></option>
              <?}?>
            </select>
        </td>
       </tr>
    <? }?>

    <?php
    $services= db_query('SELECT topic_id,topic,isactive FROM '.TOPIC_TABLE.' ORDER BY topic');
    if($services && db_num_rows($services)){ ?>
    <tr>
        <td align="left" valign="top">Help Topic:</td>
        <td>
            <select name="topicId">
				<?
				$sql_1="SELECT topic_id,topic FROM isost_help_topic WHERE isactive=1 and parent_topic_id=0 ORDER BY topic";
				$result_1 = mysql_query($sql_1);
				?>
                <option value="" selected >Select One</option>
                <?
                while (list($topicId,$topic) = db_fetch_row($result_1)){					
                    $selected = ($info['topicId']==$topicId)?'selected':''; 
					?><option value="<?=$topicId?>"<?=$selected?>><?=$topic?></option><?
					$sql_2="SELECT topic_id,topic FROM isost_help_topic WHERE isactive=1 and parent_topic_id=$topicId ORDER BY topic";
					$result_2 = mysql_query($sql_2);
					
					while (list($topicId2,$topic2) = db_fetch_row($result_2)){	
						$selected = ($info['topicId']==$topicId2)?'selected':'';
						?><option value="<?=$topicId2?>"<?=$selected?>>&nbsp;&nbsp;&nbsp;|-<?=$topic2;?></option><?
						$sql_3="SELECT topic_id,topic FROM isost_help_topic WHERE isactive=1 and parent_topic_id=$topicId2 ORDER BY topic";
						$result_3 = mysql_query($sql_3);
						
						while (list($topicId3,$topic3) = db_fetch_row($result_3)){	
						$selected = ($info['topicId']==$topicId3)?'selected':'';
												
						?><option value="<?=$topicId3?>"<?=$selected?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|-<?=$topic3;?></option><?
						}
					}
				}
				?>
            </select>
            &nbsp;(optional)<font class="error">&nbsp;<?=$errors['topicId']?></font>
        </td>
    </tr>
    <?
    }?>
    <tr>
        <td align="left" valign="top"><b>Internal Note:</b></td>
        <td>
            <i>Reasons for the edit.</i><font class="error"><b>*&nbsp;<?=$errors['note']?></b></font><br/>
            <textarea name="note" cols="45" rows="5" wrap="soft"><?=$info['note']?></textarea></td>
    </tr>
    <tr height=2px><td align="left" colspan=2 >&nbsp;</td></tr>
    <tr>
        <td></td>
        <td>
            <input class="button" type="submit" name="submit_x" value="Update Ticket" onclick="change()">
            <input class="button" type="reset" value="Reset">
            <input class="button" type="button" name="cancel" value="Cancel" onClick='window.location.href="tickets.php?id=<?=$ticket->getId()?>"'>    
        </td>
    </tr>
  </form>
</table>
