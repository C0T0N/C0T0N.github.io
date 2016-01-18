<?php
if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	header('Location: error_form.html');
}

$visitor_email = $_POST['sender_email'];
$message = $_POST['message'];

//Validate first
if(empty($visitor_email)) 
{
    echo "I need your email to reply to you!";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Bad email value!";
    exit;
}

$email_from = 'heuze.maxime@gmail.com';//<== update the email address
$email_subject = "New message from your website";
$email_body = "You have received a new message from $visitor_email.\n".
    "Here is the message:\n $message".
    
$to = "heuze.maxime@gmail.com";//<== update the email address
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.
header('Location: thank-you.html');


// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
   
?> 