<?

// ------------------------------------------------------------------------------------------------------------
// Function to query URL using curl and load XML data	

function load_xml($request_url){
		
		$ch = curl_init();
		
		//Replace spaces with %20 in request URL
		$request_url=str_replace(' ', '%20', $request_url);
		
		curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 60);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_TIMEOUT,60);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
				
		$data = curl_exec($ch);
		
		// Debug Code
		if(curl_errno($ch)){
			//echo 'Curl error: ' . curl_error($ch);
			//$info = curl_getinfo($ch);		
		}

		curl_close($ch);
		$data=simplexml_load_string($data);
		
		return $data;		
}	


?>