<?php

/**
 * @author Dick Munroe <munroe@csworks.com>
 * @copyright copyright @ 2006 by Dick Munroe, Cottage Software Works, Inc.
 * @license http://www.csworks.com/publications/ModifiedNetBSD.html
 * @version 1.0.0
 * @package Easy_Email_SMTP
 * @example ./example.smtp.php
 *
 * Edit History:
 *
 *  Dick Munroe (munroe@csworks.com) 11-Apr-2006
 *      Initial Version Created.
 */

include_once('class.Easy_Email_SMTP.php') ;
include_once('SDD/class.SDD.php') ;

/*
 * I use an alternate port smtp service locally.  The default action
 * is to send messages to the localhost at port 25.
 */ 
$smtpInfo['host'] = 'smtp.gmail.com' ;
$smtpInfo['port'] = 25;
$smtpInfo['auth'] = true ;
$smtpInfo['user'] = 'caja@colegiosanfrancisco.com' ;
$smtpInfo['pass'] = 'UESFDA' ;


$html	= "<b><i>Test class.Easy_EMail_SMTP.php</i></b>" ;
$message= "Test class.Easy_EMail.php" ;

$mail	= &new Easy_Email_SMTP() ;

$mail->to       = "piero@dicampo.com" ;						// Destination email addresss
$mail->from     = "caja@colegiosanfrancisco.com" ;                        // Source email addresss
$mail->return   = "caja@colegiosanfrancisco.com" ; 				// Return path email address
$mail->subject  = "Test class.Easy_Email_SMTP.php" ;			// Subject of this email

/*
 * I have made local modifications to Easy_Email that return
 * status on the transmission of the email messages.  If you
 * have not made a similar modification, then the following
 * if statements will fail and you will get error messages
 * instead of notification that the message has been sent.
 */

if ($mail->htmlMail($html))		                                // Use this to send html email 
{
    echo "HTML message sent\n" ;
}
else
{
    echo " error 1 sent\n" ;
    echo SDD::dump($mail->m_smtp) ;
}

if ($mail->simpleMail($message))	                                // Use this to send simple email
{
    echo " error 2 sent\n" ;
    echo "simple message sent\n" ;
}
else
{
	    echo " error 3 sent\n" ;

    echo SDD::dump($mail->m_smtp) ;
}
echo mail("piero@dicampo.com",'test mail',$html);
?>
