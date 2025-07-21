<?php
function check_input($data){
	$data = @trim($data);// replace all whitespace to single space.
 	$data = htmlspecialchars($data);
 	return $data;
}

// Send email
function sendEmail($to, $bcc, $subject, $body, $fromName, $fromEmail, $replyTo, $isHTML=1) {
	$headers = "From: ".$fromName." <".$fromEmail.">\n";
	$headers .= "MIME-Version: 1.0\n";
	if($isHTML==1) {
		$headers .= "Content-type: text/html; charset=iso-8859-1\n"; 		
	}
	$headers .= "Reply-To: ".$fromName." <".$replyTo.">\n";
	$headers .= "Bcc: ".$bcc."\r\n";
	@mail($to,$subject,$body,$headers);
	}	
 
