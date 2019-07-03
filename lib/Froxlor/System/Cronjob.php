<?php
namespace Froxlor\System;

use Froxlor\Settings;
use Froxlor\Database\Database;

class Cronjob
{

	/**
	 * Function checkLastGuid
	 *
	 * Checks if the system's last guid is not higher than the one saved
	 * in froxlor's database. If it's higher, froxlor needs to
	 * set its last guid to this one to avoid conflicts with libnss-users
	 *
	 * @return null
	 */
	public static function checkLastGuid()
	{
		$mylog = \Froxlor\FroxlorLogger::getInstanceOf();

		$group_lines = array();
		$group_guids = array();
		$update_to_guid = 0;

		$froxlor_guid = 0;
		$result_stmt = Database::query("SELECT MAX(`guid`) as `fguid` FROM `" . TABLE_PANEL_CUSTOMERS . "`");
		$result = $result_stmt->fetch(\PDO::FETCH_ASSOC);
		$froxlor_guid = $result['fguid'];

		// possibly no customers yet or f*cked up lastguid settings
		if ($froxlor_guid < Settings::Get('system.lastguid')) {
			$froxlor_guid = Settings::Get('system.lastguid');
		}

		$g_file = '/etc/group';

		if (file_exists($g_file)) {
			if (is_readable($g_file)) {
				if (true == ($groups = file_get_contents($g_file))) {

					$group_lines = explode("\n", $groups);

					foreach ($group_lines as $group) {
						$group_guids[] = explode(":", $group);
					}

					foreach ($group_guids as $group) {
						/**
						 * nogroup | nobody have very high guids
						 * ignore them
						 */
						if ($group[0] == 'nogroup' || $group[0] == 'nobody') {
							continue;
						}

						$guid = isset($group[2]) ? (int) $group[2] : 0;

						if ($guid > $update_to_guid) {
							$update_to_guid = $guid;
						}
					}

					// if it's lower, then froxlor's highest guid is the last
					if ($update_to_guid < $froxlor_guid) {
						$update_to_guid = $froxlor_guid;
					} elseif ($update_to_guid == $froxlor_guid) {
						// if it's equal, that means we already have a collision
						// to ensure it won't happen again, increase the guid by one
						$update_to_guid = (int) $update_to_guid ++;
					}

					// now check if it differs from our settings
					if ($update_to_guid != Settings::Get('system.lastguid')) {
						$mylog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_NOTICE, 'Updating froxlor last guid to ' . $update_to_guid);
						Settings::Set('system.lastguid', $update_to_guid);
					}
				} else {
					$mylog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_NOTICE, 'File /etc/group not readable; cannot check for latest guid');
				}
			} else {
				$mylog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_NOTICE, 'File /etc/group not readable; cannot check for latest guid');
			}
		} else {
			$mylog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_NOTICE, 'File /etc/group does not exist; cannot check for latest guid');
		}
	}

	/**
	 * Inserts a task into the PANEL_TASKS-Table
	 *
	 * @param
	 *        	int Type of task
	 * @param
	 *        	string Parameter 1
	 * @param
	 *        	string Parameter 2
	 * @param
	 *        	string Parameter 3
	 * @author Florian Lippert <flo@syscp.org>
	 * @author Froxlor team <team@froxlor.org>
	 */
	public static function inserttask($type, $param1 = '', $param2 = '', $param3 = '', $param4 = '')
	{

		// prepare the insert-statement
		$ins_stmt = Database::prepare("
			INSERT INTO `" . TABLE_PANEL_TASKS . "` SET `type` = :type, `data` = :data
		");

		if ($type == '1' || $type == '3' || $type == '4' || $type == '5' || $type == '10' || $type == '99') {
			// 4 = bind -> if bind disabled -> no task
			if ($type == '4' && Settings::Get('system.bind_enable') == '0') {
				return;
			}
			// 10 = quota -> if quota disabled -> no task
			if ($type == '10' && Settings::Get('system.diskquota_enabled') == '0') {
				return;
			}

			// delete previously inserted tasks if they are the same as we only need ONE
			$del_stmt = Database::prepare("
				DELETE FROM `" . TABLE_PANEL_TASKS . "` WHERE `type` = :type
			");
			Database::pexecute($del_stmt, array(
				'type' => $type
			));

			// insert the new task
			Database::pexecute($ins_stmt, array(
				'type' => $type,
				'data' => ''
			));
		} elseif ($type == '2' && $param1 != '' && $param2 != '' && $param3 != '' && ($param4 == 0 || $param4 == 1)) {
			$data = array();
			$data['loginname'] = $param1;
			$data['uid'] = $param2;
			$data['gid'] = $param3;
			$data['store_defaultindex'] = $param4;
			$data = json_encode($data);
			Database::pexecute($ins_stmt, array(
				'type' => '2',
				'data' => $data
			));
		} elseif ($type == '6' && $param1 != '') {
			$data = array();
			$data['loginname'] = $param1;
			$data = json_encode($data);
			Database::pexecute($ins_stmt, array(
				'type' => '6',
				'data' => $data
			));
		} elseif ($type == '7' && $param1 != '' && $param2 != '') {
			$data = array();
			$data['loginname'] = $param1;
			$data['email'] = $param2;
			$data = json_encode($data);
			Database::pexecute($ins_stmt, array(
				'type' => '7',
				'data' => $data
			));
		} elseif ($type == '8' && $param1 != '' && $param2 != '') {
			$data = array();
			$data['loginname'] = $param1;
			$data['homedir'] = $param2;
			$data = json_encode($data);
			Database::pexecute($ins_stmt, array(
				'type' => '8',
				'data' => $data
			));
		} elseif ($type == '11' && $param1 != '' && Settings::Get('system.bind_enable') == '1' && Settings::Get('system.dns_server') == 'PowerDNS') {
			// -> if bind disabled or dns-server not PowerDNS -> no task
			$data = array();
			$data['domain'] = $param1;
			$data = json_encode($data);
			Database::pexecute($ins_stmt, array(
				'type' => '11',
				'data' => $data
			));
		} elseif ($type == '12' && $param1 != '') {
			$data = array();
			$data['domain'] = $param1;
			$data = json_encode($data);
			Database::pexecute($ins_stmt, array(
				'type' => '12',
				'data' => $data
			));
		} elseif ($type == '20' && is_array($param1)) {
			$data = json_encode($param1);
			Database::pexecute($ins_stmt, array(
				'type' => '20',
				'data' => $data
			));
		}
	}

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

			eval("\$cronjobs_last_run .= \"" . \Froxlor\UI\Template::getTemplate("index/overview_item") . "\";");
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
			} elseif ($row['type'] == '2') {
				// adding new user/
				$loginname = '';
				if (is_array($row['data'])) {
					$loginname = $row['data']['loginname'];
				}
				$task_desc = $lng['tasks']['adding_customer'];
				$task_desc = str_replace('%loginname%', $loginname, $task_desc);
			} elseif ($row['type'] == '4') {
				// rebuilding bind-configuration
				$task_desc = $lng['tasks']['rebuild_bindconfig'];
			} elseif ($row['type'] == '5') {
				// creating ftp-user directory
				$task_desc = $lng['tasks']['creating_ftpdir'];
			} elseif ($row['type'] == '6') {
				// deleting user-files
				$loginname = '';
				if (is_array($row['data'])) {
					$loginname = $row['data']['loginname'];
				}
				$task_desc = $lng['tasks']['deleting_customerfiles'];
				$task_desc = str_replace('%loginname%', $loginname, $task_desc);
			} elseif ($row['type'] == '7') {
				// deleting email-account
				$task_desc = $lng['tasks']['remove_emailacc_files'];
			} elseif ($row['type'] == '8') {
				// deleting ftp-account
				$task_desc = $lng['tasks']['remove_ftpacc_files'];
			} elseif ($row['type'] == '10') {
				// Set FS - quota
				$task_desc = $lng['tasks']['diskspace_set_quota'];
			} elseif ($row['type'] == '11') {
				// remove domain from pdns database if used
				$task_desc = sprintf($lng['tasks']['remove_pdns_domain'], $row['data']['domain']);
			} elseif ($row['type'] == '12') {
				// remove domains ssl files
				$task_desc = sprintf($lng['tasks']['remove_ssl_domain'], $row['data']['domain']);
			} elseif ($row['type'] == '20') {
				// deleting user-files
				$loginname = '';
				if (is_array($row['data'])) {
					$loginname = $row['data']['loginname'];
				}
				$task_desc = $lng['tasks']['backup_customerfiles'];
				$task_desc = str_replace('%loginname%', $loginname, $task_desc);
			} elseif ($row['type'] == '99') {
				// re-generating of cron.d-file
				$task_desc = $lng['tasks']['regenerating_crond'];
			} else {
				// unknown
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
		eval("\$outstanding_tasks = \"" . \Froxlor\UI\Template::getTemplate("index/overview_item") . "\";");

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

			$_mail = new Mailer(true);
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
