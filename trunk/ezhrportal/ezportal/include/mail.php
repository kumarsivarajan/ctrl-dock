<?

function ezmail ($to_email,$to_name,$subject,$body){
	
	global 	$smtp_server,$smtp_port,$smtp_username,$smtp_password,$smtp_auth,$smtp_email,$smtp_name,$smtp_secure;
	
	$return=1;
	
	$reply_to_email=$smtp_email;
	$reply_to_name =$smtp_name;
	
	require_once('class.phpmailer.php');

	$mail = new PHPMailer(true); 	// the true param means it will throw exceptions on errors, which we need to catch
	$mail->IsSMTP(); 				// telling the class to use SMTP
    
	
	$mail->SMTPDebug  = 0;                    // enables SMTP debug information (for testing)
	$mail->Host       = $smtp_server; 		  // sets the SMTP server
	$mail->Port       = $smtp_port;           // set the SMTP port for the GMAIL server
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

	  
	$mail->AddReplyTo($reply_to_email, $reply_to_name);
	$mail->AddAddress($to_email, $to_name);
	$mail->SetFrom($reply_to_email, $reply_to_name);
	$mail->Subject = $subject;
	$mail->MsgHTML($body);
	
	
	if(!$mail->Send()){
		$return=0;
	}
	
	$mail->ClearAddresses();
	$mail->ClearAttachments();
	
	return $return;
}
?>
