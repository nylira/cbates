<?php

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$recipient = $_POST['recipient'];

// Simple validation
function check_email($email) {
         
	if(strpos($email, "@")) {
         return true;
	} 
		else 
		{
         return false;
	  	}
	}

if(strlen($name) >= 3 && strlen($email) >= 3 && strlen($message) >= 4 && check_email($email)) {

$email_message = <<< EMAIL

Message from website.


Name: $name

Email: $email

Message: $message

EMAIL;

mail($recipient,'Contact Form', $email_message, "From: Website");

	return true;

} else {
	
	return false;
}

?>