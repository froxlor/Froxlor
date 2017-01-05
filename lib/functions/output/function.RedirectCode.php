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
 * @package    Functions
 */

/**
 * return an array of all enabled redirect-codes
 *
 * @return array array of enabled redirect-codes
 */
function getRedirectCodesArray() {

	$sql = "SELECT * FROM `".TABLE_PANEL_REDIRECTCODES."` WHERE `enabled` = '1' ORDER BY `id` ASC";
	$result_stmt = Database::query($sql);

	$codes = array();
	while ($rc = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
		$codes[] = $rc;
	}

	return $codes;
}

/**
 * return an array of all enabled redirect-codes
 * for the settings form
 *
 * @return array array of enabled redirect-codes
 */
function getRedirectCodes() {

	global $lng;

	$sql = "SELECT * FROM `".TABLE_PANEL_REDIRECTCODES."` WHERE `enabled` = '1' ORDER BY `id` ASC";
	$result_stmt = Database::query($sql);

	$codes = array();
	while ($rc = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
		$codes[$rc['id']] = $rc['code']. ' ('.$lng['redirect_desc'][$rc['desc']].')';
	}

	return $codes;
}

/**
 * returns the redirect-code for a given
 * domain-id
 *
 * @param integer $domainid id of the domain
 * @param string $default
 *
 * @return string redirect-code
 */
function getDomainRedirectCode($domainid = 0, $default = '') {

	$code = $default;
	if ($domainid > 0) {

		$result_stmt = Database::prepare("
			SELECT `r`.`code` as `redirect`
			FROM `".TABLE_PANEL_REDIRECTCODES."` `r`, `".TABLE_PANEL_DOMAINREDIRECTS."` `rc`
			WHERE `r`.`id` = `rc`.`rid` and `rc`.`did` = :domainid
		");
		$result = Database::pexecute_first($result_stmt, array('domainid' => $domainid));

		if (is_array($result)
			&& isset($result['redirect'])
		) {
			$code = ($result['redirect'] == '---') ? $default : $result['redirect'];
		}
	}
	return $code;
}

/**
 * returns the redirect-id for a given
 * domain-id
 *
 * @param integer $domainid id of the domain
 *
 * @return integer redirect-code-id
 */
function getDomainRedirectId($domainid = 0) {

	$code = 1;
	if ($domainid > 0) {
		$result_stmt = Database::prepare("
			SELECT `r`.`id` as `redirect`
			FROM `".TABLE_PANEL_REDIRECTCODES."` `r`, `".TABLE_PANEL_DOMAINREDIRECTS."` `rc`
			WHERE `r`.`id` = `rc`.`rid` and `rc`.`did` = :domainid
		");
		$result = Database::pexecute_first($result_stmt, array('domainid' => $domainid));

		if (is_array($result)
			&& isset($result['redirect'])
		) {
			$code = (int)$result['redirect'];
		}
	}
	return $code;
}

/**
 * adds a redirectcode for a domain
 *
 * @param integer $domainid id of the domain to add the code for
 * @param integer $redirect selected redirect-id
 *
 * @return null
 */
function addRedirectToDomain($domainid = 0, $redirect = 1) {
	if ($domainid > 0) {
		$ins_stmt = Database::prepare("
			INSERT INTO `".TABLE_PANEL_DOMAINREDIRECTS."` SET `rid` = :rid, `did` = :did
		");
		Database::pexecute($ins_stmt, array('rid' => $redirect, 'did' => $domainid));
	}
}

/**
 * updates the redirectcode of a domain
 * if redirect-code is false, nothing happens
 *
 * @param integer $domainid id of the domain to update
 * @param integer $redirect selected redirect-id or false
 *
 * @return null
 */
function updateRedirectOfDomain($domainid = 0, $redirect = false) {

	if ($redirect == false) {
		return;
	}

	if ($domainid > 0) {
		$del_stmt = Database::prepare("
			DELETE FROM `".TABLE_PANEL_DOMAINREDIRECTS."` WHERE `did` = :domainid
		");
		Database::pexecute($del_stmt, array('domainid' => $domainid));

		$ins_stmt = Database::prepare("
			INSERT INTO `".TABLE_PANEL_DOMAINREDIRECTS."` SET `rid` = :rid, `did` = :did
		");
		Database::pexecute($ins_stmt, array('rid' => $redirect, 'did' => $domainid));
	}
}
