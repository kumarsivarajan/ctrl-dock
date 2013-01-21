<?

function ezsms ($phone,$message){
	include_once("../include/config_sms.php");
	
	if ($SMS==1){
			$fields = array(
				'phone'=>urlencode($phone),
				'message'=>urlencode($message)
			);
		
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string,'&');
				
		$ch = curl_init();	
			
		curl_setopt($ch, CURLOPT_URL, $SMS_GW_URL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 60);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_TIMEOUT,60);		
		curl_setopt($ch, CURLOPT_POST,count($fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
		$data = curl_exec($ch);
			
		curl_close($ch);
	}
}
?>