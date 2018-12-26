<?php
namespace Froxlor\Cron\Http;

use Froxlor\Database\Database;
use Froxlor\Settings;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Michael Kaufmann <mkaufmann@nutime.de>
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Cron
 *         
 * @since 0.9.31
 *       
 */
class WebserverBase
{

	/**
	 * returns an array with all entries required for all
	 * webserver-vhost-configs
	 *
	 * @return array
	 */
	public static function getVhostsToCreate()
	{
		$query = "SELECT `d`.*, `pd`.`domain` AS `parentdomain`, `c`.`loginname`,
				`d`.`phpsettingid`, `c`.`adminid`, `c`.`guid`, `c`.`email`,
				`c`.`documentroot` AS `customerroot`, `c`.`deactivated`,
				`c`.`phpenabled` AS `phpenabled_customer`,
				`d`.`phpenabled` AS `phpenabled_vhost`,
				`d`.`mod_fcgid_starter`,`d`.`mod_fcgid_maxrequests`,
				`d`.`ocsp_stapling`
				FROM `" . TABLE_PANEL_DOMAINS . "` `d`

				LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` `c` USING(`customerid`)
				LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `pd` ON (`pd`.`id` = `d`.`parentdomainid`)

				WHERE `d`.`aliasdomain` IS NULL AND `d`.`email_only` <> '1'
				ORDER BY `d`.`parentdomainid` DESC, `d`.`iswildcarddomain`, `d`.`domain` ASC;
		";

		$result_domains_stmt = Database::query($query);

		// prepare IP statement
		$ip_stmt = Database::prepare("
			SELECT `di`.`id_domain` , `p`.`ssl`, `p`.`ssl_cert_file`, `p`.`ssl_key_file`, `p`.`ssl_ca_file`, `p`.`ssl_cert_chainfile`
			FROM `" . TABLE_DOMAINTOIP . "` `di`, `" . TABLE_PANEL_IPSANDPORTS . "` `p`
			WHERE `p`.`id` = `di`.`id_ipandports`
			AND `di`.`id_domain` = :domainid
			AND `p`.`ssl` = '1'
		");

		// prepare fpm-config select query
		$fpm_sel_stmt = Database::prepare("
			SELECT f.id FROM `" . TABLE_PANEL_FPMDAEMONS . "` f
			LEFT JOIN `" . TABLE_PANEL_PHPCONFIGS . "` p ON p.fpmsettingid = f.id
			WHERE p.id = :phpconfigid
		");

		$domains = array();
		while ($domain = $result_domains_stmt->fetch(\PDO::FETCH_ASSOC)) {

			// set whole domain
			$domains[$domain['domain']] = $domain;
			// set empty-defaults for non-ssl
			$domains[$domain['domain']]['ssl'] = '';
			$domains[$domain['domain']]['ssl_cert_file'] = '';
			$domains[$domain['domain']]['ssl_key_file'] = '';
			$domains[$domain['domain']]['ssl_ca_file'] = '';
			$domains[$domain['domain']]['ssl_cert_chainfile'] = '';

			// now, if the domain has an ssl ip/port assigned, get
			// the corresponding information from the db
			if (\Froxlor\Domain\Domain::domainHasSslIpPort($domain['id'])) {

				$ssl_ip = Database::pexecute_first($ip_stmt, array(
					'domainid' => $domain['id']
				));

				// set ssl info for domain
				$domains[$domain['domain']]['ssl'] = '1';
				$domains[$domain['domain']]['ssl_cert_file'] = $ssl_ip['ssl_cert_file'];
				$domains[$domain['domain']]['ssl_key_file'] = $ssl_ip['ssl_key_file'];
				$domains[$domain['domain']]['ssl_ca_file'] = $ssl_ip['ssl_ca_file'];
				$domains[$domain['domain']]['ssl_cert_chainfile'] = $ssl_ip['ssl_cert_chainfile'];
			}

			// read fpm-config-id if using fpm
			if ((int) Settings::Get('phpfpm.enabled') == 1) {

				$fpm_config = Database::pexecute_first($fpm_sel_stmt, array(
					'phpconfigid' => $domain['phpsettingid']
				));
				if ($fpm_config) {
					$domains[$domain['domain']]['fpm_config_id'] = $fpm_config['id'];
				} else {
					// fallback
					$domains[$domain['domain']]['fpm_config_id'] = 1;
				}
			}
		}

		return $domains;
	}
}
