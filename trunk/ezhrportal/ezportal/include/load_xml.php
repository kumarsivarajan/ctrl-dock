<?

// ------------------------------------------------------------------------------------------------------------
// Function to query URL using curl and load XML data	

function load_xml($request_url){		
		$ch = curl_init();	
		
		curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT,60);		
		$data = curl_exec($ch);
		
		curl_close($ch);
		$data=simplexml_load_string($data);
		return $data;		
}	


?>