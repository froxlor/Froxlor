<?php
if (!defined('AREA')) {
	header("Location: index.php");
	exit();
}

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2022 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2016-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Panel
 *
 */

use Froxlor\UI\Request;
use Froxlor\UI\Panel\UI;

// This file is being included in admin_domains and customer_domains
// and therefore does not need to require lib/init.php

$errid = Request::get('errorid');

if (!empty($errid)) {
	// read error file
	$err_dir = \Froxlor\FileDir::makeCorrectDir(\Froxlor\Froxlor::getInstallDir() . "/logs/");
	$err_file = \Froxlor\FileDir::makeCorrectFile($err_dir . "/" . $errid . "_sql-error.log");

	if (file_exists($err_file)) {

		$error_content = file_get_contents($err_file);
		$error = explode("|", $error_content);

		$_error = array(
			'code' => str_replace("\n", "", substr($error[1], 5)),
			'message' => str_replace("\n", "", substr($error[2], 4)),
			'file' => str_replace("\n", "", substr($error[3], 5 + strlen(\Froxlor\Froxlor::getInstallDir()))),
			'line' => str_replace("\n", "", substr($error[4], 5)),
			'trace' => str_replace(\Froxlor\Froxlor::getInstallDir(), "", substr($error[5], 6))
		);

		// build mail-content
		$mail_body = "Dear froxlor-team,\n\n";
		$mail_body .= "the following error has been reported by a user:\n\n";
		$mail_body .= "-------------------------------------------------------------\n";
		$mail_body .= $_error['code'] . ' ' . $_error['message'] . "\n\n";
		$mail_body .= "File: " . $_error['file'] . ':' . $_error['line'] . "\n\n";
		$mail_body .= "Trace:\n" . trim($_error['trace']) . "\n\n";
		$mail_body .= "-------------------------------------------------------------\n\n";
		$mail_body .= "User-Area: " . AREA . "\n";
		$mail_body .= "Froxlor-version: " . $version . "\n";
		$mail_body .= "DB-version: " . $dbversion . "\n\n";
		$mail_body .= "End of report";
		$mail_html = nl2br($mail_body);

		// send actual report to dev-team
		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			// send mail and say thanks
			$_mailerror = false;
			try {
				$mail->Subject = '[Froxlor] Error report by user';
				$mail->AltBody = $mail_body;
				$mail->MsgHTML($mail_html);
				$mail->AddAddress('error-reports@froxlor.org', 'Froxlor Developer Team');
				$mail->Send();
			} catch (\PHPMailer\PHPMailer\Exception $e) {
				$mailerr_msg = $e->errorMessage();
				$_mailerror = true;
			} catch (Exception $e) {
				$mailerr_msg = $e->getMessage();
				$_mailerror = true;
			}

			if ($_mailerror) {
				// error when reporting an error...LOLFUQ
				\Froxlor\UI\Response::standard_error('send_report_error', $mailerr_msg);
			}

			// finally remove error from fs
			@unlink($err_file);
			\Froxlor\UI\Response::redirectTo($filename);
		}
		// show a nice summary of the error-report
		// before actually sending anything
		UI::view('user/error_report.html.twig', [
			'mail_html' => $mail_body
		]);
	} else {
		\Froxlor\UI\Response::redirectTo($filename);
	}
} else {
	\Froxlor\UI\Response::redirectTo($filename);
}
