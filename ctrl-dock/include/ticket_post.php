<?
$sql="SELECT helpdesk_url from isost_config";
$result = mysql_query($sql);

$row = mysql_fetch_row($result);
$ticket_post_url=$row[0]."/post.php?";

function ticket_post($name,$email,$topicId,$subject,$message,$ticket_type_id=''){
	global $ticket_post_url;
	$pri="2";
	$dept_id="1";
	
	$fields = array(
            'name'=>urlencode($name),
            'email'=>urlencode($email),            
            'topicId'=>urlencode($topicId),
            'subject'=>urlencode($subject),
			'tickettype'=> urlencode($ticket_type_id),
			'dept_id'=> urlencode($dept_id),
			'pri'=> urlencode($pri),
			'message'=>urlencode($message)
    );
	$fields_string='';
	$response='';
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string,'&');
	

	try{
		$response=do_post_request($ticket_post_url,$fields_string);
	}
	catch(Exception $e){
	}
	
	return $response;
}


function do_post_request($url, $data, $optional_headers = null){

  $params = array('http' => array(
              'method' => 'POST',
              'content' => $data
            ));
  $php_errormsg = "";
  if ($optional_headers !== null) {
    $params['http']['header'] = $optional_headers;
  }
  $ctx = stream_context_create($params);
  $fp = @fopen($url, 'rb', false, $ctx);
  if (!$fp) {
    throw new Exception("Problem with $url, $php_errormsg");
  }
  $response = @stream_get_contents($fp);
  if ($response === false) {
    throw new Exception("Problem reading data from $url, $php_errormsg");
  }
  return $response;
}



?>