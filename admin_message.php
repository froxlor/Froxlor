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
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Panel
 *
 */

const AREA = 'admin';
require __DIR__ . '/lib/init.php';

use Froxlor\Database\Database;
use Froxlor\UI\Request;
use Froxlor\UI\Panel\UI;

$id = (int) Request::get('id');

$note_type = null;
$note_msg = null;

if ($page == 'message') {
	if ($action == '') {
		$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, 'viewed panel_message');

		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			if ($_POST['recipient'] == 0 && $userinfo['customers_see_all'] == '1') {
				$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, 'sending messages to admins');
				$result = Database::query('SELECT `name`, `email`  FROM `' . TABLE_PANEL_ADMINS . "`");
			} elseif ($_POST['recipient'] == 1) {
				if ($userinfo['customers_see_all'] == '1') {
					$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, 'sending messages to ALL customers');
					$result = Database::query('SELECT `firstname`, `name`, `company`, `email`  FROM `' . TABLE_PANEL_CUSTOMERS . "`");
				} else {
					$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, 'sending messages to customers');
					$result = Database::prepare('
						SELECT `firstname`, `name`, `company`, `email`  FROM `' . TABLE_PANEL_CUSTOMERS . "`
						WHERE `adminid` = :adminid");
					Database::pexecute($result, array(
						'adminid' => $userinfo['adminid']
					));
				}
			} else {
				\Froxlor\UI\Response::standard_error('norecipientsgiven');
			}

			$subject = $_POST['subject'];
			$message = wordwrap($_POST['message'], 70);

			if (!empty($message)) {
				$mailcounter = 0;
				$mail->Body = $message;
				$mail->Subject = $subject;

				while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

					$row['firstname'] = isset($row['firstname']) ? $row['firstname'] : '';
					$row['company'] = isset($row['company']) ? $row['company'] : '';
					$mail->AddAddress($row['email'], \Froxlor\User::getCorrectUserSalutation(array(
						'firstname' => $row['firstname'],
						'name' => $row['name'],
						'company' => $row['company']
					)));
					$mail->From = $userinfo['email'];
					$mail->FromName = (isset($userinfo['firstname']) ? $userinfo['firstname'] . ' ' : '') . $userinfo['name'];

					if (!$mail->Send()) {
						if ($mail->ErrorInfo != '') {
							$mailerr_msg = $mail->ErrorInfo;
						} else {
							$mailerr_msg = $row['email'];
						}

						$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_ERR, 'Error sending mail: ' . $mailerr_msg);
						\Froxlor\UI\Response::standard_error('errorsendingmail', $row['email']);
					}

					$mailcounter++;
					$mail->ClearAddresses();
				}

				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page,
					'action' => 'showsuccess',
					'sentitems' => $mailcounter
				));
			} else {
				\Froxlor\UI\Response::standard_error('nomessagetosend');
			}
		}
	} elseif ($action == 'showsuccess') {

		$sentitems = isset($_GET['sentitems']) ? (int) $_GET['sentitems'] : 0;

		if ($sentitems == 0) {
			$note_type = 'info';
			$note_msg = $lng['message']['norecipients'];
		} else {
			$note_type = 'success';
			$note_msg = str_replace('%s', $sentitems, $lng['message']['success']);
		}
	}

	$recipients = [];

	if ($userinfo['customers_see_all'] == '1') {
		$recipients[0] = $lng['panel']['reseller'];
	}
	$recipients[1] = $lng['panel']['customer'];

	$messages_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/messages/formfield.messages_add.php';

	UI::view('user/form-note.html.twig', [
		'formaction' => $linker->getLink(array('section' => 'message')),
		'formdata' => $messages_add_data['messages_add'],
		'actions_links' => [[
			'href' => $linker->getLink(['section' => 'settings', 'page' => 'overview', 'part' => 'system', 'em' => 'system_mail_use_smtp']),
			'label' => $lng['admin']['smtpsettings'],
			'icon' => 'fa-solid fa-gears',
			'class' => 'btn-outline-secondary'
		]],
		// alert-box
		'type' => $note_type,
		'alert_msg' => $note_msg
	]);
}
