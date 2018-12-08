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
class SubDomains extends ApiCommand implements ResourceEntity
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
	 * @param int $openbasedir_path
	 *        	optional, either 0 for customers-homedir or 1 for domains-docroot
	 * @param int $phpsettingid
	 *        	optional, php-settings-id, if empty the $domain value is used
	 * @param int $redirectcode
	 *        	optional, redirect-code-id from TABLE_PANEL_REDIRECTCODES
	 * @param bool $ssl_redirect
	 *        	optional, whether to generate a https-redirect or not, default false; requires SSL to be enabled
	 * @param bool $letsencrypt
	 *        	optional, whether to generate a Let's Encrypt certificate for this domain, default false; requires SSL to be enabled
	 * @param int $hsts_maxage
	 *        	optional max-age value for HSTS header, default 0
	 * @param bool $hsts_sub
	 *        	optional whether or not to add subdomains to the HSTS header, default 0
	 * @param bool $hsts_preload
	 *        	optional whether or not to preload HSTS header value, default 0
	 * @param int $customerid
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
			$isemaildomain = $this->getParam('isemaildomain', true, 0);
			if (Settings::Get('system.use_ssl')) {
				$ssl_redirect = $this->getBoolParam('ssl_redirect', true, 0);
				$letsencrypt = $this->getBoolParam('letsencrypt', true, 0);
				$hsts_maxage = $this->getParam('hsts_maxage', true, 0);
				$hsts_sub = $this->getBoolParam('hsts_sub', true, 0);
				$hsts_preload = $this->getBoolParam('hsts_preload', true, 0);
			} else {
				$ssl_redirect = 0;
				$letsencrypt = 0;
				$hsts_maxage = 0;
				$hsts_sub = 0;
				$hsts_preload = 0;
			}

			// get needed customer info to reduce the subdomain-usage-counter by one
			$customer = $this->getCustomerData('subdomains');

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
			$completedomain_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_DOMAINS . "`
				WHERE `domain` = :domain
				AND `customerid` = :customerid
				AND `email_only` = '0'
				AND `caneditdomain` = '1'
			");
			$completedomain_check = Database::pexecute_first($completedomain_stmt, array(
				"domain" => $completedomain,
				"customerid" => $customer['customerid']
			), true, true);

			if ($completedomain_check) {
				// no exception so far - domain exists
				standard_error('domainexistalready', $completedomain, true);
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
					"customerid" => $customer['customerid']
				), true, true);
				if ($aliasdomain_check['id'] != $aliasdomain) {
					standard_error('domainisaliasorothercustomer', '', true);
				}
				triggerLetsEncryptCSRForAliasDestinationDomain($aliasdomain, $this->logger());
			}

			// validate / correct path/url of domain
			$_doredirect = false;
			$path = $this->validateDomainDocumentRoot($path, $url, $customer, $completedomain, $_doredirect);

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

			// if allowed, check for 'is email domain'-flag
			if ($domain_check['subcanemaildomain'] == '1' || $domain_check['subcanemaildomain'] == '2') {
				$isemaildomain = intval($isemaildomain);
			} else {
				$isemaildomain = $domain_check['subcanemaildomain'] == '3' ? 1 : 0;
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
				`adminid` = :adminid,
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
				"adminid" => $customer['adminid'],
				"domain" => $completedomain,
				"documentroot" => $path,
				"aliasdomain" => $aliasdomain != 0 ? $aliasdomain : null,
				"parentdomainid" => $domain_check['id'],
				"wwwserveralias" => $domain_check['wwwserveralias'] == '1' ? '1' : '0',
				"iswildcarddomain" => $domain_check['iswildcarddomain'] == '1' ? '1' : '0',
				"isemaildomain" => $isemaildomain,
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

			$result = $this->apiCall('SubDomains.get', array(
				'id' => $subdomain_id
			));
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
				$_custom_list_result = $this->apiCall('Customers.listing');
				$custom_list_result = $_custom_list_result['list'];
				$customer_ids = array();
				foreach ($custom_list_result as $customer) {
					$customer_ids[] = $customer['customerid'];
				}
				if (count($customer_ids) > 0) {
					$result_stmt = Database::prepare("
						SELECT d.*, pd.`subcanemaildomain`, pd.`isbinddomain` as subisbinddomain
						FROM `" . TABLE_PANEL_DOMAINS . "` d, `" . TABLE_PANEL_DOMAINS . "` pd
						WHERE " . ($id > 0 ? "d.`id` = :iddn" : "d.`domain` = :iddn") . " AND d.`customerid` IN (" . implode(", ", $customer_ids) . ")
						AND ((d.`parentdomainid`!='0' AND pd.`id` = d.`parentdomainid`) OR (d.`parentdomainid`='0' AND pd.`id` = d.`id`))
					");
					$params = array(
						'iddn' => ($id <= 0 ? $domainname : $id)
					);
				} else {
					throw new Exception("You do not have any customers yet", 406);
				}
			} else {
				$result_stmt = Database::prepare("
					SELECT d.*, pd.`subcanemaildomain`, pd.`isbinddomain` as subisbinddomain
					FROM `" . TABLE_PANEL_DOMAINS . "` d, `" . TABLE_PANEL_DOMAINS . "` pd
					WHERE " . ($id > 0 ? "d.`id` = :iddn" : "d.`domain` = :iddn") . "
					AND ((d.`parentdomainid`!='0' AND pd.`id` = d.`parentdomainid`) OR (d.`parentdomainid`='0' AND pd.`id` = d.`id`))
				");
				$params = array(
					'iddn' => ($id <= 0 ? $domainname : $id)
				);
			}
		} else {
			if (Settings::IsInList('panel.customer_hide_options', 'domains')) {
				throw new Exception("You cannot access this resource", 405);
			}
			$result_stmt = Database::prepare("
				SELECT d.*, pd.`subcanemaildomain`, pd.`isbinddomain` as subisbinddomain
				FROM `" . TABLE_PANEL_DOMAINS . "` d, `" . TABLE_PANEL_DOMAINS . "` pd
				WHERE d.`customerid`= :customerid AND " . ($id > 0 ? "d.`id` = :iddn" : "d.`domain` = :iddn") . "
				AND ((d.`parentdomainid`!='0' AND pd.`id` = d.`parentdomainid`) OR (d.`parentdomainid`='0' AND pd.`id` = d.`id`))
			");
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

	/**
	 * update subdomain entry by either id or domainname
	 *
	 * @param int $id
	 *        	optional, the domain-id
	 * @param string $domainname
	 *        	optional, the domainname
	 * @param int $alias
	 *        	optional, domain-id of a domain that the new domain should be an alias of
	 * @param string $path
	 *        	optional, destination path relative to the customers-homedir, default is customers-homedir
	 * @param string $url
	 *        	optional, overwrites path value with an URL to generate a redirect, alternatively use the path parameter also for URLs
	 * @param int $selectserveralias
	 *        	optional, 0 = wildcard, 1 = www-alias, 2 = none
	 * @param bool $isemaildomain
	 *        	optional
	 * @param int $openbasedir_path
	 *        	optional, either 0 for customers-homedir or 1 for domains-docroot
	 * @param int $phpsettingid
	 *        	optional, php-settings-id, if empty the $domain value is used
	 * @param int $redirectcode
	 *        	optional, redirect-code-id from TABLE_PANEL_REDIRECTCODES
	 * @param bool $ssl_redirect
	 *        	optional, whether to generate a https-redirect or not, default false; requires SSL to be enabled
	 * @param bool $letsencrypt
	 *        	optional, whether to generate a Let's Encrypt certificate for this domain, default false; requires SSL to be enabled
	 * @param int $hsts_maxage
	 *        	optional max-age value for HSTS header
	 * @param bool $hsts_sub
	 *        	optional whether or not to add subdomains to the HSTS header
	 * @param bool $hsts_preload
	 *        	optional whether or not to preload HSTS header value
	 * @param int $customerid
	 *        	required when called as admin, not needed when called as customer
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array
	 */
	public function update()
	{
		$id = $this->getParam('id', true, 0);
		$dn_optional = ($id <= 0 ? false : true);
		$domainname = $this->getParam('domainname', $dn_optional, '');

		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'domains')) {
			throw new Exception("You cannot access this resource", 405);
		}

		$result = $this->apiCall('SubDomains.get', array(
			'id' => $id,
			'domainname' => $domainname
		));
		$id = $result['id'];

		// parameters
		$aliasdomain = $this->getParam('alias', true, 0);
		$path = $this->getParam('path', true, $result['documentroot']);
		$url = $this->getParam('url', true, '');
		// default: 0 = wildcard, 1 = www-alias, 2 = none
		$_serveraliasdefault = $result['iswildcarddomain'] == '1' ? 0 : ($result['wwwserveralias'] == '1' ? 1 : 2);
		$selectserveralias = $this->getParam('selectserveralias', true, $_serveraliasdefault);
		$isemaildomain = $this->getBoolParam('isemaildomain', true, $result['isemaildomain']);
		$openbasedir_path = $this->getParam('openbasedir_path', true, $result['openbasedir_path']);
		$phpsettingid = $this->getParam('phpsettingid', true, $result['phpsettingid']);
		$redirectcode = $this->getParam('redirectcode', true, getDomainRedirectId($id));
		if (Settings::Get('system.use_ssl')) {
			$ssl_redirect = $this->getBoolParam('ssl_redirect', true, $result['ssl_redirect']);
			$letsencrypt = $this->getBoolParam('letsencrypt', true, $result['letsencrypt']);
			$hsts_maxage = $this->getParam('hsts_maxage', true, $result['hsts']);
			$hsts_sub = $this->getBoolParam('hsts_sub', true, $result['hsts_sub']);
			$hsts_preload = $this->getBoolParam('hsts_preload', true, $result['hsts_preload']);
		} else {
			$ssl_redirect = 0;
			$letsencrypt = 0;
			$hsts_maxage = 0;
			$hsts_sub = 0;
			$hsts_preload = 0;
		}

		// get needed customer info to reduce the subdomain-usage-counter by one
		$customer = $this->getCustomerData();

		$alias_stmt = Database::prepare("SELECT COUNT(`id`) AS count FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `aliasdomain`= :aliasdomain");
		$alias_check = Database::pexecute_first($alias_stmt, array(
			"aliasdomain" => $result['id']
		));
		$alias_check = $alias_check['count'];

		// alias domain checked?
		if ($aliasdomain != 0) {
			$aliasdomain_stmt = Database::prepare("
				SELECT `id` FROM `" . TABLE_PANEL_DOMAINS . "` `d`,`" . TABLE_PANEL_CUSTOMERS . "` `c`
				WHERE `d`.`customerid`= :customerid
				AND `d`.`aliasdomain` IS NULL
				AND `d`.`id`<>`c`.`standardsubdomain`
				AND `c`.`customerid`= :customerid
				AND `d`.`id`= :id
			");
			$aliasdomain_check = Database::pexecute_first($aliasdomain_stmt, array(
				"id" => $aliasdomain,
				"customerid" => $customer['customerid']
			), true, true);
			if ($aliasdomain_check['id'] != $aliasdomain) {
				standard_error('domainisaliasorothercustomer', '', true);
			}
			triggerLetsEncryptCSRForAliasDestinationDomain($aliasdomain, $this->logger());
		}

		// validate / correct path/url of domain
		$_doredirect = false;
		$path = $this->validateDomainDocumentRoot($path, $url, $customer, $result['domain'], $_doredirect);

		// set alias-fields according to selected alias mode
		$iswildcarddomain = ($selectserveralias == '0') ? '1' : '0';
		$wwwserveralias = ($selectserveralias == '1') ? '1' : '0';

		// if allowed, check for 'is email domain'-flag
		if ($result['parentdomainid'] != '0' && ($result['subcanemaildomain'] == '1' || $result['subcanemaildomain'] == '2') && $isemaildomain != $result['isemaildomain']) {
			$isemaildomain = intval($isemaildomain);
		} elseif ($result['parentdomainid'] != '0') {
			$isemaildomain = $result['subcanemaildomain'] == '3' ? 1 : 0;
		}

		// check changes of openbasedir-path variable
		if ($openbasedir_path != 1) {
			$openbasedir_path = 0;
		}

		if ($ssl_redirect != 0) {
			// a ssl-redirect only works if there actually is a
			// ssl ip/port assigned to the domain
			if (domainHasSslIpPort($result['id']) == true) {
				$ssl_redirect = '1';
				$_doredirect = true;
			} else {
				standard_error('sslredirectonlypossiblewithsslipport', '', true);
			}
		}

		if ($letsencrypt != 0) {
			// let's encrypt only works if there actually is a
			// ssl ip/port assigned to the domain
			if (domainHasSslIpPort($result['id']) == true) {
				$letsencrypt = '1';
			} else {
				standard_error('letsencryptonlypossiblewithsslipport', '', true);
			}
		}

		// We can't enable let's encrypt for wildcard - domains when using acme-v1
		if ($iswildcarddomain == '1' && $letsencrypt == '1' && Settings::Get('system.leapiversion') == '1') {
			standard_error('nowildcardwithletsencrypt');
		}
		// if using acme-v2 we cannot issue wildcard-certificates
		// because they currently only support the dns-01 challenge
		if ($iswildcarddomain == '0' && $letsencrypt == '1' && Settings::Get('system.leapiversion') == '2') {
			standard_error('nowildcardwithletsencryptv2');
		}

		// Temporarily deactivate ssl_redirect until Let's Encrypt certificate was generated
		if ($ssl_redirect > 0 && $letsencrypt == 1 && $result['letsencrypt'] != $letsencrypt) {
			$ssl_redirect = 2;
		}

		// is-email-domain flag changed - remove mail accounts and mail-addresses
		if (($result['isemaildomain'] == '1') && $isemaildomain == '0') {
			$params = array(
				"customerid" => $customer['customerid'],
				"domainid" => $id
			);
			$stmt = Database::prepare("DELETE FROM `" . TABLE_MAIL_USERS . "` WHERE `customerid`= :customerid AND `domainid`= :domainid");
			Database::pexecute($stmt, $params, true, true);
			$stmt = Database::prepare("DELETE FROM `" . TABLE_MAIL_VIRTUAL . "` WHERE `customerid`= :customerid AND `domainid`= :domainid");
			Database::pexecute($stmt, $params, true, true);
			$idna_convert = new idna_convert_wrapper();
			$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_NOTICE, "[API] automatically deleted mail-table entries for '" . $idna_convert->decode($result['domain']) . "'");
		}

		// handle redirect
		if ($_doredirect) {
			updateRedirectOfDomain($id, $redirectcode);
		}

		if ($path != $result['documentroot'] || $isemaildomain != $result['isemaildomain'] || $wwwserveralias != $result['wwwserveralias'] || $iswildcarddomain != $result['iswildcarddomain'] || $aliasdomain != $result['aliasdomain'] || $openbasedir_path != $result['openbasedir_path'] || $ssl_redirect != $result['ssl_redirect'] || $letsencrypt != $result['letsencrypt'] || $hsts_maxage != $result['hsts'] || $hsts_sub != $result['hsts_sub'] || $hsts_preload != $result['hsts_preload'] || $phpsettingid != $result['phpsettingid']) {
			$stmt = Database::prepare("
					UPDATE `" . TABLE_PANEL_DOMAINS . "` SET
					`documentroot`= :documentroot,
					`isemaildomain`= :isemaildomain,
					`wwwserveralias`= :wwwserveralias,
					`iswildcarddomain`= :iswildcarddomain,
					`aliasdomain`= :aliasdomain,
					`openbasedir_path`= :openbasedir_path,
					`ssl_redirect`= :ssl_redirect,
					`letsencrypt`= :letsencrypt,
					`hsts` = :hsts,
					`hsts_sub` = :hsts_sub,
					`hsts_preload` = :hsts_preload,
					`phpsettingid` = :phpsettingid
					WHERE `customerid`= :customerid AND `id`= :id
				");
			$params = array(
				"documentroot" => $path,
				"isemaildomain" => $isemaildomain,
				"wwwserveralias" => $wwwserveralias,
				"iswildcarddomain" => $iswildcarddomain,
				"aliasdomain" => ($aliasdomain != 0 && $alias_check == 0) ? $aliasdomain : null,
				"openbasedir_path" => $openbasedir_path,
				"ssl_redirect" => $ssl_redirect,
				"letsencrypt" => $letsencrypt,
				"hsts" => $hsts_maxage,
				"hsts_sub" => $hsts_sub,
				"hsts_preload" => $hsts_preload,
				"phpsettingid" => $phpsettingid,
				"customerid" => $customer['customerid'],
				"id" => $id
			);
			Database::pexecute($stmt, $params, true, true);

			if ($result['aliasdomain'] != $aliasdomain) {
				// trigger when domain id for alias destination has changed: both for old and new destination
				triggerLetsEncryptCSRForAliasDestinationDomain($result['aliasdomain'], $this->logger());
				triggerLetsEncryptCSRForAliasDestinationDomain($aliasdomain, $this->logger());
			} elseif ($result['wwwserveralias'] != $wwwserveralias || $result['letsencrypt'] != $letsencrypt) {
				// or when wwwserveralias or letsencrypt was changed
				triggerLetsEncryptCSRForAliasDestinationDomain($aliasdomain, $this->logger());
			}

			// check whether LE has been disabled, so we remove the certificate
			if ($letsencrypt == '0' && $result['letsencrypt'] == '1') {
				$del_stmt = Database::prepare("
						DELETE FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` WHERE `domainid` = :id
					");
				Database::pexecute($del_stmt, array(
					'id' => $id
				), true, true);
			}

			inserttask('1');
			inserttask('4');

			$idna_convert = new idna_convert_wrapper();
			$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_INFO, "[API] edited domain '" . $idna_convert->decode($result['domain']) . "'");
		}
		$result = $this->apiCall('SubDomains.get', array(
			'id' => $id
		));
		return $this->response(200, "successfull", $result);
	}

	/**
	 * lists all subdomain entries
	 *
	 * @access admin, customer
	 * @throws Exception
	 * @return array count|list
	 */
	public function listing()
	{
		if ($this->isAdmin()) {
			// if we're an admin, list all databases of all the admins customers
			// or optionally for one specific customer identified by id or loginname
			$customerid = $this->getParam('customerid', true, 0);
			$loginname = $this->getParam('loginname', true, '');

			if (! empty($customerid) || ! empty($loginname)) {
				$result = $this->apiCall('Customers.get', array(
					'id' => $customerid,
					'loginname' => $loginname
				));
				$custom_list_result = array(
					$result
				);
			} else {
				$_custom_list_result = $this->apiCall('Customers.listing');
				$custom_list_result = $_custom_list_result['list'];
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

		$result = $this->apiCall('SubDomains.get', array(
			'id' => $id,
			'domainname' => $domainname
		));
		$id = $result['id'];

		// get needed customer info to reduce the subdomain-usage-counter by one
		$customer = $this->getCustomerData();

		if (! $this->isAdmin() && $result['caneditdomain'] == 0) {
			throw new Exception("You cannot edit this resource", 405);
		}

		if ($result['isemaildomain'] == '1') {
			// check for e-mail addresses
			$emails_stmt = Database::prepare("
				SELECT COUNT(`id`) AS `count` FROM `" . TABLE_MAIL_VIRTUAL . "`
				WHERE `customerid` = :customerid AND `domainid` = :domainid
			");
			$emails = Database::pexecute_first($emails_stmt, array(
				"customerid" => $customer['customerid'],
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
			"customerid" => $customer['customerid'],
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
		// remove domains DNS from powerDNS if used, #581
		inserttask('11', $result['domain']);

		// reduce subdomain-usage-counter
		Customers::decreaseUsage($customer['customerid'], 'subdomains_used');
		// update admin usage
		Admins::decreaseUsage(($this->isAdmin() ? $customer['adminid'] : $this->getUserDetail('adminid')), 'subdomains_used');

		$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_WARNING, "[API] deleted subdomain '" . $result['domain'] . "'");
		return $this->response(200, "successfull", $result);
	}

	/**
	 * validate given path and replace with url if given and valid
	 *
	 * @param string $path
	 * @param string $url
	 * @param array $customer
	 * @param string $completedomain
	 * @param boolean $_doredirect
	 *
	 * @return string validated path
	 * @throws Exception
	 */
	private function validateDomainDocumentRoot($path = null, $url = null, $customer = null, $completedomain = null, &$_doredirect = false)
	{
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
		return $path;
	}
}
