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
class Ftps extends ApiCommand implements ResourceEntity
{

	/**
	 * add a new ftp-user
	 *
	 * @param string $ftp_password
	 *        	password for the created database and database-user
	 * @param string $path
	 *        	destination path relative to the customers-homedir
	 * @param string $ftp_description
	 *        	optional, description for ftp-user
	 * @param bool $sendinfomail
	 *        	optional, send created resource-information to customer, default: false
	 * @param string $shell
	 *        	optional, default /bin/false (not changeable when deactivated)
	 * @param string $ftp_username
	 *        	optional if customer.ftpatdomain is allowed, specify an username
	 * @param string $ftp_domain
	 *        	optional if customer.ftpatdomain is allowed, specify a domain (customer must be owner)
	 * @param int $customerid
	 *        	required when called as admin, not needed when called as customer
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array
	 */
	public function add()
	{
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'ftp')) {
			throw new Exception("You cannot access this resource", 405);
		}
		
		if ($this->getUserDetail('ftps_used') < $this->getUserDetail('ftps') || $this->getUserDetail('ftps') == '-1') {
			
			// required paramters
			$path = $this->getParam('path');
			$password = $this->getParam('ftp_password');
			
			// parameters
			$description = $this->getParam('ftp_description', true, '');
			$sendinfomail = $this->getBoolParam('sendinfomail', true, 0);
			$shell = $this->getParam('shell', true, '/bin/false');
			
			$ftpusername = $this->getParam('ftp_username', true, '');
			$ftpdomain = $this->getParam('ftp_domain', true, '');
			
			// validation
			$password = validate($password, 'password', '', '', array(), true);
			$password = validatePassword($password, true);
			$description = validate(trim($description), 'description', '', '', array(), true);
			
			if (Settings::Get('system.allow_customer_shell') == '1') {
				$shell = validate(trim($shell), 'shell', '', '', array(), true);
			} else {
				$shell = "/bin/false";
			}
			
			if (Settings::Get('customer.ftpatdomain') == '1') {
				$ftpusername = validate(trim($ftpusername), 'username', '/^[a-zA-Z0-9][a-zA-Z0-9\-_]+\$?$/', '', array(), true);
				if (substr($ftpdomain, 0, 4) != 'xn--') {
					$idna_convert = new idna_convert_wrapper();
					$ftpdomain = $idna_convert->encode(validate($ftpdomain, 'domain', '', '', array(), true));
				}
			}
			
			$params = array();
			// get needed customer info to reduce the ftp-user-counter by one
			$customer = $this->getCustomerData('ftps');
			
			if ($sendinfomail != 1) {
				$sendinfomail = 0;
			}
			
			if (Settings::Get('customer.ftpatdomain') == '1') {
				if ($ftpusername == '') {
					standard_error(array(
						'stringisempty',
						'username'
					), '', true);
				}
				$ftpdomain_check_stmt = Database::prepare("SELECT `id`, `domain`, `customerid` FROM `" . TABLE_PANEL_DOMAINS . "`
						WHERE `domain` = :domain
						AND `customerid` = :customerid");
				$ftpdomain_check = Database::pexecute_first($ftpdomain_check_stmt, array(
					"domain" => $ftpdomain,
					"customerid" => $customer['customerid']
				), true, true);
				
				if ($ftpdomain_check && $ftpdomain_check['domain'] != $ftpdomain) {
					standard_error('maindomainnonexist', $ftpdomain, true);
				}
				$username = $ftpusername . "@" . $ftpdomain;
			} else {
				$username = $customer['loginname'] . Settings::Get('customer.ftpprefix') . (intval($customer['ftp_lastaccountnumber']) + 1);
			}
			
			$username_check_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_FTP_USERS . "`	WHERE `username` = :username
			");
			$username_check = Database::pexecute_first($username_check_stmt, array(
				"username" => $username
			), true, true);
			
			if (! empty($username_check) && $username_check['username'] = $username) {
				standard_error('usernamealreadyexists', $username, true);
			} elseif ($username == $password) {
				standard_error('passwordshouldnotbeusername', '', true);
			} else {
				$path = makeCorrectDir($customer['documentroot'] . '/' . $path);
				$cryptPassword = makeCryptPassword($password);
				
				$stmt = Database::prepare("INSERT INTO `" . TABLE_FTP_USERS . "`
						(`customerid`, `username`, `description`, `password`, `homedir`, `login_enabled`, `uid`, `gid`, `shell`)
						VALUES (:customerid, :username, :description, :password, :homedir, 'y', :guid, :guid, :shell)");
				$params = array(
					"customerid" => $customer['customerid'],
					"username" => $username,
					"description" => $description,
					"password" => $cryptPassword,
					"homedir" => $path,
					"guid" => $customer['guid'],
					"shell" => $shell
				);
				Database::pexecute($stmt, $params, true, true);
				
				$result_stmt = Database::prepare("
					SELECT `bytes_in_used` FROM `" . TABLE_FTP_QUOTATALLIES . "` WHERE `name` = :name
				");
				Database::pexecute($result_stmt, array(
					"name" => $customer['loginname']
				), true, true);
				
				while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
					$stmt = Database::prepare("INSERT INTO `" . TABLE_FTP_QUOTATALLIES . "`
						(`name`, `quota_type`, `bytes_in_used`, `bytes_out_used`, `bytes_xfer_used`, `files_in_used`, `files_out_used`, `files_xfer_used`)
						VALUES (:name, 'user', :bytes_in_used, '0', '0', '0', '0', '0')
					");
					Database::pexecute($stmt, array(
						"name" => $username,
						"bytes_in_used" => $row['bytes_in_used']
					), true, true);
				}
				
				$stmt = Database::prepare("
					UPDATE `" . TABLE_FTP_GROUPS . "`
					SET `members` = CONCAT_WS(',',`members`, :username)
					WHERE `customerid`= :customerid AND `gid`= :guid
				");
				$params = array(
					"username" => $username,
					"customerid" => $customer['customerid'],
					"guid" => $customer['guid']
				);
				Database::pexecute($stmt, $params, true, true);

				// update customer usage
				Customers::increaseUsage($customer['customerid'], 'ftps_used');
				Customers::increaseUsage($customer['customerid'], 'ftp_lastaccountnumber');
				
				// update admin usage
				Admins::increaseUsage($customer['adminid'], 'ftps_used');

				$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_INFO, "[API] added ftp-account '" . $username . " (" . $path . ")'");
				inserttask(5);
				
				if ($sendinfomail == 1) {
					$replace_arr = array(
						'SALUTATION' => getCorrectUserSalutation($customer),
						'CUST_NAME' => getCorrectUserSalutation($customer), // < keep this for compatibility
						'USR_NAME' => $username,
						'USR_PASS' => $password,
						'USR_PATH' => makeCorrectDir(str_replace($customer['documentroot'], "/", $path))
					);
					// get template for mail subject
					$mail_subject = $this->getMailTemplate($customer, 'mails', 'new_ftpaccount_by_customer_subject', $replace_arr, $this->lng['mails']['new_ftpaccount_by_customer']['subject']);
					// get template for mail body
					$mail_body = $this->getMailTemplate($customer, 'mails', 'new_ftpaccount_by_customer_mailbody', $replace_arr, $this->lng['mails']['new_ftpaccount_by_customer']['mailbody']);

					$_mailerror = false;
					$mailerr_msg = "";
					try {
						$this->mailer()->Subject = $mail_subject;
						$this->mailer()->AltBody = $mail_body;
						$this->mailer()->msgHTML(str_replace("\n", "<br />", $mail_body));
						$this->mailer()->addAddress($customer['email'], getCorrectUserSalutation($customer));
						$this->mailer()->send();
					} catch (phpmailerException $e) {
						$mailerr_msg = $e->errorMessage();
						$_mailerror = true;
					} catch (Exception $e) {
						$mailerr_msg = $e->getMessage();
						$_mailerror = true;
					}
					
					if ($_mailerror) {
						$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_ERR, "[API] Error sending mail: " . $mailerr_msg);
						standard_error('errorsendingmail', $customer['email'], true);
					}
					
					$this->mailer()->clearAddresses();
				}
				$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_WARNING, "[API] added ftp-user '" . $username . "'");

				$result = $this->apiCall('Ftps.get', array(
					'username' => $username
				));
				return $this->response(200, "successfull", $result);
			}
		}
		throw new Exception("No more resources available", 406);
	}

	/**
	 * return a ftp-user entry by either id or username
	 *
	 * @param int $id
	 *        	optional, the customer-id
	 * @param string $username
	 *        	optional, the username
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array
	 */
	public function get()
	{
		$id = $this->getParam('id', true, 0);
		$un_optional = ($id <= 0 ? false : true);
		$username = $this->getParam('username', $un_optional, '');
		
		$params = array();
		if ($this->isAdmin()) {
			if ($this->getUserDetail('customers_see_all') == false) {
				// if it's a reseller or an admin who cannot see all customers, we need to check
				// whether the database belongs to one of his customers
				$_custom_list_result = $this->apiCall('Customers.listing');
				$custom_list_result = $_custom_list_result['list'];
				$customer_ids = array();
				foreach ($custom_list_result as $customer) {
					$customer_ids[] = $customer['customerid'];
				}
				$result_stmt = Database::prepare("
					SELECT * FROM `" . TABLE_FTP_USERS . "`
					WHERE `customerid` IN (".implode(", ", $customer_ids).")
					AND (`id` = :idun OR `username` = :idun)
				");
			} else {
				$result_stmt = Database::prepare("
					SELECT * FROM `" . TABLE_FTP_USERS . "`
					WHERE (`id` = :idun OR `username` = :idun)
				");
			}
		} else {
			if (Settings::IsInList('panel.customer_hide_options', 'ftp')) {
				throw new Exception("You cannot access this resource", 405);
			}
			$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_FTP_USERS . "`
				WHERE `customerid` = :customerid
				AND (`id` = :idun OR `username` = :idun)
			");
			$params['customerid'] = $this->getUserDetail('customerid');
		}
		$params['idun'] = ($id <= 0 ? $username : $id);
		$result = Database::pexecute_first($result_stmt, $params, true, true);
		if ($result) {
			$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_NOTICE, "[API] get ftp-user '" . $result['username'] . "'");
			return $this->response(200, "successfull", $result);
		}
		$key = ($id > 0 ? "id #" . $id : "username '" . $username . "'");
		throw new Exception("FTP user with " . $key . " could not be found", 404);
	}

	/**
	 * update a given ftp-user by id or username
	 *
	 * @param int $id
	 *        	optional, the customer-id
	 * @param string $username
	 *        	optional, the username
	 * @param string $ftp_password
	 *        	password for the created database and database-user
	 * @param string $path
	 *        	destination path relative to the customers-homedir
	 * @param string $ftp_description
	 *        	optional, description for ftp-user
	 * @param string $shell
	 *        	optional, default /bin/false (not changeable when deactivated)
	 * @param int $customerid
	 *        	required when called as admin, not needed when called as customer
	 *
	 * @access admin, customer
	 * @throws Exception
	 * @return array
	 */
	public function update()
	{
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'ftp')) {
			throw new Exception("You cannot access this resource", 405);
		}
		
		$id = $this->getParam('id', true, 0);
		$un_optional = ($id <= 0 ? false : true);
		$username = $this->getParam('username', $un_optional, '');

		$result = $this->apiCall('Ftps.get', array(
			'id' => $id,
			'username' => $username
		));
		$id = $result['id'];
		
		// parameters
		$path = $this->getParam('path', true, '');
		$password = $this->getParam('ftp_password', true, '');
		$description = $this->getParam('ftp_description', true, $result['description']);
		$shell = $this->getParam('shell', true, $result['shell']);
		
		// validation
		$password = validate($password, 'password', '', '', array(), true);
		$description = validate(trim($description), 'description', '', '', array(), true);
		
		if (Settings::Get('system.allow_customer_shell') == '1') {
			$shell = validate(trim($shell), 'shell', '', '', array(), true);
		} else {
			$shell = "/bin/false";
		}

		// get needed customer info to reduce the ftp-user-counter by one
		$customer = $this->getCustomerData();
		
		// password update?
		if ($password != '') {
			// validate password
			$password = validatePassword($password, true);
			
			if ($password == $result['username']) {
				standard_error('passwordshouldnotbeusername', '', true);
			}
			$cryptPassword = makeCryptPassword($password);
			
			$stmt = Database::prepare("UPDATE `" . TABLE_FTP_USERS . "`
				SET `password` = :password
				WHERE `customerid` = :customerid
				AND `id` = :id
			");
			Database::pexecute($stmt, array(
				"customerid" => $customer['customerid'],
				"id" => $id,
				"password" => $cryptPassword
			), true, true);
			$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_INFO, "[API] updated ftp-account password for '" . $result['username'] . "'");
		}
		
		// path update?
		if ($path != '') {
			$path = makeCorrectDir($customer['documentroot'] . '/' . $path);
			
			if ($path != $result['homedir']) {
				$stmt = Database::prepare("UPDATE `" . TABLE_FTP_USERS . "`
					SET `homedir` = :homedir
					WHERE `customerid` = :customerid
					AND `id` = :id
				");
				Database::pexecute($stmt, array(
					"homedir" => $path,
					"customerid" => $customer['customerid'],
					"id" => $id
				), true, true);
				$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_INFO, "[API] updated ftp-account homdir for '" . $result['username'] . "'");
			}
		}
		// it's the task for "new ftp" but that will
		// create all directories and correct their permissions
		inserttask(5);
		
		$stmt = Database::prepare("
			UPDATE `" . TABLE_FTP_USERS . "`
			SET `description` = :desc, `shell` = :shell
			WHERE `customerid` = :customerid
			AND `id` = :id
		");
		Database::pexecute($stmt, array(
			"desc" => $description,
			"shell" => $shell,
			"customerid" => $customer['customerid'],
			"id" => $id
		), true, true);

		$result = $this->apiCall('Ftps.get', array(
			'username' => $result['username']
		));
		$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_NOTICE, "[API] updated ftp-user '" . $result['username'] . "'");
		return $this->response(200, "successfull", $result);
	}

	/**
	 * list all ftp-users, if called from an admin, list all ftp-users of all customers you are allowed to view, or specify id or loginname for one specific customer
	 *
	 * @param int $customerid
	 *        	optional, admin-only, select ftp-users of a specific customer by id
	 * @param string $loginname
	 *        	optional, admin-only, select ftp-users of a specific customer by loginname
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array count|list
	 */
	public function listing()
	{
		$customer_ids = $this->getAllowedCustomerIds('ftp');
		$result = array();
		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_FTP_USERS . "`
			WHERE `customerid` IN (".implode(", ", $customer_ids).")
		");
		Database::pexecute($result_stmt, null, true, true);
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			$result[] = $row;
		}
		$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_NOTICE, "[API] list ftp-users");
		return $this->response(200, "successfull", array(
			'count' => count($result),
			'list' => $result
		));
	}

	/**
	 * delete a ftp-user by either id or username
	 *
	 * @param int $id
	 *        	optional, the ftp-user-id
	 * @param string $username
	 *        	optional, the username
	 * @param bool $delete_userfiles
	 *        	optional, default false
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array
	 */
	public function delete()
	{
		$id = $this->getParam('id', true, 0);
		$un_optional = ($id <= 0 ? false : true);
		$username = $this->getParam('username', $un_optional, '');
		$delete_userfiles = $this->getBoolParam('delete_userfiles', true, 0);
		
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'ftp')) {
			throw new Exception("You cannot access this resource", 405);
		}
		
		// get ftp-user
		$result = $this->apiCall('Ftps.get', array(
			'id' => $id,
			'username' => $username
		));
		$id = $result['id'];
		
		if ($this->isAdmin()) {
			// get customer-data
			$customer_data = $this->apiCall('Customers.get', array(
				'id' => $result['customerid']
			));
		} else {
			$customer_data = $this->getUserData();
		}
		
		// add usage of this ftp-user to main-ftp user of customer if different
		if ($result['username'] != $customer_data['loginname']) {
			$stmt = Database::prepare("UPDATE `" . TABLE_FTP_USERS . "`
				SET `up_count` = `up_count` + :up_count,
				`up_bytes` = `up_bytes` + :up_bytes,
				`down_count` = `down_count` + :down_count,
				`down_bytes` = `down_bytes` + :down_bytes
				WHERE `username` = :username
			");
			$params = array(
				"up_count" => $result['up_count'],
				"up_bytes" => $result['up_bytes'],
				"down_count" => $result['down_count'],
				"down_bytes" => $result['down_bytes'],
				"username" => $customer_data['loginname']
			);
			Database::pexecute($stmt, $params, true, true);
		}
		
		// remove all quotatallies
		$stmt = Database::prepare("DELETE FROM `" . TABLE_FTP_QUOTATALLIES . "` WHERE `name` = :name");
		Database::pexecute($stmt, array(
			"name" => $result['username']
		), true, true);
		
		// remove user itself
		$stmt = Database::prepare("
			DELETE FROM `" . TABLE_FTP_USERS . "` WHERE `customerid` = :customerid AND `id` = :id
		");
		Database::pexecute($stmt, array(
			"customerid" => $customer_data['customerid'],
			"id" => $id
		), true, true);
		
		// update ftp-groups
		$stmt = Database::prepare("
			UPDATE `" . TABLE_FTP_GROUPS . "` SET
			`members` = REPLACE(`members`, :username,'')
			WHERE `customerid` = :customerid
		");
		Database::pexecute($stmt, array(
			"username" => "," . $result['username'],
			"customerid" => $customer_data['customerid']
		), true, true);
		
		// refs #293
		if ($delete_userfiles == 1) {
			inserttask('8', $customer_data['loginname'], $result['homedir']);
		} else {
			if (Settings::Get('system.nssextrausers') == 1) {
				// this is used so that the libnss-extrausers cron is fired
				inserttask(5);
			}
		}
		
		// decrease ftp-user usage for customer
		$resetaccnumber = ($customer_data['ftps_used'] == '1') ? " , `ftp_lastaccountnumber`='0'" : '';
		Customers::decreaseUsage($customer_data['customerid'], 'ftps_used', $resetaccnumber);
		// update admin usage
		Admins::decreaseUsage(($this->isAdmin() ? $customer_data['adminid'] : $this->getUserDetail('adminid')), 'ftps_used');
		
		$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_WARNING, "[API] deleted ftp-user '" . $result['username'] . "'");
		return $this->response(200, "successfull", $result);
	}
}
