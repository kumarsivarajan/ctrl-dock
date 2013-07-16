<?php
if(!defined('OSTSCPINC') || !@$thisuser->isStaff()) die('Access Denied');

//Get ready for some deep shit..(I admit..this could be done better...but the shit just works... so shutup for now).

$qstr='&'; //Query string collector
if($_REQUEST['status']) { //Query string status has nothing to do with the real status used below; gets overloaded.
    $qstr.='status='.urlencode($_REQUEST['status']);
}

//See if this is a search
$search=$_REQUEST['a']=='search'?true:false;
$searchTerm='';
//make sure the search query is 2 chars min...defaults to no query with warning message
if($search) {
  $searchTerm=$_REQUEST['query'];
  if( ($_REQUEST['query'] && strlen($_REQUEST['query'])<2) 
      || (!$_REQUEST['query'] && isset($_REQUEST['basic_search'])) ){ //Why do I care about this crap...
      $search=false; //Instead of an error page...default back to regular query..with no search.
      $errors['err']='Search term must be more than 2 chars';
      $searchTerm='';
  }
}
$showoverdue=$showanswered=false;
$staffId=0; //Nothing for now...TODO: Allow admin and manager to limit tickets to single staff level.
//Get status we are actually going to use on the query...making sure it is clean!
$status=null;
switch(strtolower($_REQUEST['status'])){ //Status is overloaded
    case 'open':
        $status='open';
        break;
    case 'closed':
        $status='closed';
        break;
    case 'overdue':
        $status='open';
        $showoverdue=true;
        $results_type='Overdue Tickets';
        break;
    case 'assigned':
        $status='open'; //
        $staffId=$thisuser->getId();
        break;
    case 'answered':
        $status='open';
        $showanswered=true;
        $results_type='Answered Tickets';
        break;
    default:
        if(!$search)
            $status='open';
}

// This sucks but we need to switch queues on the fly! depending on stats fetched on the parent.
if($stats) { 
    if(!$stats['open'] && (!$status || $status=='open')){
        if(!$cfg->showAnsweredTickets() && $stats['answered']) {
             $status='open';
             $showanswered=true;
             $results_type='Answered Tickets';
        }elseif(!$stats['answered']) { //no open or answered tickets (+-queue?) - show closed tickets.???
            $status='closed';
            $results_type='Closed Tickets';
        }
    }
}

$qwhere ='';
/* DEPTS
   STRICT DEPARTMENTS BASED (a.k.a Categories) PERM. starts the where 
   if dept returns nothing...show only tickets without dept which could mean..none?
   Note that dept selected on search has nothing to do with departments allowed.
   User can also see tickets assigned to them regardless of the ticket's dept.
*/
$depts=$thisuser->getDepts(); //if dept returns nothing...show only tickets without dept which could mean..none...and display an error. huh?
if(!$depts or !is_array($depts) or !count($depts)){
    //if dept returns nothing...show only orphaned tickets (without dept) which could mean..none...and display an error.
    $qwhere =' WHERE ticket.dept_id IN ( 0 ) ';
}else if($thisuser->isadmin()){
    //user allowed acess to all departments.
    $qwhere =' WHERE 1'; // Brain fart...can not thing of a better way other than selecting all depts + 0 ..wasted query in my book?
}else{
    //limited depts....user can access tickets assigned to them regardless of the dept.
    $qwhere =' WHERE (ticket.dept_id IN ('.implode(',',$depts).') OR ticket.staff_id='.$thisuser->getId().')';
}

// Dirty Fix to exclude merged tickets

$hide_merged_tkts=0;

if(!isset($_REQUEST['hide_merged_tkts'])){
	$hide_merged_tkts=1;
}

if(isset($_REQUEST['hide_merged_tkts']) && $_REQUEST['hide_merged_tkts']==1){
	$hide_merged_tkts=1;
}
if(isset($_REQUEST['hide_merged_tkts']) && $_REQUEST['hide_merged_tkts']==0){
	$hide_merged_tkts=0;
}

if($hide_merged_tkts==1){
	$qwhere.=' AND ticket.track_id!=999999';
}

//STATUS
if($status){
    $qwhere.=' AND status='.db_input(strtolower($status));    
}

//Sub-statuses Trust me!
if($staffId && ($staffId==$thisuser->getId())) { //Staff's assigned tickets.
    $results_type='Assigned Tickets';
    $qwhere.=' AND ticket.staff_id='.db_input($staffId);    
}elseif($showoverdue) { //overdue
    $qwhere.=' AND isoverdue=1 ';
}elseif($showanswered) { ////Answered
    $qwhere.=' AND isanswered=1 ';
}elseif(!$search && !$cfg->showAnsweredTickets() && !strcasecmp($status,'open')) {
    $qwhere.=' AND isanswered=0 ';
}
 

//Show assigned?? Admin can not be limited. Dept managers see all tickets within the dept.
if(!$cfg->showAssignedTickets() && !$thisuser->isadmin()) {
    $qwhere.=' AND (ticket.staff_id=0 OR ticket.staff_id='.db_input($thisuser->getId()).' OR dept.manager_id='.db_input($thisuser->getId()).') ';
}


//Search?? Somebody...get me some coffee 
$deep_search=false;
if($search):
    $qstr.='&a='.urlencode($_REQUEST['a']);
    $qstr.='&t='.urlencode($_REQUEST['t']);
    if(isset($_REQUEST['advance_search'])){ //advance search box!
        $qstr.='&advance_search=Search';
    }

    //query
    if($searchTerm){
        $qstr.='&query='.urlencode($searchTerm);
        $queryterm=db_real_escape($searchTerm,false); //escape the term ONLY...no quotes.
        if(is_numeric($searchTerm)){
            $qwhere.=" AND ticket.ticketID LIKE '$queryterm%'";
        }elseif(strpos($searchTerm,'@') && Validator::is_email($searchTerm)){ //pulling all tricks!
            $qwhere.=" AND ticket.email='$queryterm'";
        }else{//Deep search!
            //This sucks..mass scan! search anything that moves! 
            
            $deep_search=true;
            if($_REQUEST['stype'] && $_REQUEST['stype']=='FT') { //Using full text on big fields.
                $qwhere.=" AND ( ticket.email LIKE '%$queryterm%'".
                            " OR ticket.name LIKE '%$queryterm%'".
                            " OR ticket.subject LIKE '%$queryterm%'".
                            " OR note.title LIKE '%$queryterm%'".
                            " OR MATCH(message.message)   AGAINST('$queryterm')".
                            " OR MATCH(response.response) AGAINST('$queryterm')".
                            " OR MATCH(note.note) AGAINST('$queryterm')".
                            ' ) ';
            }else{
                $qwhere.=" AND ( ticket.email LIKE '%$queryterm%'".
                            " OR ticket.name LIKE '%$queryterm%'".
                            " OR ticket.subject LIKE '%$queryterm%'".
                            " OR message.message LIKE '%$queryterm%'".
                            " OR response.response LIKE '%$queryterm%'".
                            " OR note.note LIKE '%$queryterm%'".
                            " OR note.title LIKE '%$queryterm%'".
                            ' ) ';
            }
        }
    }
    //department
    if($_REQUEST['dept'] && ($thisuser->isadmin() || in_array($_REQUEST['dept'],$thisuser->getDepts()))) {
    //This is dept based search..perm taken care above..put the sucker in.
        $qwhere.=' AND ticket.dept_id='.db_input($_REQUEST['dept']);
        $qstr.='&dept='.urlencode($_REQUEST['dept']);
    }
	
	if($_REQUEST['helptopic']) {
    //This is helptopic based search
        $qwhere.=' AND ticket.helptopic='.db_input($_REQUEST['helptopic']);
        $qstr.='&helptopic='.urlencode($_REQUEST['helptopic']);
    }
	
	if($_REQUEST['staffId']) {
	    //This is staff id based search
        $qwhere.=' AND ticket.staff_id='.db_input($_REQUEST['staffId']);
		$qstr.='&staffId='.urlencode($_REQUEST['staffId']);
	}
	
	if($_REQUEST['ticketType']){
		$qwhere.=' AND ticket.ticket_type_id='.db_input($_REQUEST['ticketType']);
		$qstr.='&ticketType='.urlencode($_REQUEST['ticketType']);
	}
	
    //dates
    $startTime  =($_REQUEST['startDate'] && (strlen($_REQUEST['startDate'])>=8))?strtotime($_REQUEST['startDate']):0;
    $endTime    =($_REQUEST['endDate'] && (strlen($_REQUEST['endDate'])>=8))?strtotime($_REQUEST['endDate']):0;
    if( ($startTime && $startTime>time()) or ($startTime>$endTime && $endTime>0)){
        $errors['err']='Entered date span is invalid. Selection ignored.';
        $startTime=$endTime=0;
    }else{
        //Have fun with dates.
        if($startTime){
            $qwhere.=' AND ticket.created>=FROM_UNIXTIME('.$startTime.')';
            $qstr.='&startDate='.urlencode($_REQUEST['startDate']);
                        
        }
        if($endTime){
            $qwhere.=' AND ticket.created<=FROM_UNIXTIME('.$endTime.')';
            $qstr.='&endDate='.urlencode($_REQUEST['endDate']);
        }
}
//Due Dates
	$duestartTime  =($_REQUEST['startDueDate'] && (strlen($_REQUEST['startDueDate'])>=8))?strtotime($_REQUEST['startDueDate']):0;
	$dueendTime    =($_REQUEST['endDueDate'] && (strlen($_REQUEST['endDueDate'])>=8))?strtotime($_REQUEST['endDueDate']):0;
       	if($duestartTime){
      		$qwhere.=' AND ticket.duedate>=FROM_UNIXTIME('.$duestartTime.')';
       		$qstr.='&startDueDate='.urlencode($_REQUEST['startDueDate']);
        }
       	if($dueendTime){
            $qwhere.=' AND ticket.duedate<=FROM_UNIXTIME('.$dueendTime.')';
       	    $qstr.='&endDueDate='.urlencode($_REQUEST['endDueDate']);
       	}
endif;

//I admit this crap sucks...but who cares??
$sortOptions=array('date'=>'ticket.created','ID'=>'ticketID','pri'=>'priority_urgency','dept'=>'dept_name');
$orderWays=array('DESC'=>'DESC','ASC'=>'ASC');

//Sorting options...
if($_REQUEST['sort']) {
    $order_by =$sortOptions[$_REQUEST['sort']];
}
if($_REQUEST['order']) {
    $order=$orderWays[$_REQUEST['order']];
}
if($_GET['limit']){
    $qstr.='&limit='.urlencode($_GET['limit']);
}
if(!$order_by && $showanswered) {
    $order_by='ticket.lastresponse DESC, ticket.created'; //No priority sorting for answered tickets.
}elseif(!$order_by && !strcasecmp($status,'closed')){
    $order_by='ticket.closed DESC, ticket.created'; //No priority sorting for closed tickets.
}


$order_by =$order_by?$order_by:'priority_urgency,effective_date DESC ,ticket.created';
$order=$order?$order:'DESC';
$pagelimit=$_GET['limit']?$_GET['limit']:$thisuser->getPageLimit();
$pagelimit=$pagelimit?$pagelimit:PAGE_LIMIT; //true default...if all fails.
$page=($_GET['p'] && is_numeric($_GET['p']))?$_GET['p']:1;


		$qselect = 'SELECT DISTINCT ticket.ticket_id,lock_id,ticketID,ticket.track_id,ticket.dept_id,ticket.staff_id,ticket.helptopic,subject,name,email,dept_name '.
		',ticket.status,ticket.source,isoverdue,isanswered,ticket.created,ticket.duedate,pri.* ,count(attach.attach_id) as attachments,ticket.ticket_type_id ';
		
		$qfrom=' FROM '.TICKET_TABLE.' ticket '.
		'LEFT  JOIN '.DEPT_TABLE.' dept ON ticket.dept_id=dept.dept_id '.
		' AND ticket.status="open" ';

if($search && $deep_search) {
    $qfrom.=' LEFT JOIN '.TICKET_MESSAGE_TABLE.' message ON (ticket.ticket_id=message.ticket_id )';
    $qfrom.=' LEFT JOIN '.TICKET_RESPONSE_TABLE.' response ON (ticket.ticket_id=response.ticket_id )';
    $qfrom.=' LEFT JOIN '.TICKET_NOTE_TABLE.' note ON (ticket.ticket_id=note.ticket_id )';
}

$qgroup=' GROUP BY ticket.ticket_id';
//get ticket count based on the query so far..
$total=db_count("SELECT count(DISTINCT ticket.ticket_id) $qfrom $qwhere");
//pagenate
$pageNav=new Pagenate($total,$page,$pagelimit);
$pageNav->setURL('tickets.php',$qstr.'&sort='.urlencode($_REQUEST['sort']).'&order='.urlencode($_REQUEST['order']));
//
//Ok..lets roll...create the actual query
//ADD attachment,priorities and lock crap
$qselect.=' ,count(attach.attach_id) as attachments, IF(ticket.reopened is NULL,ticket.created,ticket.reopened) as effective_date';
$qfrom.=' LEFT JOIN '.TICKET_PRIORITY_TABLE.' pri ON ticket.priority_id=pri.priority_id '.
        ' LEFT JOIN '.TICKET_LOCK_TABLE.' tlock ON ticket.ticket_id=tlock.ticket_id AND tlock.expire>NOW() '.
        ' LEFT JOIN '.TICKET_ATTACHMENT_TABLE.' attach ON  ticket.ticket_id=attach.ticket_id ';
		

$query="$qselect $qfrom $qwhere $qgroup ORDER BY $order_by $order LIMIT ".$pageNav->getStart().",".$pageNav->getLimit();
//echo $query;
$tickets_res = db_query($query);
$showing=db_num_rows($tickets_res)?$pageNav->showing():"";
if(!$results_type) {
    $results_type=($search)?'Search Results':ucfirst($status).' Tickets';
}
$negorder=$order=='DESC'?'ASC':'DESC'; //Negate the sorting..
//Permission  setting we are going to reuse.
$canDelete=$canClose=false;
$canDelete=$thisuser->canDeleteTickets();
$canClose=$thisuser->canCloseTickets();
$basic_display=!isset($_REQUEST['advance_search'])?true:false;

//YOU BREAK IT YOU FIX IT.
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
<!-- SEARCH FORM START -->
<div id='basic' style="display:<?=$basic_display?'block':'none'?>">
    <form action="tickets.php" method="get">
    <input type="hidden" name="a" value="search">
    <table>
        <tr>
            <td>Query: </td>
            <td><input type="text" id="query" name="query" size=30 value="<?=Format::htmlchars($_REQUEST['query'])?>"></td>
			<td>
			<select name="hide_merged_tkts">
				<option value=1 selected>Hide Merged Tickets</option>
				<option value=0>Show Merged Tickets</option>
			</select>
			</td>
            <td><input type="submit" name="basic_search" class="button" value="Search">
             &nbsp;[<a href="#" onClick="showHide('basic','advance'); return false;">Advanced</a> ] </td>
        </tr>
    </table>
    </form>
</div>
<div id='advance' style="display:<?=$basic_display?'none':'block'?>">
 <form action="tickets.php" method="get">
 <input type="hidden" name="a" value="search">
  <table>
    <tr>
        <td>Query: </td><td><input type="text" id="query" name="query" value="<?=Format::htmlchars($_REQUEST['query'])?>"></td>
        <td>Dept:</td>
        <td><select name="dept"><option value=0>All Departments</option>
            <?
                //Showing only departments the user has access to...
                $sql='SELECT dept_id,dept_name FROM '.DEPT_TABLE;
                if(!$thisuser->isadmin())
                    $sql.=' WHERE dept_id IN ('.implode(',',$thisuser->getDepts()).')';
                
                $depts= db_query($sql);
                while (list($deptId,$deptName) = db_fetch_row($depts)){
                $selected = ($_GET['dept']==$deptId)?'selected':''; ?>
                <option value="<?=$deptId?>"<?=$selected?>><?=$deptName?></option>
            <?
            }?>
            </select>
        </td>
        <td>Status is:</td><td>
    
        <select name="status">
            <option value='any' selected >Any status</option>
            <option value="open" <?=!strcasecmp($_REQUEST['status'],'Open')?'selected':''?>>Open</option>
            <option value="overdue" <?=!strcasecmp($_REQUEST['status'],'overdue')?'selected':''?>>Overdue</option>
            <option value="closed" <?=!strcasecmp($_REQUEST['status'],'Closed')?'selected':''?>>Closed</option>
        </select>
        </td>
     </tr>
	 <tr>
	 <!-- help topic added -->
	 <td>Help Topics: </td>
	 <td><select style="width:147px;" name="helptopic">
			<option value="">Select</option>
			<?
                $sql='SELECT topic_id,topic FROM '.TOPIC_TABLE;
                $topics= db_query($sql);
                while (list($topicId,$topicName) = db_fetch_row($topics)){
					$selected = ($_GET['helptopic']==$topicName)?'selected':''; ?>
					<option value="<?=$topicName?>"<?=$selected?>><?=$topicName?></option>
            <?
            }?></select>
	</td>
	<td>Assigned To: </td>
	<td><select id="staffId" name="staffId" style="width:147px;">
			<option value="" selected="selected">Select</option>
			<?
				$sql=' SELECT staff_id,CONCAT_WS(" ",firstname,lastname) as name FROM '.STAFF_TABLE.' WHERE isactive=1 AND onvacation=0 ';
				$depts= db_query($sql.' ORDER BY firstname,lastname ');
				while (list($staffId,$staffName) = db_fetch_row($depts)){
					$selected = ($_GET['staffId']==$staffId)?'selected':''; ?>
					<option value="<?=$staffId?>"<?=$selected?>><?=$staffName?></option>
			<?
			}?>
		</select>
	</td>
	<td>Ticket Type: </td>
	<td><select style="width:80px;" name="ticketType">
			<option value="">Select</option>
			<?
                $sql='SELECT ticket_type_id,ticket_type FROM '.TICKET_TYPE_TABLE;
                $types= db_query($sql);
                while (list($typeId,$type) = db_fetch_row($types)){
					$selected = ($_GET['ticketType']==$typeId)?'selected':''; ?>
					<option value="<?=$typeId?>"<?=$selected?>><?=$type?></option>
            <?
            }?></select>
	</td>
	</tr>
    </table>
    <div>
        Date Span:
        From&nbsp;<input id="sd" name="startDate" value="<?=Format::htmlchars($_REQUEST['startDate'])?>" 
                onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF>
            <a href="#" onclick="event.cancelBubble=true;calendar(getObj('sd')); return false;"><img src='images/cal.png'border=0 alt=""></a>
            &nbsp;&nbsp; to &nbsp;&nbsp;
            <input id="ed" name="endDate" value="<?=Format::htmlchars($_REQUEST['endDate'])?>" 
                onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF >
                <a href="#" onclick="event.cancelBubble=true;calendar(getObj('ed')); return false;"><img src='images/cal.png'border=0 alt=""></a>
            &nbsp;&nbsp;
    </div>
     <div>
        Due Date  :
        &nbsp;From&nbsp;<input id="sdd" name="startDueDate" value="<?=Format::htmlchars($_REQUEST['startDueDate'])?>"
                onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF>
            <a href="#" onclick="event.cancelBubble=true;calendar(getObj('sdd')); return false;"><img src='images/cal.png'border=0 alt=""></a>
            &nbsp;&nbsp; to &nbsp;&nbsp;
            <input id="edd" name="endDueDate" value="<?=Format::htmlchars($_REQUEST['endDueDate'])?>"
                onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF >
                <a href="#" onclick="event.cancelBubble=true;calendar(getObj('edd')); return false;"><img src='images/cal.png'border=0 alt=""></a>
            &nbsp;&nbsp;
    </div>

    <table>
    <tr>
       <td>Type:</td>
       <td>       
        <select name="stype">
            <option value="LIKE" <?=(!$_REQUEST['stype'] || $_REQUEST['stype'] == 'LIKE') ?'selected':''?>>Scan (%)</option>
            <option value="FT"<?= $_REQUEST['stype'] == 'FT'?'selected':''?>>Fulltext</option>
        </select>
 

       </td>
       <td>Sort by:</td><td>
        <? 
         $sort=$_GET['sort']?$_GET['sort']:'date';
        ?>
        <select name="sort">
    	    <option value="ID" <?= $sort== 'ID' ?'selected':''?>>Ticket #</option>
            <option value="pri" <?= $sort == 'pri' ?'selected':''?>>Priority</option>
            <option value="date" <?= $sort == 'date' ?'selected':''?>>Date</option>
            <option value="dept" <?= $sort == 'dept' ?'selected':''?>>Dept.</option>
        </select>
        <select name="order">
            <option value="DESC"<?= $_REQUEST['order'] == 'DESC' ?'selected':''?>>Descending</option>
            <option value="ASC"<?= $_REQUEST['order'] == 'ASC'?'selected':''?>>Ascending</option>
        </select>
       </td>
        <td>Results Per Page:</td><td>
        <select name="limit">
        <?
         $sel=$_REQUEST['limit']?$_REQUEST['limit']:15;
         for ($x = 5; $x <= 25; $x += 5) {?>
            <option  value="<?=$x?>" <?=($sel==$x )?'selected':''?>><?=$x?></option>
        <?}?>
        </select>
     </td>
     <td>
     <input type="submit" name="advance_search" class="button" value="Search">
       &nbsp;[ <a href="#" onClick="showHide('advance','basic'); return false;" >Basic</a> ]
    </td>
  </tr>
 </table>
 </form>
</div>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<script type="text/javascript">

    var options = {
        script:"ajax.php?api=tickets&f=search&limit=10&",
        varname:"input",
        shownoresults:false,
        maxresults:10,
        callback: function (obj) { document.getElementById('query').value = obj.id; document.forms[0].submit();}
    };
    var autosug = new bsn.AutoSuggest('query', options);
</script>




<script type="text/javascript">
function mergeChecks(ticket_id,track_id)
{

	var tt=document.tickets;
	var cc=document.getElementById('checkCount').value;
	var theForm = document.tickets;
	for (i=0; i<theForm.elements.length; i++) 
	{

	var sub=theForm.elements[i].value.split(',');
	if (theForm.elements[i].name=='tids[]'&& sub[1]==track_id )
	   if(theForm.elements[i].checked=ticket_id)
	   {
		theForm.elements[i].checked = true;
		var flag=sub[1]; // Getting track_ids
		var ids=ids+','+sub[0];//Getting ticket_ids
		
	   }
      
	}

	var answer = confirm("Are you sure ??")
	if (answer)
	{
	 
	    var effIds=ids.substr(10);
		if(effIds.indexOf(',')<0)
		{
			alert("Same group ticket not found ..!");
			mergeUnChecks(ticket_id,track_id);
			return false;
		}
		
		//window.location = "tickets.php?ids="+flag;
		var param='option=mergeTickets&ticket_ids='+effIds+'&track_id='+flag;
		$('#processDiv').slideDown('1000');
		$('#processDiv').html('<img src="../images/loading.gif" align="absmiddle"/> '+'Please wait');
		var includefilespath= escape("ajaxload/loaddata.php");
		
	    $.ajax
		({
			type: "POST",
			url: includefilespath,
			data: param,
			success: function(response)
			{
			
				$('#processDiv').html(response);
			}
		});
        
	}
	else
	{

		mergeUnChecks(ticket_id,track_id);
	}

}

function hideResult()
{
  $('#processDiv').slideUp('1000');
  window.location=document.URL;
}

function mergeUnChecks(ticket_id,track_id)
{
	var tt=document.tickets;
	var cc=document.getElementById('checkCount').value;
	var theForm = document.tickets;
	for (i=0; i<theForm.elements.length; i++)
	{
		var sub=theForm.elements[i].value.split(',');
		if (theForm.elements[i].name=='tids[]'&& sub[1]==track_id)
		//alert(sub[1]);
		if(theForm.elements[i].checked=ticket_id)
		{
		theForm.elements[i].checked = false;
		}
	}

}

function manualMerge() 
{
	
	var theForm = document.tickets;
	var mids='';
	var tracks='';
	//$('#disp_tracks').slideDown('1000');
    
$( "#disp_tracks:first" ).animate({
    left: 430
  }, {
    duration: 500,
    step: function( now, fx ){
      $( ".block:gt(0)" ).css( "left", now );
    }
  });



	for (i=0; i<theForm.elements.length; i++) 
	{
		
    if(theForm.elements[i].checked == true)
		{
		 var vv=theForm.elements[i].value.split(',');
		 
		 mids=mids+','+vv[0];
		 tracks=tracks+','+vv[1];
		}
	  
	}
	var trk_ids=mids.substr(1);
	var ticket_ids=mids.substr(1);
	

	display_track_selection(ticket_ids);
	return false;
	

		//setTimeout('hideResult()', 3000);

}


function callMerge(primary_track) 
{
	var tt=document.tickets;
	var cc=document.getElementById('checkCount').value;
	var theForm = document.tickets;
	var mids='';
	var tracks='';
	$('#disp_tracks').slideDown('1000');
	for (i=0; i<theForm.elements.length; i++) 
	{
		
    if(theForm.elements[i].checked == true)
		{
		 var vv=theForm.elements[i].value.split(',');
		 
		 mids=mids+','+vv[0];
		 tracks=tracks+','+vv[1];
		}
	  
	}
	var trk_ids=mids.substr(1);
	
	display_track_selection(tracks);
	
	
	var f_ids=mids.substr(1);
	
		var param='option=manualTickets&ticket_ids='+f_ids+'&pri_track='+primary_track;
		$('#disp_tracks').slideDown('1000');
		$('#disp_tracks').css('padding-top','10px');
		$('#disp_tracks').html('<img src="../images/loading.gif" align="absmiddle"/> '+'Please wait');
		var includefilespath= escape("ajaxload/loaddata.php");
        


		$.ajax
		({
			type: "POST",
			url: includefilespath,
			data: param,
			success: function(response)
			{
			
				$('#disp_tracks').css('padding-top','0px');
				$('#disp_tracks').html(response);
				setTimeout('hideDisptracks()',500);
 

			}
		});
        
		//setTimeout('hideResult()', 3000);

}

function hideDisptracks()
{
	
			 $( "#disp_tracks" ).slideUp(100);
			 window.location=document.URL;
}
function display_track_selection(tids)
{
	
	 if(tids=='')
	{	
	 alert("Select Tickets"); 
	 return false;
	}
	
	if(tids.indexOf(',')<0)
	{
      alert("Choose Multiple Tickets ");
	  return false;
 	}
   
	document.getElementById('disp_tracks').style.display="block";
	var param='option=selectTrack&ticket_ids='+tids;
		$('#disp_tracks').slideDown('1000');
		$('#disp_tracks').css('padding-top','10px');
		$('#disp_tracks').html('<img src="../images/loading.gif" align="absmiddle"/> '+'Please wait');
		var includefilespath= escape("ajaxload/loaddata.php");
        //alert(param); 
		$.ajax
		({
			type: "POST",
			url: includefilespath,
			data: param,
			success: function(response)
			{
			    //alert(response);
				$('#disp_tracks').css('padding-top','0px');
				$('#disp_tracks').html(response);

		
			}
		});

       
		
}
function selectBoxval(tval)
{
	
	if(tval!='')
	{
		//alert(tval);
		callMerge(tval);
	}
	else
	{
		alert("Val required");
	}
	
}

</script>
<style type="text/css">
.light-font
{
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#000;
}
#disp_tracks
{
	position:absolute;
	top:250px;
	font-family:11px;
	font-size:11px;
	color:#333;
	font-weight:bold;
	width:30%;
	height:90px;
	background-Color:#fbfbfb;
	border:4px solid #5C5C5C;
	opacity:0.9;
	text-align:center;
	left:35%;
	
}
#dispTracks
{
	height:30px;
	width:280px;
	border:2px solid #D1D1D1;
	background-Color:#fafafa;
	font-family:Arial;
	font-size:11px;
	color:#333;
    
	padding-left:10px;
}

</style>

<!-- SEARCH FORM END -->

<div id="disp_tracks" style="display:none">
	<div style="background-Color:#333;color:#ffffff;text-align:right;margin-bottom:10px;padding-right:5px;height:20px;border-bottom:2px solid #FFCC00">
		<a href="" ><strong style='color:#ffffff'>Close</strong></a>
	</div>
</div>

 
<table width="100%" border="0" cellspacing=0 cellpadding=0 align="center">
		<tr>
			<td width="80%" class="msg" >&nbsp;<b><?=$showing?>&nbsp;&nbsp;&nbsp;<?=$results_type?></b></td>
			<td nowrap style="text-align:right;padding-right:5px;">
				<a href=""><img src="images/refresh.gif" alt="Refresh" border=0 align="absmiddle"></a>
				<a href="javascript:void(0)" onclick="manualMerge()" > <img src='images/mergemanual.gif' align="absmiddle"></a>
			</td >
		</tr>
</table>

<div id="processDiv" style="padding:2px;background-Color:#CCFFCC;color:#000;display:none;border:1px solid #339900;margin-top:5px;margin-bottom:5px; font-size:11px; color:#360; font-weight:bold">&nbsp;
</div>
 

<table width="100%" border="0" cellspacing=0 cellpadding=2 class="dtable" align="center">
		<form action="tickets.php" method="POST" name='tickets' onSubmit="return checkbox_checker(this,1,0);">
			<input type="hidden" name="a" value="mass_process">
			<input type="hidden" name="status" value="<?=$statusss?>">

            <?if($canDelete || $canClose) {?>
	        <th width="20">&nbsp;</th>
            <?}?>
	        <th width="70" ><a href="tickets.php?sort=ID&order=<?=$negorder?><?=$qstr?>" title="Sort By Ticket ID <?=$negorder?>">Ticket</a></th>
			<th width="65"><a href="tickets.php?sort=date&order=<?=$negorder?><?=$qstr?>" title="Sort By Date <?=$negorder?>">Date</a></th>
			<th width="15"></th>		
			<th>Topic</th>			
	        <th>Subject</th>
            <th width="126">From</th>
			<th width="126">Assigned</th>
			<th width="50" >Status</th>
			<th width="65">Due Date</th>           
        </tr>       
        <?
        $class = "row1";
        $total=0;
			
        if($tickets_res && ($num=db_num_rows($tickets_res))):
            while ($row = db_fetch_array($tickets_res)) {
                $tag=$row['staff_id']?'assigned':'openticket';
                $flag=null;
                if($row['lock_id'])
                    $flag='locked';
                elseif($row['staff_id'])
                    $flag='assigned';
                elseif($row['isoverdue'])
                    $flag='overdue';

                $tid=$row['ticketID'];
				$subject = $row['subject'];
                if(!strcasecmp($row['status'],'open') && !$row['isanswered'] && !$row['lock_id']) {
                    $tid=sprintf('<b>%s</b>',$tid);
                }
                ?>
               
               <tr class="<?=$class?> " id="<?=$row['ticket_id']?>">
                <?if($canDelete || $canClose) {?>
                <td align="center" class="nohover">
                    <input type="checkbox" name="tids[]" value="<?=$row['ticket_id'].','.$row['track_id'];?>" onClick="highLight(this.value,this.checked);" >
                </td>
                <?}?>
                <td align="left" title="<?=$row['email']?>" nowrap class="light-font">
                  <a class="Icon <?=strtolower($row['source'])?>Ticket" title="<?=$row['source']?> Ticket: <?=$row['email']?>" 
                    href="tickets.php?id=<?=$row['ticket_id']?>"><b><?=$tid?></a> 
                      <?
					  $n="";
                      if($row['track_id']!=0 && $row['track_id']!=999999) {
					  ?>
						<a href="#" onclick="javascript:window.open('mtickets.php?track_id=<?=$row['ticket_id'];?>', 'Merged_Tickets', 'scrollbars=yes,toolbar=no,menubar=no,status=no,location=no,status=no,width=500,height=400');">
						<img src='../images/link.png' align='absmiddle'>
						</a>
						<?
					  }
					  else {
						echo "&nbsp;&nbsp;&nbsp;&nbsp;";
					  }
					  ?>
                 </td>
				 
                <td align="center" nowrap class="light-font"><?=Format::db_date($row['created'])?></td>
				
				<?php
						$type_name= $row['ticket_type_id'];
						$type_code="F";
						if ($row['ticket_type_id']==1){$type_code="F";}
						if ($row['ticket_type_id']==2){$type_code="P";}
						if ($row['ticket_type_id']==3){$type_code="C";}
						if ($row['ticket_type_id']==4){$type_code="S";}
				?>
				<td class="light-font" style="background-color:<?=$row['priority_color']?>;text-align:center;"><?=$type_code;?></td>
				<td nowrap class="light-font"><?=$row['helptopic'];?>&nbsp;</td>

                <td class="light-font">
                   <a <?if($flag) { ?> class="Icon <?=$flag?>Ticket" title="<?=ucfirst($flag)?> Ticket" <?}?> 
                    href="tickets.php?id=<?=$row['ticket_id']?>&track_id=<?php echo $row['track_id'];?>">
					<?=$subject?>
                    </a>
                <?=$row['attachments']?"<span class='Icon file'>&nbsp;</span>":''?></td>

                
                <td nowrap class="light-font">&nbsp;<?=Format::truncate($row['name'],22,strpos($row['name'],'@'))?>&nbsp;</td>
				
				<td nowrap class="light-font">&nbsp;
					<?php
						$staff_id= $row['staff_id'];
						$assigned_sql = "SELECT firstname,lastname from isost_staff where staff_id = '$staff_id'";
						$assigned_sql_res = mysql_query($assigned_sql);
						$assigned_sql_row = db_fetch_row($assigned_sql_res);
						echo $assigned_sql_row[0] . " " .$assigned_sql_row[1];
					?>
				</td>
				<td align="center" nowrap class="light-font"><? echo strtoupper($row['status']);?></td>
				<td align="center" nowrap class="light-font">&nbsp;<?=Format::db_date($row['duedate'])?></td>
				<input type="hidden" id="checkCount" value="<?php echo $num;?>"/>
           
            </tr>
 
            <?
			
            $class = ($class =='row2') ?'row1':'row2';
            } //end of while.
        else: //not tickets found!! ?> 
            <tr class="<?=$class?>"><td colspan=10><b>Query returned 0 results.</b></td></tr>
        <?
        endif; ?>
    </table>

	
	<table width=100% border="0" cellspacing=0 cellpadding=2>
	
    <?
    if($num>0){ //if we actually had any tickets returned.
    ?>
        <tr><td style="padding-left:20px">
            <?if($canDelete || $canClose) { ?>
            Select:
                <a href="#" onclick="return select_all(document.forms['tickets'],true)">All</a>&nbsp;
                <a href="#" onclick="return reset_all(document.forms['tickets'])">None</a>&nbsp;
                <a href="#" onclick="return toogle_all(document.forms['tickets'],true)">Toggle</a>&nbsp;
            <?}?>
            page:<?=$pageNav->getPageLinks()?>
        </td></tr>
	</table>
	<table width=100% border="0" cellspacing=0 cellpadding=2>
		<tr>
			<td width=60 style='text-align: center; background-color: #FFFF66;'><font face=Arial size=1 color=#333333><b>low</td>
			<td width=60 style='text-align: center; background-color: #82A0DF;'><font face=Arial size=1 color=#333333><b>normal</td>
			<td width=60 style='text-align: center; background-color: #FF6600;'><font face=Arial size=1 color=#333333><b>high</td>
			<td width=60 style='text-align: center; background-color: #CC0000;'><font face=Arial size=1 color=#FFFFFF><b>emergency</td>
			<td width=60 style='text-align: center; background-color: #00FFFF;'><font face=Arial size=1 color=#333333><b>exception</td>
			<td width=400 style='text-align: center; background-color: #DDDDDD;'><font face=Arial size=1 color=#666666><b>
			F : fault / incident&nbsp;&nbsp;
			P : problem &nbsp;&nbsp;
			S : service request&nbsp;&nbsp;
			C : change request&nbsp;&nbsp;
			</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	
	<table width=100% border="0" cellspacing=0 cellpadding=2>
        <? if($canClose or $canDelete) { ?>
        <tr><td align="center"> <br>
            <?
            $status=$_REQUEST['status']?$_REQUEST['status']:$status;

            //If the user can close the ticket...mass reopen is allowed.
            //If they can delete tickets...they are allowed to close--reopen..etc.
            switch (strtolower($status)) {
                case 'closed': ?>
                    <input class="button" type="submit" name="reopen" value="Reopen"
                        onClick=' return confirm("Are you sure you want to reopen selected tickets?");'>
                    <?
                    break;
                case 'open':
                case 'answered':
                case 'assigned':
                    ?>
                    <input class="button" type="submit" name="close" value="Close"
                        onClick=' return confirm("Are you sure you want to close selected tickets?");'>
                    <?
                    break;
                default: //search??
                    ?>
                    <input class="button" type="submit" name="close" value="Close"
                        onClick=' return confirm("Are you sure you want to close selected tickets?");'>
                    <input class="button" type="submit" name="reopen" value="Reopen"
                        onClick=' return confirm("Are you sure you want to reopen selected tickets?");'>
            <?
            }
            if($canDelete){?>
                <input class="button" type="submit" name="delete" value="Delete" 
                    onClick=' return confirm("Are you sure you want to DELETE selected tickets?");'>
            <?}?>
        </td></tr>

        <? }
    } ?>
    </form>
	</table>
 
</div>
<?
