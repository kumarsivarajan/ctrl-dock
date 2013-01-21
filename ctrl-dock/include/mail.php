<?

function ezmail ($to_email,$to_name,$subject,$body,$attachment,$html=false){
	
	global 	$smtp_server,$smtp_port,$smtp_username,$smtp_password,$smtp_auth,$smtp_email,$smtp_name,$smtp_secure,$SECRET_SALT;
	
	$return=1;
	
	$reply_to_email=$smtp_email;
	$reply_to_name =$smtp_name;
	
	require_once('class.phpmailer.php');

	$mail = new PHPMailer(true); 	// the true param means it will throw exceptions on errors, which we need to catch
	$mail->IsSMTP(); 				// telling the class to use SMTP
    
	
	$mail->SMTPDebug  = 0;                    // enables SMTP debug information (for testing)
	$mail->Host       = $smtp_server; 		  // sets the SMTP server
	$mail->Port       = $smtp_port;           // set the SMTP port
	$mail->Username   = $smtp_username; 	  // SMTP account username
	$mail->Password   = $smtp_password;       // SMTP account password
	
	
	if($smtp_auth==1){
		$mail->SMTPAuth =  true;
		$mail->Password = $smtp_password;
		$mail->Username = $smtp_username;
	}
	
	if($smtp_secure==1){
		$mail->SMTPSecure  =  "tls";
	}

	$address=array();
	if(strrpos($to_email,";")>0){
		$address = explode(";", $to_email);
	}elseif(strrpos($to_email,",")>0){
		$address = explode(",", $to_email);
	}	
	
	if (count($address)>0){
		for($i=0;$i<count($address);$i++){			
			$mail->AddReplyTo($reply_to_email, $reply_to_name);
			$mail->AddAddress($address[$i]);
			$mail->SetFrom($reply_to_email, $reply_to_name);
			$mail->Subject = $subject;
			$mail->Body = $body;
			$mail->IsHTML($html);
		
			if(!$mail->Send()){
				$return=0;
			}
		}
	}else{
		$mail->AddReplyTo($reply_to_email, $reply_to_name);
		$mail->AddAddress($to_email, $to_name);
		$mail->SetFrom($reply_to_email, $reply_to_name);
		$mail->Subject = $subject;
		$mail->Body = $body;
		
		if(strlen($attachment)>0){
			$file_name=substr($attachment,strpos($attachment,"/")+1);
			$mail->AddAttachment($attachment, $file_name);
		}
		$mail->IsHTML($html);
		
		if(!$mail->Send()){
			$return=0;
		}
	}

	$mail->ClearAddresses();
	$mail->ClearAttachments();
	
	return $return;
}
?>
