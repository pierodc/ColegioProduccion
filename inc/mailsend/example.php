<?php 
include "sendmail.class.php";
$Mail = new sendmail();

// Set congif
$Mail->SendMailVia = 'smtp';  // Send via smtp server or mail function
$Mail->smtp_host = 'smtp.gmail.com';
$Mail->smtp_port = 465;
$Mail->smtp_user = 'caja@colegiosanfrancisco.com';
$Mail->smtp_password = 'UESFDA';


// Example 1 (mail from me)
if($Mail->Send('caja@colegiosanfrancisco.com; "Giampiero 1 D C" <piero@dicampo.com>','Prueba','Esta es una prueba de mensaje'))
{
  echo 'message Mail send!';
}
else
{
  echo $Mail->error;
}

// Example 2 (mail from me)
$Mail->mail_to = 'caja@colegiosanfrancisco.com; Giampiero D C2 <piero@dicampo.com>,"Giampiero 3 D C" <pierodc@dicampo.com>';
$Mail->subject = 'My Prueba2';
$Mail->message = 'Esta es una prueba de mensaje2';

if($Mail->Send())
{
  echo 'message Mail send!';
}
else
{
  echo $Mail->error;
}


// Example 3 (mail from another user: example user2@site2.com)

$Mail->mail_to = 'Giampiero 4 <piero@dicampo.com>';
$Mail->subject = 'My Prueba3';
$Mail->message = 'Esta es una prueba de mensaje3';
$Mail->from_name = 'caja@colegiosanfrancisco.com';
$Mail->SendFromMail = 'caja@colegiosanfrancisco.com';

if($Mail->Send())
{
  echo 'message Mail send!';
}
else
{
  echo $Mail->error;
}

?>