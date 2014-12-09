<?php
if(!defined('OSTCLIENTINC')) die('Kwaheri rafiki!'); //Say bye to our friend..
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
<div>
    <?if($errors['err']) {?>
        <p align="center" id="errormessage"><?=$errors['err']?></p>
    <?}elseif($msg) {?>
        <p align="center" id="infomessage"><?=$msg?></p>
    <?}elseif($warn) {?>
        <p id="warnmessage"><?=$warn?></p>
    <?}?>
</div>
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
</script>
<div>Please fill in the form below to open a new ticket.</div><br>
<form action="open.php" method="POST" enctype="multipart/form-data">
<table align="left" cellpadding=2 cellspacing=1 width="90%">
    <tr>
        <th width="20%">Full Name:</th>
        <td>
            <?if ($thisclient && ($name=$thisclient->getName())) {
                ?>
                <input type="hidden" name="name" value="<?=$name?>"><?=$name?>
            <?}else {?>
                <input type="text" name="name" size="25" value="<?=$info['name']?>">
	        <?}?>
            &nbsp;<font class="error">*&nbsp;<?=$errors['name']?></font>
        </td>
    </tr>
    <tr>
        <th nowrap >Email Address:</th>
        <td>
            <?if ($thisclient && ($email=$thisclient->getEmail())) {
                ?>
                <input type="hidden" name="email" size="25" value="<?=$email?>"><?=$email?>
            <?}else {?>             
                <input type="text" name="email" size="25" value="<?=$info['email']?>">
            <?}?>
            &nbsp;<font class="error">*&nbsp;<?=$errors['email']?></font>
        </td>
    </tr>
    <tr>
        <td>Telephone:</td>
        <td><input type="text" name="phone" size="25" value="<?=$info['phone']?>">
             &nbsp;Ext&nbsp;<input type="text" name="phone_ext" size="6" value="<?=$info['phone_ext']?>">
            &nbsp;<font class="error">&nbsp;<?=$errors['phone']?></font></td>
    </tr>
    <tr height=2px><td align="left" colspan=2 >&nbsp;</td</tr>
    <tr><th nowrap >Department:</th>
    <td><select id="dept_id" name="dept_id" onChange="Javascript:getTopic('<?=$url;?>ajax_open.php?ajx_dept_id='+this.value);">
        <option value="" selected="selected">-Select Dept-</option>
        <?$depts= mysql_query('SELECT dept_id,dept_name FROM isost_department where ispublic=1');
          while (list($deptId,$deptName) = db_fetch_row($depts)){
            $selected = ($info['dept_id']==$deptId)?'selected':''; ?>
            <option value="<?=$deptId?>"<?=$selected?>><?=$deptName?></option>
        <?}?>
        </select><font class='error'>&nbsp;*<?=$errors['dept_id']?></font>
    </td>	
    </tr>	
    <tr>
        <th>Help Topic:</th>
	<td>
	<?
	  if($_REQUEST["dept_id"] != "" && $_REQUEST["topicId"]!= ""){
		print"<div id='hideonchange'>";
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
                                 	 ORDER BY topic",$_REQUEST["dept_id"]);
               	 	$result_2 = mysql_query($sql_2);
                	while (list($topicId2,$topic2) = db_fetch_row($result_2)){
                        	$selected = ($info['topicId']==$topicId2)?'selected':'';
                        	$result .= "<option value='$topicId2' $selected>".$topic." -> ".$topic2."</option>";
                	}
        	}
        	$result .= "</select>";
		print $result;
		print "</div>";
	}
	print "<div id='topicdiv'></div>";

	?>
	</td>
    </tr>
    <tr>
        <th>Subject:</th>
        <td>
            <input type="text" name="subject" size="35" value="<?=$info['subject']?>">
            &nbsp;<font class="error">*&nbsp;<?=$errors['subject']?></font>
        </td>
    </tr>
    <tr>
        <th valign="top">Message:</th>
        <td>
            <? if($errors['message']) {?> <font class="error"><b>&nbsp;<?=$errors['message']?></b></font><br/><?}?>
            <textarea name="message" cols="35" rows="8" wrap="soft" style="width:85%"><?=$info['message']?></textarea></td>
    </tr>
    <?
    if($cfg->allowPriorityChange() ) {
      $sql='SELECT priority_id,priority_desc FROM '.TICKET_PRIORITY_TABLE.' WHERE ispublic=1 ORDER BY priority_urgency DESC';
      if(($priorities=db_query($sql)) && db_num_rows($priorities)){ ?>
      <tr>
        <td>Priority:</td>
        <td>
            <select name="pri">
              <?
                $info['pri']=$info['pri']?$info['pri']:$cfg->getDefaultPriorityId(); //use system's default priority.
                while($row=db_fetch_array($priorities)){ ?>
                    <option value="<?=$row['priority_id']?>" <?=$info['pri']==$row['priority_id']?'selected':''?> ><?=$row['priority_desc']?></option>
              <?}?>
            </select>
        </td>
       </tr>
    <? }
    }?>

    <?if(($cfg->allowOnlineAttachments() && !$cfg->allowAttachmentsOnlogin())  
                || ($cfg->allowAttachmentsOnlogin() && ($thisclient && $thisclient->isValid()))){
        
        ?>
    <tr>
        <td>Attachment:</td>
        <td>
            <input type="file" name="attachment"><font class="error">&nbsp;<?=$errors['attachment']?></font>
        </td>
    </tr>
    <?}?>
    <?if($cfg && $cfg->enableCaptcha() && (!$thisclient || !$thisclient->isValid())) {
        if($_POST && $errors && !$errors['captcha'])
            $errors['captcha']='Please re-enter the text again';
        ?>
    <tr>
        <th valign="top">Captcha Text:</th>
        <td><img src="captcha.php" border="0" align="left">
        <span>&nbsp;&nbsp;<input type="text" name="captcha" size="7" value="">&nbsp;<i>Enter the text shown on the image.</i></span><br/>
                <font class="error">&nbsp;<?=$errors['captcha']?></font>
        </td>
    </tr>
    <?}?>
    <tr height=2px><td align="left" colspan=2 >&nbsp;</td</tr>
    <tr>
        <td></td>
        <td>
            <input class="button" type="submit" name="submit_x" value="Submit Ticket">
            <input class="button" type="reset" value="Reset">
            <input class="button" type="button" name="cancel" value="Cancel" onClick='window.location.href="index.php"'>    
        </td>
    </tr>
</table>
</form>
