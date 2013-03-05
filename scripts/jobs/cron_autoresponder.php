<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author	   Remo Fritzsche
 * @author	   Manuel Aller
 * @author	   Michael Schlechtinger
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Cron
 *
 * @todo	   skip mail parsing after x bytes for large mails
 */

$mail = new PHPMailer(true);

//dont do anything when module is disabled
if((int)$settings['autoresponder']['autoresponder_active'] == 0)
{
	return;
}

//only send autoresponder to mails which were delivered since last run
if((int)$settings['autoresponder']['last_autoresponder_run'] == 0)
{
	//mails from last 5 minutes, otherwise all mails will be parsed -> mailbomb prevention
	$cycle = 300;
}
else
{
	// calculate seconds since last check
	$cycle = time() - (int)$settings['autoresponder']['last_autoresponder_run'];

	//prevent mailbombs when cycle is bigger than two days
	if($cycle > (2 * 60 * 60 * 24))$cycle = (60 * 60 * 24);
}

// set last_autoresponder_run
$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '" . (int)time() . "' WHERE `settinggroup` = 'autoresponder' AND `varname` = 'last_autoresponder_run'");

// get all customer set ip autoresponders
$result = $db->query("SELECT * FROM `" . TABLE_MAIL_AUTORESPONDER . "` INNER JOIN `" . TABLE_MAIL_USERS . "` ON `" . TABLE_MAIL_AUTORESPONDER . "`.`email` = `" . TABLE_MAIL_USERS . "`.`email` WHERE `enabled` = 1");

if($db->num_rows($result) > 0)
{
	while($row = $db->fetch_array($result))
	{
		/*
		 * check if specific autoresponder should be used
		 */
		$ts_now = time();
		$ts_start = (int)$row['date_from'];
		$ts_end = (int)$row['date_until'];
		
		// not yet
		if($ts_start != -1 && $ts_start > $ts_now) continue;
		// already ended
		if($ts_end != -1 && $ts_end < $ts_now) continue;

		// setup mail-path (e.g. /var/customers/mail/[loginname]/[user@domain.tld]/new
		$path = $row['homedir'] . $row['maildir'] . "new/";

		// if the directory does not exist, inform syslog
		if(!is_dir($path))
		{
			$cronlog->logAction(CRON_ACTION, LOG_WARNING, "Error accessing maildir: " . $path);
			continue;
		}

		// get all files 
		$its = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($path)
		);

		$responded_counter = 0;
		foreach ($its as $fullFilename => $it ) 
		{
			if($it->getFilename() == '.' || $it->getFilename() == '..')
			{
				continue;
			}

			/*
			 * is the time passed between now and
			 * the time we received the mail lower/equal
			 * than our cycle-seconds?
			 */
			$filemtime = $it->getMTime(); 
			if(time() - $filemtime <= $cycle)
			{
				// why not read up to k lines?
				// I've been patching this forever, to avoid FATAL ERROR / memory exhausted
				// (fgets() is now binary safe, too)
				// $content = file($fullFilename);
				$lcount = 0; $content = array(); $handle = @fopen($fullFilename, "r");
				if ($handle) {
				    // 1023 lines of an email should be enough to analyze it
				    while (($lcount++<1023) && (($buffer = fgets($handle)) !== false)) {
				        $content[]=$buffer;
				    }
				    fclose($handle);
				}

				// error reading mail contents or just empty
				if(count($content) == 0)
				{
					$cronlog->logAction(CRON_ACTION, LOG_WARNING, "Unable to read mail from maildir: " . dirname($fullFilename));
					continue;
				}

				$match = array();
				$from = '';
				$to = '';
				$sender = '';
				$spam = false;
				foreach($content as $line)
				{
					// header ends on first empty line, skip rest of mail
					if(strlen(rtrim($line)) == 0)
					{
						break;
					}

					//fetching from field
					if(!strlen($from)
					   && preg_match("/^From:(.+)<(.*)>$/", $line, $match)
					) {
						$from = $match[2];
					}
					elseif(!strlen($from)
					       && preg_match("/^From:\s+(.*@.*)$/", $line, $match)
					) {
						$from = $match[1];
					}

					//fetching to field
					if((!strlen($to) || $to != $row['email'])
						&& preg_match("/^To:(.+)<(.*)>$/", $line, $match)
					) {
						$to = $match[2];
					}
					elseif((!strlen($to) || $to != $row['email'])
						&& preg_match("/^To:\s+(.*@.*)$/", $line, $match)
					) {
						$to = $match[1];
					}
					/*
					 * if we still don't have a To:-address
					 * OR even worse, the $to is NOT the mail-address
					 * of the customer which autoresponder this is
					 * we have to check for CC too, #476
					 */
					elseif((!strlen($to) || $to != $row['email'])
						&& preg_match("/^Cc:(.+)<(.*)>$/", $line, $match)
					) {
						$to = $match[2];
					}
					elseif((!strlen($to) || $to != $row['email'])
						&& preg_match("/^Cc:\s+(.*@.*)$/", $line, $match)
					) {
						$to = $match[1];
					}

					//fetching sender field
					if(!strlen($sender)
					   && preg_match("/^Sender:(.+)<(.*)>$/", $line, $match)
					) {
						$sender = $match[2];
					}
					elseif(!strlen($sender)
					       && preg_match("/Sender:\s+(.*@.*)$/", $line, $match)
					) {
						$sender = $match[1];
					}

					//check for amavis/spamassassin spam headers
					if(preg_match("/^X-Spam-Status: (Yes|No)(.*)$/", $line, $match))
					{
						if($match[1] == 'Yes')$spam = true;
					}
					
					//check for precedence header
					if(preg_match("/^Precedence: (bulk|list|junk)(.*)$/", $line, $match))
					{
						// use the spam flag to skip reply
						$spam = true;
					}
				}

				// check if the receiver is really the one 
				// with the autoresponder
				if(!strlen($to) || $to != $row['email'])
				{
					$to = '';
				}

				//skip mail when marked as spam
				if($spam == true)
				{
					continue;
				}

				//error while parsing mail
				if($to == '' || $from == '')
				{
					$cronlog->logAction(CRON_ACTION, LOG_WARNING, "No valid headers found in mail to parse");
					continue;
				}

				//important! prevent mailbombs when mail comes from a maildaemon/mailrobot
				//robot/daemon mails must go to Sender: field in envelope header
				//refers to "Das Postfix-Buch" / RFC 2822
				if($sender != '')
				{
					$from = $sender;
				}

				//make message valid to email format
				$message = str_replace("\r\n", "\n", $row['message']);

				//check if mail is already an answer
				$fullcontent = implode("", $content);

				if(strstr($fullcontent, $message) || $from == $to)
				{
					continue;
				}

				$_mailerror = false;
				try {
					$mail->CharSet = "UTF-8";
					$mail->SetFrom($to, $to);
					$mail->AddReplyTo($to, $to);
					$mail->Subject = $row['subject'];
					$mail->AltBody = $message;
					$html_message = str_replace("\n", "<br />", $message);
					$mail->MsgHTML(html_entity_decode($html_message));
					$mail->AddAddress($from, $from);
					$mail->AddCustomHeader('Precedence: bulk');
					$mail->Send();
				} catch(phpmailerException $e) {
					$mailerr_msg = $e->errorMessage();
					$_mailerror = true;
				} catch (Exception $e) {
					$mailerr_msg = $e->getMessage();
					$_mailerror = true;
				}
		
				if ($_mailerror) {
					$cronlog->logAction(CRON_ACTION, LOG_WARNING, "Error sending autoresponder mail: " . $mailerr_msg);
				}

				$mail->ClearAddresses();
				$responded_counter++;
			}
		}
		$cronlog->logAction(CRON_ACTION, LOG_INFO, "Responded to '" . $responded_counter . "' mails from '".$path."'");
	}
}
