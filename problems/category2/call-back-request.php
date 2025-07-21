<?php
ob_start();
require_once('functions.php'); 

$ERROR = 1;
$ERRORMSG = '';
$MSG = '';
$SUCCESS = 0;
  

#=================================================================
if(isset($_POST['submit_callback_form'])){
 
  	$name = check_input($_POST['name']);
 	$email = check_input($_POST['email']);
	$phone = check_input($_POST['tel']);
	$contactTime = check_input($_POST['contactTime']);
	//$message = check_input($_POST['comment']);
	//$message = str_replace("\\r\\n", "\n", $message); 
 	
	$CheckboxGroup = isset($_POST['CheckboxGroup']) ? $_POST['CheckboxGroup'] : array();
 	
	if(count($CheckboxGroup)){
		$CheckboxGroup = implode(', ',$CheckboxGroup);
	}else{
		$CheckboxGroup = '';
	}
	
  	 // Validate
   if(empty($name)):
		$ERROR = 1;	
		$ERRORMSG = 'Please enter name.';
	elseif(empty($email)):
		$ERROR = 1;	
		$ERRORMSG = 'Please enter email.';
	elseif(!filter_var($email, FILTER_VALIDATE_EMAIL) ):
		$ERROR = 1;
  		$ERRORMSG = 'The email address is not valid';
 	elseif(empty($phone)):
		$ERROR = 1;	
		$ERRORMSG = 'Please enter Phone number.';
	elseif($phone && !is_numeric($phone)):
		$ERROR = 1;	
		$ERRORMSG = 'Phone number must be numeric.';	 
	elseif(empty($contactTime)):
		$ERROR = 1;	
		$ERRORMSG = 'Please select: Best time to contact?';	 
	/*
	elseif(empty($message)):
		$ERROR = 1;	
		$ERRORMSG = 'Message is mandatory field.';
	*/
	else:
		 $ERROR = 0;
		 $ERRORMSG = ''; 
 	endif;
#=================================================================  	
if(!$ERROR){ 

$to = 'aj@jgbaccountants.com' ;
$bcc = '' ;
// Send email to user 
$subject = 'Request a call back from: '. $name;

$body = "Dear Webmaster,".PHP_EOL."
You have received a 'call back request' from following visitor.

--------------------------------------------------------
Sender Details:
--------------------------------------------------------
Sender's Name: $name,
Sender's Email: $email,
Sender's Phone: $phone
Best time to contact?: $contactTime

Yes please, I'd like to hear about offers and services by: $CheckboxGroup

This email was sent from 'Request a Call Back' form.

";

$fromEmail = 'noreply@'.$_SERVER['HTTP_HOST'];
$replyTo = $email;

sendEmail($to, $bcc, $subject, $body, $name, $fromEmail, $replyTo,0);

$MSG = '<div class="greenText"><b>Thanks for Request!</b> We will call you shortly.</div>';
$MSG .= '<script>				 
				document.getElementById("callback_form").reset();			 
			</script>';	
		
$SUCCESS = 1;
		
 
 
} //==========END !ERROR
}else{
	$ERROR = 1;
	$ERRORMSG = 'Invalid Request';
}

$data['error'] = $ERROR;
$data['errorMsg'] = $ERRORMSG;
$data['success'] = $SUCCESS;
$data['successMsg'] = $MSG;
echo json_encode($data);
exit;



//====================================
//exit;


?>
