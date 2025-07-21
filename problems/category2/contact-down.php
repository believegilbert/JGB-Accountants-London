<?php
require '/home/jgbaccountants/public_html/contact-function.php';

$ERROR = 0;
$ERRORMSG = '';
$SUCCESS = 0;
$MSG = '';

if(isset($_POST)){

	// Validate
	if (empty($_POST["name"])) {
		$ERROR = 1;
		$ERRORMSG = 'Please enter your Name.';
	} else {
		$name = check_input($_POST["name"]);
		// check name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
			$ERROR = 1;
			$ERRORMSG = 'Only letters and white space allowed.';
		}
	}

	if (empty($_POST["email"])) {
		$ERROR = 1;
		$ERRORMSG = 'Please enter Email.';
	} else {
		$email = check_input($_POST["email"]);
		if(filter_var($email, FILTER_VALIDATE_EMAIL) ){
			$ERROR = 0;
		} else {
			$ERROR = 1;
		    $ERRORMSG = 'The email address is not valid';
    	}
	}
	
	if (empty($_POST["tel"])) {
		$ERROR = 1;
		$ERRORMSG = 'Please enter your Phone Number.';
	} else {
		$phone = check_input($_POST["tel"]);
		// check phone number only contains numbers
		if (!preg_match("/^[0-9]*$/",$phone)) {
			$ERROR = 1;
			$ERRORMSG = 'Only numbers allowed.';
		}
		if(!is_numeric($phone)){
			$ERROR = 1;
			$ERRORMSG = 'Phone number must be numeric.';
		}
	}

    if (empty($_POST["contactTime"])) {
		$ERROR = 1;
		$ERRORMSG = 'Please select: Best time to contact?';
	} else {
		$contactTime = check_input($_POST["contactTime"]);
	}

    if (empty($_POST["CheckboxGroup"])) {
		$ERROR = 1;
		$ERRORMSG = 'Please select: Best way to contact you';
	} else {
		$CheckboxGroup = isset($_POST['CheckboxGroup']) ? $_POST['CheckboxGroup'] : array();
        if(count($CheckboxGroup)){
            $CheckboxGroup = implode(', ', $CheckboxGroup);
        }else{
            $CheckboxGroup = '';
        }
	}	
#=================================================================  	
	if(!$ERROR){
		$fromEmail = 'aj@jgbaccountant.com';
		$replyTo = $email;
        $to = 'info@jgbaccountant.com';
		//$to = 'daverickyus@gmail.com';
		$bcc = '';
		$toName = 'JGB Accountants';
		$subject = 'Request a call back from: '. $name;
		$headers = "From: ".$name." <".$email."> \r\n";
		//$headers = "From: ".$name." <".$fromEmail."> \r\n";
		$headers .= "Reply-To: ".$name." <".$replyTo."> \r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Bcc: ".$bcc."\r\n";
		$body = "Dear JGB Accountants,".PHP_EOL."<br>
		<br>
		You have received a 'call back request' from following visitor.<br>
		<br>

		Sender Details:<br>
		--------------------------------------------------------<br>
		Sender's Name: $name,<br>
		Sender's Email: $email,<br>
		Sender's Phone: $phone<br><br>
		Best time to contact?: $contactTime<br><br>
		
        Yes please, I'd like to hear about offers and services by: $CheckboxGroup<br><br>

		This email was sent from 'Speak to a Tax Expert Today' form.";

		//$send_email = mail($to,$subject,$body,$headers);
		$send_email = sendEmail($to, $bcc, $toName, $subject, $body, $name, $fromEmail, $replyTo);
		
		if($send_email){
			$SUCCESS = 1;
			$MSG .= '<div class="greenText">Request Sent. <b>Thanks for Request!</b><br> We will call you shortly.</div>';	 
			$MSG .= '<script>
					document.getElementById("callback_form").reset();
					</script>'; 	
		} else {
			$SUCCESS = 0;
			$MSG = 'Message Not Sent.';
		}
	}
	 //==========END !ERROR	 
}else{
	$ERROR = 1;
	$ERRORMSG = 'Invalid Request';
	exit;
}

$data['error'] = $ERROR;
$data['errorMsg'] = $ERRORMSG;
$data['success'] = $SUCCESS;
$data['successMsg'] = $MSG;
//echo json_encode($data);

if($ERROR == 0){
        echo $MSG;
}else{
        echo '<div class="redText"><b>'.$ERRORMSG.'</b></div>';
}

function check_input($data) {
	$data = @trim($data);// replace all whitespace to single space.
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>