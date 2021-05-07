<?php
/***************************************
** Filename.......: test.php
** Project........: SMTP Class
** Last Modified..: 30 September 2001
***************************************/

	/***************************************
    ** Include the class. The header() makes
	** the output look lovely.
    ***************************************/
	include('class.smtp.inc');
	header('Content-Type: text/plain');

	/***************************************
    ** Setup some parameters which will be 
	** passed to the smtp::connect() call.
    ***************************************/
	$params['host'] = 'smtp.gmail.com';				// The smtp server host/ip
	$params['port'] = 465;						// The smtp server port
	$params['helo'] = 'hostname';			// What to use when sending the helo command. Typically, your domain/hostname
	$params['auth'] = TRUE;						// Whether to use basic authentication or not
	$params['user'] = 'caja@colegiosanfrancisco.com';				// Username for authentication
	$params['pass'] = 'UESFDA';				// Password for authentication

	/***************************************
    ** These parameters get passed to the 
	** smtp->send() call.
    ***************************************/

	$send_params['recipients']	= array('piero@dicampo.com');							// The recipients (can be multiple)
	$send_params['headers']		= array(
										'From: "Colegio San Francisco de As´ˆö" <caja@colegiosanfrancisco.com>',	// Headers
										'To: piero@dicampo.com',
										'Subject: Test email'
									   );
	$send_params['from']		= 'caja@colegiosanfrancisco.com';									// This is used as in the MAIL FROM: cmd
																						// It should end up as the Return-Path: header
	$send_params['body']		= '.Test email.';										// The body of the email


	/***************************************
    ** The code that creates the object and
	** sends the email.
    ***************************************/

	if(is_object($smtp = smtp::connect($params)) AND $smtp->send($send_params)){
		echo 'Email sent successfully!'."\r\n\r\n";

		// Any recipients that failed (relaying denied for example) will be logged in the errors variable.
		print_r($smtp->errors);

	}else{
		echo 'Error sending mail'."\r\n\r\n";
		
		// The reason for failure should be in the errors variable
		print_r($smtp->errors);
	}

?>