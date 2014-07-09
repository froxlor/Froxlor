<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Panel
 *
 */

define('AREA', 'admin');
require './lib/init.php';

if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
} elseif(isset($_GET['id'])) {
	$id = intval($_GET['id']);
}

if ($page == 'domains'
   || $page == 'overview'
) {
	// Let's see how many customers we have
	$stmt = Database::prepare("
		SELECT COUNT(`customerid`) as `countcustomers` FROM `" . TABLE_PANEL_CUSTOMERS . "` " . ($userinfo['customers_see_all'] ? '' : " WHERE `adminid` = :adminid")
	);
	$params = array();
	if ($userinfo['customers_see_all'] == '0') {
		$params['adminid'] = $userinfo['adminid'];
	}
	$countcustomers = Database::pexecute_first($stmt, $params);
	$countcustomers = (int)$countcustomers['countcustomers'];

	if ($action == '') {

		$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_domains");
		$fields = array(
			'd.domain' => $lng['domains']['domainname'],
			'c.name' => $lng['customer']['name'],
			'c.firstname' => $lng['customer']['firstname'],
			'c.company' => $lng['customer']['company'],
			'c.loginname' => $lng['login']['username'],
			'd.aliasdomain' => $lng['domains']['aliasdomain']
		);
		$paging = new paging($userinfo, TABLE_PANEL_DOMAINS, $fields);
		$domains = '';
		$result_stmt = Database::prepare("
			SELECT `d`.*, `c`.`loginname`, `c`.`name`, `c`.`firstname`, `c`.`company`, `c`.`standardsubdomain`, `ad`.`id` AS `aliasdomainid`, `ad`.`domain` AS `aliasdomain`
			FROM `" . TABLE_PANEL_DOMAINS . "` `d`
			LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` `c` USING(`customerid`)
			LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `ad` ON `d`.`aliasdomain`=`ad`.`id`
			WHERE `d`.`parentdomainid`='0' " .
			($userinfo['customers_see_all'] ? '' : " AND `d`.`adminid` = :adminid ") .
			" " . $paging->getSqlWhere(true) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit()
		);
		$params = array();
		if ($userinfo['customers_see_all'] == '0') {
			$params['adminid'] = $userinfo['adminid'];
		}
		Database::pexecute($result_stmt, $params);
		$numrows_domains = Database::num_rows();
		$paging->setEntries($numrows_domains);
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$domain_array = array();

		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {

			$row['domain'] = $idna_convert->decode($row['domain']);
			$row['aliasdomain'] = $idna_convert->decode($row['aliasdomain']);

			$resultips_stmt = Database::prepare("
				SELECT `ips`.* FROM `".TABLE_DOMAINTOIP . "` AS `dti`, `".TABLE_PANEL_IPSANDPORTS."` AS `ips`
				WHERE `dti`.`id_ipandports` = `ips`.`id` AND `dti`.`id_domain` = :domainid"
			);
			Database::pexecute($resultips_stmt, array('domainid' => $row['id']));

			$row['ipandport'] = '';
			while ($rowip = $resultips_stmt->fetch(PDO::FETCH_ASSOC)) {

				if (filter_var($rowip['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
					$row['ipandport'] .= '[' . $rowip['ip'] . ']:' . $rowip['port'] . "\n";
				} else {
					$row['ipandport'] .= $rowip['ip'] . ':' . $rowip['port'] . "\n";
				}
			}
			$row['ipandport'] = substr($row['ipandport'], 0, -1);

			if (!isset($domain_array[$row['domain']])) {
				$domain_array[$row['domain']] = $row;
			} else {
				$domain_array[$row['domain']] = array_merge($row, $domain_array[$row['domain']]);
			}

			if (isset($row['aliasdomainid'])
				&& $row['aliasdomainid'] != null
				&& isset($row['aliasdomain'])
				&& $row['aliasdomain'] != ''
			) {
				if (!isset($domain_array[$row['aliasdomain']])) {
					$domain_array[$row['aliasdomain']] = array();
				}
				$domain_array[$row['aliasdomain']]['domainaliasid'] = $row['id'];
				$domain_array[$row['aliasdomain']]['domainalias'] = $row['domain'];
			}
		}

		/**
		 * We need ksort/krsort here to make sure idna-domains are also sorted correctly
		 */
		if ($paging->sortfield == 'd.domain'
			&& $paging->sortorder == 'asc'
		) {
			ksort($domain_array);
		} elseif ($paging->sortfield == 'd.domain'
			&& $paging->sortorder == 'desc'
		) {
			krsort($domain_array);
		}

		$i = 0;
		$count = 0;
		foreach ($domain_array as $row) {

			if (isset($row['domain'])
				&& $row['domain'] != ''
				&& $paging->checkDisplay($i)
			) {
				$row['customername'] = getCorrectFullUserDetails($row);
				$row = htmlentities_array($row);
				// display a nice list of IP's
				$row['ipandport'] = str_replace("\n", "<br />", $row['ipandport']);
				eval("\$domains.=\"" . getTemplate("domains/domains_domain") . "\";");
				$count++;
			}
			$i++;
		}

		$domainscount = $numrows_domains;

		// Display the list
		eval("echo \"" . getTemplate("domains/domains") . "\";");

	} elseif($action == 'delete'
		&& $id != 0
	) {

		$result_stmt = Database::prepare("
			SELECT `d`.* FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_CUSTOMERS . "` `c`
			WHERE `d`.`id` = :id AND `d`.`id` <> `c`.`standardsubdomain`" .
			($userinfo['customers_see_all'] ? '' : " AND `d`.`adminid` = :adminid")
		);
		$params = array('id' => $id);
		if ($userinfo['customers_see_all'] == '0') {
			$params['adminid'] = $userinfo['adminid'];
		}
		$result = Database::pexecute_first($result_stmt, $params);

		$alias_check_stmt = Database::prepare("
			SELECT COUNT(`id`) AS `count` FROM `" . TABLE_PANEL_DOMAINS . "`
			WHERE `aliasdomain`= :id"
		);
		$alias_check = Database::pexecute_first($alias_check_stmt, array('id' => $id));

		if ($result['domain'] != ''
			&& $alias_check['count'] == 0
		) {
			if (isset($_POST['send'])
				&& $_POST['send'] == 'send'
			) {
				// check for deletion of main-domains which are logically subdomains, #329
				$rsd_sql = '';
				$remove_subbutmain_domains = isset($_POST['delete_userfiles']) ? 1 : 0;
				if ($remove_subbutmain_domains == 1) {
					$rsd_sql .= " OR `ismainbutsubto` = :id";
				}

				$subresult_stmt = Database::prepare("
					SELECT `id` FROM `" . TABLE_PANEL_DOMAINS . "`
					WHERE (`id` = :id OR `parentdomainid` = :id ".$rsd_sql.") AND `isemaildomain` = '1'"
				);
				$subResult = Database::pexecute($subresult_stmt, array('id' => $id));
				$idString = array();
				$paramString = array();
				while ($subRow = $subresult_stmt->fetch(PDO::FETCH_ASSOC)) {
					$idString[] = "`domainid` = :domain_" . (int)$subRow['id'];
					$paramString['domain_'.$subRow['id']] = $subRow['id'];
				}

				$idString = implode(' OR ', $idString);

				if ($idString != '') {
					$del_stmt = Database::prepare("
						DELETE FROM `" . TABLE_MAIL_USERS . "` WHERE " . $idString
					);
					Database::pexecute($del_stmt, $paramString);
					$del_stmt = Database::prepare("
						DELETE FROM `" . TABLE_MAIL_VIRTUAL . "` WHERE " . $idString
					);
					Database::pexecute($del_stmt, $paramString);
					$log->logAction(ADM_ACTION, LOG_NOTICE, "deleted domain/s from mail-tables");
				}

				$del_stmt = Database::prepare("
					DELETE FROM `" . TABLE_PANEL_DOMAINS . "`
					WHERE `id` = :id OR `parentdomainid` = :id ".$rsd_sql
				);
				Database::pexecute($del_stmt, array('id' => $id));
				$deleted_domains = $del_stmt->rowCount();

				$upd_stmt = Database::prepare("
					UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET
					`subdomains_used` = `subdomains_used` - :domaincount
					WHERE `customerid` = :customerid"
				);
				Database::pexecute($upd_stmt, array('domaincount' => ($deleted_domains -1), 'customerid' => $result['customerid']));

				$upd_stmt = Database::prepare("
					UPDATE `" . TABLE_PANEL_ADMINS . "` SET
					`domains_used` = `domains_used` - 1
					WHERE `adminid` = :adminid"
				);
				Database::pexecute($upd_stmt, array('adminid' => $userinfo['adminid']));

				$upd_stmt = Database::prepare("
					UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET
					`standardsubdomain` = '0'
					WHERE `standardsubdomain` = :id AND `customerid` = :customerid"
				);
				Database::pexecute($upd_stmt, array('id' => $result['id'], 'customerid' => $result['customerid']));

				$del_stmt = Database::prepare("
					DELETE FROM `" . TABLE_DOMAINTOIP . "`
					WHERE `id_domain` = :domainid"
				);
				Database::pexecute($del_stmt, array('domainid' => $id));

				$del_stmt = Database::prepare("
					DELETE FROM `" . TABLE_PANEL_DOMAINREDIRECTS . "`
					WHERE `did` = :domainid"
				);
				Database::pexecute($del_stmt, array('domainid' => $id));

				$log->logAction(ADM_ACTION, LOG_INFO, "deleted domain/subdomains (#" . $result['id'] . ")");
				updateCounters();
				inserttask('1');

				// Using nameserver, insert a task which rebuilds the server config
				inserttask('4');

				redirectTo($filename, array('page' => $page, 's' => $s));

			} elseif ($alias_check['count'] > 0) {
				standard_error('domains_cantdeletedomainwithaliases');

			} else {

				$showcheck = false;
				if (domainHasMainSubDomains($id)) {
					$showcheck = true;
				}
				ask_yesno_withcheckbox('admin_domain_reallydelete', 'remove_subbutmain_domains', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $idna_convert->decode($result['domain']), $showcheck);
			}
		}

	} elseif($action == 'add') {

		if ($userinfo['domains_used'] < $userinfo['domains']
			|| $userinfo['domains'] == '-1'
		) {
			if (isset($_POST['send'])
				&& $_POST['send'] == 'send'
			) {

				if ($_POST['domain'] == Settings::Get('system.hostname')) {
					standard_error('admin_domain_emailsystemhostname');
					exit;
				}

				$domain = $idna_convert->encode(preg_replace(array('/\:(\d)+$/', '/^https?\:\/\//'), '', validate($_POST['domain'], 'domain')));
				$subcanemaildomain = intval($_POST['subcanemaildomain']);

				$isemaildomain = 0;
				if (isset($_POST['isemaildomain'])) {
					$isemaildomain = intval($_POST['isemaildomain']);
				}

				$email_only = 0;
				if (isset($_POST['email_only'])) {
					$email_only = intval($_POST['email_only']);
				}

				$serveraliasoption = 0;
				if (isset($_POST['selectserveralias'])) {
					$serveraliasoption = intval($_POST['selectserveralias']);
				}

				$speciallogfile = 0;
				if (isset($_POST['speciallogfile'])) {
					$speciallogfile = intval($_POST['speciallogfile']);
				}

				$aliasdomain = intval($_POST['alias']);
				$issubof = intval($_POST['issubof']);
				$customerid = intval($_POST['customerid']);
				$customer_stmt = Database::prepare("
					SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "`
					WHERE `customerid` = :customerid " .
					($userinfo['customers_see_all'] ? '' : " AND `adminid` = :adminid")
				);
				$params = array('customerid' => $customerid);
				if ($userinfo['customers_see_all'] == '0') {
					$params['adminid'] = $userinfo['adminid'];
				}
				$customer = Database::pexecute_first($customer_stmt, $params);

				if (empty($customer)
					|| $customer['customerid'] != $customerid
				) {
					standard_error('customerdoesntexist');
				}

				if ($userinfo['customers_see_all'] == '1') {

					$adminid = intval($_POST['adminid']);
					$admin_stmt = Database::prepare("
						SELECT * FROM `" . TABLE_PANEL_ADMINS . "`
						WHERE `adminid` = :adminid AND (`domains_used` < `domains` OR `domains` = '-1')"
					);
					$admin = Database::pexecute_first($admin_stmt, array('adminid' => $adminid));

					if (empty($admin)
						|| $admin['adminid'] != $adminid
					) {
						standard_error('admindoesntexist');
					}

				} else {
					$adminid = $userinfo['adminid'];
					$admin = $userinfo;
				}

				// set default path if admin/reseller has "change_serversettings == false" but we still
				// need to respect the documentroot_use_default_value - setting
				$path_suffix = '';
				if (Settings::Get('system.documentroot_use_default_value') == 1) {
					$path_suffix = '/'.$domain;
				}
				$documentroot = makeCorrectDir($customer['documentroot'] . $path_suffix);

				$registration_date = trim($_POST['registration_date']);
				$registration_date = validate($registration_date, 'registration_date', '/^(19|20)\d\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$/', '', array('0000-00-00', '0', ''));

				if ($userinfo['change_serversettings'] == '1') {

					$caneditdomain = isset($_POST['caneditdomain']) ? intval($_POST['caneditdomain']) : 0;

					$isbinddomain = '0';
					$zonefile = '';
					if (Settings::Get('system.bind_enable') == '1') {
						if (isset($_POST['isbinddomain'])) {
							$isbinddomain = intval($_POST['isbinddomain']);
						}
						$zonefile = validate($_POST['zonefile'], 'zonefile');
					}

					if (isset($_POST['dkim'])) {
						$dkim = intval($_POST['dkim']);
					} else {
						$dkim = '1';
					}

					$specialsettings = validate(str_replace("\r\n", "\n", $_POST['specialsettings']), 'specialsettings', '/^[^\0]*$/');
					validate($_POST['documentroot'], 'documentroot');

					// If path is empty and 'Use domain name as default value for DocumentRoot path' is enabled in settings,
					// set default path to subdomain or domain name
					if (isset($_POST['documentroot'])
						&& $_POST['documentroot'] != ''
					) {
						if (substr($_POST['documentroot'], 0, 1) != '/'
							&& !preg_match('/^https?\:\/\//', $_POST['documentroot'])
						) {
							$documentroot.= '/' . $_POST['documentroot'];
						} else {
							$documentroot = $_POST['documentroot'];
						}
					} elseif (isset($_POST['documentroot'])
						&& ($_POST['documentroot'] == '') 
						&& (Settings::Get('system.documentroot_use_default_value') == 1)
					) {
						$documentroot = makeCorrectDir($customer['documentroot'] . '/' . $domain);
					}

				} else {
					$isbinddomain = '0';
					if (Settings::Get('system.bind_enable') == '1') {
						$isbinddomain = '1';
					}
					$caneditdomain = '1';
					$zonefile = '';
					$dkim = '1';
					$specialsettings = '';
				}

				if ($userinfo['caneditphpsettings'] == '1'
					|| $userinfo['change_serversettings'] == '1'
				) {

					$openbasedir = isset($_POST['openbasedir']) ? intval($_POST['openbasedir']) : 0;

					if ((int)Settings::Get('system.mod_fcgid') == 1
						|| (int)Settings::Get('phpfpm.enabled') == 1
					) {
						$phpsettingid = (int)$_POST['phpsettingid'];
						$phpsettingid_check_stmt = Database::prepare("
							SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "`
							WHERE `id` = :phpsettingid"
						);
						$phpsettingid_check = Database::pexecute_first($phpsettingid_check_stmt, array('phpsettingid' => $phpsettingid));

						if (!isset($phpsettingid_check['id'])
							|| $phpsettingid_check['id'] == '0'
							|| $phpsettingid_check['id'] != $phpsettingid
						) {
							standard_error('phpsettingidwrong');
						}

						if ((int)Settings::Get('system.mod_fcgid') == 1) {
							$mod_fcgid_starter = validate($_POST['mod_fcgid_starter'], 'mod_fcgid_starter', '/^[0-9]*$/', '', array('-1', ''));
							$mod_fcgid_maxrequests = validate($_POST['mod_fcgid_maxrequests'], 'mod_fcgid_maxrequests', '/^[0-9]*$/', '', array('-1', ''));
						} else {
							$mod_fcgid_starter = '-1';
							$mod_fcgid_maxrequests = '-1';
						}

					} else {

						if ((int)Settings::Get('phpfpm.enabled') == 1) {
							$phpsettingid = Settings::Get('phpfpm.defaultini');
						} else {
							$phpsettingid = Settings::Get('system.mod_fcgid_defaultini');
						}
						$mod_fcgid_starter = '-1';
						$mod_fcgid_maxrequests = '-1';
					}

				} else {

					$openbasedir = '1';
					if ((int)Settings::Get('phpfpm.enabled') == 1) {
						$phpsettingid = Settings::Get('phpfpm.defaultini');
					} else {
						$phpsettingid = Settings::Get('system.mod_fcgid_defaultini');
					}
					$mod_fcgid_starter = '-1';
					$mod_fcgid_maxrequests = '-1';
				}

				if ($userinfo['ip'] != "-1") {
					$admin_ip_stmt = Database::prepare("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "`
						WHERE `id` = :id ORDER BY `ip`, `port` ASC"
					);
					$admin_ip = Database::pexecute_first($admin_ip_stmt, array('id' => $userinfo['ip']));
					$additional_ip_condition = " AND `ip` = :adminip ";
					$aip_param = array('adminip' => $admin_ip['ip']);
				} else {
					$additional_ip_condition = '';
					$aip_param = array();
				}

				$ipandports = array();
				if (isset($_POST['ipandport']) && !is_array($_POST['ipandport'])) {
					$_POST['ipandport'] = unserialize($_POST['ipandport']);
				}

				if (isset($_POST['ipandport']) && is_array($_POST['ipandport'])) {
					foreach($_POST['ipandport'] as $ipandport) {
						$ipandport = intval($ipandport);
						$ipandport_check_stmt = Database::prepare("
							SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "`
							WHERE `id` = :id " . $additional_ip_condition
						);
						$ip_params = null;
						$ip_params = array_merge(array('id' => $ipandport), $aip_param);
						$ipandport_check = Database::pexecute_first($ipandport_check_stmt, $ip_params);

						if (!isset($ipandport_check['id'])
							|| $ipandport_check['id'] == '0'
							|| $ipandport_check['id'] != $ipandport
						) {
							standard_error('ipportdoesntexist');
						} else {
							$ipandports[] = $ipandport;
						}
					}
				}

				if (Settings::Get('system.use_ssl') == "1"
					&& isset($_POST['ssl_ipandport'])
				) {
					$ssl_redirect = 0;
					if (isset($_POST['ssl_redirect'])) {
						$ssl_redirect = (int)$_POST['ssl_redirect'];
					}

					$ssl_ipandports = array();
					if (isset($_POST['ssl_ipandport']) && !is_array($_POST['ssl_ipandport'])) {
						$_POST['ssl_ipandport'] = unserialize($_POST['ssl_ipandport']);
					}

					// Verify SSL-Ports
					if (isset($_POST['ssl_ipandport']) && is_array($_POST['ssl_ipandport'])) {
						foreach ($_POST['ssl_ipandport'] as $ssl_ipandport) {
							if (trim($ssl_ipandport) == "") continue;
							// fix if no ssl-ip/port is checked
							if (trim($ssl_ipandport) < 1) continue;
							$ssl_ipandport = intval($ssl_ipandport);
							$ssl_ipandport_check_stmt = Database::prepare("
								SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "`
								WHERE `id` = :id " . $additional_ip_condition
							);
							$ip_params = null;
							$ip_params = array_merge(array('id' => $ssl_ipandport), $aip_param);
							$ssl_ipandport_check = Database::pexecute_first($ssl_ipandport_check_stmt, $ip_params);

							if (!isset($ssl_ipandport_check['id'])
								|| $ssl_ipandport_check['id'] == '0'
								|| $ssl_ipandport_check['id'] != $ssl_ipandport
							) {
								standard_error('ipportdoesntexist');
							} else {
								$ssl_ipandports[] = $ssl_ipandport;
							}
						}
					} else {
						$ssl_redirect = 0;
						// we need this for the serialize
						// if ssl is disabled or no ssl-ip/port exists
						$ssl_ipandports[] = -1;
					}
				} else {
					$ssl_redirect = 0;
					// we need this for the serialize
					// if ssl is disabled or no ssl-ip/port exists
					$ssl_ipandports[] = -1;
				}

				if (!preg_match('/^https?\:\/\//', $documentroot)) {
					if (strstr($documentroot, ":") !== false) {
						standard_error('pathmaynotcontaincolon');
					} else {
						$documentroot = makeCorrectDir($documentroot);
					}
				}

				$domain_check_stmt = Database::prepare("
					SELECT `id`, `domain` FROM `" . TABLE_PANEL_DOMAINS . "`
					WHERE `domain` = :domain"
				);
				$domain_check = Database::pexecute_first($domain_check_stmt, array('domain' => strtolower($domain)));

				$aliasdomain_check = array(
					'id' => 0
				);

				if ($aliasdomain != 0) {
					// Overwrite given ipandports with these of the "main" domain
					$ipandports = array();
					$origipresult_stmt = Database::prepare("
						SELECT `id_ipandports` FROM `" . TABLE_DOMAINTOIP ."`
						WHERE `id_domain` = :id"
					);
					Database::pexecute($origipresult_stmt, array('id' => $aliasdomain));

					while ($origip = $origipresult_stmt->fetch(PDO::FETCH_ASSOC)) {
						$ipandports[] = $origip['id_ipandports'];
					}

					$aliasdomain_check_stmt = Database::prepare("
						SELECT `d`.`id` FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_CUSTOMERS . "` `c`
						WHERE `d`.`customerid` = :customerid
						AND `d`.`aliasdomain` IS NULL AND `d`.`id` <> `c`.`standardsubdomain`
						AND `c`.`customerid` = :customerid
						AND `d`.`id` = :aliasdomainid"
					);
					$alias_params = array('customerid' => $customerid, 'aliasdomainid' => $aliasdomain);
					$aliasdomain_check = Database::pexecute_first($aliasdomain_check_stmt, $alias_params);
				}

				if (count($ipandports) == 0) {
					standard_error('noipportgiven');
				}

				if ($openbasedir != '1') {
					$openbasedir = '0';
				}

				if ($speciallogfile != '1') {
					$speciallogfile = '0';
				}

				if ($isbinddomain != '1') {
					$isbinddomain = '0';
				}

				if ($isemaildomain != '1') {
					$isemaildomain = '0';
				}

				if ($email_only == '1') {
					$isemaildomain = '1';
				} else {
					$email_only = '0';
				}

				if ($subcanemaildomain != '1'
					&& $subcanemaildomain != '2'
					&& $subcanemaildomain != '3'
				) {
					$subcanemaildomain = '0';
				}

				if ($dkim != '1') {
					$dkim = '0';
				}

				if ($serveraliasoption != '1' && $serveraliasoption != '2') {
					$serveraliasoption = '0';
				}

				if ($caneditdomain != '1') {
					$caneditdomain = '0';
				}

				if ($issubof <= '0') {
					$issubof = '0';
				}

				if ($domain == '') {
					standard_error(array('stringisempty', 'mydomain'));
				}
				// Check whether domain validation is enabled and if, validate the domain
				elseif (Settings::Get('system.validate_domain') && !validateDomain($domain)) {
					standard_error(array('stringiswrong', 'mydomain'));
				} elseif($documentroot == '') {
					standard_error(array('stringisempty', 'mydocumentroot'));
				} elseif($customerid == 0) {
					standard_error('adduserfirst');
				} elseif(strtolower($domain_check['domain']) == strtolower($domain)) {
					standard_error('domainalreadyexists', $idna_convert->decode($domain));
				} elseif($aliasdomain_check['id'] != $aliasdomain) {
					standard_error('domainisaliasorothercustomer');
				} else {
					$params = array(
						'page' => $page,
						'action' => $action,
						'domain' => $domain,
						'customerid' => $customerid,
						'adminid' => $adminid,
						'documentroot' => $documentroot,
						'alias' => $aliasdomain,
						'isbinddomain' => $isbinddomain,
						'isemaildomain' => $isemaildomain,
						'email_only' => $email_only,
						'subcanemaildomain' => $subcanemaildomain,
						'caneditdomain' => $caneditdomain,
						'zonefile' => $zonefile,
						'dkim' => $dkim,
						'speciallogfile' => $speciallogfile,
						'selectserveralias' => $serveraliasoption,
						'ipandport' => serialize($ipandports),
						'ssl_redirect' => $ssl_redirect,
						'ssl_ipandport' => serialize($ssl_ipandports),
						'openbasedir' => $openbasedir,
						'phpsettingid' => $phpsettingid,
						'mod_fcgid_starter' => $mod_fcgid_starter,
						'mod_fcgid_maxrequests' => $mod_fcgid_maxrequests,
						'specialsettings' => $specialsettings,
						'registration_date' => $registration_date,
						'issubof' => $issubof
					);

					$security_questions = array(
						'reallydisablesecuritysetting' => ($openbasedir == '0' && $userinfo['change_serversettings'] == '1'),
						'reallydocrootoutofcustomerroot' => (substr($documentroot, 0, strlen($customer['documentroot'])) != $customer['documentroot'] && !preg_match('/^https?\:\/\//', $documentroot))
					);
					$question_nr = 1;
					foreach ($security_questions as $question_name => $question_launch) {
						if ($question_launch !== false) {
							$params[$question_name] = $question_name;

							if (!isset($_POST[$question_name])
								|| $_POST[$question_name] != $question_name
							) {
								ask_yesno('admin_domain_' . $question_name, $filename, $params, $question_nr);
								exit;
							}
						}
						$question_nr++;
					}

					$wwwserveralias = ($serveraliasoption == '1') ? '1' : '0';
					$iswildcarddomain = ($serveraliasoption == '0') ? '1' : '0';

					$ins_data = array(
						'domain' => $domain,
						'customerid' => $customerid,
						'adminid' => $adminid,
						'documentroot' => $documentroot,
						'aliasdomain' => ($aliasdomain != 0 ? $aliasdomain : null),
						'zonefile' => $zonefile,
						'dkim' => $dkim,
						'wwwserveralias' => $wwwserveralias,
						'iswildcarddomain' => $iswildcarddomain,
						'isbinddomain' => $isbinddomain,
						'isemaildomain' => $isemaildomain,
						'email_only' => $email_only,
						'subcanemaildomain' => $subcanemaildomain,
						'caneditdomain' => $caneditdomain,
						'openbasedir' => $openbasedir,
						'speciallogfile' => $speciallogfile,
						'specialsettings' => $specialsettings,
						'ssl_redirect' => $ssl_redirect,
						'add_date' => time(),
						'registration_date' => $registration_date,
						'phpsettingid' => $phpsettingid,
						'mod_fcgid_starter' => $mod_fcgid_starter,
						'mod_fcgid_maxrequests' => $mod_fcgid_maxrequests,
						'ismainbutsubto' => $issubof
					);

					$ins_stmt = Database::prepare("
						INSERT INTO `" . TABLE_PANEL_DOMAINS . "` SET
						`domain` = :domain,
						`customerid` = :customerid,
						`adminid` = :adminid,
						`documentroot` = :documentroot,
						`aliasdomain` = :aliasdomain,
						`zonefile` = :zonefile,
						`dkim` = :dkim,
						`dkim_id` = '0',
						`dkim_privkey` = '',
						`dkim_pubkey` = '',
						`wwwserveralias` = :wwwserveralias,
						`iswildcarddomain` = :iswildcarddomain,
						`isbinddomain` = :isbinddomain,
						`isemaildomain` = :isemaildomain,
						`email_only` = :email_only,
						`subcanemaildomain` = :subcanemaildomain,
						`caneditdomain` = :caneditdomain,
						`openbasedir` = :openbasedir,
						`speciallogfile` = :speciallogfile,
						`specialsettings` = :specialsettings,
						`ssl_redirect` = :ssl_redirect,
						`add_date` = :add_date,
						`registration_date` = :registration_date,
						`phpsettingid` = :phpsettingid,
						`mod_fcgid_starter` = :mod_fcgid_starter,
						`mod_fcgid_maxrequests` = :mod_fcgid_maxrequests,
						`ismainbutsubto` = :ismainbutsubto
					");
					Database::pexecute($ins_stmt, $ins_data);
					$domainid = Database::lastInsertId();

					$upd_stmt = Database::prepare("
						UPDATE `" . TABLE_PANEL_ADMINS . "` SET `domains_used` = `domains_used` + 1
						WHERE `adminid` = :adminid"
					);
					Database::pexecute($upd_stmt, array('adminid' => $adminid));

					foreach ($ipandports as $ipportid) {
						$ins_data = array(
							'domainid' => $domainid,
							'ipandportsid' => $ipportid
						);
						$ins_stmt = Database::prepare("
							INSERT INTO `" . TABLE_DOMAINTOIP . "` SET
							`id_domain` = :domainid,
							`id_ipandports` = :ipandportsid
						");
						Database::pexecute($ins_stmt, $ins_data);
					}

					foreach ($ssl_ipandports as $ssl_ipportid) {
						if ($ssl_ipportid > 0) {
							$ins_data = array(
								'domainid' => $domainid,
								'ipandportsid' => $ssl_ipportid
							);
							$ins_stmt = Database::prepare("
								INSERT INTO `" . TABLE_DOMAINTOIP . "` SET
								`id_domain` = :domainid,
								`id_ipandports` = :ipandportsid
							");
							Database::pexecute($ins_stmt, $ins_data);
						}
					}
					$log->logAction(ADM_ACTION, LOG_INFO, "added domain '" . $domain . "'");
					inserttask('1');

					// Using nameserver, insert a task which rebuilds the server config
					inserttask('4');

					redirectTo($filename, array('page' => $page, 's' => $s));
				}

			} else {

				$customers = makeoption($lng['panel']['please_choose'], 0, 0, true);
				$result_customers_stmt = Database::prepare("
					SELECT `customerid`, `loginname`, `name`, `firstname`, `company`
					FROM `" . TABLE_PANEL_CUSTOMERS . "` " .
					($userinfo['customers_see_all'] ? '' : " WHERE `adminid` = '" . (int)$userinfo['adminid'] . "' ") .
					" ORDER BY `name` ASC"
				);
				$params = array();
				if ($userinfo['customers_see_all'] == '0') {
					$params['adminid'] = $userinfo['adminid'];
				}
				Database::pexecute($result_customers_stmt, $params);

				while ($row_customer = $result_customers_stmt->fetch(PDO::FETCH_ASSOC)) {
					$customers.= makeoption(getCorrectFullUserDetails($row_customer) . ' (' . $row_customer['loginname'] . ')', $row_customer['customerid']);
				}

				$admins = '';
				if ($userinfo['customers_see_all'] == '1') {

					$result_admins_stmt = Database::query("
						SELECT `adminid`, `loginname`, `name`
						FROM `" . TABLE_PANEL_ADMINS . "`
						WHERE `domains_used` < `domains` OR `domains` = '-1' ORDER BY `name` ASC"
					);

					while ($row_admin = $result_admins_stmt->fetch(PDO::FETCH_ASSOC)) {
						$admins.= makeoption(getCorrectFullUserDetails($row_admin) . ' (' . $row_admin['loginname'] . ')', $row_admin['adminid'], $userinfo['adminid']);
					}
				}

				if ($userinfo['ip'] == "-1") {
					$result_ipsandports_stmt = Database::query("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ssl`='0' ORDER BY `ip`, `port` ASC
					");
					$result_ssl_ipsandports_stmt = Database::query("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ssl`='1' ORDER BY `ip`, `port` ASC
					");
				} else {
					$admin_ip_stmt = Database::prepare("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `id` = :ipid ORDER BY `ip`, `port` ASC
					");
					$admin_ip = Database::pexecute_first($admin_ip_stmt, array('ipid' => $userinfo['ip']));

					$result_ipsandports_stmt = Database::prepare("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ssl`='0' AND `ip` = :ipid ORDER BY `ip`, `port` ASC
					");
					Database::pexecute($result_ipsandports_stmt, array('ipid' => $admin_ip['ip']));

					$result_ssl_ipsandports_stmt = Database::prepare("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ssl`='1' AND `ip` = :ipid ORDER BY `ip`, `port` ASC
					");
					Database::pexecute($result_ssl_ipsandports_stmt, array('ipid' => $admin_ip['ip']));
				}

				// Build array holding all IPs and Ports available to this admin
				$ipsandports = array();
				while ($row_ipandport = $result_ipsandports_stmt->fetch(PDO::FETCH_ASSOC)) {

					if (filter_var($row_ipandport['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
						$row_ipandport['ip'] = '[' . $row_ipandport['ip'] . ']';
					}

					$ipsandports[] = array('label' => $row_ipandport['ip'] . ':' . $row_ipandport['port'] . '<br />', 'value' => $row_ipandport['id']);
				}

				$ssl_ipsandports = array();
				while ($row_ssl_ipandport = $result_ssl_ipsandports_stmt->fetch(PDO::FETCH_ASSOC)) {

					if (filter_var($row_ssl_ipandport['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
						$row_ssl_ipandport['ip'] = '[' . $row_ssl_ipandport['ip'] . ']';
					}

					$ssl_ipsandports[] = array('label' => $row_ssl_ipandport['ip'] . ':' . $row_ssl_ipandport['port'] . '<br />', 'value' => $row_ssl_ipandport['id']);
				}

				$standardsubdomains = array();
				$result_standardsubdomains_stmt = Database::query("
					SELECT `id` FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_CUSTOMERS . "` `c` WHERE `d`.`id` = `c`.`standardsubdomain`
				");

				while ($row_standardsubdomain = $result_standardsubdomains_stmt->fetch(PDO::FETCH_ASSOC)) {
					$standardsubdomains[] = $row_standardsubdomain['id'];
				}

				if (count($standardsubdomains) > 0) {
					$standardsubdomains = " AND `d`.`id` NOT IN (" . join(',', $standardsubdomains) . ") ";
				} else {
					$standardsubdomains = '';
				}

				$domains = makeoption($lng['domains']['noaliasdomain'], 0, NULL, true);
				$result_domains_stmt = Database::prepare("
					SELECT `d`.`id`, `d`.`domain`, `c`.`loginname` FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_CUSTOMERS . "` `c`
					WHERE `d`.`aliasdomain` IS NULL AND `d`.`parentdomainid` = 0" . $standardsubdomains .
					($userinfo['customers_see_all'] ? '' : " AND `d`.`adminid` = :adminid") . "
					AND `d`.`customerid`=`c`.`customerid` ORDER BY `loginname`, `domain` ASC
				");
				$params = array();
				if ($userinfo['customers_see_all'] == '0') {
					$params['adminid'] = $userinfo['adminid'];
				}
				Database::pexecute($result_domains_stmt, $params);

				while ($row_domain = $result_domains_stmt->fetch(PDO::FETCH_ASSOC)) {
					$domains.= makeoption($idna_convert->decode($row_domain['domain']) . ' (' . $row_domain['loginname'] . ')', $row_domain['id']);
				}

				$subtodomains = makeoption($lng['domains']['nosubtomaindomain'], 0, NULL, true);
				$result_domains_stmt = Database::prepare("
					SELECT `d`.`id`, `d`.`domain`, `c`.`loginname` FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_CUSTOMERS . "` `c`
					WHERE `d`.`aliasdomain` IS NULL AND `d`.`parentdomainid` = 0 AND `d`.`ismainbutsubto` = 0 " . $standardsubdomains .
					($userinfo['customers_see_all'] ? '' : " AND `d`.`adminid` = :adminid") . "
					AND `d`.`customerid`=`c`.`customerid` ORDER BY `loginname`, `domain` ASC
				");
				// params from above still valid
				Database::pexecute($result_domains_stmt, $params);

				while ($row_domain = $result_domains_stmt->fetch(PDO::FETCH_ASSOC)) {
					$subtodomains.= makeoption($idna_convert->decode($row_domain['domain']) . ' (' . $row_domain['loginname'] . ')', $row_domain['id']);
				}

				$phpconfigs = '';
				$configs = Database::query("SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "`");

				while ($row = $configs->fetch(PDO::FETCH_ASSOC)) {
					if ((int)Settings::Get('phpfpm.enabled') == 1) {
						$phpconfigs.= makeoption($row['description'], $row['id'], Settings::Get('phpfpm.defaultini'), true, true);
					} else {
						$phpconfigs.= makeoption($row['description'], $row['id'], Settings::Get('system.mod_fcgid_defaultini'), true, true);
					}
				}

				// create serveralias options
				$serveraliasoptions = "";
				$serveraliasoptions .= makeoption($lng['domains']['serveraliasoption_wildcard'], '0', '0', true, true);
				$serveraliasoptions .= makeoption($lng['domains']['serveraliasoption_www'], '1', '0', true, true);
				$serveraliasoptions .= makeoption($lng['domains']['serveraliasoption_none'], '2', '0', true, true);

				$subcanemaildomain = makeoption($lng['admin']['subcanemaildomain']['never'], '0', '0', true, true);
				$subcanemaildomain.= makeoption($lng['admin']['subcanemaildomain']['choosableno'], '1', '0', true, true);
				$subcanemaildomain.= makeoption($lng['admin']['subcanemaildomain']['choosableyes'], '2', '0', true, true);
				$subcanemaildomain.= makeoption($lng['admin']['subcanemaildomain']['always'], '3', '0', true, true);

				$add_date = date('Y-m-d');

				$domain_add_data = include_once dirname(__FILE__).'/lib/formfields/admin/domains/formfield.domains_add.php';
				$domain_add_form = htmlform::genHTMLForm($domain_add_data);

				$title = $domain_add_data['domain_add']['title'];
				$image = $domain_add_data['domain_add']['image'];

				eval("echo \"" . getTemplate("domains/domains_add") . "\";");
			}
		}

	} elseif($action == 'edit'
		&& $id != 0
	) {

		$result_stmt = Database::prepare("
			SELECT `d`.*, `c`.`customerid` FROM `" . TABLE_PANEL_DOMAINS . "` `d` LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` `c` USING(`customerid`)
			WHERE `d`.`parentdomainid` = '0' AND `d`.`id` = :id" .
			($userinfo['customers_see_all'] ? '' : " AND `d`.`adminid` = :adminid")
		);
		$params = array('id' => $id);
		if ($userinfo['customers_see_all'] == '0') {
			$params['adminid'] = $userinfo['adminid'];
		}
		$result = Database::pexecute_first($result_stmt, $params);

		if ($result['domain'] != '') {

			$subdomains_stmt = Database::prepare("
				SELECT COUNT(`id`) AS count FROM `" . TABLE_PANEL_DOMAINS . "` WHERE
				`parentdomainid` = :resultid
			");
			$subdomains = Database::pexecute_first($subdomains_stmt, array('resultid' => $result['id']));
			$subdomains = $subdomains['count'];

			$alias_check_stmt = Database::prepare("
				SELECT COUNT(`id`) AS count FROM `" . TABLE_PANEL_DOMAINS . "` WHERE
				`aliasdomain` = :resultid
			");
			$alias_check = Database::pexecute_first($alias_check_stmt, array('resultid' => $result['id']));
			$alias_check = $alias_check['count'];

			$domain_emails_result_stmt = Database::prepare("
				SELECT `email`, `email_full`, `destination`, `popaccountid` AS `number_email_forwarders`
				FROM `" . TABLE_MAIL_VIRTUAL . "` WHERE `customerid` = :customerid AND `domainid` = :id
			");
			Database::pexecute($domain_emails_result_stmt, array('customerid' => $result['customerid'], 'id' => $result['id']));

			$emails = Database::num_rows();
			$email_forwarders = 0;
			$email_accounts = 0;

			while ($domain_emails_row = $domain_emails_result_stmt->fetch(PDO::FETCH_ASSOC)) {

				if ($domain_emails_row['destination'] != '') {

					$domain_emails_row['destination'] = explode(' ', makeCorrectDestination($domain_emails_row['destination']));
					$email_forwarders+= count($domain_emails_row['destination']);

					if (in_array($domain_emails_row['email_full'], $domain_emails_row['destination'])) {
						$email_forwarders-= 1;
						$email_accounts++;
					}
				}
			}

			$ipsresult_stmt = Database::prepare("
				SELECT `id_ipandports` FROM `" . TABLE_DOMAINTOIP . "` WHERE `id_domain` = :id
			");
			Database::pexecute($ipsresult_stmt, array('id' => $result['id']));

			$usedips = array();
			while ($ipsresultrow = $ipsresult_stmt->fetch(PDO::FETCH_ASSOC)) {
				$usedips[] = $ipsresultrow['id_ipandports'];
			}

			if (isset($_POST['send'])
				&& $_POST['send'] == 'send'
			) {

				$customer_stmt = Database::prepare("
					SELECT * FROM " . TABLE_PANEL_CUSTOMERS . " WHERE `customerid` = :customerid
				");
				$customer = Database::pexecute_first($customer_stmt, array('customerid' => $result['customerid']));

				$customerid = -1;
				if (isset($_POST['customerid'])) {
					$customerid = intval($_POST['customerid']);
				}

				if ($customerid > 0
					&& $customerid != $result['customerid']
					&& Settings::Get('panel.allow_domain_change_customer') == '1'
				) {

					$customer_stmt = Database::prepare("
						SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "`
						WHERE `customerid` = :customerid
						AND (`subdomains_used` + :subdomains <= `subdomains` OR `subdomains` = '-1' )
						AND (`emails_used` + :emails <= `emails` OR `emails` = '-1' )
						AND (`email_forwarders_used` + :forwarders <= `email_forwarders` OR `email_forwarders` = '-1' )
						AND (`email_accounts_used` + :accounts <= `email_accounts` OR `email_accounts` = '-1' ) " .
						($userinfo['customers_see_all'] ? '' : " AND `adminid` = :adminid")
					);

					$params = array(
						'customerid' => $customerid,
						'subdomains' => $subdomains,
						'emails' => $emails,
						'forwarders' => $email_forwarders,
						'accounts' => $email_accounts
					);
					if ($userinfo['customers_see_all'] == '0') {
						$params['adminid'] = $userinfo['adminid'];
					}

					$customer = Database::pexecute_first($customer_stmt, $params);
					if (empty($customer)
						|| $customer['customerid'] != $customerid
					) {
						standard_error('customerdoesntexist');
					}
				} else {
					$customerid = $result['customerid'];
				}

				$customer_stmt = Database::prepare("
					SELECT * FROM " . TABLE_PANEL_ADMINS . " WHERE `adminid` = :adminid
				");
				$admin = Database::pexecute_first($customer_stmt, array('adminid' => $result['adminid']));

				if ($userinfo['customers_see_all'] == '1') {

					$adminid = -1;
					if (isset($_POST['adminid'])) {
						$adminid = intval($_POST['adminid']);
					}

					if ($adminid > 0
						&& $adminid != $result['adminid']
						&& Settings::Get('panel.allow_domain_change_admin') == '1'
					) {

						$admin_stmt = Database::prepare("
							SELECT * FROM `" . TABLE_PANEL_ADMINS . "`
							WHERE `adminid` = :adminid AND ( `domains_used` < `domains` OR `domains` = '-1' )
						");
						$admin = Database::pexecute_first($admin_stmt, array('adminid' => $adminid));

						if (empty($admin)
							|| $admin['adminid'] != $adminid
						) {
							standard_error('admindoesntexist');
						}
					} else {
						$adminid = $result['adminid'];
					}
				} else {
					$adminid = $result['adminid'];
				}

				$aliasdomain = intval($_POST['alias']);
				$issubof = intval($_POST['issubof']);
				$subcanemaildomain = intval($_POST['subcanemaildomain']);
				$caneditdomain = isset($_POST['caneditdomain']) ? intval($_POST['caneditdomain']) : 0;
				$registration_date = trim($_POST['registration_date']);
				$registration_date = validate($registration_date, 'registration_date', '/^(19|20)\d\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$/', '', array('0000-00-00', '0', ''));

				$isemaildomain = 0;
				if (isset($_POST['isemaildomain'])) {
					$isemaildomain = intval($_POST['isemaildomain']);
				}

				$email_only = 0;
				if (isset($_POST['email_only'])) {
					$email_only = intval($_POST['email_only']);
				}

				$serveraliasoption = '2';
				if ($result['iswildcarddomain'] == '1') {
					$serveraliasoption = '0';
				} elseif ($result['wwwserveralias'] == '1') {
					$serveraliasoption = '1';
				}
				if (isset($_POST['selectserveralias'])) {
					$serveraliasoption = intval($_POST['selectserveralias']);
				}

				$speciallogfile = 0;
				if(isset($_POST['speciallogfile']))
					$speciallogfile = intval($_POST['speciallogfile']);


				if ($userinfo['change_serversettings'] == '1') {
					$isbinddomain = $result['isbinddomain'];
					$zonefile = $result['zonefile'];
					if (Settings::Get('system.bind_enable') == '1') {
						if (isset($_POST['isbinddomain'])) {
							$isbinddomain = (int)$_POST['isbinddomain'];
						} else {
							$isbinddomain = 0;
						}
						$zonefile = validate($_POST['zonefile'], 'zonefile');
					}

					if (Settings::Get('dkim.use_dkim') == '1') {
						$dkim = isset($_POST['dkim']) ? 1 : 0;
					} else {
						$dkim = $result['dkim'];
					}

					$specialsettings = validate(str_replace("\r\n", "\n", $_POST['specialsettings']), 'specialsettings', '/^[^\0]*$/');
					$documentroot = validate($_POST['documentroot'], 'documentroot');

					if ($documentroot == '') {
						// If path is empty and 'Use domain name as default value for DocumentRoot path' is enabled in settings,
						// set default path to subdomain or domain name
						if (Settings::Get('system.documentroot_use_default_value') == 1) {
							$documentroot = makeCorrectDir($customer['documentroot'] . '/' . $result['domain']);
						} else {
							$documentroot = $customer['documentroot'];
						}
					}

					if (!preg_match('/^https?\:\/\//', $documentroot)
						&& strstr($documentroot, ":") !== false
					) {
						standard_error('pathmaynotcontaincolon');
					}

				} else {
					$isbinddomain = $result['isbinddomain'];
					$zonefile = $result['zonefile'];
					$dkim = $result['dkim'];
					$specialsettings = $result['specialsettings'];
					$documentroot = $result['documentroot'];
				}

				$speciallogverified = (isset($_POST['speciallogverified']) ? (int)$_POST['speciallogverified'] : 0);

				if ($userinfo['caneditphpsettings'] == '1'
					|| $userinfo['change_serversettings'] == '1'
				) {

					$openbasedir = isset($_POST['openbasedir']) ? intval($_POST['openbasedir']) : 0;

					if ((int)Settings::Get('system.mod_fcgid') == 1
						|| (int)Settings::Get('phpfpm.enabled') == 1
					) {
						$phpsettingid = (int)$_POST['phpsettingid'];
						$phpsettingid_check_stmt = Database::prepare("
							SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "` WHERE `id` = :phpid
						");
						$phpsettingid_check = Database::pexecute_first($phpsettingid_check_stmt, array('phpid' => $phpsettingid));

						if (!isset($phpsettingid_check['id'])
							|| $phpsettingid_check['id'] == '0'
							|| $phpsettingid_check['id'] != $phpsettingid
						) {
							standard_error('phpsettingidwrong');
						}

						if ((int)Settings::Get('system.mod_fcgid') == 1) {
							$mod_fcgid_starter = validate($_POST['mod_fcgid_starter'], 'mod_fcgid_starter', '/^[0-9]*$/', '', array('-1', ''));
							$mod_fcgid_maxrequests = validate($_POST['mod_fcgid_maxrequests'], 'mod_fcgid_maxrequests', '/^[0-9]*$/', '', array('-1', ''));
						} else {
							$mod_fcgid_starter = $result['mod_fcgid_starter'];
							$mod_fcgid_maxrequests = $result['mod_fcgid_maxrequests'];
						}

					} else {
						$phpsettingid = $result['phpsettingid'];
						$mod_fcgid_starter = $result['mod_fcgid_starter'];
						$mod_fcgid_maxrequests = $result['mod_fcgid_maxrequests'];
					}

				} else {
					$openbasedir = $result['openbasedir'];
					$phpsettingid = $result['phpsettingid'];
					$mod_fcgid_starter = $result['mod_fcgid_starter'];
					$mod_fcgid_maxrequests = $result['mod_fcgid_maxrequests'];
				}

				$ipandports = array();
				if (isset($_POST['ipandport']) && !is_array($_POST['ipandport'])) {
					$_POST['ipandport'] = unserialize($_POST['ipandport']);
				}
				if (isset($_POST['ipandport']) && is_array($_POST['ipandport'])) {

					$ipandport_check_stmt = Database::prepare("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `id` = :ipandport
					");
					foreach ($_POST['ipandport'] as $ipandport) {
						if (trim($ipandport) == "") continue;
						$ipandport = intval($ipandport);
						$ipandport_check = Database::pexecute_first($ipandport_check_stmt, array('ipandport' => $ipandport));
						if (!isset($ipandport_check['id'])
							|| $ipandport_check['id'] == '0'
							|| $ipandport_check['id'] != $ipandport
						) {
							standard_error('ipportdoesntexist');
						} else {
							$ipandports[] = $ipandport;
						}
					}
				}

				if (Settings::Get('system.use_ssl') == '1'
					&& isset($_POST['ssl_ipandport'])
				) {
					$ssl = 1; // if ssl is set and != 0, it can only be 1
					$ssl_redirect = 0;
					if (isset($_POST['ssl_redirect'])) {
						$ssl_redirect = (int)$_POST['ssl_redirect'];
					}

					$ssl_ipandports = array();
					if (isset($_POST['ssl_ipandport']) && !is_array($_POST['ssl_ipandport'])) {
						$_POST['ssl_ipandport'] = unserialize($_POST['ssl_ipandport']);
					}
					if (isset($_POST['ssl_ipandport']) && is_array($_POST['ssl_ipandport'])) {

						$ssl_ipandport_check_stmt = Database::prepare("
							SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `id` = :ipandport
						");
						foreach ($_POST['ssl_ipandport'] as $ssl_ipandport) {
							if (trim($ssl_ipandport) == "") continue;
							// fix if ip/port got de-checked and it was the last one
							if (trim($ssl_ipandport) < 1) continue;
							$ssl_ipandport = intval($ssl_ipandport);
							$ssl_ipandport_check = Database::pexecute_first($ssl_ipandport_check_stmt, array('ipandport' => $ssl_ipandport));
							if (!isset($ssl_ipandport_check['id'])
								|| $ssl_ipandport_check['id'] == '0'
								|| $ssl_ipandport_check['id'] != $ssl_ipandport
							) {
								standard_error('ipportdoesntexist');
							} else {
								$ssl_ipandports[] = $ssl_ipandport;
							}
						}
					} else {
						$ssl_redirect = 0;
						// we need this for the serialize
						// if ssl is disabled or no ssl-ip/port exists
						$ssl_ipandports[] = -1;
					}
				} else {
					$ssl_redirect = 0;
					// we need this for the serialize
					// if ssl is disabled or no ssl-ip/port exists
					$ssl_ipandports[] = -1;
				}

				if (!preg_match('/^https?\:\/\//', $documentroot)) {
					$documentroot = makeCorrectDir($documentroot);
				}

				if ($openbasedir != '1') {
					$openbasedir = '0';
				}

				if ($isbinddomain != '1') {
					$isbinddomain = '0';
				}

				if ($isemaildomain != '1') {
					$isemaildomain = '0';
				}

				if ($email_only == '1') {
					$isemaildomain = '1';
				} else {
					$email_only = '0';
				}

				if ($subcanemaildomain != '1'
					&& $subcanemaildomain != '2'
					&& $subcanemaildomain != '3'
				) {
					$subcanemaildomain = '0';
				}

				if	($dkim != '1') {
					$dkim = '0';
				}

				if ($caneditdomain != '1') {
					$caneditdomain = '0';
				}

				$aliasdomain_check = array(
					'id' => 0
				);

				if ($aliasdomain != 0) {
					// Overwrite given ipandports with these of the "main" domain
					$ipandports = array();
					$origipresult_stmt = Database::prepare("
						SELECT `id_ipandports` FROM `" . TABLE_DOMAINTOIP ."` WHERE `id_domain` = :aliasdomain
					");
					Database::pexecute($origipresult_stmt, array('aliasdomain' => $aliasdomain));
					while ($origip = $origipresult_stmt->fetch(PDO::FETCH_ASSOC)) {
						$ipandports[] = $origip['id_ipandports'];
					}
					$aliasdomain_check_stmt = Database::prepare("
						SELECT `d`.`id` FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_CUSTOMERS . "` `c`
						WHERE `d`.`customerid` = :customerid
						AND `d`.`aliasdomain` IS NULL AND `d`.`id` <> `c`.`standardsubdomain`
						AND `c`.`customerid` = :customerid
						AND `d`.`id` = :aliasdomain
					");
					$aliasdomain_check = Database::pexecute_first($aliasdomain_check_stmt, array('customerid' => $customerid, 'aliasdomain' => $aliasdomain));
				}

				if (count($ipandports) == 0) {
					standard_error('noipportgiven');
				}

				if ($aliasdomain_check['id'] != $aliasdomain) {
					standard_error('domainisaliasorothercustomer');
				}

				if ($issubof <= '0') {
					$issubof = '0';
				}

				if ($serveraliasoption != '1' && $serveraliasoption != '2') {
					$serveraliasoption = '0';
				}

				$params = array(
					'id' => $id,
					'page' => $page,
					'action' => $action,
					'customerid' => $customerid,
					'adminid' => $adminid,
					'documentroot' => $documentroot,
					'alias' => $aliasdomain,
					'isbinddomain' => $isbinddomain,
					'isemaildomain' => $isemaildomain,
					'email_only' => $email_only,
					'subcanemaildomain' => $subcanemaildomain,
					'caneditdomain' => $caneditdomain,
					'zonefile' => $zonefile,
					'dkim' => $dkim,
					'selectserveralias' => $serveraliasoption,
					'ssl_redirect' => $ssl_redirect,
					'openbasedir' => $openbasedir,
					'phpsettingid' => $phpsettingid,
					'mod_fcgid_starter' => $mod_fcgid_starter,
					'mod_fcgid_maxrequests' => $mod_fcgid_maxrequests,
					'specialsettings' => $specialsettings,
					'registration_date' => $registration_date,
					'issubof' => $issubof,
					'speciallogfile' => $speciallogfile,
					'speciallogverified' => $speciallogverified,
					'ipandport' => serialize($ipandports),
					'ssl_ipandport' => serialize($ssl_ipandports)
				);

				$security_questions = array(
					'reallydisablesecuritysetting' => ($openbasedir == '0' && $userinfo['change_serversettings'] == '1'),
					'reallydocrootoutofcustomerroot' => (substr($documentroot, 0, strlen($customer['documentroot'])) != $customer['documentroot'] && !preg_match('/^https?\:\/\//', $documentroot))
				);
				foreach ($security_questions as $question_name => $question_launch) {
					if ($question_launch !== false) {
						$params[$question_name] = $question_name;
						if (!isset($_POST[$question_name])
							|| $_POST[$question_name] != $question_name
						) {
							ask_yesno('admin_domain_' . $question_name, $filename, $params);
							exit;
						}
					}
				}

				$wwwserveralias = ($serveraliasoption == '1') ? '1' : '0';
				$iswildcarddomain = ($serveraliasoption == '0') ? '1' : '0';

				if ($documentroot != $result['documentroot']
					|| $ssl_redirect != $result['ssl_redirect']
					|| $wwwserveralias != $result['wwwserveralias']
					|| $iswildcarddomain != $result['iswildcarddomain']
					|| $openbasedir != $result['openbasedir']
					|| $phpsettingid != $result['phpsettingid']
					|| $mod_fcgid_starter != $result['mod_fcgid_starter']
					|| $mod_fcgid_maxrequests != $result['mod_fcgid_maxrequests']
					|| $specialsettings != $result['specialsettings']
					|| $aliasdomain != $result['aliasdomain']
					|| $issubof != $result['ismainbutsubto']
					|| $email_only != $result['email_only']
					|| ($speciallogfile != $result['speciallogfile'] && $speciallogverified == '1')
				) {
					inserttask('1');
				}

				if ($speciallogfile != $result['speciallogfile'] && $speciallogverified != '1') {
					$speciallogfile = $result['speciallogfile'];
				}

				if ($isbinddomain != $result['isbinddomain']
					|| $zonefile != $result['zonefile']
					|| $dkim != $result['dkim']
				) {
					inserttask('4');
				}

				if ($isemaildomain == '0'
					&& $result['isemaildomain'] == '1'
				) {
					$del_stmt = Database::prepare("
						DELETE FROM `" . TABLE_MAIL_USERS . "` WHERE `domainid` = :id
					");
					Database::pexecute($del_stmt, array('id' => $id));

					$del_stmt = Database::prepare("
						DELETE FROM `" . TABLE_MAIL_VIRTUAL . "` WHERE `domainid` = :id
					");
					Database::pexecute($del_stmt, array('id' => $id));
					$log->logAction(ADM_ACTION, LOG_NOTICE, "deleted domain #" . $id . " from mail-tables");
				}

				$updatechildren = '';

				if ($subcanemaildomain == '0'
					&& $result['subcanemaildomain'] != '0'
				) {
					$updatechildren = ", `isemaildomain` = '0' ";

				} elseif($subcanemaildomain == '3'
					&& $result['subcanemaildomain'] != '3'
				) {
					$updatechildren = ", `isemaildomain` = '1' ";
				}

				if ($customerid != $result['customerid']
					&& Settings::Get('panel.allow_domain_change_customer') == '1'
				) {
					$upd_data = array('customerid' => $customerid, 'domainid' => $result['id']);
					$upd_stmt = Database::prepare("
						UPDATE `" . TABLE_MAIL_USERS . "` SET `customerid` = :customerid WHERE `domainid` = :domainid
					");
					Database::pexecute($upd_stmt, $upd_data);
					$upd_stmt = Database::prepare("
						UPDATE `" . TABLE_MAIL_VIRTUAL . "` SET `customerid` = :customerid WHERE `domainid` = :domainid
					");
					Database::pexecute($upd_stmt, $upd_data);
					$upd_data = array('subdomains' => $subdomains, 'emails' => $emails, 'forwarders' => $email_forwarders, 'accounts' => $email_accounts);
					$upd_data['customerid'] = $customerid;
					$upd_stmt = Database::prepare("
						UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET
						`subdomains_used` = `subdomains_used` + :subdomains,
						`emails_used` = `emails_used` + :emails,
						`email_forwarders_used` = `email_forwarders_used` + :forwarders,
						`email_accounts_used` = `email_accounts_used` + :accounts
						WHERE `customerid` = :customerid
					");
					Database::pexecute($upd_stmt, $upd_data);

					$upd_data['customerid'] = $result['customerid'];
					$upd_stmt = Database::prepare("
						UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET
						`subdomains_used` = `subdomains_used` - :subdomains,
						`emails_used` = `emails_used` - :emails,
						`email_forwarders_used` = `email_forwarders_used` - :forwarders,
						`email_accounts_used` = `email_accounts_used` - :accounts
						WHERE `customerid` = :customerid
					");
					Database::pexecute($upd_stmt, $upd_data);
				}

				if ($adminid != $result['adminid']
					&& Settings::Get('panel.allow_domain_change_admin') == '1'
				) {
					$upd_stmt = Database::prepare("
						UPDATE `" . TABLE_PANEL_ADMINS . "` SET `domains_used` = `domains_used` + 1 WHERE `adminid` = :adminid
					");
					Database::pexecute($upd_stmt, array('adminid' => $adminid));

					$upd_stmt = Database::prepare("
						UPDATE `" . TABLE_PANEL_ADMINS . "` SET `domains_used` = `domains_used` - 1 WHERE `adminid` = :adminid
					");
					Database::pexecute($upd_stmt, array('adminid' => $result['adminid']));
				}

				$_update_data = array();

				$ssfs = isset($_POST['specialsettingsforsubdomains']) ? 1 : 0;
				if ($ssfs == 1) {
					$_update_data['specialsettings'] = $specialsettings;
					$upd_specialsettings = ", `specialsettings` = :specialsettings ";
				} else {
					$upd_specialsettings = '';
					unset($_update_data['specialsettings']);
					$upd_stmt = Database::prepare("
						UPDATE `" . TABLE_PANEL_DOMAINS . "` SET `specialsettings`='' WHERE `parentdomainid` = :id
					");
					Database::pexecute($upd_stmt, array('id' => $id));
					$log->logAction(ADM_ACTION, LOG_INFO, "removed specialsettings on all subdomains of domain #" . $id);
				}

				$wwwserveralias = ($serveraliasoption == '1') ? '1' : '0';
				$iswildcarddomain = ($serveraliasoption == '0') ? '1' : '0';

				$update_data = array();
				$update_data['customerid'] = $customerid;
				$update_data['adminid'] = $adminid;
				$update_data['documentroot'] = $documentroot;
				$update_data['ssl_redirect'] = $ssl_redirect;
				$update_data['aliasdomain'] = ($aliasdomain != 0 && $alias_check == 0) ? $aliasdomain : null;
				$update_data['isbinddomain'] = $isbinddomain;
				$update_data['isemaildomain'] = $isemaildomain;
				$update_data['email_only'] = $email_only;
				$update_data['subcanemaildomain'] = $subcanemaildomain;
				$update_data['dkim'] = $dkim;
				$update_data['caneditdomain'] = $caneditdomain;
				$update_data['zonefile'] = $zonefile;
				$update_data['wwwserveralias'] = $wwwserveralias;
				$update_data['iswildcarddomain'] = $iswildcarddomain;
				$update_data['openbasedir'] = $openbasedir;
				$update_data['speciallogfile'] = $speciallogfile;
				$update_data['phpsettingid'] = $phpsettingid;
				$update_data['mod_fcgid_starter'] = $mod_fcgid_starter;
				$update_data['mod_fcgid_maxrequests'] = $mod_fcgid_maxrequests;
				$update_data['specialsettings'] = $specialsettings;
				$update_data['registration_date'] = $registration_date;
				$update_data['ismainbutsubto'] = $issubof;
				$update_data['id'] = $id;

				$update_stmt = Database::prepare("
					UPDATE `" . TABLE_PANEL_DOMAINS . "` SET
					`customerid` = :customerid,
					`adminid` = :adminid,
					`documentroot` = :documentroot,
					`ssl_redirect` = :ssl_redirect,
					`aliasdomain` = :aliasdomain,
					`isbinddomain` = :isbinddomain,
					`isemaildomain` = :isemaildomain,
					`email_only` = :email_only,
					`subcanemaildomain` = :subcanemaildomain,
					`dkim` = :dkim,
					`caneditdomain` = :caneditdomain,
					`zonefile` = :zonefile,
					`wwwserveralias` = :wwwserveralias,
					`iswildcarddomain` = :iswildcarddomain,
					`openbasedir` = :openbasedir,
					`speciallogfile` = :speciallogfile,
					`phpsettingid` = :phpsettingid,
					`mod_fcgid_starter` = :mod_fcgid_starter,
					`mod_fcgid_maxrequests` = :mod_fcgid_maxrequests,
					`specialsettings` = :specialsettings,
					`registration_date` = :registration_date,
					`ismainbutsubto` = :ismainbutsubto
					WHERE `id` = :id
				");
				Database::pexecute($update_stmt, $update_data);

				$_update_data['customerid'] = $customerid;
				$_update_data['adminid'] = $adminid;
				$_update_data['openbasedir'] = $openbasedir;
				$_update_data['phpsettingid'] = $phpsettingid;
				$_update_data['mod_fcgid_starter'] = $mod_fcgid_starter;
				$_update_data['mod_fcgid_maxrequests'] = $mod_fcgid_maxrequests;
				$_update_data['parentdomainid'] = $id;

				// if we have no more ssl-ip's for this domain,
				// all its subdomains must have "ssl-redirect = 0"
				$update_sslredirect = '';
				if (count($ssl_ipandports) == 1 && $ssl_ipandports[0] == -1) {
					$update_sslredirect = ", `ssl_redirect` = '0' ";
				}

				$_update_stmt = Database::prepare("
					UPDATE `" . TABLE_PANEL_DOMAINS . "` SET
					`customerid` = :customerid,
					`adminid` = :adminid,
					`openbasedir` = :openbasedir,
					`phpsettingid` = :phpsettingid,
					`mod_fcgid_starter` = :mod_fcgid_starter,
					`mod_fcgid_maxrequests` = :mod_fcgid_maxrequests
					" . $upd_specialsettings . $updatechildren . $update_sslredirect . "
					WHERE `parentdomainid` = :parentdomainid
				");
				Database::pexecute($_update_stmt, $_update_data);

				// FIXME check how many we got and if the amount of assigned IP's
				// has changed so we can insert a config-rebuild task if only
				// the ip's of this domain were changed
				// -> for now, always insert a rebuild-task
				inserttask('1');

				// Cleanup domain <-> ip mapping
				$del_stmt = Database::prepare("
					DELETE FROM `" . TABLE_DOMAINTOIP . "` WHERE `id_domain` = :id
				");
				Database::pexecute($del_stmt, array('id' => $id));

				$ins_stmt = Database::prepare("
					INSERT INTO `" . TABLE_DOMAINTOIP . "` SET `id_domain` = :domainid, `id_ipandports` = :ipportid
				");

				foreach ($ipandports as $ipportid) {
					Database::pexecute($ins_stmt, array('domainid' => $id, 'ipportid' => $ipportid));
				}
				foreach ($ssl_ipandports as $ssl_ipportid) {
					if ($ssl_ipportid > 0) {
						Database::pexecute($ins_stmt, array('domainid' => $id, 'ipportid' => $ssl_ipportid));
					}
				}

				// Cleanup domain <-> ip mapping for subdomains
				$domainidsresult_stmt = Database::prepare("
					SELECT `id` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `parentdomainid` = :id
				");
				Database::pexecute($domainidsresult_stmt, array('id' => $id));

				while ($row = $domainidsresult_stmt->fetch(PDO::FETCH_ASSOC)) {

					$del_stmt = Database::prepare("
						DELETE FROM `" . TABLE_DOMAINTOIP . "` WHERE `id_domain` = :rowid
					");
					Database::pexecute($del_stmt, array('rowid' => $row['id']));

					$ins_stmt = Database::prepare("
						INSERT INTO `" . TABLE_DOMAINTOIP . "` SET
						`id_domain` = :rowid,
						`id_ipandports` = :ipportid
					");

					foreach ($ipandports as $ipportid) {
						Database::pexecute($ins_stmt, array('rowid' => $row['id'], 'ipportid' => $ipportid));
					}
					foreach ($ssl_ipandports as $ssl_ipportid) {
						Database::pexecute($ins_stmt, array('rowid' => $row['id'], 'ipportid' => $ssl_ipportid));
					}
				}

				$log->logAction(ADM_ACTION, LOG_INFO, "edited domain #" . $id);
				redirectTo($filename, array('page' => $page, 's' => $s));

			} else {


				if (Settings::Get('panel.allow_domain_change_customer') == '1') {
					$customers = '';
					$result_customers_stmt = Database::prepare("
						SELECT `customerid`, `loginname`, `name`, `firstname`, `company` FROM `" . TABLE_PANEL_CUSTOMERS . "`
						WHERE ( (`subdomains_used` + :subdomains <= `subdomains` OR `subdomains` = '-1' )
						AND (`emails_used` + :emails <= `emails` OR `emails` = '-1' )
						AND (`email_forwarders_used` + :forwarders <= `email_forwarders` OR `email_forwarders` = '-1' )
						AND (`email_accounts_used` + :accounts <= `email_accounts` OR `email_accounts` = '-1' ) " .
						($userinfo['customers_see_all'] ? '' : " AND `adminid` = :adminid ") . ")
						OR `customerid` = :customerid ORDER BY `name` ASC
					");
					$params = array(
						'subdomains' => $subdomains,
						'emails' => $emails,
						'forwarders' => $email_forwarders,
						'accounts' => $email_accounts,
						'customerid' => $result['customerid']
					);
					if ($userinfo['customers_see_all'] == '0') {
						$params['adminid'] = $userinfo['adminid'];
					}
					Database::pexecute($result_customers_stmt, $params);

					while ($row_customer = $result_customers_stmt->fetch(PDO::FETCH_ASSOC)) {
						$customers.= makeoption(getCorrectFullUserDetails($row_customer) . ' (' . $row_customer['loginname'] . ')', $row_customer['customerid'], $result['customerid']);
					}

				} else {
					$customer_stmt = Database::prepare("
						SELECT `customerid`, `loginname`, `name`, `firstname`, `company` FROM `" . TABLE_PANEL_CUSTOMERS . "`
						WHERE `customerid` = :customerid
					");
					$customer = Database::pexecute_first($customer_stmt, array('customerid' => $result['customerid']));
					$result['customername'] = getCorrectFullUserDetails($customer) . ' (' . $customer['loginname'] . ')';
				}

				if ($userinfo['customers_see_all'] == '1') {
					if (Settings::Get('panel.allow_domain_change_admin') == '1') {

						$admins = '';
						$result_admins_stmt = Database::prepare("
							SELECT `adminid`, `loginname`, `name` FROM `" . TABLE_PANEL_ADMINS . "`
							WHERE (`domains_used` < `domains` OR `domains` = '-1') OR `adminid` = :adminid ORDER BY `name` ASC
						");
						Database::pexecute($result_admins_stmt, array('adminid' => $result['adminid']));

						while ($row_admin = $result_admins_stmt->fetch(PDO::FETCH_ASSOC)) {
							$admins.= makeoption(getCorrectFullUserDetails($row_admin) . ' (' . $row_admin['loginname'] . ')', $row_admin['adminid'], $result['adminid']);
						}
					} else {
						$admin_stmt = Database::prepare("
							SELECT `adminid`, `loginname`, `name` FROM `" . TABLE_PANEL_ADMINS . "` WHERE `adminid` = :adminid
						");
						$admin = Database::pexecute_first($admin_stmt, array('adminid' => $result['adminid']));
						$result['adminname'] = getCorrectFullUserDetails($admin) . ' (' . $admin['loginname'] . ')';
					}
				}

				$result['domain'] = $idna_convert->decode($result['domain']);
				$domains = makeoption($lng['domains']['noaliasdomain'], 0, null, true);

				$result_domains_stmt = Database::prepare("
					SELECT `d`.`id`, `d`.`domain`  FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_CUSTOMERS . "` `c`
					WHERE `d`.`aliasdomain` IS NULL AND `d`.`parentdomainid` = '0' AND `d`.`id` <> :id
					AND `c`.`standardsubdomain`<>`d`.`id` AND `d`.`customerid` = :customerid AND `c`.`customerid`=`d`.`customerid`
					ORDER BY `d`.`domain` ASC
				");
				Database::pexecute($result_domains_stmt, array('id' => $result['id'], 'customerid' => $result['customerid']));

				while ($row_domain = $result_domains_stmt->fetch(PDO::FETCH_ASSOC)) {
					$domains.= makeoption($idna_convert->decode($row_domain['domain']), $row_domain['id'], $result['aliasdomain']);
				}

				$subtodomains = makeoption($lng['domains']['nosubtomaindomain'], 0, null, true);
				$result_domains_stmt = Database::prepare("
					SELECT `d`.`id`, `d`.`domain` FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_CUSTOMERS . "` `c`
					WHERE `d`.`aliasdomain` IS NULL AND `d`.`parentdomainid` = '0' AND `d`.`id` <> :id
					AND `c`.`standardsubdomain`<>`d`.`id` AND `c`.`customerid`=`d`.`customerid`".
					($userinfo['customers_see_all'] ? '' : " AND `d`.`adminid` = :adminid") . "
					ORDER BY `d`.`domain` ASC
				");
				$params = array('id' => $result['id']);
				if ($userinfo['customers_see_all'] == '0') {
					$params['adminid'] = $userinfo['adminid'];
				}
				Database::pexecute($result_domains_stmt, $params);

				while ($row_domain = $result_domains_stmt->fetch(PDO::FETCH_ASSOC)) {
					$subtodomains.= makeoption($idna_convert->decode($row_domain['domain']), $row_domain['id'], $result['ismainbutsubto']);
				}

				if ($userinfo['ip'] == "-1") {
					$result_ipsandports_stmt = Database::query("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ssl`='0' ORDER BY `ip`, `port` ASC
					");
					$result_ssl_ipsandports_stmt = Database::query("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ssl`='1' ORDER BY `ip`, `port` ASC
					");
				} else {
					$admin_ip_stmt = Database::prepare("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `id` = :ipid ORDER BY `ip`, `port` ASC
					");
					$admin_ip = Database::pexecute_first($admin_ip_stmt, array('ipid' => $userinfo['ip']));

					$result_ipsandports_stmt = Database::prepare("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ssl`='0' AND `ip` = :ipid ORDER BY `ip`, `port` ASC
					");
					Database::pexecute($result_ipsandports_stmt, array('ipid' => $admin_ip['ip']));

					$result_ssl_ipsandports_stmt = Database::prepare("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ssl`='1' AND `ip` = :ipid ORDER BY `ip`, `port` ASC
					");
					Database::pexecute($result_ssl_ipsandports_stmt, array('ipid' => $admin_ip['ip']));
				}

				$ipsandports = array();
				while ($row_ipandport = $result_ipsandports_stmt->fetch(PDO::FETCH_ASSOC)) {
					if (filter_var($row_ipandport['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
						$row_ipandport['ip'] = '[' . $row_ipandport['ip'] . ']';
					}
					$ipsandports[] = array('label' => $row_ipandport['ip'] . ':' . $row_ipandport['port'] . '<br />', 'value' => $row_ipandport['id']);
				}

				$ssl_ipsandports = array();
				while ($row_ssl_ipandport = $result_ssl_ipsandports_stmt->fetch(PDO::FETCH_ASSOC)) {
					if (filter_var($row_ssl_ipandport['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
						$row_ssl_ipandport['ip'] = '[' . $row_ssl_ipandport['ip'] . ']';
					}
					$ssl_ipsandports[] = array('label' => $row_ssl_ipandport['ip'] . ':' . $row_ssl_ipandport['port'] . '<br />', 'value' => $row_ssl_ipandport['id']);
				}

				$result['specialsettings'] = $result['specialsettings'];

				// create serveralias options
				$serveraliasoptions = "";
				$_value = '2';
				if ($result['iswildcarddomain'] == '1') {
					$_value = '0';
				} elseif ($result['wwwserveralias'] == '1') {
					$_value = '1';
				}
				$serveraliasoptions .= makeoption($lng['domains']['serveraliasoption_wildcard'], '0', $_value, true, true);
				$serveraliasoptions .= makeoption($lng['domains']['serveraliasoption_www'], '1', $_value, true, true);
				$serveraliasoptions .= makeoption($lng['domains']['serveraliasoption_none'], '2', $_value, true, true);

				$subcanemaildomain = makeoption($lng['admin']['subcanemaildomain']['never'], '0', $result['subcanemaildomain'], true, true);
				$subcanemaildomain.= makeoption($lng['admin']['subcanemaildomain']['choosableno'], '1', $result['subcanemaildomain'], true, true);
				$subcanemaildomain.= makeoption($lng['admin']['subcanemaildomain']['choosableyes'], '2', $result['subcanemaildomain'], true, true);
				$subcanemaildomain.= makeoption($lng['admin']['subcanemaildomain']['always'], '3', $result['subcanemaildomain'], true, true);
				$speciallogfile = ($result['speciallogfile'] == 1 ? $lng['panel']['yes'] : $lng['panel']['no']);
				$result['add_date'] = date('Y-m-d', $result['add_date']);

				$phpconfigs = '';
				$phpconfigs_result_stmt = Database::query("SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "`");

				while ($phpconfigs_row = $phpconfigs_result_stmt->fetch(PDO::FETCH_ASSOC)) {
					$phpconfigs.= makeoption($phpconfigs_row['description'], $phpconfigs_row['id'], $result['phpsettingid'], true, true);
				}

				$result = htmlentities_array($result);

				$domain_edit_data = include_once dirname(__FILE__).'/lib/formfields/admin/domains/formfield.domains_edit.php';
				$domain_edit_form = htmlform::genHTMLForm($domain_edit_data);

				$title = $domain_edit_data['domain_edit']['title'];
				$image = $domain_edit_data['domain_edit']['image'];

				$speciallogwarning = sprintf($lng['admin']['speciallogwarning'], $lng['admin']['delete_statistics']);

				eval("echo \"" . getTemplate("domains/domains_edit") . "\";");
			}
		}
	}
}
