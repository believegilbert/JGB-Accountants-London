<?php
ob_start();

require_once('functions.php'); 

$ERROR = 1;
$ERRORMSG = '';
$MSG = '';
$SUCCESS = 0;
  

#=================================================================
if(isset($_POST['submit_contact_main'])){
 
  	$name = check_input($_POST['name']);
 	$email = check_input($_POST['email']);
	$phone = check_input($_POST['tel']);
	$why = check_input($_POST['why']);
	$message = check_input($_POST['comment']);
  	$message = str_replace("\\r\\n", "\n", $message); 
 	
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
	elseif(empty($why)):
		$ERROR = 1;	
		$ERRORMSG = 'Please select: Why do you need to do a tax return?';	 
	elseif(empty($message)):
		$ERROR = 1;	
		$ERRORMSG = 'Message is mandatory field.';
	else:
		 $ERROR = 0;
		 $ERRORMSG = ''; 
 	endif;
#=================================================================  	
if(!$ERROR){ 

$to = 'aj@jgbaccountants.com' ;
$bcc = '' ;
// Send email to user 
$subject = 'New message from: '. $name;

$body = "Dear Webmaster,".PHP_EOL."
You've received a message from a visitor.

Here is the message:
--------------------------------------------------------
$message 

--------------------------------------------------------
Sender Details:
--------------------------------------------------------
Sender's Name: $name,
Sender's Email: $email,
Sender's Phone: $phone
How can we help you?: $why

This email was sent from 'Speak to a Tax Expert Today' form.

";
$fromEmail = 'noreply@'.$_SERVER['HTTP_HOST'];
$replyTo = $email;

sendEmail($to, $bcc, $subject, $body, $name, $fromEmail, $replyTo,0);

$MSG = '<div class="greenText"><b>Thanks for Enquiry!</b> We will contact you shortly.</div>';
$MSG .= '<script>				 
				document.getElementById("contact-form-main").reset();			 
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
