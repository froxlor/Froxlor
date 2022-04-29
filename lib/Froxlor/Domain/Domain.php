<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

namespace Froxlor\Domain;

use Froxlor\Cron\Http\LetsEncrypt\AcmeSh;
use Froxlor\Database\Database;
use Froxlor\FileDir;
use Froxlor\FroxlorLogger;
use Froxlor\Settings;
use PDO;

class Domain
{

	/**
	 * return all ip addresses associated with given domain,
	 * returns all ips if domain-id = 0 (froxlor.vhost)
	 *
	 * @param int $domain_id
	 * @return array
	 */
	public static function getIpsOfDomain($domain_id)
	{
		if ($domain_id > 0) {
			$sel_stmt = Database::prepare("
				SELECT i.ip FROM `" . TABLE_PANEL_IPSANDPORTS . "` `i`
				LEFT JOIN `" . TABLE_DOMAINTOIP . "` `dip` ON dip.id_ipandports = i.id
				AND dip.id_domain = :domainid
				GROUP BY i.ip
			");
			$sel_param = [
				'domainid' => $domain_id
			];
		} else {
			// assuming froxlor.vhost (id = 0)
			$sel_stmt = Database::prepare("
				SELECT ip FROM `" . TABLE_PANEL_IPSANDPORTS . "`
				GROUP BY ip
			");
			$sel_param = [];
		}
		Database::pexecute($sel_stmt, $sel_param);
		$result = [];
		while ($ip = $sel_stmt->fetch(PDO::FETCH_ASSOC)) {
			$result[] = $ip['ip'];
		}
		return $result;
	}

	/**
	 * return an array of all enabled redirect-codes
	 *
	 * @return array array of enabled redirect-codes
	 */
	public static function getRedirectCodesArray()
	{
		$sql = "SELECT * FROM `" . TABLE_PANEL_REDIRECTCODES . "` WHERE `enabled` = '1' ORDER BY `id` ASC";
		$result_stmt = Database::query($sql);

		$codes = [];
		while ($rc = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			$codes[] = $rc;
		}

		return $codes;
	}

	/**
	 * returns the redirect-code for a given
	 * domain-id
	 *
	 * @param integer $domainid
	 *            id of the domain
	 *
	 * @return string redirect-code
	 */
	public static function getDomainRedirectCode($domainid = 0)
	{
		// get system default
		$default = '301';
		if (Settings::Get('customredirect.enabled') == '1') {
			$all_codes = self::getRedirectCodes(false);
			$_default = $all_codes[Settings::Get('customredirect.default')];
			$default = ($_default == '---') ? $default : $_default;
		}
		$code = $default;
		if ($domainid > 0) {
			$result_stmt = Database::prepare("
				SELECT `r`.`code` as `redirect`
				FROM `" . TABLE_PANEL_REDIRECTCODES . "` `r`, `" . TABLE_PANEL_DOMAINREDIRECTS . "` `rc`
				WHERE `r`.`id` = `rc`.`rid` and `rc`.`did` = :domainid
			");
			$result = Database::pexecute_first($result_stmt, [
				'domainid' => $domainid
			]);

			if (is_array($result) && isset($result['redirect'])) {
				$code = ($result['redirect'] == '---') ? $default : $result['redirect'];
			}
		}
		return $code;
	}

	/**
	 * return an array of all enabled redirect-codes
	 * for the settings form
	 *
	 * @param bool $add_desc
	 *            optional, default true, add the code-description
	 *
	 * @return array array of enabled redirect-codes
	 */
	public static function getRedirectCodes($add_desc = true)
	{
		$sql = "SELECT * FROM `" . TABLE_PANEL_REDIRECTCODES . "` WHERE `enabled` = '1' ORDER BY `id` ASC";
		$result_stmt = Database::query($sql);

		$codes = [];
		while ($rc = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			$codes[$rc['id']] = $rc['code'];
			if ($add_desc) {
				$codes[$rc['id']] .= ' (' . lng('redirect_desc.' . $rc['desc']) . ')';
			}
		}

		return $codes;
	}

	/**
	 * returns the redirect-id for a given
	 * domain-id
	 *
	 * @param integer $domainid
	 *            id of the domain
	 *
	 * @return integer redirect-code-id
	 */
	public static function getDomainRedirectId($domainid = 0)
	{
		$code = 1;
		if ($domainid > 0) {
			$result_stmt = Database::prepare("
				SELECT `r`.`id` as `redirect`
				FROM `" . TABLE_PANEL_REDIRECTCODES . "` `r`, `" . TABLE_PANEL_DOMAINREDIRECTS . "` `rc`
				WHERE `r`.`id` = `rc`.`rid` and `rc`.`did` = :domainid
			");
			$result = Database::pexecute_first($result_stmt, [
				'domainid' => $domainid
			]);

			if (is_array($result) && isset($result['redirect'])) {
				$code = (int)$result['redirect'];
			}
		}
		return $code;
	}

	/**
	 * adds a redirectcode for a domain
	 *
	 * @param integer $domainid
	 *            id of the domain to add the code for
	 * @param integer $redirect
	 *            selected redirect-id
	 *
	 * @return null
	 */
	public static function addRedirectToDomain($domainid = 0, $redirect = 1)
	{
		if ($domainid > 0) {
			$ins_stmt = Database::prepare("
				INSERT INTO `" . TABLE_PANEL_DOMAINREDIRECTS . "` SET `rid` = :rid, `did` = :did
			");
			Database::pexecute($ins_stmt, [
				'rid' => $redirect,
				'did' => $domainid
			]);
		}
	}

	/**
	 * updates the redirectcode of a domain
	 * if redirect-code is false, nothing happens
	 *
	 * @param integer $domainid
	 *            id of the domain to update
	 * @param integer $redirect
	 *            selected redirect-id or false
	 *
	 * @return null
	 */
	public static function updateRedirectOfDomain($domainid = 0, $redirect = false)
	{
		if ($redirect == false) {
			return;
		}

		if ($domainid > 0) {
			$del_stmt = Database::prepare("
				DELETE FROM `" . TABLE_PANEL_DOMAINREDIRECTS . "` WHERE `did` = :domainid
			");
			Database::pexecute($del_stmt, [
				'domainid' => $domainid
			]);

			$ins_stmt = Database::prepare("
				INSERT INTO `" . TABLE_PANEL_DOMAINREDIRECTS . "` SET `rid` = :rid, `did` = :did
			");
			Database::pexecute($ins_stmt, [
				'rid' => $redirect,
				'did' => $domainid
			]);
		}
	}

	/**
	 * check whether a domain has subdomains added as full-domains
	 * #329
	 *
	 * @param int $id
	 *            domain-id
	 *
	 * @return boolean
	 */
	public static function domainHasMainSubDomains($id = 0)
	{
		$result_stmt = Database::prepare("
		SELECT COUNT(`id`) as `mainsubs` FROM `" . TABLE_PANEL_DOMAINS . "`
		WHERE `ismainbutsubto` = :id");
		$result = Database::pexecute_first($result_stmt, [
			'id' => $id
		]);

		if (isset($result['mainsubs']) && $result['mainsubs'] > 0) {
			return true;
		}
		return false;
	}

	/**
	 * check whether a subof-domain exists
	 * #329
	 *
	 * @param int $id
	 *            subof-domain-id
	 *
	 * @return boolean
	 */
	public static function domainMainToSubExists($id = 0)
	{
		$result_stmt = Database::prepare("
		SELECT `id` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `id` = :id");
		Database::pexecute($result_stmt, [
			'id' => $id
		]);
		$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($result['id']) && $result['id'] > 0) {
			return true;
		}
		return false;
	}

	/**
	 * Check whether a given domain has an ssl-ip/port assigned
	 *
	 * @param int $domainid
	 *
	 * @return boolean
	 */
	public static function domainHasSslIpPort($domainid = 0)
	{
		$result_stmt = Database::prepare("
			SELECT `dt`.* FROM `" . TABLE_DOMAINTOIP . "` `dt`, `" . TABLE_PANEL_IPSANDPORTS . "` `iap`
			WHERE `dt`.`id_ipandports` = `iap`.`id` AND `iap`.`ssl` = '1' AND `dt`.`id_domain` = :domainid;");
		Database::pexecute($result_stmt, [
			'domainid' => $domainid
		]);
		$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

		if (is_array($result) && isset($result['id_ipandports'])) {
			return true;
		}
		return false;
	}

	/**
	 * returns true or false whether a given domain id
	 * is the std-subdomain of a customer
	 *
	 * @param
	 *            int domain-id
	 *
	 * @return boolean
	 */
	public static function isCustomerStdSubdomain($did = 0)
	{
		if ($did > 0) {
			$result_stmt = Database::prepare("
				SELECT `customerid` FROM `" . TABLE_PANEL_CUSTOMERS . "`
				WHERE `standardsubdomain` = :did
			");
			$result = Database::pexecute_first($result_stmt, [
				'did' => $did
			]);

			if (is_array($result) && isset($result['customerid']) && $result['customerid'] > 0) {
				return true;
			}
		}
		return false;
	}

	public static function triggerLetsEncryptCSRForAliasDestinationDomain($aliasDestinationDomainID, $log)
	{
		if (isset($aliasDestinationDomainID) && $aliasDestinationDomainID > 0) {
			$log->logAction(FroxlorLogger::ADM_ACTION, LOG_INFO, "LetsEncrypt CSR triggered for domain ID " . $aliasDestinationDomainID);
			$upd_stmt = Database::prepare("UPDATE
					`" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "`
				SET
					`expirationdate` = null
				WHERE
					domainid = :domainid
			");
			Database::pexecute($upd_stmt, [
				'domainid' => $aliasDestinationDomainID
			]);
		}
	}

	public static function doLetsEncryptCleanUp($domainname = null)
	{
		// @ see \Froxlor\Cron\Http\LetsEncrypt\AcmeSh.php
		$acmesh = AcmeSh::getAcmeSh();
		if (file_exists($acmesh)) {
			$certificate_folder = AcmeSh::getWorkingDirFromEnv($domainname);
			if (file_exists($certificate_folder)) {
				$params = " --remove -d " . $domainname;
				if (Settings::Get('system.leecc') > 0) {
					$params .= " --ecc";
				}
				// run remove command
				FileDir::safe_exec($acmesh . $params);
				// remove certificates directory
				FileDir::safe_exec('rm -rf ' . $certificate_folder);
			}
		}
		return true;
	}

	/**
	 * checks give path for security issues
	 * and returns a string that can be appended
	 * to a line for a open_basedir directive
	 *
	 * @param string $path
	 *            the path to check and append
	 * @param boolean $first
	 *            if true, no ':' will be prefixed to the path
	 *
	 * @return string
	 */
	public static function appendOpenBasedirPath($path = '', $first = false)
	{
		if ($path != '' && $path != '/' && (!preg_match("#^/dev#i", $path) || preg_match("#^/dev/urandom#i", $path)) && !preg_match("#^/proc#i", $path) && !preg_match("#^/etc#i", $path) && !preg_match("#^/sys#i", $path) && !preg_match("#:#", $path)) {
			if (preg_match("#^/dev/urandom#i", $path)) {
				$path = FileDir::makeCorrectFile($path);
			} else {
				$path = FileDir::makeCorrectDir($path);
			}

			// check for php-version that requires the trailing
			// slash to be removed as it does not allow the usage
			// of the subfolders within the given folder, fixes #797
			if ((PHP_MINOR_VERSION == 2 && PHP_VERSION_ID >= 50216) || PHP_VERSION_ID >= 50304) {
				// check trailing slash
				if (substr($path, -1, 1) == '/') {
					// remove it
					$path = substr($path, 0, -1);
				}
			}

			if ($first) {
				return $path;
			}

			return ':' . $path;
		}
		return '';
	}
}
