<?php
if(!defined('OSTSCPINC') || !is_object($thisuser) || !$thisuser->isStaff()) die('Access Denied');
$info=($_POST && $errors)?Format::input($_POST):array(); //on error...use the post data

$sql="select https from config";
$result=mysql_query($sql);
$row=mysql_fetch_row($result);
$https=$row[0];

$url_type="http://";
if ($https==1){$url_type="https://";}

$url=$url_type.$_SERVER["HTTP_HOST"]."/eztickets/";
if(strlen($INSTALL_HOME)>0){
        $url=$url_type.$_SERVER["HTTP_HOST"]."/".$INSTALL_HOME."/eztickets/";
}

?>
<script type="text/javascript">

function getTopic(strURL){
        var xmlhttp;
        if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
        }else{// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function(){
          if (xmlhttp.readyState==4 && xmlhttp.status==200){
                 document.getElementById('topicdiv').innerHTML=xmlhttp.responseText;
                 document.getElementById('hideonchange').style.display='none';
          }
        }
        xmlhttp.open("GET", strURL, true); //open url using get method
        xmlhttp.send(null);
}


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
<table width="80%" border="0" cellspacing=1 cellpadding=2>
   <form action="tickets.php" method="post" enctype="multipart/form-data" name="form">
    <input type='hidden' name='a' value='open'>
    <tr><td align="left" colspan=2>Please fill in the form below to open a new ticket.</td></tr>
    <tr>
        <td align="left" nowrap width="20%"><b>Email Address:</b></td>
        <td>
            <input type="text" id="email" name="email" size="25" value="<?=$info['email']?>">
            &nbsp;<font class="error"><b>*</b>&nbsp;<?=$errors['email']?></font>
            <? if($cfg->notifyONNewStaffTicket()) {?>
               &nbsp;&nbsp;&nbsp;
               <input type="checkbox" name="alertuser" <?=(!$errors || $info['alertuser'])? 'checked': ''?>>Send alert to user.
            <?}?>
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
        <td align="left">Telephone:</td>
        <td><input type="text" name="phone" size="25" value="<?=$info['phone']?>">
            &nbsp;Ext&nbsp;<input type="text" name="phone_ext" size="6" value="<?=$info['phone_ext']?>">
            <font class="error">&nbsp;<?=$errors['phone']?></font></td>
    </tr>
    <tr height=2px><td align="left" colspan=2 >&nbsp;</td</tr>
    <tr>
        <td align="left"><b>Ticket Source:</b></td>
        <td>
            <select name="source">
                <option value="" selected >Select Source</option>
                <option value="Phone" <?=($info['source']=='Phone')?'selected':''?>>Phone</option>
                <option value="Email" <?=($info['source']=='Email')?'selected':''?>>Email</option>
                <option value="Other" <?=($info['source']=='Other')?'selected':''?>>Other</option>
            </select>
            &nbsp;<font class="error"><b>*</b>&nbsp;<?=$errors['source']?></font>
        </td>
    </tr>
    <tr>
        <td align="left"><b>Department:</b></td>
        <td>
            <select name="deptId" id="deptId" onChange="Javascript:getTopic('<?=$url;?>ajax_open.php?ajx_dept_id_staff='+this.value);">
                <option value="" selected >Select Department</option>
                <?
                 $services= db_query('SELECT dept_id,dept_name FROM '.DEPT_TABLE.' ORDER BY dept_name');
                 while (list($deptId,$dept) = db_fetch_row($services)){
                    $selected = ($info['deptId']==$deptId)?'selected':''; ?>
                    <option value="<?=$deptId?>"<?=$selected?>><?=$dept?></option>
                <?
                 }?>
            </select>
            &nbsp;<font class="error"><b>*</b>&nbsp;<?=$errors['deptId']?></font>
        </td>
    </tr>

    <tr>
        <td align="left" valign="top">Help Topic:</td>
        <td>
<?
 if($_REQUEST["deptId"] != "" && $_REQUEST["topicId"]!= ""){
		
                $sql_1="SELECT topic_id,topic
                FROM isost_help_topic
                WHERE isactive=1 and parent_topic_id=0 ORDER BY topic";
                $result_1 = mysql_query($sql_1);
                $result = "<select name='topicId'>";
                $result .= "<option value='' selected >Select One</option>";
                while (list($topicId,$topic) = db_fetch_row($result_1)){
			$selected = ($info['topicId']==$topicId)?'selected':'';
			$result .= "<option value='$topicId' $selected>".$topic."</option>";
                        $sql_2= sprintf("SELECT topic_id,topic
                                         FROM isost_help_topic
                                         WHERE isactive=1 and parent_topic_id=$topicId
                                         AND dept_id=%d
                                         ORDER BY topic",$_REQUEST["deptId"]);
                        $result_2 = mysql_query($sql_2);
                        while (list($topicId2,$topic2) = db_fetch_row($result_2)){
                                $selected = ($info['topicId']==$topicId2)?'selected':'';
                                $result .= "<option value='$topicId2' $selected>".$topic." -> ".$topic2."</option>";
                        }
                }
                $result .= "</select>";
                print $result;
}else{
?>
                <select name='topicId' id='topicdiv'>
                <option value='' selected >Select One</option>
                </select>
<?
}
?>
        </td>
    </tr>
    <tr>
    	<td align="left"><b>Ticket Type:</b></td>
        <td>
        	<select name="tickettype">
                <?
                $tickettype= db_query('SELECT ticket_type_id,ticket_type FROM isost_ticket_type');
                while (list($typeid,$type) = db_fetch_row($tickettype)){
                ?>
                	<option value="<?=$typeid?>"<?=$selected?>><?=$type?></option>
                 <?
                }?>
                </select>
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
                $info['pri']=$info['pri']?$info['pri']:$cfg->getDefaultPriorityId();
                while($row=db_fetch_array($priorities)){ ?>
                    <option value="<?=$row['priority_id']?>" <?=$info['pri']==$row['priority_id']?'selected':''?> ><?=$row['priority_desc']?></option>
              <?}?>
            </select>
        </td>
       </tr>
    <? }?>	


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

	
    <tr>
		<td align="left"><b>Asset ID:</b></td>
		<td>
			<?php
			$sql_asset_prefix = db_query('SELECT asset_prefix from config LIMIT 1');
			$asset_prefix = db_fetch_row($sql_asset_prefix);
			$asset_prefix = $asset_prefix[0];
			?>
			<select name="assetId">
				<option value="" selected >Select</option>
				<?					
				$assetIDs= db_query('SELECT assetid,hostname,ipaddress FROM asset ORDER BY assetid asc');
				while (list($assetId,$hostname,$ipaddress) = db_fetch_row($assetIDs)){
					$id=str_pad($assetId, 5, "0", STR_PAD_LEFT);
					$asset=$asset_prefix.'-'.$id;
					$selected = ($info['assetId']==$assetId)?'selected':''; ?>
					<?
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

    <tr>
	<td align="left"><b>Subject:</b></td>
        <td>
            <input type="text" name="subject" size="35" value="<?=$info['subject']?>">
            &nbsp;<font class="error">*&nbsp;<?=$errors['subject']?></font>
        </td>
    </tr>


    <tr>
	<td align="left" valign="top"><b>Issue Summary:</b></td>
        <td>
            <i>Visible to client/customer.</i><font class="error"><b>*&nbsp;<?=$errors['issue']?></b></font><br/>
            <?
            $sql='SELECT premade_id,title FROM '.KB_PREMADE_TABLE.' WHERE isenabled=1';
            $canned=db_query($sql);
            if($canned && db_num_rows($canned)) {
            ?>
             Premade:&nbsp;
              <select id="canned" name="canned"
                onChange="getCannedResponse(this.options[this.selectedIndex].value,this.form,'issue');this.selectedIndex='0';" >
                <option value="0" selected="selected">Select a premade reply/issue</option>
                <?while(list($cannedId,$title)=db_fetch_row($canned)) { ?>
                <option value="<?=$cannedId?>" ><?=Format::htmlchars($title)?></option>
                <?}?>
              </select>&nbsp;&nbsp;&nbsp;<label><input type='checkbox' value='1' name=append checked="true" />Append</label>
            <?}?>
            <textarea name="issue" cols="55" rows="8" wrap="soft"><?=$info['issue']?></textarea></td>
    </tr>
    <?if($cfg->canUploadFiles()) {
        ?>
    <tr>
        <td>Attachment:</td>
        <td>
            <input type="file" name="attachment"><font class="error">&nbsp;<?=$errors['attachment']?></font>
        </td>
    </tr>
    <?}?>
    <tr>
        <td align="left" valign="top">Internal Note:</td>
        <td>
            <i>Optional Internal note(s).</i><font class="error"><b>&nbsp;<?=$errors['note']?></b></font><br/>
            <textarea name="note" cols="55" rows="5" wrap="soft"><?=$info['note']?></textarea></td>
    </tr>

    <tr>
        <td>Assign To:</td>
        <td>
            <select id="staffId" name="staffId">
                <option value="0" selected="selected">-Assign To Staff-</option>
                <?
                    //TODO: make sure the user's group is also active....DO a join.
                    $sql=' SELECT staff_id,CONCAT_WS(", ",firstname,lastname) as name FROM '.STAFF_TABLE.' WHERE isactive=1 AND onvacation=0 ';
                    $depts= db_query($sql.' ORDER BY firstname,lastname ');
                    while (list($staffId,$staffName) = db_fetch_row($depts)){
                        $selected = ($info['staffId']==$staffId)?'selected':''; ?>
                        <option value="<?=$staffId?>"<?=$selected?>><?=$staffName?></option>
                    <?
                    }?>
            </select><font class='error'>&nbsp;<?=$errors['staffId']?></font>
                &nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="alertstaff" <?=(!$errors || $info['alertstaff'])? 'checked': ''?>>Send alert to assigned staff.
        </td>
    </tr>
    <tr>
        <td>Signature:</td>
        <td> <?php
            $appendStaffSig=$thisuser->appendMySignature();
            $info['signature']=!$info['signature']?'none':$info['signature']; //change 'none' to 'mine' to default to staff signature.
            ?>
            <div style="margin-top: 2px;">
                <label><input type="radio" name="signature" value="none" checked > None</label>
                <?if($appendStaffSig) {?>
                    <label> <input type="radio" name="signature" value="mine" <?=$info['signature']=='mine'?'checked':''?> > My signature</label>
                 <?}?>
                 <label><input type="radio" name="signature" value="dept" <?=$info['signature']=='dept'?'checked':''?> > Dept Signature (if any)</label>
            </div>
        </td>
    </tr>
    <tr height=2px><td align="left" colspan=2 >&nbsp;</td</tr>
    <tr>
        <td></td>
        <td>
            <input class="button" type="submit" name="submit_x" value="Submit Ticket" onclick="change()">
            <input class="button" type="reset" value="Reset">
            <input class="button" type="button" name="cancel" value="Cancel" onClick='window.location.href="tickets.php"'>    
        </td>
    </tr>
  </form>
</table>
<script type="text/javascript">
    
    var options = {
        script:"ajax.php?api=tickets&f=searchbyemail&limit=10&",
        varname:"input",
        json: true,
        shownoresults:false,
        maxresults:10,
        callback: function (obj) { document.getElementById('email').value = obj.id; document.getElementById('name').value = obj.info; return false;}
    };
    var autosug = new bsn.AutoSuggest('email', options);
</script>
