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
 * @package    Panel
 *
 */
class Customers extends ApiCommand implements ResourceEntity
{

	/**
	 * lists all customer entries
	 *
	 * @return array count|list
	 */
	public function list()
	{
		if ($this->isAdmin()) {
			$this->logger()->logAction(ADM_ACTION, LOG_NOTICE, "[API] list customers");
			$result_stmt = Database::prepare("
			SELECT `c`.*, `a`.`loginname` AS `adminname`
			FROM `" . TABLE_PANEL_CUSTOMERS . "` `c`, `" . TABLE_PANEL_ADMINS . "` `a`
			WHERE " . ($this->getUserDetail('customers_see_all') ? '' : " `c`.`adminid` = :adminid AND ") . "
			`c`.`adminid` = `a`.`adminid`
			");
			$params = array();
			if ($this->getUserDetail('customers_see_all') == '0') {
				$params = array(
					'adminid' => $this->getUserDetail('adminid')
				);
			}
			Database::pexecute($result_stmt, $params, true, true);
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
	 * return a customer entry by id
	 *
	 * @param int $id
	 *        	customer-id
	 *        	
	 * @throws Exception
	 * @return array
	 */
	public function get()
	{
		if ($this->isAdmin()) {
			$id = $this->getParam('id');
			$this->logger()->logAction(ADM_ACTION, LOG_NOTICE, "[API] get customer #" . $id);
			$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "`
			WHERE `customerid` = :id" . ($this->getUserDetail('customers_see_all') ? '' : " AND `adminid` = :adminid"));
			$params = array(
				'id' => $id
			);
			if ($this->getUserDetail('customers_see_all') == '0') {
				$params['adminid'] = $this->getUserDetail('adminid');
			}
			$result = Database::pexecute_first($result_stmt, $params, true, true);
			if ($result) {
				return $this->response(200, "successfull", $result);
			}
			throw new Exception("Customer with id #" . $id . " could not be found", 404);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	public function add()
	{
		global $lng;
		
		if ($this->isAdmin()) {
			if ($this->getUserDetail('customers_used') < $this->getUserDetail('customers') || $this->getUserDetail('customers') == '-1') {
				
				// required parameters
				$email = $this->getParam('email');

				// parameters
				$name = $this->getParam('name', true, '');
				$firstname = $this->getParam('firstname', true, '');
				$company_required = (empty($name) && empty($firstname));
				$company = $this->getParam('company', $company_required, '');
				$street = $this->getParam('street', true, '');
				$zipcode = $this->getParam('zipcode', true, '');
				$city = $this->getParam('city', true, '');
				$phone = $this->getParam('phone', true, '');
				$fax = $this->getParam('fax', true, '');
				$customernumber = $this->getParam('customernumber', true, '');
				$def_language = $this->getParam('def_language', true, '');
				$gender = intval_ressource($this->getParam('gender', true, 0));
				$custom_notes = $this->getParam('custom_notes', true, '');
				$custom_notes_show = $this->getParam('custom_notes_show', true, 0);
				
				$diskspace = $this->getUlParam('diskspace', 'diskspace_ul', true, 0);
				$traffic = $this->getUlParam('traffic', 'traffic_ul', true, 0);
				$subdomains = $this->getUlParam('subdomains', 'subdomains_ul', true, 0);
				$emails = $this->getUlParam('emails', 'emails_ul', true, 0);
				$email_accounts = $this->getUlParam('email_accounts', 'email_accounts_ul', true, 0);
				$email_forwarders = $this->getUlParam('email_forwarders', 'email_forwarders_ul', true, 0);
				$email_quota = $this->getUlParam('email_quota', 'email_quota_ul', true, 0);
				$email_imap = $this->getParam('email_imap', true, 0);
				$email_pop3 = $this->getParam('email_pop3', true, 0);
				$ftps = $this->getUlParam('ftps', 'ftps_ul', true, 0);
				$tickets = $this->getUlParam('tickets', 'tickets_ul', true, 0);
				$mysqls = $this->getUlParam('mysqls', 'mysqls_ul', true, 0);
				$createstdsubdomain = $this->getParam('createstdsubdomain', true, 0);
				$password = $this->getParam('new_customer_password', true, '');
				$sendpassword = $this->getParam('sendpassword', true, 0);
				$phpenabled = $this->getParam('phpenabled', true, 0);
				$p_allowed_phpconfigs = $this->getParam('allowed_phpconfigs', true, array());
				$perlenabled = $this->getParam('perlenabled', true, 0);
				$dnsenabled = $this->getParam('dnsenabled', true, 0);
				$store_defaultindex = $this->getParam('store_defaultindex', true, 0);
				$loginname = $this->getParam('new_loginname', true, '');
				
				// validation
				$idna_convert = new idna_convert_wrapper();
				$name = validate($name, 'name', '', '', array(), true);
				$firstname = validate($firstname, 'first name', '', '', array(), true);
				$company = validate($company, 'company', '', '', array(), true);
				$street = validate($street, 'street', '', '', array(), true);
				$zipcode = validate($zipcode, 'zipcode', '/^[0-9 \-A-Z]*$/', '', array(), true);
				$city = validate($city, 'city', '', '', array(), true);
				$phone = validate($phone, 'phone', '/^[0-9\- \+\(\)\/]*$/', '', array(), true);
				$fax = validate($fax, 'fax', '/^[0-9\- \+\(\)\/]*$/', '', array(), true);
				$idna_convert = new idna_convert_wrapper();
				$email = $idna_convert->encode(validate($email, 'email', '', '', array(), true));
				$customernumber = validate($customernumber, 'customer number', '/^[A-Za-z0-9 \-]*$/Di', '', array(), true);
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
				
				// gender out of range? [0,2]
				if ($gender < 0 || $gender > 2) {
					$gender = 0;
				}
				
				$allowed_phpconfigs = array();
				if (! empty($p_allowed_phpconfigs) && is_array($p_allowed_phpconfigs)) {
					foreach ($p_allowed_phpconfigs as $allowed_phpconfig) {
						$allowed_phpconfig = intval($allowed_phpconfig);
						$allowed_phpconfigs[] = $allowed_phpconfig;
					}
				}
				
				$diskspace = $diskspace * 1024;
				$traffic = $traffic * 1024 * 1024;
				
				if (((($this->getUserDetail('diskspace_used') + $diskspace) > $this->getUserDetail('diskspace')) && ($this->getUserDetail('diskspace') / 1024) != '-1') || ((($this->getUserDetail('mysqls_used') + $mysqls) > $this->getUserDetail('mysqls')) && $this->getUserDetail('mysqls') != '-1') || ((($this->getUserDetail('emails_used') + $emails) > $this->getUserDetail('emails')) && $this->getUserDetail('emails') != '-1') || ((($this->getUserDetail('email_accounts_used') + $email_accounts) > $this->getUserDetail('email_accounts')) && $this->getUserDetail('email_accounts') != '-1') || ((($this->getUserDetail('email_forwarders_used') + $email_forwarders) > $this->getUserDetail('email_forwarders')) && $this->getUserDetail('email_forwarders') != '-1') || ((($this->getUserDetail('email_quota_used') + $email_quota) > $this->getUserDetail('email_quota')) && $this->getUserDetail('email_quota') != '-1' && Settings::Get('system.mail_quota_enabled') == '1') || ((($this->getUserDetail('ftps_used') + $ftps) > $this->getUserDetail('ftps')) && $this->getUserDetail('ftps') != '-1') || ((($this->getUserDetail('tickets_used') + $tickets) > $this->getUserDetail('tickets')) && $this->getUserDetail('tickets') != '-1') || ((($this->getUserDetail('subdomains_used') + $subdomains) > $this->getUserDetail('subdomains')) && $this->getUserDetail('subdomains') != '-1') || (($diskspace / 1024) == '-1' && ($this->getUserDetail('diskspace') / 1024) != '-1') || ($mysqls == '-1' && $this->getUserDetail('mysqls') != '-1') || ($emails == '-1' && $this->getUserDetail('emails') != '-1') || ($email_accounts == '-1' && $this->getUserDetail('email_accounts') != '-1') || ($email_forwarders == '-1' && $this->getUserDetail('email_forwarders') != '-1') || ($email_quota == '-1' && $this->getUserDetail('email_quota') != '-1' && Settings::Get('system.mail_quota_enabled') == '1') || ($ftps == '-1' && $this->getUserDetail('ftps') != '-1') || ($tickets == '-1' && $this->getUserDetail('tickets') != '-1') || ($subdomains == '-1' && $this->getUserDetail('subdomains') != '-1')) {
					standard_error('youcantallocatemorethanyouhave', '', true);
				}
				
				// Either $name and $firstname or the $company must be inserted
				if ($name == '' && $company == '') {
					standard_error(array(
						'stringisempty',
						'myname'
					));
				} elseif ($firstname == '' && $company == '') {
					standard_error(array(
						'stringisempty',
						'myfirstname'
					), '', true);
				} elseif ($email == '') {
					standard_error(array(
						'stringisempty',
						'emailadd'
					), '', true);
				} elseif (! validateEmail($email)) {
					standard_error('emailiswrong', $email, true);
				} else {
					
					if ($loginname != '') {
						$accountnumber = intval(Settings::Get('system.lastaccountnumber'));
						$loginname = validate($loginname, 'loginname', '/^[a-z][a-z0-9\-_]+$/i', '', array(), true);
						
						// Accounts which match systemaccounts are not allowed, filtering them
						if (preg_match('/^' . preg_quote(Settings::Get('customer.accountprefix'), '/') . '([0-9]+)/', $loginname)) {
							standard_error('loginnameissystemaccount', Settings::Get('customer.accountprefix'), true);
						}
						
						// Additional filtering for Bug #962
						if (function_exists('posix_getpwnam') && ! in_array("posix_getpwnam", explode(",", ini_get('disable_functions'))) && posix_getpwnam($loginname)) {
							standard_error('loginnameissystemaccount', Settings::Get('customer.accountprefix'), true);
						}
					} else {
						$accountnumber = intval(Settings::Get('system.lastaccountnumber')) + 1;
						$loginname = Settings::Get('customer.accountprefix') . $accountnumber;
					}
					
					// Check if the account already exists
					$loginname_check_stmt = Database::prepare("
						SELECT `loginname` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `loginname` = :loginname
					");
					$loginname_check = Database::pexecute_first($loginname_check_stmt, array(
						'loginname' => $loginname
					), true, true);
					
					$loginname_check_admin_stmt = Database::prepare("
						SELECT `loginname` FROM `" . TABLE_PANEL_ADMINS . "` WHERE `loginname` = :loginname
					");
					$loginname_check_admin = Database::pexecute_first($loginname_check_admin_stmt, array(
						'loginname' => $loginname
					), true, true);
					
					if (strtolower($loginname_check['loginname']) == strtolower($loginname) || strtolower($loginname_check_admin['loginname']) == strtolower($loginname)) {
						standard_error('loginnameexists', $loginname, true);
					} elseif (! validateUsername($loginname, Settings::Get('panel.unix_names'), 14 - strlen(Settings::Get('customer.mysqlprefix')))) {
						if (strlen($loginname) > 14 - strlen(Settings::Get('customer.mysqlprefix'))) {
							standard_error('loginnameiswrong2', 14 - strlen(Settings::Get('customer.mysqlprefix')), true);
						} else {
							standard_error('loginnameiswrong', $loginname, true);
						}
					}
					
					$guid = intval(Settings::Get('system.lastguid')) + 1;
					$documentroot = makeCorrectDir(Settings::Get('system.documentroot_prefix') . '/' . $loginname);
					
					if (file_exists($documentroot)) {
						standard_error('documentrootexists', $documentroot, true);
					}
					
					if ($createstdsubdomain != '1') {
						$createstdsubdomain = '0';
					}
					
					if ($phpenabled != '0') {
						$phpenabled = '1';
					}
					
					if ($perlenabled != '0') {
						$perlenabled = '1';
					}
					
					if ($dnsenabled != '0') {
						$dnsenabled = '1';
					}
					
					if ($password == '') {
						$password = generatePassword();
					}
					
					$_theme = Settings::Get('panel.default_theme');
					
					$ins_data = array(
						'adminid' => $this->getUserDetail('adminid'),
						'loginname' => $loginname,
						'passwd' => makeCryptPassword($password),
						'name' => $name,
						'firstname' => $firstname,
						'gender' => $gender,
						'company' => $company,
						'street' => $street,
						'zipcode' => $zipcode,
						'city' => $city,
						'phone' => $phone,
						'fax' => $fax,
						'email' => $email,
						'customerno' => $customernumber,
						'lang' => $def_language,
						'docroot' => $documentroot,
						'guid' => $guid,
						'diskspace' => $diskspace,
						'traffic' => $traffic,
						'subdomains' => $subdomains,
						'emails' => $emails,
						'email_accounts' => $email_accounts,
						'email_forwarders' => $email_forwarders,
						'email_quota' => $email_quota,
						'ftps' => $ftps,
						'tickets' => $tickets,
						'mysqls' => $mysqls,
						'phpenabled' => $phpenabled,
						'allowed_phpconfigs' => empty($allowed_phpconfigs) ? "" : json_encode($allowed_phpconfigs),
						'imap' => $email_imap,
						'pop3' => $email_pop3,
						'perlenabled' => $perlenabled,
						'dnsenabled' => $dnsenabled,
						'theme' => $_theme,
						'custom_notes' => $custom_notes,
						'custom_notes_show' => $custom_notes_show
					);
					
					$ins_stmt = Database::prepare("
						INSERT INTO `" . TABLE_PANEL_CUSTOMERS . "` SET
						`adminid` = :adminid,
						`loginname` = :loginname,
						`password` = :passwd,
						`name` = :name,
						`firstname` = :firstname,
						`gender` = :gender,
						`company` = :company,
						`street` = :street,
						`zipcode` = :zipcode,
						`city` = :city,
						`phone` = :phone,
						`fax` = :fax,
						`email` = :email,
						`customernumber` = :customerno,
						`def_language` = :lang,
						`documentroot` = :docroot,
						`guid` = :guid,
						`diskspace` = :diskspace,
						`traffic` = :traffic,
						`subdomains` = :subdomains,
						`emails` = :emails,
						`email_accounts` = :email_accounts,
						`email_forwarders` = :email_forwarders,
						`email_quota` = :email_quota,
						`ftps` = :ftps,
						`tickets` = :tickets,
						`mysqls` = :mysqls,
						`standardsubdomain` = '0',
						`phpenabled` = :phpenabled,
						`allowed_phpconfigs` = :allowed_phpconfigs,
						`imap` = :imap,
						`pop3` = :pop3,
						`perlenabled` = :perlenabled,
						`dnsenabled` = :dnsenabled,
						`theme` = :theme,
						`custom_notes` = :custom_notes,
						`custom_notes_show` = :custom_notes_show
					");
					Database::pexecute($ins_stmt, $ins_data, true, true);
					
					$customerid = Database::lastInsertId();
					$ins_data['customerid'] = $customerid;
					
					// update admin resource-usage
					$admin_update_query = "UPDATE `" . TABLE_PANEL_ADMINS . "` SET `customers_used` = `customers_used` + 1";
					
					if ($mysqls != '-1') {
						$admin_update_query .= ", `mysqls_used` = `mysqls_used` + 0" . (int) $mysqls;
					}
					
					if ($emails != '-1') {
						$admin_update_query .= ", `emails_used` = `emails_used` + 0" . (int) $emails;
					}
					
					if ($email_accounts != '-1') {
						$admin_update_query .= ", `email_accounts_used` = `email_accounts_used` + 0" . (int) $email_accounts;
					}
					
					if ($email_forwarders != '-1') {
						$admin_update_query .= ", `email_forwarders_used` = `email_forwarders_used` + 0" . (int) $email_forwarders;
					}
					
					if ($email_quota != '-1') {
						$admin_update_query .= ", `email_quota_used` = `email_quota_used` + 0" . (int) $email_quota;
					}
					
					if ($subdomains != '-1') {
						$admin_update_query .= ", `subdomains_used` = `subdomains_used` + 0" . (int) $subdomains;
					}
					
					if ($ftps != '-1') {
						$admin_update_query .= ", `ftps_used` = `ftps_used` + 0" . (int) $ftps;
					}
					
					if ($tickets != '-1' && Settings::Get('ticket.enabled') == 1) {
						$admin_update_query .= ", `tickets_used` = `tickets_used` + 0" . (int) $tickets;
					}
					
					if (($diskspace / 1024) != '-1') {
						$admin_update_query .= ", `diskspace_used` = `diskspace_used` + 0" . (int) $diskspace;
					}
					
					$admin_update_query .= " WHERE `adminid` = '" . (int) $this->getUserDetail('adminid') . "'";
					Database::query($admin_update_query);
					
					// update last guid
					Settings::Set('system.lastguid', $guid, true);
					
					if ($accountnumber != intval(Settings::Get('system.lastaccountnumber'))) {
						// update last account number
						Settings::Set('system.lastaccountnumber', $accountnumber, true);
					}
					
					$this->logger()->logAction(ADM_ACTION, LOG_INFO, "[API] added customer '" . $loginname . "'");
					$customer_ins_data = $ins_data;
					unset($ins_data);
					
					// insert task to create homedir etc.
					inserttask('2', $loginname, $guid, $guid, $store_defaultindex);
					
					// Using filesystem - quota, insert a task which cleans the filesystem - quota
					inserttask('10');
					
					// Add htpasswd for the webalizer stats
					if (CRYPT_STD_DES == 1) {
						$saltfordescrypt = substr(md5(uniqid(microtime(), 1)), 4, 2);
						$htpasswdPassword = crypt($password, $saltfordescrypt);
					} else {
						$htpasswdPassword = crypt($password);
					}
					
					$ins_stmt = Database::prepare("
						INSERT INTO `" . TABLE_PANEL_HTPASSWDS . "` SET
						`customerid` = :customerid,
						`username` = :username,
						`password` = :passwd,
						`path` = :path
					");
					$ins_data = array(
						'customerid' => $customerid,
						'username' => $loginname,
						'passwd' => $htpasswdPassword
					);
					
					if (Settings::Get('system.awstats_enabled') == '1') {
						$ins_data['path'] = makeCorrectDir($documentroot . '/awstats/');
						$this->logger()->logAction(ADM_ACTION, LOG_NOTICE, "[API] automatically added awstats htpasswd for user '" . $loginname . "'");
					} else {
						$ins_data['path'] = makeCorrectDir($documentroot . '/webalizer/');
						$this->logger()->logAction(ADM_ACTION, LOG_NOTICE, "[API] automatically added webalizer htpasswd for user '" . $loginname . "'");
					}
					Database::pexecute($ins_stmt, $ins_data, true, true);
					
					inserttask('1');
					$cryptPassword = makeCryptPassword($password);
					// add FTP-User
					// @fixme use Ftp-ApiCommand later
					$ins_stmt = Database::prepare("
						INSERT INTO `" . TABLE_FTP_USERS . "` SET `customerid` = :customerid, `username` = :username, `description` = :desc,
						`password` = :passwd, `homedir` = :homedir, `login_enabled` = 'y', `uid` = :guid, `gid` = :guid
					");
					$ins_data = array(
						'customerid' => $customerid,
						'username' => $loginname,
						'passwd' => $cryptPassword,
						'homedir' => $documentroot,
						'guid' => $guid,
						'desc' => "Default"
					);
					Database::pexecute($ins_stmt, $ins_data, true, true);
					// add FTP-Group
					// @fixme use Ftp-ApiCommand later
					$ins_stmt = Database::prepare("
						INSERT INTO `" . TABLE_FTP_GROUPS . "` SET `customerid` = :customerid, `groupname` = :groupname, `gid` = :guid, `members` = :members
					");
					$ins_data = array(
						'customerid' => $customerid,
						'groupname' => $loginname,
						'guid' => $guid,
						'members' => $loginname . ',' . Settings::Get('system.httpuser')
					);
					
					// also, add froxlor-local user to ftp-group (if exists!) to
					// allow access to customer-directories from within the panel, which
					// is necessary when pathedit = Dropdown
					if ((int) Settings::Get('system.mod_fcgid_ownvhost') == 1 || (int) Settings::Get('phpfpm.enabled_ownvhost') == 1) {
						if ((int) Settings::Get('system.mod_fcgid') == 1) {
							$local_user = Settings::Get('system.mod_fcgid_httpuser');
						} else {
							$local_user = Settings::Get('phpfpm.vhost_httpuser');
						}
						// check froxlor-local user membership in ftp-group
						// without this check addition may duplicate user in list if httpuser == local_user
						if (strpos($ins_data['members'], $local_user) == false) {
							$ins_data['members'] .= ',' . $local_user;
						}
					}
					Database::pexecute($ins_stmt, $ins_data, true, true);
					
					// FTP-Quotatallies
					// @fixme use Ftp-ApiCommand later
					$ins_stmt = Database::prepare("
						INSERT INTO `" . TABLE_FTP_QUOTATALLIES . "` SET `name` = :name, `quota_type` = 'user', `bytes_in_used` = '0',
						`bytes_out_used` = '0', `bytes_xfer_used` = '0', `files_in_used` = '0', `files_out_used` = '0', `files_xfer_used` = '0'
					");
					Database::pexecute($ins_stmt, array(
						'name' => $loginname
					), true, true);
					$this->logger()->logAction(ADM_ACTION, LOG_NOTICE, "[API] automatically added ftp-account for user '" . $loginname . "'");
					
					$_stdsubdomain = '';
					if ($createstdsubdomain == '1') {
						if (Settings::Get('system.stdsubdomain') !== null && Settings::Get('system.stdsubdomain') != '') {
							$_stdsubdomain = $loginname . '.' . Settings::Get('system.stdsubdomain');
						} else {
							$_stdsubdomain = $loginname . '.' . Settings::Get('system.hostname');
						}
						
						$ins_data = array(
							'domain' => $_stdsubdomain,
							'customerid' => $customerid,
							'adminid' => $this->getUserDetail('adminid'),
							'parentdomainid' => '0',
							'docroot' => $documentroot,
							'adddate' => time(),
							'phpenabled' => $phpenabled,
							'zonefile' => '',
							'isemaildomain' => '0',
							'caneditdomain' => '0',
							'openbasedir' => '1',
							'speciallogfile' => '0',
							'dkim_id' => '0',
							'dkim_privkey' => '',
							'dkim_pubkey' => '',
							'ipandport' => explode(',', Settings::Get('system.defaultip'))
						);
						$domainid = - 1;
						try {
							$std_domain = Domains::getLocal($this->getUserData(), $ins_data)->add();
							$domainid = json_decode($std_domain, true)['data']['id'];
						} catch (Exception $e) {
							$this->logger()->logAction(ADM_ACTION, LOG_ERR, "[API] Unable to add standard-subdomain: " . $e->getMessage());
						}
						
						if ($domainid > 0) {
							$upd_stmt = Database::prepare("
								UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `standardsubdomain` = :domainid WHERE `customerid` = :customerid
							");
							Database::pexecute($upd_stmt, array(
								'domainid' => $domainid,
								'customerid' => $customerid
							), true, true);
							$this->logger()->logAction(ADM_ACTION, LOG_NOTICE, "[API] automatically added standardsubdomain for user '" . $loginname . "'");
							inserttask('1');
						}
					}
					
					if ($sendpassword == '1') {
						
						$srv_hostname = Settings::Get('system.hostname');
						if (Settings::Get('system.froxlordirectlyviahostname') == '0') {
							$srv_hostname .= '/' . basename(FROXLOR_INSTALL_DIR);
						}
						
						$srv_ip_stmt = Database::prepare("
							SELECT ip, port FROM `" . TABLE_PANEL_IPSANDPORTS . "`
							WHERE `id` = :defaultip
						");
						$default_ips = Settings::Get('system.defaultip');
						$default_ips = explode(',', $default_ips);
						$srv_ip = Database::pexecute_first($srv_ip_stmt, array(
							'defaultip' => reset($default_ips)
						), true, true);
						
						$replace_arr = array(
							'FIRSTNAME' => $firstname,
							'NAME' => $name,
							'COMPANY' => $company,
							'SALUTATION' => getCorrectUserSalutation(array(
								'firstname' => $firstname,
								'name' => $name,
								'company' => $company
							)),
							'USERNAME' => $loginname,
							'PASSWORD' => $password,
							'SERVER_HOSTNAME' => $srv_hostname,
							'SERVER_IP' => isset($srv_ip['ip']) ? $srv_ip['ip'] : '',
							'SERVER_PORT' => isset($srv_ip['port']) ? $srv_ip['port'] : '',
							'DOMAINNAME' => $_stdsubdomain
						);
						
						// Get mail templates from database; the ones from 'admin' are fetched for fallback
						$result_stmt = Database::prepare("
						SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
						WHERE `adminid` = :adminid AND `language` = :deflang AND `templategroup` = 'mails' AND `varname` = 'createcustomer_subject'");
						$result = Database::pexecute_first($result_stmt, array(
							'adminid' => $this->getUserDetail('adminid'),
							'deflang' => $def_language
						), true, true);
						$mail_subject = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $lng['mails']['createcustomer']['subject']), $replace_arr));
						
						$result_stmt = Database::prepare("
						SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
						WHERE `adminid` = :adminid AND `language` = :deflang AND `templategroup` = 'mails' AND `varname` = 'createcustomer_mailbody'");
						$result = Database::pexecute_first($result_stmt, array(
							'adminid' => $this->getUserDetail('adminid'),
							'deflang' => $def_language
						), true, true);
						$mail_body = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $lng['mails']['createcustomer']['mailbody']), $replace_arr));
						
						$_mailerror = false;
						try {
							$this->mailer()->Subject = $mail_subject;
							$this->mailer()->AltBody = $mail_body;
							$this->mailer()->MsgHTML(str_replace("\n", "<br />", $mail_body));
							$this->mailer()->AddAddress($email, getCorrectUserSalutation(array(
								'firstname' => $firstname,
								'name' => $name,
								'company' => $company
							)));
							$this->mailer()->Send();
						} catch (phpmailerException $e) {
							$mailerr_msg = $e->errorMessage();
							$_mailerror = true;
						} catch (Exception $e) {
							$mailerr_msg = $e->getMessage();
							$_mailerror = true;
						}
						
						if ($_mailerror) {
							$this->logger()->logAction(ADM_ACTION, LOG_ERR, "[API] Error sending mail: " . $mailerr_msg);
							standard_error('errorsendingmail', $email, true);
						}
						
						$this->mailer()->ClearAddresses();
						$this->logger()->logAction(ADM_ACTION, LOG_NOTICE, "[API] automatically sent password to user '" . $loginname . "'");
					}
				}
				
				$this->logger()->logAction(ADM_ACTION, LOG_WARNING, "[API] added customer '" . $loginname . "'");
				return $this->response(200, "successfull", $customer_ins_data);
			}
			throw new Exception("No more resources available", 406);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	public function update()
	{
		if ($this->isAdmin()) {
			$id = $this->getParam('id');
			
			$json_result = Customers::getLocal($this->getUserData(), array(
				'id' => $id
			))->get();
			$result = json_decode($json_result, true)['data'];
			
			// parameters
			$move_to_admin = intval_ressource($this->getParam('move_to_admin', true, 0));

			$idna_convert = new idna_convert_wrapper();
			$email = $this->getParam('email', true, $idna_convert->decode($result['email']));
			$name = $this->getParam('name', true, $result['name']);
			$firstname = $this->getParam('firstname', true, $result['firstname']);
			$company = $this->getParam('company', true, $result['company']);
			$street = $this->getParam('street', true, $result['street']);
			$zipcode = $this->getParam('zipcode', true, $result['zipcode']);
			$city = $this->getParam('city', true, $result['city']);
			$phone = $this->getParam('phone', true, $result['phone']);
			$fax = $this->getParam('fax', true, $result['fax']);
			$customernumber = $this->getParam('customernumber', true, $result['customernumber']);
			$def_language = $this->getParam('def_language', true, $result['def_language']);
			$gender = intval_ressource($this->getParam('gender', true, $result['gender']));
			$custom_notes = $this->getParam('custom_notes', true, $result['custom_notes']);
			$custom_notes_show = $this->getParam('custom_notes_show', true, $result['custom_notes_show']);

			$dec_places = Settings::Get('panel.decimal_places');
			$diskspace = $this->getUlParam('diskspace', 'diskspace_ul', true, round($result['diskspace'] / 1024, $dec_places));
			$traffic = $this->getUlParam('traffic', 'traffic_ul', true, round($result['traffic'] / (1024 * 1024), $dec_places));
			$subdomains = $this->getUlParam('subdomains', 'subdomains_ul', true, $result['subdomains']);
			$emails = $this->getUlParam('emails', 'emails_ul', true, $result['emails']);
			$email_accounts = $this->getUlParam('email_accounts', 'email_accounts_ul', true, $result['email_accounts']);
			$email_forwarders = $this->getUlParam('email_forwarders', 'email_forwarders_ul', true, $result['email_forwarders']);
			$email_quota = $this->getUlParam('email_quota', 'email_quota_ul', true, $result['email_quota']);
			$email_imap = $this->getParam('email_imap', true, $result['imap']);
			$email_pop3 = $this->getParam('email_pop3', true, $result['pop3']);
			$ftps = $this->getUlParam('ftps', 'ftps_ul', true, $result['ftps']);
			$tickets = $this->getUlParam('tickets', 'tickets_ul', true, $result['tickets']);
			$mysqls = $this->getUlParam('mysqls', 'mysqls_ul', true, $result['mysqls']);
			$createstdsubdomain = $this->getParam('createstdsubdomain', true, 0);
			$password = $this->getParam('new_customer_password', true, '');
			$sendpassword = $this->getParam('sendpassword', true, 0);
			$phpenabled = $this->getParam('phpenabled', true, $result['phpenabled']);
			$allowed_phpconfigs = $this->getParam('allowed_phpconfigs', true, json_decode($result['allowed_phpconfigs'], true));
			$perlenabled = $this->getParam('perlenabled', true, $result['perlenabled']);
			$dnsenabled = $this->getParam('dnsenabled', true, $result['dnsenabled']);
			$deactivated = $this->getParam('deactivated', true, $result['deactivated']);

			// validation
			$idna_convert = new idna_convert_wrapper();
			$name = validate($name, 'name', '', '', array(), true);
			$firstname = validate($firstname, 'first name', '', '', array(), true);
			$company = validate($company, 'company', '', '', array(), true);
			$street = validate($street, 'street', '', '', array(), true);
			$zipcode = validate($zipcode, 'zipcode', '/^[0-9 \-A-Z]*$/', '', array(), true);
			$city = validate($city, 'city', '', '', array(), true);
			$phone = validate($phone, 'phone', '/^[0-9\- \+\(\)\/]*$/', '', array(), true);
			$fax = validate($fax, 'fax', '/^[0-9\- \+\(\)\/]*$/', '', array(), true);
			$email = $idna_convert->encode(validate($email, 'email', '', '', array(), true));
			$customernumber = validate($customernumber, 'customer number', '/^[A-Za-z0-9 \-]*$/Di', '', array(), true);
			$def_language = validate($def_language, 'default language', '', '', array(), true);
			$custom_notes = validate(str_replace("\r\n", "\n", $custom_notes), 'custom_notes', '/^[^\0]*$/', '', array(), true);

			if (Settings::Get('system.mail_quota_enabled') != '1') {
				$email_quota = - 1;
			}

			if (Settings::Get('ticket.enabled') != '1') {
				$tickets = - 1;
			}

			// Either $name and $firstname or the $company must be inserted
			if ($name == '' && $company == '') {
				standard_error(array(
					'stringisempty',
					'myname'
				));
			} elseif ($firstname == '' && $company == '') {
				standard_error(array(
					'stringisempty',
					'myfirstname'
				));
			} elseif ($email == '') {
				standard_error(array(
					'stringisempty',
					'emailadd'
				));
			} elseif (! validateEmail($email)) {
				standard_error('emailiswrong', $email);
			} else {
				
				if ($password != '') {
					$password = validatePassword($password);
					$password = makeCryptPassword($password);
				} else {
					$password = $result['password'];
				}
				
				if ($createstdsubdomain != '1') {
					$createstdsubdomain = '0';
				}
				
				if ($createstdsubdomain == '1' && $result['standardsubdomain'] == '0') {
					
					if (Settings::Get('system.stdsubdomain') !== null && Settings::Get('system.stdsubdomain') != '') {
						$_stdsubdomain = $result['loginname'] . '.' . Settings::Get('system.stdsubdomain');
					} else {
						$_stdsubdomain = $result['loginname'] . '.' . Settings::Get('system.hostname');
					}
					
					$ins_data = array(
						'domain' => $_stdsubdomain,
						'customerid' => $result['customerid'],
						'adminid' => $this->getUserDetail('adminid'),
						'parentdomainid' => '0',
						'docroot' => $result['documentroot'],
						'adddate' => time(),
						'phpenabled' => $phpenabled,
						'zonefile' => '',
						'isemaildomain' => '0',
						'caneditdomain' => '0',
						'openbasedir' => '1',
						'speciallogfile' => '0',
						'dkim_id' => '0',
						'dkim_privkey' => '',
						'dkim_pubkey' => '',
						'ipandport' => explode(',', Settings::Get('system.defaultip'))
					);
					$domainid = - 1;
					try {
						$std_domain = Domains::getLocal($this->getUserData(), $ins_data)->add();
						$domainid = json_decode($std_domain, true)['data']['id'];
					} catch (Exception $e) {
						$this->logger()->logAction(ADM_ACTION, LOG_ERR, "[API] Unable to add standard-subdomain: " . $e->getMessage());
					}
					
					if ($domainid > 0) {
						$upd_stmt = Database::prepare("
							UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `standardsubdomain` = :domainid WHERE `customerid` = :customerid
						");
						Database::pexecute($upd_stmt, array(
							'domainid' => $domainid,
							'customerid' => $result['customerid']
						), true, true);
						$this->logger()->logAction(ADM_ACTION, LOG_NOTICE, "[API] automatically added standardsubdomain for user '" . $result['loginname'] . "'");
						inserttask('1');
					}
				}
				
				if ($createstdsubdomain == '0' && $result['standardsubdomain'] != '0') {
					
					try {
						$std_domain = Domains::getLocal($this->getUserData(), array(
							'id' => $result['standardsubdomain'],
							'is_stdsubdomain' => 1
						))->delete();
					} catch (Exception $e) {
						$this->logger()->logAction(ADM_ACTION, LOG_ERR, "[API] Unable to delete standard-subdomain: " . $e->getMessage());
					}
					$this->logger()->logAction(ADM_ACTION, LOG_NOTICE, "[API] automatically deleted standardsubdomain for user '" . $result['loginname'] . "'");
					inserttask('1');
				}
				
				if ($deactivated != '1') {
					$deactivated = '0';
				}
				
				if ($phpenabled != '0') {
					$phpenabled = '1';
				}
				
				if ($perlenabled != '0') {
					$perlenabled = '1';
				}
				
				if ($dnsenabled != '0') {
					$dnsenabled = '1';
				}
				
				if ($phpenabled != $result['phpenabled'] || $perlenabled != $result['perlenabled']) {
					inserttask('1');
				}
				
				// activate/deactivate customer services
				if ($deactivated != $result['deactivated']) {
					
					$yesno = (($deactivated) ? 'N' : 'Y');
					$pop3 = (($deactivated) ? '0' : (int) $result['pop3']);
					$imap = (($deactivated) ? '0' : (int) $result['imap']);
					
					$upd_stmt = Database::prepare("
							UPDATE `" . TABLE_MAIL_USERS . "` SET `postfix`= :yesno, `pop3` = :pop3, `imap` = :imap WHERE `customerid` = :customerid");
					Database::pexecute($upd_stmt, array(
						'yesno' => $yesno,
						'pop3' => $pop3,
						'imap' => $imap,
						'customerid' => $id
					));
					
					$upd_stmt = Database::prepare("
							UPDATE `" . TABLE_FTP_USERS . "` SET `login_enabled` = :yesno WHERE `customerid` = :customerid");
					Database::pexecute($upd_stmt, array(
						'yesno' => $yesno,
						'customerid' => $id
					));
					
					$upd_stmt = Database::prepare("
							UPDATE `" . TABLE_PANEL_DOMAINS . "` SET `deactivated`= :deactivated WHERE `customerid` = :customerid");
					Database::pexecute($upd_stmt, array(
						'deactivated' => $deactivated,
						'customerid' => $id
					));
					
					// Retrieve customer's databases
					$databases_stmt = Database::prepare("SELECT * FROM " . TABLE_PANEL_DATABASES . " WHERE customerid = :customerid ORDER BY `dbserver`");
					Database::pexecute($databases_stmt, array(
						'customerid' => $id
					));
					
					Database::needRoot(true);
					$last_dbserver = 0;
					
					$dbm = new DbManager($this->logger());
					
					// For each of them
					while ($row_database = $databases_stmt->fetch(PDO::FETCH_ASSOC)) {
						
						if ($last_dbserver != $row_database['dbserver']) {
							$dbm->getManager()->flushPrivileges();
							Database::needRoot(true, $row_database['dbserver']);
							$last_dbserver = $row_database['dbserver'];
						}
						
						foreach (array_unique(explode(',', Settings::Get('system.mysql_access_host'))) as $mysql_access_host) {
							$mysql_access_host = trim($mysql_access_host);
							
							// Prevent access, if deactivated
							if ($deactivated) {
								// failsafe if user has been deleted manually (requires MySQL 4.1.2+)
								$dbm->getManager()->disableUser($row_database['databasename'], $mysql_access_host);
							} else {
								// Otherwise grant access
								$dbm->getManager()->enableUser($row_database['databasename'], $mysql_access_host);
							}
						}
					}
					
					// At last flush the new privileges
					$dbm->getManager()->flushPrivileges();
					Database::needRoot(false);
					
					$this->logger()->logAction(ADM_ACTION, LOG_INFO, "[API] deactivated user '" . $result['loginname'] . "'");
					inserttask('1');
				}
				
				// Disable or enable POP3 Login for customers Mail Accounts
				if ($email_pop3 != $result['pop3']) {
					$upd_stmt = Database::prepare("UPDATE `" . TABLE_MAIL_USERS . "` SET `pop3` = :pop3 WHERE `customerid` = :customerid");
					Database::pexecute($upd_stmt, array(
						'pop3' => $email_pop3,
						'customerid' => $id
					));
				}
				
				// Disable or enable IMAP Login for customers Mail Accounts
				if ($email_imap != $result['imap']) {
					$upd_stmt = Database::prepare("UPDATE `" . TABLE_MAIL_USERS . "` SET `imap` = :imap WHERE `customerid` = :customerid");
					Database::pexecute($upd_stmt, array(
						'imap' => $email_imap,
						'customerid' => $id
					));
				}
				
				$upd_data = array(
					'customerid' => $id,
					'passwd' => $password,
					'name' => $name,
					'firstname' => $firstname,
					'gender' => $gender,
					'company' => $company,
					'street' => $street,
					'zipcode' => $zipcode,
					'city' => $city,
					'phone' => $phone,
					'fax' => $fax,
					'email' => $email,
					'customerno' => $customernumber,
					'lang' => $def_language,
					'diskspace' => $diskspace,
					'traffic' => $traffic,
					'subdomains' => $subdomains,
					'emails' => $emails,
					'email_accounts' => $email_accounts,
					'email_forwarders' => $email_forwarders,
					'email_quota' => $email_quota,
					'ftps' => $ftps,
					'tickets' => $tickets,
					'mysqls' => $mysqls,
					'deactivated' => $deactivated,
					'phpenabled' => $phpenabled,
					'allowed_phpconfigs' => empty($allowed_phpconfigs) ? "" : json_encode($allowed_phpconfigs),
					'imap' => $email_imap,
					'pop3' => $email_pop3,
					'perlenabled' => $perlenabled,
					'dnsenabled' => $dnsenabled,
					'custom_notes' => $custom_notes,
					'custom_notes_show' => $custom_notes_show
				);
				$upd_stmt = Database::prepare("
					UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET
					`name` = :name,
					`firstname` = :firstname,
					`gender` = :gender,
					`company` = :company,
					`street` = :street,
					`zipcode` = :zipcode,
					`city` = :city,
					`phone` = :phone,
					`fax` = :fax,
					`email` = :email,
					`customernumber` = :customerno,
					`def_language` = :lang,
					`password` = :passwd,
					`diskspace` = :diskspace,
					`traffic` = :traffic,
					`subdomains` = :subdomains,
					`emails` = :emails,
					`email_accounts` = :email_accounts,
					`email_forwarders` = :email_forwarders,
					`ftps` = :ftps,
					`tickets` = :tickets,
					`mysqls` = :mysqls,
					`deactivated` = :deactivated,
					`phpenabled` = :phpenabled,
					`allowed_phpconfigs` = :allowed_phpconfigs,
					`email_quota` = :email_quota,
					`imap` = :imap,
					`pop3` = :pop3,
					`perlenabled` = :perlenabled,
					`dnsenabled` = :dnsenabled,
					`custom_notes` = :custom_notes,
					`custom_notes_show` = :custom_notes_show
					WHERE `customerid` = :customerid
				");
				Database::pexecute($upd_stmt, $upd_data);
				
				// Using filesystem - quota, insert a task which cleans the filesystem - quota
				inserttask('10');
				
				$admin_update_query = "UPDATE `" . TABLE_PANEL_ADMINS . "` SET `customers_used` = `customers_used` ";
				
				if ($mysqls != '-1' || $result['mysqls'] != '-1') {
					$admin_update_query .= ", `mysqls_used` = `mysqls_used` ";
					
					if ($mysqls != '-1') {
						$admin_update_query .= " + 0" . (int) $mysqls . " ";
					}
					if ($result['mysqls'] != '-1') {
						$admin_update_query .= " - 0" . (int) $result['mysqls'] . " ";
					}
				}
				
				if ($emails != '-1' || $result['emails'] != '-1') {
					$admin_update_query .= ", `emails_used` = `emails_used` ";
					
					if ($emails != '-1') {
						$admin_update_query .= " + 0" . (int) $emails . " ";
					}
					if ($result['emails'] != '-1') {
						$admin_update_query .= " - 0" . (int) $result['emails'] . " ";
					}
				}
				
				if ($email_accounts != '-1' || $result['email_accounts'] != '-1') {
					$admin_update_query .= ", `email_accounts_used` = `email_accounts_used` ";
					
					if ($email_accounts != '-1') {
						$admin_update_query .= " + 0" . (int) $email_accounts . " ";
					}
					if ($result['email_accounts'] != '-1') {
						$admin_update_query .= " - 0" . (int) $result['email_accounts'] . " ";
					}
				}
				
				if ($email_forwarders != '-1' || $result['email_forwarders'] != '-1') {
					$admin_update_query .= ", `email_forwarders_used` = `email_forwarders_used` ";
					
					if ($email_forwarders != '-1') {
						$admin_update_query .= " + 0" . (int) $email_forwarders . " ";
					}
					if ($result['email_forwarders'] != '-1') {
						$admin_update_query .= " - 0" . (int) $result['email_forwarders'] . " ";
					}
				}
				
				if ($email_quota != '-1' || $result['email_quota'] != '-1') {
					$admin_update_query .= ", `email_quota_used` = `email_quota_used` ";
					
					if ($email_quota != '-1') {
						$admin_update_query .= " + 0" . (int) $email_quota . " ";
					}
					if ($result['email_quota'] != '-1') {
						$admin_update_query .= " - 0" . (int) $result['email_quota'] . " ";
					}
				}
				
				if ($subdomains != '-1' || $result['subdomains'] != '-1') {
					$admin_update_query .= ", `subdomains_used` = `subdomains_used` ";
					
					if ($subdomains != '-1') {
						$admin_update_query .= " + 0" . (int) $subdomains . " ";
					}
					if ($result['subdomains'] != '-1') {
						$admin_update_query .= " - 0" . (int) $result['subdomains'] . " ";
					}
				}
				
				if ($ftps != '-1' || $result['ftps'] != '-1') {
					$admin_update_query .= ", `ftps_used` = `ftps_used` ";
					
					if ($ftps != '-1') {
						$admin_update_query .= " + 0" . (int) $ftps . " ";
					}
					if ($result['ftps'] != '-1') {
						$admin_update_query .= " - 0" . (int) $result['ftps'] . " ";
					}
				}
				
				if ($tickets != '-1' || $result['tickets'] != '-1') {
					$admin_update_query .= ", `tickets_used` = `tickets_used` ";
					
					if ($tickets != '-1') {
						$admin_update_query .= " + 0" . (int) $tickets . " ";
					}
					if ($result['tickets'] != '-1') {
						$admin_update_query .= " - 0" . (int) $result['tickets'] . " ";
					}
				}
				
				if (($diskspace / 1024) != '-1' || ($result['diskspace'] / 1024) != '-1') {
					$admin_update_query .= ", `diskspace_used` = `diskspace_used` ";
					
					if (($diskspace / 1024) != '-1') {
						$admin_update_query .= " + 0" . (int) $diskspace . " ";
					}
					if (($result['diskspace'] / 1024) != '-1') {
						$admin_update_query .= " - 0" . (int) $result['diskspace'] . " ";
					}
				}
				
				$admin_update_query .= " WHERE `adminid` = '" . (int) $result['adminid'] . "'";
				Database::query($admin_update_query);
				$this->logger()->logAction(ADM_ACTION, LOG_INFO, "[API] edited user '" . $result['loginname'] . "'");
				
				/*
				 * move customer to another admin/reseller; #1166
				 */
				if ($move_to_admin > 0 && $move_to_admin != $result['adminid']) {
					$move_result = moveCustomerToAdmin($id, $move_to_admin);
					if ($move_result != true) {
						standard_error('moveofcustomerfailed', $move_result, true);
					}
				}
				
				return $this->response(200, "successfull", $upd_data);
			}
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * delete a customer entry by id
	 *
	 * @param int $id
	 *        	customer-id
	 * @param bool $delete_userfiles
	 *        	optional, default false
	 *        	
	 * @throws Exception
	 * @return array
	 */
	public function delete()
	{
		if ($this->isAdmin()) {
			$id = $this->getParam('id');
			$delete_userfiles = $this->getParam('delete_userfiles', true, 0);
			
			$json_result = Customers::getLocal($this->getUserData(), array(
				'id' => $id
			))->get();
			$result = json_decode($json_result, true)['data'];
			
			// @fixme use Databases-ApiCommand later
			$databases_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_DATABASES . "`
				WHERE `customerid` = :id ORDER BY `dbserver`
			");
			Database::pexecute($databases_stmt, array(
				'id' => $id
			));
			Database::needRoot(true);
			$last_dbserver = 0;
			
			$dbm = new DbManager($this->logger());
			
			while ($row_database = $databases_stmt->fetch(PDO::FETCH_ASSOC)) {
				if ($last_dbserver != $row_database['dbserver']) {
					Database::needRoot(true, $row_database['dbserver']);
					$dbm->getManager()->flushPrivileges();
					$last_dbserver = $row_database['dbserver'];
				}
				$dbm->getManager()->deleteDatabase($row_database['databasename']);
			}
			$dbm->getManager()->flushPrivileges();
			Database::needRoot(false);
			
			// delete customer itself
			$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `customerid` = :id");
			Database::pexecute($stmt, array(
				'id' => $id
			), true, true);
			
			// delete customer databases
			$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_DATABASES . "` WHERE `customerid` = :id");
			Database::pexecute($stmt, array(
				'id' => $id
			), true, true);
			
			// first gather all domain-id's to clean up panel_domaintoip and dns-entries accordingly
			$did_stmt = Database::prepare("SELECT `id` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `customerid` = :id");
			Database::pexecute($did_stmt, array(
				'id' => $id
			), true, true);
			while ($row = $did_stmt->fetch(PDO::FETCH_ASSOC)) {
				// remove domain->ip connection
				$stmt = Database::prepare("DELETE FROM `" . TABLE_DOMAINTOIP . "` WHERE `id_domain` = :did");
				Database::pexecute($stmt, array(
					'did' => $row['id']
				), true, true);
				// remove domain->dns entries
				$stmt = Database::prepare("DELETE FROM `" . TABLE_DOMAIN_DNS . "` WHERE `domain_id` = :did");
				Database::pexecute($stmt, array(
					'did' => $row['id']
				), true, true);
			}
			// remove customer domains
			$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `customerid` = :id");
			Database::pexecute($stmt, array(
				'id' => $id
			), true, true);
			$domains_deleted = $stmt->rowCount();
			
			// delete htpasswds
			$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_HTPASSWDS . "` WHERE `customerid` = :id");
			Database::pexecute($stmt, array(
				'id' => $id
			), true, true);
			
			// delete htaccess options
			$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_HTACCESS . "` WHERE `customerid` = :id");
			Database::pexecute($stmt, array(
				'id' => $id
			), true, true);
			
			// delete potential existing sessions
			$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_SESSIONS . "` WHERE `userid` = :id AND `adminsession` = '0'");
			Database::pexecute($stmt, array(
				'id' => $id
			), true, true);
			
			// delete traffic information
			$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_TRAFFIC . "` WHERE `customerid` = :id");
			Database::pexecute($stmt, array(
				'id' => $id
			), true, true);
			
			// remove diskspace analysis
			$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_DISKSPACE . "` WHERE `customerid` = :id");
			Database::pexecute($stmt, array(
				'id' => $id
			), true, true);
			
			// delete mail-accounts
			$stmt = Database::prepare("DELETE FROM `" . TABLE_MAIL_USERS . "` WHERE `customerid` = :id");
			Database::pexecute($stmt, array(
				'id' => $id
			), true, true);
			
			// delete mail-addresses
			$stmt = Database::prepare("DELETE FROM `" . TABLE_MAIL_VIRTUAL . "` WHERE `customerid` = :id");
			Database::pexecute($stmt, array(
				'id' => $id
			), true, true);
			
			// gather ftp-user names
			$result2_stmt = Database::prepare("SELECT `username` FROM `" . TABLE_FTP_USERS . "` WHERE `customerid` = :id");
			Database::pexecute($result2_stmt, array(
				'id' => $id
			), true, true);
			while ($row = $result2_stmt->fetch(PDO::FETCH_ASSOC)) {
				// delete ftp-quotatallies by username
				$stmt = Database::prepare("DELETE FROM `" . TABLE_FTP_QUOTATALLIES . "` WHERE `name` = :name");
				Database::pexecute($stmt, array(
					'name' => $row['username']
				), true, true);
			}
			
			// remove ftp-group
			$stmt = Database::prepare("DELETE FROM `" . TABLE_FTP_GROUPS . "` WHERE `customerid` = :id");
			Database::pexecute($stmt, array(
				'id' => $id
			), true, true);
			
			// remove ftp-users
			$stmt = Database::prepare("DELETE FROM `" . TABLE_FTP_USERS . "` WHERE `customerid` = :id");
			Database::pexecute($stmt, array(
				'id' => $id
			), true, true);
			
			// Delete all waiting "create user" -tasks for this user, #276
			// Note: the WHERE selects part of a serialized array, but it should be safe this way
			$del_stmt = Database::prepare("
				DELETE FROM `" . TABLE_PANEL_TASKS . "`
				WHERE `type` = '2' AND `data` LIKE :loginname
			");
			Database::pexecute($del_stmt, array(
				'loginname' => "%:{$result['loginname']};%"
			), true, true);
			
			// update admin-resource-usage
			$admin_update_query = "UPDATE `" . TABLE_PANEL_ADMINS . "` SET `customers_used` = `customers_used` - 1 ";
			$admin_update_query .= ", `domains_used` = `domains_used` - 0" . (int) ($domains_deleted - $result['subdomains_used']);
			
			if ($result['mysqls'] != '-1') {
				$admin_update_query .= ", `mysqls_used` = `mysqls_used` - 0" . (int) $result['mysqls'];
			}
			
			if ($result['emails'] != '-1') {
				$admin_update_query .= ", `emails_used` = `emails_used` - 0" . (int) $result['emails'];
			}
			
			if ($result['email_accounts'] != '-1') {
				$admin_update_query .= ", `email_accounts_used` = `email_accounts_used` - 0" . (int) $result['email_accounts'];
			}
			
			if ($result['email_forwarders'] != '-1') {
				$admin_update_query .= ", `email_forwarders_used` = `email_forwarders_used` - 0" . (int) $result['email_forwarders'];
			}
			
			if ($result['email_quota'] != '-1') {
				$admin_update_query .= ", `email_quota_used` = `email_quota_used` - 0" . (int) $result['email_quota'];
			}
			
			if ($result['subdomains'] != '-1') {
				$admin_update_query .= ", `subdomains_used` = `subdomains_used` - 0" . (int) $result['subdomains'];
			}
			
			if ($result['ftps'] != '-1') {
				$admin_update_query .= ", `ftps_used` = `ftps_used` - 0" . (int) $result['ftps'];
			}
			
			if ($result['tickets'] != '-1') {
				$admin_update_query .= ", `tickets_used` = `tickets_used` - 0" . (int) $result['tickets'];
			}
			
			if (($result['diskspace'] / 1024) != '-1') {
				$admin_update_query .= ", `diskspace_used` = `diskspace_used` - 0" . (int) $result['diskspace'];
			}
			
			$admin_update_query .= " WHERE `adminid` = '" . (int) $result['adminid'] . "'";
			Database::query($admin_update_query);
			
			// rebuild configs
			inserttask('1');
			
			// Using nameserver, insert a task which rebuilds the server config
			inserttask('4');
			
			if ($delete_userfiles == 1) {
				// insert task to remove the customers files from the filesystem
				inserttask('6', $result['loginname']);
			}
			
			// Using filesystem - quota, insert a task which cleans the filesystem - quota
			inserttask('10');
			
			// move old tickets to archive
			$tickets = ticket::customerHasTickets($id);
			if ($tickets !== false && isset($tickets[0])) {
				foreach ($tickets as $ticket) {
					$now = time();
					$mainticket = ticket::getInstanceOf($userinfo, (int) $ticket);
					$mainticket->Set('lastchange', $now, true, true);
					$mainticket->Set('lastreplier', '1', true, true);
					$mainticket->Set('status', '3', true, true);
					$mainticket->Update();
					$mainticket->Archive();
					$this->logger()->logAction(ADM_ACTION, LOG_NOTICE, "[API] archived ticket '" . $mainticket->Get('subject') . "'");
				}
			}
			
			$this->logger()->logAction(ADM_ACTION, LOG_WARNING, "[API] deleted customer '" . $result['loginname'] . "'");
			return $this->response(200, "successfull", $result);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * unlock a locked customer by id
	 *
	 * @param int $id
	 *        	customer-id
	 *        	
	 * @throws Exception
	 * @return array
	 */
	public function unlock()
	{
		if ($this->isAdmin()) {
			$id = $this->getParam('id');
			
			$json_result = Customers::getLocal($this->getUserData(), array(
				'id' => $id
			))->get();
			$result = json_decode($json_result, true)['data'];
			
			$result_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET
				`loginfail_count` = '0'
				WHERE `customerid`= :id
			");
			Database::pexecute($result_stmt, array(
				'id' => $id
			), true, true);
			
			$this->logger()->logAction(ADM_ACTION, LOG_WARNING, "[API] unlocked customer '" . $result['loginname'] . "'");
			return $this->response(200, "successfull", $result);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}
}
