<?php

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
	 * @param int $id customer-id
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
				
				$idna_convert = new idna_convert_wrapper();
				$name = validate($this->getParam('name'), 'name', '', '', array(), true);
				$firstname = validate($this->getParam('firstname'), 'first name', '', '', array(), true);
				$company = validate($this->getParam('company'), 'company', '', '', array(), true);
				$street = validate($this->getParam('street'), 'street', '', '', array(), true);
				$zipcode = validate($this->getParam('zipcode'), 'zipcode', '/^[0-9 \-A-Z]*$/', '', array(), true);
				$city = validate($this->getParam('city'), 'city', '', '', array(), true);
				$phone = validate($this->getParam('phone'), 'phone', '/^[0-9\- \+\(\)\/]*$/', '', array(), true);
				$fax = validate($this->getParam('fax'), 'fax', '/^[0-9\- \+\(\)\/]*$/', '', array(), true);
				$email = $idna_convert->encode(validate($this->getParam('email'), 'email', '', '', array(), true));
				$customernumber = validate($this->getParam('customernumber'), 'customer number', '/^[A-Za-z0-9 \-]*$/Di', '', array(), true);
				$def_language = validate($this->getParam('def_language'), 'default language', '', '', array(), true);
				$gender = intval_ressource($this->getParam('gender', 0));
				
				$custom_notes = validate(str_replace("\r\n", "\n", $this->getParam('custom_notes', '')), 'custom_notes', '/^[^\0]*$/', '', array(), true);
				$custom_notes_show = $this->getParam('custom_notes_show', 0);
				
				$diskspace = intval_ressource($this->getParam('diskspace', 0));
				if ($this->getParam('diskspace_ul', 0) == -1) {
					$diskspace = - 1;
				}
				
				$traffic = doubleval_ressource($this->getParam('traffic', 0));
				if ($this->getParam('traffic_ul', 0) == -1) {
					$traffic = - 1;
				}
				
				$subdomains = intval_ressource($this->getParam('subdomains', 0));
				if ($this->getParam('subdomains_ul', 0) == -1) {
					$subdomains = - 1;
				}
				
				$emails = intval_ressource($this->getParam('emails', 0));
				if ($this->getParam('emails_ul', 0) == -1) {
					$emails = - 1;
				}
				
				$email_accounts = intval_ressource($this->getParam('email_accounts', 0));
				if ($this->getParam('email_accounts_ul', 0) == -1) {
					$email_accounts = - 1;
				}
				
				$email_forwarders = intval_ressource($this->getParam('email_forwarders', 0));
				if ($this->getParam('email_forwarders_ul', 0) == -1) {
					$email_forwarders = - 1;
				}
				
				if (Settings::Get('system.mail_quota_enabled') == '1') {
					$email_quota = validate($this->getParam('email_quota', 0), 'email_quota', '/^\d+$/', 'vmailquotawrong', array(
						'0',
						''
					), true);
					if ($this->getParam('email_quota_ul', 0) == -1) {
						$email_quota = - 1;
					}
				} else {
					$email_quota = - 1;
				}
				
				$email_imap = $this->getParam('email_imap', 0);
				$email_pop3 = $this->getParam('email_pop3', 0);
				
				$ftps = intval_ressource($this->getParam('ftps', 0));
				if ($this->getParam('ftps_ul', 0) == -1) {
					$ftps = - 1;
				}
				
				if (Settings::Get('ticket.enabled') == '1') {
					$tickets = intval_ressource($this->getParam('tickets', 0));
					if ($this->getParam('tickets_ul', 0) == -1) {
						$tickets = - 1;
					}
				} else {
					$tickets = - 1;
				}
				
				$mysqls = intval_ressource($this->getParam('mysqls', 0));
				if ($this->getParam('mysqls_ul', 0) == -1) {
					$mysqls = - 1;
				}
				
				$createstdsubdomain = $this->getParam('createstdsubdomain', 0);
				
				$password = validate($this->getParam('new_customer_password', ''), 'password', '', '', array(), true);
				// only check if not empty,
				// cause empty == generate password automatically
				if ($password != '') {
					$password = validatePassword($password, true);
				}
				
				// gender out of range? [0,2]
				if ($gender < 0 || $gender > 2) {
					$gender = 0;
				}
				
				$sendpassword = $this->getParam('sendpassword', 0);
				$phpenabled = $this->getParam('phpenabled', 0);
				
				$allowed_phpconfigs = array();
				if (! empty($this->getParam('allowed_phpconfigs', array())) && is_array($this->getParam('allowed_phpconfigs'))) {
					foreach ($this->getParam('allowed_phpconfigs') as $allowed_phpconfig) {
						$allowed_phpconfig = intval($allowed_phpconfig);
						$allowed_phpconfigs[] = $allowed_phpconfig;
					}
				}
				
				$perlenabled = $this->getParam('perlenabled', 0);
				$dnsenabled = $this->getParam('dnsenabled', 0);
				$store_defaultindex = $this->getParam('store_defaultindex', 0);
				
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
					
					if ($this->getParam('new_loginname', '') != '') {
						$accountnumber = intval(Settings::Get('system.lastaccountnumber'));
						$loginname = validate($this->getParam('new_loginname'), 'loginname', '/^[a-z][a-z0-9\-_]+$/i', '', array(), true);
						
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
							$srv_hostname .= '/'.basename(FROXLOR_INSTALL_DIR);
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
			
			$this->logger()->logAction(ADM_ACTION, LOG_WARNING, "[API] changed customer '" . $result['loginname'] . "'");
			return $this->response(200, "successfull", $upd_data);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * delete a customer entry by id
	 *
	 * @param int $id customer-id
	 *
	 * @throws Exception
	 * @return array
	 */
	public function delete()
	{
		if ($this->isAdmin()) {
			$id = $this->getParam('id');
			
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
			
			$dbm = new DbManager($log);
			
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
			
			if ($this->getParam('delete_userfiles', 0) == 1) {
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
	 * @param int $id customer-id
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
