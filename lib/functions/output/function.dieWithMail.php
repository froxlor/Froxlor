<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Cron
 *
 * @since      0.9.33
 *
 */

/**
 * Cronjob function to end a cronjob in a critical condition
 * but not without sending a notification mail to the admin
 *
 * @param string $message
 * @param string $subject
 *
 * @return void
 */
function dieWithMail($message, $subject = "[froxlor] Cronjob error") {

	if (Settings::Get('system.send_cron_errors') == '1') {

		$_mail = new PHPMailer(true);
		$_mail->CharSet = "UTF-8";

		if (Settings::Get('system.mail_use_smtp')) {
			$_mail->isSMTP();
			$_mail->Host = Settings::Get('system.mail_smtp_host');
			$_mail->SMTPAuth = Settings::Get('system.mail_smtp_auth') == '1' ? true : false;
			$_mail->Username = Settings::Get('system.mail_smtp_user');
			$_mail->Password = Settings::Get('system.mail_smtp_passwd');
			if (Settings::Get('system.mail_smtp_usetls')) {
				$_mail->SMTPSecure = 'tls';
			}
			$_mail->Port = Settings::Get('system.mail_smtp_port');
		}

		if (PHPMailer::ValidateAddress(Settings::Get('panel.adminmail')) !== false) {
			// set return-to address and custom sender-name, see #76
			$_mail->SetFrom(Settings::Get('panel.adminmail'), Settings::Get('panel.adminmail_defname'));
			if (Settings::Get('panel.adminmail_return') != '') {
				$_mail->AddReplyTo(Settings::Get('panel.adminmail_return'), Settings::Get('panel.adminmail_defname'));
			}
		}

		$_mailerror = false;
		try {
			$_mail->Subject = $subject;
			$_mail->AltBody = $message;
			$_mail->MsgHTML(nl2br($message));
			$_mail->AddAddress(Settings::Get('panel.adminmail'), Settings::Get('panel.adminmail_defname'));
			$_mail->Send();
		} catch (phpmailerException $e) {
			$mailerr_msg = $e->errorMessage();
			$_mailerror = true;
		} catch (Exception $e) {
			$mailerr_msg = $e->getMessage();
			$_mailerror = true;
		}

		$_mail->ClearAddresses();

		if ($_mailerror) {
			echo 'Error sending mail: ' . $mailerr_msg . "\n";
		}
	}

	die($message);

}
