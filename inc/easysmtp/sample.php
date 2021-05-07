<?php
/**
 * vim: ts=4: sw=4: cin: fdm=marker:
 * CVS : $Id: sample.php,v 1.2 2006/04/12 02:53:57 mynusa Exp $
 */

include('Easy_Mail.class.php') ;
$file   = "handbook.pdf" ;  // File name or path Example : file/image.gif
$html   = "<b><i>Tes Mail.class.php</i></b>" ;
$message= "Tes aja" ;
$subject= "Recovery Easy_Email.class.php" ;
$to     = "dolly.aswin@gmail.com" ;
$from   = "Dolly Aswin Hrp <dolly.aswin@nusa.net.id>" ;
$return = "dolly.aswin@nusa.net.id" ;
$mail   = &new Easy_Email($from, $to, $subject, $return) ;
$mail->simpleMail($message) ;   // Use this to send simple email
$mail->htmlMail($html) ;        // Use this to send html email
$mail->simpleAttachment($file,$message) ;   // Use this to send simple email with attachment
$mail->htmlAttachment($file,$html) ;        // Use this to send html email with attachment
?>
