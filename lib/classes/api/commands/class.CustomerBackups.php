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
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    API
 * @since      0.10.0
 *
 */
class CustomerBackups extends ApiCommand implements ResourceEntity
{

	private function validateAccess()
	{
		if (Settings::Get('system.backupenabled') != 1) {
			throw new Exception("You cannot access this resource", 405);
		}
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'extras')) {
			throw new Exception("You cannot access this resource", 405);
		}
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'extras.backup')) {
			throw new Exception("You cannot access this resource", 405);
		}
	}

	public function add()
	{
		$this->validateAccess();
		
		// required parameter
		$path = $this->getParam('path');
		
		// parameter
		$backup_dbs = $this->getParam('backup_dbs', true, 0);
		$backup_mail = $this->getParam('backup_mail', true, 0);
		$backup_web = $this->getParam('backup_web', true, 0);
		
		// get customer data
		$customer = $this->getCustomerData();
		
		// validation
		$path = makeCorrectDir(validate($path, 'path', '', '', array(), true));
		$userpath = $path;
		$path = makeCorrectDir($customer['documentroot'] . '/' . $path);
		
		if ($backup_dbs != '1') {
			$backup_dbs = '0';
		}
		
		if ($backup_mail != '1') {
			$backup_mail = '0';
		}
		
		if ($backup_web != '1') {
			$backup_web = '0';
		}
		
		$task_data = array(
			'customerid' => $customer['customerid'],
			'uid' => $customer['guid'],
			'gid' => $customer['guid'],
			'loginname' => $customer['loginname'],
			'destdir' => $path,
			'backup_dbs' => $backup_dbs,
			'backup_mail' => $backup_mail,
			'backup_web' => $backup_web
		);
		// schedule backup job
		inserttask('20', $task_data);
		
		$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_NOTICE, "[API] added customer-backup job for '" . $customer['loginname'] . "'. Target directory: " . $userpath);
		return $this->response(200, "successfull", $task_data);
	}

	public function get()
	{
		throw new Exception('You cannot get a planned backup. Try CustomerBackups.listing()', 303);
	}

	public function update()
	{
		throw new Exception('You cannot update a planned backup. You need to delete it and re-add it.', 303);
	}

	public function listing()
	{
		$this->validateAccess();
		
		$customer_ids = $this->getAllowedCustomerIds('extras.backup');
		
		// check whether there is a backup-job for this customer
		$sel_stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_TASKS . "` WHERE `type` = '20'");
		Database::pexecute($sel_stmt);
		$result = array();
		while ($entry = $sel_stmt->fetch(PDO::FETCH_ASSOC)) {
			$entry['data'] = json_decode($entry['data'], true);
			if (in_array($entry['data']['customerid'], $customer_ids)) {
				$result[] = $entry;
			}
		}
		$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_NOTICE, "[API] list customer-backups");
		return $this->response(200, "successfull", array(
			'count' => count($result),
			'list' => $result
		));
	}

	public function delete()
	{
		// get planned backups
		$result = $this->apiCall('CustomerBackups.listing', $this->getParamList());

		$entry = $this->getParam('backup_job_entry');
		$customer_ids = $this->getAllowedCustomerIds('extras.backup');

		if ($result['count'] > 0 && $entry > 0) {
			// prepare statement
			$del_stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_TASKS . "` WHERE `id` = :tid");
			// check for the correct job
			foreach ($result['list'] as $backupjob) {
				if ($backupjob['id'] == $entry && in_array($backupjob['data']['customerid'], $customer_ids)) {
					Database::pexecute($del_stmt, array(
						'tid' => $entry
					));
					$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_NOTICE, "[API] deleted planned customer-backup #" . $entry);
					return $this->response(200, "successfull", true);
				}
			}
		}
		throw new Exception('Backup job with id #' . $entry . ' could not be found', 404);
	}
}
