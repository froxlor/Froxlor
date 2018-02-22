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
class Admins extends ApiCommand implements ResourceEntity
{

	/**
	 * lists all admin entries
	 *
	 * @return array count|list
	 */
	public function list()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings') == 1) {
			$this->logger()->logAction(ADM_ACTION, LOG_NOTICE, "[API] list admins");
			$result_stmt = Database::prepare("
				SELECT *
				FROM `" . TABLE_PANEL_ADMINS . "`
				ORDER BY `loginname` ASC
			");
			Database::pexecute($result_stmt, null, true, true);
			$result = array();
			while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
				$result[] = $row;
			}
			return $this->response(200, "successfull", array(
				'count' => count($result),
				'list' => $result
			));
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * return an admin entry by either id or loginname
	 *
	 * @param int $id
	 *        	optional, the admin-id
	 * @param string $loginname
	 *        	optional, the loginname
	 *        	
	 * @throws Exception
	 * @return array
	 */
	public function get()
	{
		$id = $this->getParam('id', true, 0);
		$ln_optional = ($id <= 0 ? false : true);
		$loginname = $this->getParam('loginname', $ln_optional, '');
		
		if ($id <= 0 && empty($loginname)) {
			throw new Exception("Either 'id' or 'loginname' parameter must be given", 406);
		}
		
		if ($this->isAdmin() && ($this->getUserDetail('change_serversettings') == 1 || ($this->getUserDetail('adminid') == $id || $this->getUserDetail('loginname') == $loginname))) {
			$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_ADMINS . "`
				WHERE " . ($id > 0 ? "`adminid` = :idln" : "`loginname` = :idln"));
			$params = array(
				'idln' => ($id <= 0 ? $loginname : $id)
			);
			$result = Database::pexecute_first($result_stmt, $params, true, true);
			if ($result) {
				$this->logger()->logAction(ADM_ACTION, LOG_NOTICE, "[API] get admin '" . $result['loginname'] . "'");
				return $this->response(200, "successfull", $result);
			}
			$key = ($id > 0 ? "id #" . $id : "loginname '" . $loginname . "'");
			throw new Exception("Admin with " . $key . " could not be found", 404);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	public function add()
	{
		if ($this->isAdmin()) {

			// required parameters
			$name = $this->getParam('name');
			$email = $this->getParam('email');

			// parameters
			$def_language = $this->getParam('def_language', true, '');
			$custom_notes = $this->getParam('custom_notes', true, '');
			$custom_notes_show = $this->getParam('custom_notes_show', true, 0);
			$password = $this->getParam('admin_password', true, '');
			$sendpassword = $this->getParam('sendpassword', true, 0);
			$loginname = $this->getParam('new_loginname', true, '');

			$diskspace = $this->getUlParam('diskspace', 'diskspace_ul', true, 0);
			$traffic = $this->getUlParam('traffic', 'traffic_ul', true, 0);
			$customers = $this->getUlParam('customers', 'customers_ul', true, 0);
			$domains = $this->getUlParam('domains', 'domains_ul', true, 0);
			$subdomains = $this->getUlParam('subdomains', 'subdomains_ul', true, 0);
			$emails = $this->getUlParam('emails', 'emails_ul', true, 0);
			$email_accounts = $this->getUlParam('email_accounts', 'email_accounts_ul', true, 0);
			$email_forwarders = $this->getUlParam('email_forwarders', 'email_forwarders_ul', true, 0);
			$email_quota = $this->getUlParam('email_quota', 'email_quota_ul', true, 0);
			$ftps = $this->getUlParam('ftps', 'ftps_ul', true, 0);
			$tickets = $this->getUlParam('tickets', 'tickets_ul', true, 0);
			$mysqls = $this->getUlParam('mysqls', 'mysqls_ul', true, 0);

			$customers_see_all = $this->getParam('customers_see_all', true, 0);
			$domains_see_all = $this->getParam('domains_see_all', true, 0);
			$tickets_see_all = $this->getParam('tickets_see_all', true, 0);
			$caneditphpsettings = $this->getParam('caneditphpsettings', true, 0);
			$change_serversettings = $this->getParam('change_serversettings', true, 0);
			$ipaddress = intval_ressource($this->getParam('ipaddress', true, -1));

			// validation
			$name = validate($name, 'name', '', '', array(), true);
			$idna_convert = new idna_convert_wrapper();
			$email = $idna_convert->encode(validate($email, 'email', '', '', array(), true));
			$def_language = validate($def_language, 'default language', '', '', array(), true);
			$custom_notes = validate(str_replace("\r\n", "\n", $custom_notes), 'custom_notes', '/^[^\0]*$/', '', array(), true);

			if (Settings::Get('system.mail_quota_enabled') != '1') {
				$email_quota = - 1;
			}

			if (Settings::Get('ticket.enabled') != '1') {
				$tickets = - 1;
			}

			$password = validate($password, 'password', '', '', array(), true);
			// only check if not empty,
			// cause empty == generate password automatically
			if ($password != '') {
				$password = validatePassword($password, true);
			}

			$diskspace = $diskspace * 1024;
			$traffic = $traffic * 1024 * 1024;

			// Check if the account already exists
			try {
				$dup_check_result = Customers::getLocal($this->getUserData(), array(
					'loginname' => $loginname
				))->get();
				$loginname_check = json_decode($dup_check_result, true)['data'];
			} catch (Exception $e) {
				$loginname_check = array(
					'loginname' => ''
				);
			}

			// Check if an admin with the loginname already exists
			try {
				$dup_check_result = Admins::getLocal($this->getUserData(), array(
					'loginname' => $loginname
				))->get();
				$loginname_check_admin = json_decode($dup_check_result, true)['data'];
			} catch (Exception $e) {
				$loginname_check_admin = array(
					'loginname' => ''
				);
			}

			if ($loginname == '') {
				standard_error(array(
					'stringisempty',
					'myloginname'
				), '', true);
			} elseif (strtolower($loginname_check['loginname']) == strtolower($loginname) || strtolower($loginname_check_admin['loginname']) == strtolower($loginname)) {
				standard_error('loginnameexists', $loginname, true);
			} // Accounts which match systemaccounts are not allowed, filtering them
			elseif (preg_match('/^' . preg_quote(Settings::Get('customer.accountprefix'), '/') . '([0-9]+)/', $loginname)) {
				standard_error('loginnameissystemaccount', Settings::Get('customer.accountprefix'), true);
			} elseif (! validateUsername($loginname)) {
				standard_error('loginnameiswrong', $loginname, true);
			} elseif ($name == '') {
				standard_error(array(
					'stringisempty',
					'myname'
				), '', true);
			} elseif ($email == '') {
				standard_error(array(
					'stringisempty',
					'emailadd'
				), '', true);
			} elseif (! validateEmail($email)) {
				standard_error('emailiswrong', $email, true);
			} else {

				if ($customers_see_all != '1') {
					$customers_see_all = '0';
				}

				if ($domains_see_all != '1') {
					$domains_see_all = '0';
				}

				if ($caneditphpsettings != '1') {
					$caneditphpsettings = '0';
				}

				if ($change_serversettings != '1') {
					$change_serversettings = '0';
				}

				if ($tickets_see_all != '1') {
					$tickets_see_all = '0';
				}

				if ($password == '') {
					$password = generatePassword();
				}

				$_theme = Settings::Get('panel.default_theme');

				$ins_data = array(
					'loginname' => $loginname,
					'password' => makeCryptPassword($password),
					'name' => $name,
					'email' => $email,
					'lang' => $def_language,
					'change_serversettings' => $change_serversettings,
					'customers' => $customers,
					'customers_see_all' => $customers_see_all,
					'domains' => $domains,
					'domains_see_all' => $domains_see_all,
					'caneditphpsettings' => $caneditphpsettings,
					'diskspace' => $diskspace,
					'traffic' => $traffic,
					'subdomains' => $subdomains,
					'emails' => $emails,
					'accounts' => $email_accounts,
					'forwarders' => $email_forwarders,
					'quota' => $email_quota,
					'ftps' => $ftps,
					'tickets' => $tickets,
					'tickets_see_all' => $tickets_see_all,
					'mysqls' => $mysqls,
					'ip' => $ipaddress,
					'theme' => $_theme,
					'custom_notes' => $custom_notes,
					'custom_notes_show' => $custom_notes_show
				);

				$ins_stmt = Database::prepare("
					INSERT INTO `" . TABLE_PANEL_ADMINS . "` SET
					`loginname` = :loginname,
					`password` = :password,
					`name` = :name,
					`email` = :email,
					`def_language` = :lang,
					`change_serversettings` = :change_serversettings,
					`customers` = :customers,
					`customers_see_all` = :customers_see_all,
					`domains` = :domains,
					`domains_see_all` = :domains_see_all,
					`caneditphpsettings` = :caneditphpsettings,
					`diskspace` = :diskspace,
					`traffic` = :traffic,
					`subdomains` = :subdomains,
					`emails` = :emails,
					`email_accounts` = :accounts,
					`email_forwarders` = :forwarders,
					`email_quota` = :quota,
					`ftps` = :ftps,
					`tickets` = :tickets,
					`tickets_see_all` = :tickets_see_all,
					`mysqls` = :mysqls,
					`ip` = :ip,
					`theme` = :theme,
					`custom_notes` = :custom_notes,
					`custom_notes_show` = :custom_notes_show
				");
				Database::pexecute($ins_stmt, $ins_data, true, true);

				$adminid = Database::lastInsertId();
				$ins_data['adminid'] = $adminid;
				$this->logger()->logAction(ADM_ACTION, LOG_WARNING, "[API] added admin '" . $loginname . "'");
				return $this->response(200, "successfull", $admin_ins_data);
			}
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	public function update()
	{}

	/**
	 * delete a admin entry by either id or loginname
	 *
	 * @param int $id
	 *        	optional, the admin-id
	 * @param string $loginname
	 *        	optional, the loginname
	 * @param bool $delete_userfiles
	 *        	optional, default false
	 *        	
	 * @throws Exception
	 * @return array
	 */
	public function delete()
	{}

	/**
	 * unlock a locked admin by either id or loginname
	 *
	 * @param int $id
	 *        	optional, the admin-id
	 * @param string $loginname
	 *        	optional, the loginname
	 *        	
	 * @throws Exception
	 * @return array
	 */
	public function unlock()
	{
		if ($this->isAdmin()) {
			$id = $this->getParam('id', true, 0);
			$ln_optional = ($id <= 0 ? false : true);
			$loginname = $this->getParam('loginname', $ln_optional, '');
			
			if ($id <= 0 && empty($loginname)) {
				throw new Exception("Either 'id' or 'loginname' parameter must be given", 406);
			}
			
			$json_result = Admins::getLocal($this->getUserData(), array(
				'id' => $id,
				'loginname' => $loginname
			))->get();
			$result = json_decode($json_result, true)['data'];
			$id = $result['adminid'];
			
			$result_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_ADMINS . "` SET
				`loginfail_count` = '0'
				WHERE `adminid`= :id
			");
			Database::pexecute($result_stmt, array(
				'id' => $id
			), true, true);
			
			$this->logger()->logAction(ADM_ACTION, LOG_WARNING, "[API] unlocked admin '" . $result['loginname'] . "'");
			return $this->response(200, "successfull", $result);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}
}
