<?php
namespace Froxlor\System;

use Froxlor\Settings;
use Froxlor\Database\Database;

class Cronjob
{

	public static function getCronjobsLastRun()
	{
		global $lng;

		$query = "SELECT `lastrun`, `desc_lng_key` FROM `" . TABLE_PANEL_CRONRUNS . "` WHERE `isactive` = '1' ORDER BY `cronfile` ASC";
		$result = Database::query($query);

		$cronjobs_last_run = '';
		while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {

			$lastrun = $lng['cronjobs']['notyetrun'];
			if ($row['lastrun'] > 0) {
				$lastrun = date('d.m.Y H:i:s', $row['lastrun']);
			}

			$text = $lng['crondesc'][$row['desc_lng_key']];
			$value = $lastrun;

			eval("\$cronjobs_last_run .= \"" . getTemplate("index/overview_item") . "\";");
		}

		return $cronjobs_last_run;
	}

	public static function toggleCronStatus($module = null, $isactive = 0)
	{
		if ($isactive != 1) {
			$isactive = 0;
		}

		$upd_stmt = Database::prepare("
		UPDATE `" . TABLE_PANEL_CRONRUNS . "` SET `isactive` = :active WHERE `module` = :module");
		Database::pexecute($upd_stmt, array(
			'active' => $isactive,
			'module' => $module
		));
	}

	public static function getOutstandingTasks()
	{
		global $lng;

		$query = "SELECT * FROM `" . TABLE_PANEL_TASKS . "` ORDER BY `type` ASC";
		$result = Database::query($query);

		$value = '<ul class="cronjobtask">';
		$tasks = '';
		while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {

			if ($row['data'] != '') {
				$row['data'] = json_decode($row['data'], true);
			}

			// rebuilding webserver-configuration
			if ($row['type'] == '1') {
				$task_desc = $lng['tasks']['rebuild_webserverconfig'];
			} // adding new user/
			elseif ($row['type'] == '2') {
				$loginname = '';
				if (is_array($row['data'])) {
					$loginname = $row['data']['loginname'];
				}
				$task_desc = $lng['tasks']['adding_customer'];
				$task_desc = str_replace('%loginname%', $loginname, $task_desc);
			} // rebuilding bind-configuration
			elseif ($row['type'] == '4') {
				$task_desc = $lng['tasks']['rebuild_bindconfig'];
			} // creating ftp-user directory
			elseif ($row['type'] == '5') {
				$task_desc = $lng['tasks']['creating_ftpdir'];
			} // deleting user-files
			elseif ($row['type'] == '6') {
				$loginname = '';
				if (is_array($row['data'])) {
					$loginname = $row['data']['loginname'];
				}
				$task_desc = $lng['tasks']['deleting_customerfiles'];
				$task_desc = str_replace('%loginname%', $loginname, $task_desc);
			} // deleting email-account
			elseif ($row['type'] == '7') {
				$task_desc = $lng['tasks']['remove_emailacc_files'];
			} // deleting ftp-account
			elseif ($row['type'] == '8') {
				$task_desc = $lng['tasks']['remove_ftpacc_files'];
			} // Set FS - quota
			elseif ($row['type'] == '10') {
				$task_desc = $lng['tasks']['diskspace_set_quota'];
			} // deleting user-files
			elseif ($row['type'] == '20') {
				$loginname = '';
				if (is_array($row['data'])) {
					$loginname = $row['data']['loginname'];
				}
				$task_desc = $lng['tasks']['backup_customerfiles'];
				$task_desc = str_replace('%loginname%', $loginname, $task_desc);
			} // re-generating of cron.d-file
			elseif ($row['type'] == '99') {
				$task_desc = $lng['tasks']['regenerating_crond'];
			} // unknown
			else {
				$task_desc = "ERROR: Unknown task type '" . $row['type'] . "'";
			}

			if ($task_desc != '') {
				$tasks .= '<li>' . $task_desc . '</li>';
			}
		}

		if (trim($tasks) == '') {
			$value .= '<li>' . $lng['tasks']['noneoutstanding'] . '</li>';
		} else {
			$value .= $tasks;
		}

		$value .= '</ul>';
		$text = $lng['tasks']['outstanding_tasks'];
		eval("\$outstanding_tasks = \"" . getTemplate("index/overview_item") . "\";");

		return $outstanding_tasks;
	}

	/**
	 * Cronjob function to end a cronjob in a critical condition
	 * but not without sending a notification mail to the admin
	 *
	 * @param string $message
	 * @param string $subject
	 *
	 * @return void
	 */
	public static function dieWithMail($message, $subject = "[froxlor] Cronjob error")
	{
		if (Settings::Get('system.send_cron_errors') == '1') {

			$_mail = new \PHPMailer\PHPMailer\PHPMailer(true);
			$_mail->CharSet = "UTF-8";

			if (Settings::Get('system.mail_use_smtp')) {
				$_mail->isSMTP();
				$_mail->Host = Settings::Get('system.mail_smtp_host');
				$_mail->SMTPAuth = Settings::Get('system.mail_smtp_auth') == '1' ? true : false;
				$_mail->Username = Settings::Get('system.mail_smtp_user');
				$_mail->Password = Settings::Get('system.mail_smtp_passwd');
				if (Settings::Get('system.mail_smtp_usetls')) {
					$_mail->SMTPSecure = 'tls';
				} else {
					$_mail->SMTPAutoTLS = false;
				}
				$_mail->Port = Settings::Get('system.mail_smtp_port');
			}

			if (\PHPMailer\PHPMailer\PHPMailer::ValidateAddress(Settings::Get('panel.adminmail')) !== false) {
				// set return-to address and custom sender-name, see #76
				$_mail->SetFrom(Settings::Get('panel.adminmail'), Settings::Get('panel.adminmail_defname'));
				if (Settings::Get('panel.adminmail_return') != '') {
					$_mail->AddReplyTo(Settings::Get('panel.adminmail_return'), Settings::Get('panel.adminmail_defname'));
				}
			}

			$_mailerror = false;
			$mailerr_msg = "";
			try {
				$_mail->Subject = $subject;
				$_mail->AltBody = $message;
				$_mail->MsgHTML(nl2br($message));
				$_mail->AddAddress(Settings::Get('panel.adminmail'), Settings::Get('panel.adminmail_defname'));
				$_mail->Send();
			} catch (\PHPMailer\PHPMailer\Exception $e) {
				$mailerr_msg = $e->errorMessage();
				$_mailerror = true;
			} catch (\Exception $e) {
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
}