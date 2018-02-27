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
class Subdomains extends ApiCommand implements ResourceEntity
{

	/**
	 * add a new subdomain
	 *
	 * @param string $subdomain
	 *        	part before domain.tld to create as subdomain
	 * @param string $domain
	 *        	domainname of main-domain
	 * @param int $alias
	 *        	optional, domain-id of a domain that the new domain should be an alias of
	 * @param string $path
	 *        	optional, destination path relative to the customers-homedir, default is customers-homedir
	 * @param string $url
	 *        	optional, overwrites path value with an URL to generate a redirect, alternatively use the path parameter also for URLs
	 * @param string $openbasedir_path
	 *        	optional, either 0 for customers-homedir or 1 for domains-docroot
	 * @param int $phpsettingid
	 *        	optional, php-settings-id, if empty the $domain value is used
	 * @param int $redirectcode
	 *        	optional, redirect-code-id from TABLE_PANEL_REDIRECTCODES
	 * @param bool $ssl_redirect
	 *        	optional, whether to generate a https-redirect or not, default false; requires SSL to be enabled
	 * @param bool $letsencrypt
	 *        	optional, whether to generate a Let's Encrypt certificate for this domain, default false; requires SSL to be enabled
	 * @param int $customer_id
	 *        	required when called as admin, not needed when called as customer
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array
	 */
	public function add()
	{
		if ($this->getUserDetail('subdomains_used') < $this->getUserDetail('subdomains') || $this->getUserDetail('subdomains') == '-1') {
			// parameters
			$subdomain = $this->getParam('subdomain');
			$domain = $this->getParam('domain');
			
			// optional parameters
			$aliasdomain = $this->getParam('alias', true, 0);
			$path = $this->getParam('path', true, '');
			$url = $this->getParam('url', true, '');
			$openbasedir_path = $this->getParam('openbasedir_path', true, 1);
			$phpsettingid = $this->getParam('phpsettingid', true, 0);
			$redirectcode = $this->getParam('redirectcode', true, Settings::Get('customredirect.default'));
			if (Settings::Get('system.use_ssl')) {
				$ssl_redirect = $this->getParam('ssl_redirect', true, 0);
				$letsencrypt = $this->getParam('letsencrypt', true, 0);
				$hsts_maxage = $this->getParam('hsts_maxage', true, 0);
				$hsts_sub = $this->getParam('hsts_sub', true, 0);
				$hsts_preload = $this->getParam('hsts_preload', true, 0);
			} else {
				$ssl_redirect = 0;
				$letsencrypt = 0;
				$hsts_maxage = 0;
				$hsts_sub = 0;
				$hsts_preload = 0;
			}
			
			// get needed customer info to reduce the mysql-usage-counter by one
			if ($this->isAdmin()) {
				// get customer id
				$customer_id = $this->getParam('customer_id');
				$json_result = Customers::getLocal($this->getUserData(), array(
					'id' => $customer_id
				))->get();
				$customer = json_decode($json_result, true)['data'];
				// check whether the customer has enough resources to get the subdomain added
				if ($customer['subdomains_used'] >= $customer['subdomains'] && $customer['subdomains'] != '-1') {
					throw new Exception("Customer has no more resources available", 406);
				}
			} else {
				$customer_id = $this->getUserDetail('customerid');
				$customer = $this->getUserData();
			}
			
			// validation
			if (substr($subdomain, 0, 4) == 'xn--') {
				standard_error('domain_nopunycode', '', true);
			}
			
			$idna_convert = new idna_convert_wrapper();
			$subdomain = $idna_convert->encode(preg_replace(array(
				'/\:(\d)+$/',
				'/^https?\:\/\//'
			), '', validate($subdomain, 'subdomain', '', 'subdomainiswrong', array(), true)));
			
			// merge the two parts together
			$completedomain = $subdomain . '.' . $domain;
			
			if (Settings::Get('system.validate_domain') && ! validateDomain($completedomain)) {
				standard_error(array(
					'stringiswrong',
					'mydomain'
				), '', true);
			}
			if ($completedomain == Settings::Get('system.hostname')) {
				standard_error('admin_domain_emailsystemhostname', '', true);
			}
			
			// check whether the domain already exists
			try {
				$json_result = SubDomains::getLocal($this->getUserData(), array(
					'domainname' => $completedomain
				))->get();
				// no exception so far - domain exists
				standard_error('domainexistalready', $completedomain, true);
			} catch (Exception $e) {
				// all good, domain does not exist
			}
			
			// alias domain checked?
			if ($aliasdomain != 0) {
				// also check ip/port combination to be the same, #176
				$aliasdomain_stmt = Database::prepare("
					SELECT `d`.`id` FROM `" . TABLE_PANEL_DOMAINS . "` `d` , `" . TABLE_PANEL_CUSTOMERS . "` `c` , `" . TABLE_DOMAINTOIP . "` `dip`
					WHERE `d`.`aliasdomain` IS NULL
					AND `d`.`id` = :id
					AND `c`.`standardsubdomain` <> `d`.`id`
					AND `d`.`customerid` = :customerid
					AND `c`.`customerid` = `d`.`customerid`
					AND `d`.`id` = `dip`.`id_domain`
					AND `dip`.`id_ipandports`
					IN (SELECT `id_ipandports` FROM `" . TABLE_DOMAINTOIP . "` WHERE `id_domain` = :id )
					GROUP BY `d`.`domain`
					ORDER BY `d`.`domain` ASC
				");
				$aliasdomain_check = Database::pexecute_first($aliasdomain_stmt, array(
					"id" => $aliasdomain,
					"customerid" => $customer_id
				), true, true);
				if ($aliasdomain_check['id'] != $aliasdomain) {
					standard_error('domainisaliasorothercustomer', '', true);
				}
				triggerLetsEncryptCSRForAliasDestinationDomain($aliasdomain, $this->logger());
			}
			
			// check whether an URL was specified
			$_doredirect = false;
			if (! empty($url) && validateUrl($url)) {
				$path = $url;
				$_doredirect = true;
			} else {
				$path = validate($path, 'path', '', '', array(), true);
			}
			
			// check whether path is a real path
			if (! preg_match('/^https?\:\/\//', $path) || ! validateUrl($path)) {
				if (strstr($path, ":") !== false) {
					standard_error('pathmaynotcontaincolon', '', true);
				}
				// If path is empty or '/' and 'Use domain name as default value for DocumentRoot path' is enabled in settings,
				// set default path to subdomain or domain name
				if ((($path == '') || ($path == '/')) && Settings::Get('system.documentroot_use_default_value') == 1) {
					$path = makeCorrectDir($customer['documentroot'] . '/' . $completedomain);
				} else {
					$path = makeCorrectDir($customer['documentroot'] . '/' . $path);
				}
			} else {
				// no it's not, create a redirect
				$_doredirect = true;
			}
			
			if ($openbasedir_path != 1) {
				$openbasedir_path = 0;
			}
			
			// get main domain for various checks
			$domain_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_DOMAINS . "`
				WHERE `domain` = :domain
				AND `customerid` = :customerid
				AND `parentdomainid` = '0'
				AND `email_only` = '0'
				AND `caneditdomain` = '1'
			");
			$domain_check = Database::pexecute_first($domain_stmt, array(
				"domain" => $domain,
				"customerid" => $customer['customerid']
			), true, true);
			
			if (! $domain_check) {
				// the given main-domain
				standard_error('maindomainnonexist', $domain, true);
			} elseif ($subdomain == 'www' && $domain_check['wwwserveralias'] == '1') {
				// you cannot add 'www' as subdomain when the maindomain generates a www-alias
				standard_error('wwwnotallowed', '', true);
			} elseif (strtolower($completedomain_check['domain']) == strtolower($completedomain)) {
				// the domain does already exist as main-domain
				standard_error('domainexistalready', $completedomain, true);
			}
			
			if ($ssl_redirect != 0) {
				// a ssl-redirect only works if there actually is a
				// ssl ip/port assigned to the domain
				if (domainHasSslIpPort($domain_check['id']) == true) {
					$ssl_redirect = '1';
					$_doredirect = true;
				} else {
					standard_error('sslredirectonlypossiblewithsslipport', '', true);
				}
			}
			
			if ($letsencrypt != 0) {
				// let's encrypt only works if there actually is a
				// ssl ip/port assigned to the domain
				if (domainHasSslIpPort($domain_check['id']) == true) {
					$letsencrypt = '1';
				} else {
					standard_error('letsencryptonlypossiblewithsslipport', '', true);
				}
			}
			
			// Temporarily deactivate ssl_redirect until Let's Encrypt certificate was generated
			if ($ssl_redirect > 0 && $letsencrypt == 1) {
				$ssl_redirect = 2;
			}
			
			// get the phpsettingid from parentdomain, #107
			$phpsid_stmt = Database::prepare("
				SELECT `phpsettingid` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `id` = :id
			");
			$phpsid_result = Database::pexecute_first($phpsid_stmt, array(
				"id" => $domain_check['id']
			), true, true);
			
			if (! isset($phpsid_result['phpsettingid']) || (int) $phpsid_result['phpsettingid'] <= 0) {
				// assign default config
				$phpsid_result['phpsettingid'] = 1;
			}
			// check whether the customer has chosen its own php-config
			if ($phpsettingid > 0 && $phpsettingid != $phpsid_result['phpsettingid']) {
				$phpsid_result['phpsettingid'] = intval($phpsettingid);
			}
			
			// acutall insert domain
			$stmt = Database::prepare("
				INSERT INTO `" . TABLE_PANEL_DOMAINS . "` SET
				`customerid` = :customerid,
				`domain` = :domain,
				`documentroot` = :documentroot,
				`aliasdomain` = :aliasdomain,
				`parentdomainid` = :parentdomainid,
				`wwwserveralias` = :wwwserveralias,
				`isemaildomain` = :isemaildomain,
				`iswildcarddomain` = :iswildcarddomain,
				`phpenabled` = :phpenabled,
				`openbasedir` = :openbasedir,
				`openbasedir_path` = :openbasedir_path,
				`speciallogfile` = :speciallogfile,
				`specialsettings` = :specialsettings,
				`ssl_redirect` = :ssl_redirect,
				`phpsettingid` = :phpsettingid,
				`letsencrypt` = :letsencrypt,
				`hsts` = :hsts,
				`hsts_sub` = :hsts_sub,
				`hsts_preload` = :hsts_preload
			");
			$params = array(
				"customerid" => $customer['customerid'],
				"domain" => $completedomain,
				"documentroot" => $path,
				"aliasdomain" => $aliasdomain != 0 ? $aliasdomain : null,
				"parentdomainid" => $domain_check['id'],
				"wwwserveralias" => $domain_check['wwwserveralias'] == '1' ? '1' : '0',
				"iswildcarddomain" => $domain_check['iswildcarddomain'] == '1' ? '1' : '0',
				"isemaildomain" => $domain_check['subcanemaildomain'] == '3' ? '1' : '0',
				"openbasedir" => $domain_check['openbasedir'],
				"openbasedir_path" => $openbasedir_path,
				"phpenabled" => $domain_check['phpenabled'],
				"speciallogfile" => $domain_check['speciallogfile'],
				"specialsettings" => $domain_check['specialsettings'],
				"ssl_redirect" => $ssl_redirect,
				"phpsettingid" => $phpsid_result['phpsettingid'],
				"letsencrypt" => $letsencrypt,
				"hsts" => $hsts_maxage,
				"hsts_sub" => $hsts_sub,
				"hsts_preload" => $hsts_preload
			);
			Database::pexecute($stmt, $params, true, true);
			$subdomain_id = Database::lastInsertId();
			
			$stmt = Database::prepare("
				INSERT INTO `" . TABLE_DOMAINTOIP . "`
				(`id_domain`, `id_ipandports`)
				SELECT LAST_INSERT_ID(), `id_ipandports`
				FROM `" . TABLE_DOMAINTOIP . "`
				WHERE `id_domain` = :id_domain
			");
			Database::pexecute($stmt, array(
				"id_domain" => $domain_check['id']
			));
			
			if ($_doredirect) {
				addRedirectToDomain($subdomain_id, $redirectcode);
			}
			
			inserttask('1');
			// Using nameserver, insert a task which rebuilds the server config
			inserttask('4');
			
			Customers::increaseUsage($customer['customerid'], 'subdomains_used');
			Admins::increaseUsage(($this->isAdmin() ? $customer['adminid'] : $this->getUserDetail('adminid')), 'subdomains_used');
			
			$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_INFO, "[API] added subdomain '" . $completedomain . "'");
			
			$json_result = Subdomains::getLocal($this->getUserData(), array(
				'id' => $subdomain_id
			))->get();
			$result = json_decode($json_result, true)['data'];
			return $this->response(200, "successfull", $result);
		}
		throw new Exception("No more resources available", 406);
	}

	/**
	 * return a subdomain entry by either id or domainname
	 *
	 * @param int $id
	 *        	optional, the domain-id
	 * @param string $domainname
	 *        	optional, the domainname
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array
	 */
	public function get()
	{
		$id = $this->getParam('id', true, 0);
		$dn_optional = ($id <= 0 ? false : true);
		$domainname = $this->getParam('domainname', $dn_optional, '');
		
		// convert possible idn domain to punycode
		if (substr($domainname, 0, 4) != 'xn--') {
			$idna_convert = new idna_convert_wrapper();
			$domainname = $idna_convert->encode($domainname);
		}
		
		if ($this->isAdmin()) {
			if ($this->getUserDetail('customers_see_all') != 1) {
				// if it's a reseller or an admin who cannot see all customers, we need to check
				// whether the database belongs to one of his customers
				$json_result = Customers::getLocal($this->getUserData())->list();
				$custom_list_result = json_decode($json_result, true)['data']['list'];
				$customer_ids = array();
				foreach ($custom_list_result as $customer) {
					$customer_ids[] = $customer['customerid'];
				}
				if (count($customer_ids) > 0) {
					$result_stmt = Database::prepare("
						SELECT * FROM `" . TABLE_PANEL_DOMAINS . "`
						WHERE " . ($id > 0 ? "`id` = :iddn" : "`domain` = :iddn") . " AND `customerid` IN (:customerids)
					");
					$params = array(
						'iddn' => ($id <= 0 ? $domainname : $id),
						'customerids' => implode(", ", $customer_ids)
					);
				} else {
					throw new Exception("You do not have any customers yet", 406);
				}
			} else {
				$result_stmt = Database::prepare("
					SELECT * FROM `" . TABLE_PANEL_DOMAINS . "`
					WHERE " . ($id > 0 ? "`id` = :iddn" : "`databasename` = :iddn"));
				$params = array(
					'iddn' => ($id <= 0 ? $domainname : $id)
				);
			}
		} else {
			if (Settings::IsInList('panel.customer_hide_options', 'domains')) {
				throw new Exception("You cannot access this resource", 405);
			}
			$result_stmt = Database::prepare("
				SELECT `id`, `customerid`, `domain`, `documentroot`, `isemaildomain`, `parentdomainid`, `aliasdomain` FROM `" . TABLE_PANEL_DOMAINS . "`
				WHERE `customerid`= :customerid AND " . ($id > 0 ? "`id` = :iddn" : "`databasename` = :iddn"));
			$params = array(
				'customerid' => $this->getUserDetail('customerid'),
				'iddn' => ($id <= 0 ? $domainname : $id)
			);
		}
		$result = Database::pexecute_first($result_stmt, $params, true, true);
		if ($result) {
			$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_NOTICE, "[API] get subdomain '" . $result['domain'] . "'");
			return $this->response(200, "successfull", $result);
		}
		$key = ($id > 0 ? "id #" . $id : "domainname '" . $domainname . "'");
		throw new Exception("Subdomain with " . $key . " could not be found", 404);
	}

	public function update()
	{
		throw new Exception("Not available yet.", 501);
	}

	public function list()
	{
		if ($this->isAdmin()) {
			// if we're an admin, list all databases of all the admins customers
			// or optionally for one specific customer identified by id or loginname
			$customerid = $this->getParam('customerid', true, 0);
			$loginname = $this->getParam('loginname', true, '');
			
			if (! empty($customer_id) || ! empty($loginname)) {
				$json_result = Customers::getLocal($this->getUserData(), array(
					'id' => $customerid,
					'loginname' => $loginname
				))->get();
				$custom_list_result = array(
					json_decode($json_result, true)['data']
				);
			} else {
				$json_result = Customers::getLocal($this->getUserData())->list();
				$custom_list_result = json_decode($json_result, true)['data']['list'];
			}
			$customer_ids = array();
			$customer_stdsubs = array();
			foreach ($custom_list_result as $customer) {
				$customer_ids[] = $customer['customerid'];
				$customer_stdsubs[$customer['customerid']] = $customer['standardsubdomain'];
			}
		} else {
			if (Settings::IsInList('panel.customer_hide_options', 'domains')) {
				throw new Exception("You cannot access this resource", 405);
			}
			$customer_ids = array(
				$this->getUserDetail('customerid')
			);
			$customer_stdsubs = array(
				$this->getUserDetail('customerid') => $this->getUserDetail('standardsubdomain')
			);
		}
		
		// prepare select statement
		$domains_stmt = Database::prepare("
			SELECT `d`.`id`, `d`.`customerid`, `d`.`domain`, `d`.`documentroot`, `d`.`isbinddomain`, `d`.`isemaildomain`, `d`.`caneditdomain`, `d`.`iswildcarddomain`, `d`.`parentdomainid`, `d`.`letsencrypt`, `d`.`termination_date`, `ad`.`id` AS `aliasdomainid`, `ad`.`domain` AS `aliasdomain`, `da`.`id` AS `domainaliasid`, `da`.`domain` AS `domainalias`
			FROM `" . TABLE_PANEL_DOMAINS . "` `d`
			LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `ad` ON `d`.`aliasdomain`=`ad`.`id`
			LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `da` ON `da`.`aliasdomain`=`d`.`id`
			WHERE `d`.`customerid`= :customerid
			AND `d`.`email_only`='0'
			AND `d`.`id` <> :standardsubdomain
		");
		
		$result = array();
		foreach ($customer_ids as $customer_id) {
			Database::pexecute($domains_stmt, array(
				"customerid" => $customer_id,
				"standardsubdomain" => $customer_stdsubs[$customer_id]
			), true, true);
			while ($row = $domains_stmt->fetch(PDO::FETCH_ASSOC)) {
				$result[] = $row;
			}
		}
		return $this->response(200, "successfull", array(
			'count' => count($result),
			'list' => $result
		));
	}

	/**
	 * delete a subdomain by either id or domainname
	 *
	 * @param int $id
	 *        	optional, the domain-id
	 * @param string $domainname
	 *        	optional, the domainname
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array
	 */
	public function delete()
	{
		$id = $this->getParam('id', true, 0);
		$dn_optional = ($id <= 0 ? false : true);
		$domainname = $this->getParam('domainname', $dn_optional, '');
		
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'domains')) {
			throw new Exception("You cannot access this resource", 405);
		}
		
		$json_result = SubDomains::getLocal($this->getUserData(), array(
			'id' => $id,
			'domainname' => $domainname
		))->get();
		$result = json_decode($json_result, true)['data'];
		$id = $result['id'];
		
		// get needed customer info to reduce the subdomain-usage-counter by one
		if ($this->isAdmin()) {
			$json_result = Customers::getLocal($this->getUserData(), array(
				'id' => $result['customerid']
			))->get();
			$customer = json_decode($json_result, true)['data'];
			$subdomains_used = $customer['subdomains_used'];
			$customer_id = $customer['customer_id'];
		} else {
			if ($result['caneditdomain'] == 0) {
				throw new Exception("You cannot edit this resource", 405);
			}
			$subdomains_used = $this->getUserDetail('subdomains_used');
			$customer_id = $this->getUserDetail('customerid');
		}
		
		if ($result['isemaildomain'] == '1') {
			// check for e-mail addresses
			$emails_stmt = Database::prepare("
				SELECT COUNT(`id`) AS `count` FROM `" . TABLE_MAIL_VIRTUAL . "`
				WHERE `customerid` = :customerid AND `domainid` = :domainid
			");
			$emails = Database::pexecute_first($emails_stmt, array(
				"customerid" => $customer_id,
				"domainid" => $id
			), true, true);
			
			if ($emails['count'] != '0') {
				standard_error('domains_cantdeletedomainwithemail', '', true);
			}
		}
		
		triggerLetsEncryptCSRForAliasDestinationDomain($result['aliasdomain'], $this->logger());
		
		// delete domain from table
		$stmt = Database::prepare("
			DELETE FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `customerid` = :customerid AND `id` = :id
		");
		Database::pexecute($stmt, array(
			"customerid" => $customer_id,
			"id" => $id
		), true, true);
		
		// remove connections to ips and domainredirects
		$del_stmt = Database::prepare("
			DELETE FROM `" . TABLE_DOMAINTOIP . "`
			WHERE `id_domain` = :domainid
		");
		Database::pexecute($del_stmt, array(
			'domainid' => $id
		), true, true);
		
		// remove redirect-codes
		$del_stmt = Database::prepare("
			DELETE FROM `" . TABLE_PANEL_DOMAINREDIRECTS . "`
			WHERE `did` = :domainid
		");
		Database::pexecute($del_stmt, array(
			'domainid' => $id
		), true, true);
		
		// remove certificate from domain_ssl_settings, fixes #1596
		$del_stmt = Database::prepare("
			DELETE FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "`
			WHERE `domainid` = :domainid
		");
		Database::pexecute($del_stmt, array(
			'domainid' => $id
		), true, true);
		
		// remove possible existing DNS entries
		$del_stmt = Database::prepare("
			DELETE FROM `" . TABLE_DOMAIN_DNS . "`
			WHERE `domain_id` = :domainid
		");
		Database::pexecute($del_stmt, array(
			'domainid' => $id
		), true, true);
		
		inserttask('1');
		// Using nameserver, insert a task which rebuilds the server config
		inserttask('4');
		
		// reduce subdomain-usage-counter
		$stmt = Database::prepare("
			UPDATE `" . TABLE_PANEL_CUSTOMERS . "`
			SET `subdomains_used` = `subdomains_used` - 1
			WHERE `customerid` = :customerid
		");
		Database::pexecute($stmt, array(
			"customerid" => $customer_id
		), true, true);
		// update admin usage
		$stmt = Database::prepare("
			UPDATE `" . TABLE_PANEL_ADMINS . "`
			SET `subdomains_used` = `subdomains_used` - 1
			WHERE `adminid` = :adminid
		");
		Database::pexecute($stmt, array(
			"adminid" => ($this->isAdmin() ? $customer['adminid'] : $this->getUserDetail('adminid'))
		), true, true);
		
		$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_WARNING, "[API] deleted subdomain '" . $result['domain'] . "'");
		return $this->response(200, "successfull", $result);
	}
}
