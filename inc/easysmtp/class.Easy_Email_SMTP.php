<?php

/**
 * @author Dick Munroe <munroe@csworks.com>
 * @copyright copyright @ 2006 by Dick Munroe, Cottage Software Works, Inc.
 * @license http://www.csworks.com/publications/ModifiedNetBSD.html
 * @version 1.0.2
 * @package Easy_Email_SMTP
 * @example ./example.smtp.php
 *
 * Edit History:
 *
 *  Dick Munroe (munroe@csworks.com) 11-Apr-2006
 *      Initial Version Created.
 *
 *  Dick Munroe (munroe@csworks.com) 02-May-2006
 *      The to header isn't being generated.
 *
 *  Dick Munroe (munroe@csworks.com) 03-May-2006
 *      Merge headers into whatever got provided in the SMTP parameters array.
 *
 *  Dick Munroe (munroe@csworks.com) 26-Sep-2006 (1.0.2)
 *  	PHP 5.0 compatibility.
 */

include_once('Easy_Mail.class.php') ;
include_once('SMTP/class.smtp.inc') ;

/**
 * Extend the Easy_Email class to use SMTP directly in the event that the
 * the local host doesn't have an smtp server running.  This ISN'T a
 * particularly high performance implementation in that, like the mail()
 * function, a new socket is opened to the SMTP server for each message.
 */

class Easy_Email_SMTP extends Easy_Email
{
    /*
     * @var object the SMTP object used to send the message.
     * @access private
     */

    var $m_smtp ;

    /*
     * @var array the parameters for creating the SMTP object.
     * @access private
     */

    var $m_smtpParams ;

    /**
     * @desc the class constructor.
     * @param array The parameters to be fed to the constructor/factory
     *              of the smtp object.
     * @return void
     * @access public
     */

    function Easy_Email_SMTP($theSMTPParams = array())
    {
        $this->m_smtpParams =& $theSMTPParams ;

        /*
         * Provide a default for the helo transaction.
         */

        if ($this->m_smtpParams['helo'] === NULL)
        {
            if (isset($_SERVER['HTTP_HOST']))
            {
				/*
				 * In case the host is hiding behind a private port,
				 * take apart the http host.
				 */

				$xxx = explode(':', $_SERVER['HTTP_HOST']) ;
						$this->m_smtpParams['helo'] = $xxx[0] ;
            }
        }

		/*
		 * For PHP 5.0 compatibility to keep from getting warnings about arrays
         * not being defined, define the stuff that downstream must be defined.
		 */

		if (! array_key_exists('recipients', $this->m_smtpParams))
		{
			$this->m_smtpParams['recipients'] = array() ;
		}

		if (! array_key_exists('headers', $this->m_smtpParams))
		{
			$this->m_smtpParams['headers'] = array() ;
		}
    }

    /*
     * @desc Override Easy_Email's send function to use SMTP.
     * @param string the body of the message.
     * @return boolean TRUE => message sent, FALSE otherwise.
     */

    function send($theMessage)
    {
        /*
         * Ideally this would all be caught by accessors, but Easy_Email doesn't
         * have them yet, so...
         */

        if ($this->to !== NULL)
        {
            $this->m_smtpParams['recipients'] =
                array_merge($this->m_smtpParams['recipients'],
                            preg_split('/\s*,\s*/', $this->to)) ;
        }

        /*
         * The return path header (which is where bounces are sent) is built
         * from the "mail from" SMTP transaction.  Therefore, if the return
         * field is set, use it, otherwise use the from address.
         */

        if ($this->return !== NULL)
        {
            $this->m_smtpParams['from'] = $this->return ;
        }
        else if ($this->from !== NULL)
        {
            $this->m_smtpParams['from'] = $this->from ;
        }

        /*
         * The following assumes that everything ends with a new line.
         * In case it doesn't though, make sure the header isn't lost.
         */

        $theHeaders = explode("\n", $this->header) ;
        $xxx = array_pop($theHeaders) ;
        if ($xxx != '')
        {
            array_push($theHeaders, $xxx) ;
        }

        if ($this->subject !== NULL)
        {
            $theHeaders[] = sprintf("Subject: %s", $this->subject) ;
        }

        if ($this->to !== NULL)
        {
            $theHeaders[] = sprintf("To: %s", $this->to) ;
        }

        /*
         * Merge parameters provided through Easy_Email into those that may
         * have been provided in the constructor this object.
         */

        $this->m_smtpParams['headers'] =&
            array_merge($this->m_smtpParams['headers'], $theHeaders) ;

        $this->m_smtpParams['body'] =& $theMessage ;

        if (is_object($this->m_smtp = smtp::connect($this->m_smtpParams)))
        {
			return $this->m_smtp->send() ;
        }
        else
        {
            return FALSE ;
        }
    }
}

?>
