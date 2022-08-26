<?php
namespace Froxlor\System;

use Froxlor\Settings;
use Froxlor\Database\Database;

use Froxlor\Cron\TaskId;

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
	 *        	string Parameter (possible to pass multiple times)
	 *
	 * @author Florian Lippert <flo@syscp.org>
	 * @author Froxlor team <team@froxlor.org>
	 */
	public static function inserttask($type, ...$params)
	{
		// prepare the insert-statement
		$ins_stmt = Database::prepare("
			INSERT INTO `" . TABLE_PANEL_TASKS . "` SET `type` = :type, `data` = :data
		");

		if ($type == TaskId::REBUILD_VHOST || $type == TaskId::REBUILD_DNS || $type == TaskId::CREATE_FTP || $type == TaskId::CREATE_QUOTA || $type == TaskId::REBUILD_CRON) {
			// 4 = bind -> if bind disabled -> no task
			if ($type == TaskId::REBUILD_DNS && Settings::Get('system.bind_enable') == '0') {
				return;
			}
			// 10 = quota -> if quota disabled -> no task
			if ($type == TaskId::CREATE_QUOTA && Settings::Get('system.diskquota_enabled') == '0') {
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
		} elseif ($type == TaskId::CREATE_HOME && count($params) == 4 && $params[0] != '' && $params[1] != '' && $params[2] != '' && ($params[3] == 0 || $params[3] == 1)) {
			$data = array();
			$data['loginname'] = $params[0];
			$data['uid'] = $params[1];
			$data['gid'] = $params[2];
			$data['store_defaultindex'] = $params[3];
			$data = json_encode($data);
			Database::pexecute($ins_stmt, array(
				'type' => TaskId::CREATE_HOME,
				'data' => $data
			));
		} elseif ($type == TaskId::DELETE_CUSTOMER_FILES && isset($params[0]) && $params[0] != '') {
			$data = array();
			$data['loginname'] = $params[0];
			$data = json_encode($data);
			Database::pexecute($ins_stmt, array(
				'type' => TaskId::DELETE_CUSTOMER_FILES,
				'data' => $data
			));
		} elseif ($type == TaskId::DELETE_EMAIL_DATA && count($params) == 2 && $params[0] != '' && $params[1] != '') {
			$data = array();
			$data['loginname'] = $params[0];
			$data['email'] = $params[1];
			$data = json_encode($data);
			Database::pexecute($ins_stmt, array(
				'type' => TaskId::DELETE_EMAIL_DATA,
				'data' => $data
			));
		} elseif ($type == TaskId::DELETE_FTP_DATA && count($params) == 2 && $params[0] != '' && $params[1] != '') {
			$data = array();
			$data['loginname'] = $params[0];
			$data['homedir'] = $params[1];
			$data = json_encode($data);
			Database::pexecute($ins_stmt, array(
				'type' => TaskId::DELETE_FTP_DATA,
				'data' => $data
			));
		} elseif ($type == TaskId::DELETE_DOMAIN_PDNS && isset($params[0]) && $params[0] != '' && Settings::Get('system.bind_enable') == '1' && Settings::Get('system.dns_server') == 'PowerDNS') {
			// -> if bind disabled or dns-server not PowerDNS -> no task
			$data = array();
			$data['domain'] = $params[0];
			$data = json_encode($data);
			Database::pexecute($ins_stmt, array(
				'type' => TaskId::DELETE_DOMAIN_PDNS,
				'data' => $data
			));
		} elseif ($type == TaskId::DELETE_DOMAIN_SSL && isset($params[0]) && $params[0] != '') {
			$data = array();
			$data['domain'] = $params[0];
			$data = json_encode($data);
			Database::pexecute($ins_stmt, array(
				'type' => TaskId::DELETE_DOMAIN_SSL,
				'data' => $data
			));
		} elseif ($type == TaskId::CREATE_CUSTOMER_BACKUP && isset($params[0]) && is_array($params[0])) {
			$data = json_encode($params[0]);
			Database::pexecute($ins_stmt, array(
				'type' => TaskId::CREATE_CUSTOMER_BACKUP,
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

			$task_id = $row['type'];
			if (\Froxlor\Cron\TaskId::isValid($task_id)) {
				$task_constname = \Froxlor\Cron\TaskId::convertToConstant($task_id);
				$task_desc = isset($lng['tasks'][$task_constname]) ? $lng['tasks'][$task_constname] : $task_constname;
				
				if (is_array($row['data'])) {
					// task includes loginname
					if (isset($row['data']['loginname'])) {
						$loginname = $row['data']['loginname'];
						$task_desc = str_replace('%loginname%', $loginname, $task_desc);
					}
					// task includes domain data
					if (isset($row['data']['domain'])) {
						$domain = $row['data']['domain'];
						$task_desc = str_replace('%domain%', $domain, $task_desc);
					}
				}
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

	public static function updateLastRunOfCron($cronname)
	{
		$upd_stmt = Database::prepare("
			UPDATE `" . TABLE_PANEL_CRONRUNS . "` SET `lastrun` = UNIX_TIMESTAMP() WHERE `cronfile` = :cron;
		");
		Database::pexecute($upd_stmt, array(
			'cron' => $cronname
		));
	}
}
