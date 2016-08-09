<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2016-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Functions
 *
 */

function getAllowedDomainEntry($domain_id, $area = 'customer', $userinfo, &$idna_convert)
{
	$dom_data = array(
		'did' => $domain_id
	);

	$where_clause = '';
	if ($area == 'admin') {
		if ($userinfo['domains_see_all'] != '1') {
			$where_clause = '`adminid` = :uid AND ';
			$dom_data['uid'] = $userinfo['userid'];
		}
	} else {
		$where_clause = '`customerid` = :uid AND ';
		$dom_data['uid'] = $userinfo['userid'];
	}

	$dom_stmt = Database::prepare("
		SELECT domain, isbinddomain
		FROM `" . TABLE_PANEL_DOMAINS . "`
		WHERE " . $where_clause . " id = :did
	");
	$domain = Database::pexecute_first($dom_stmt, $dom_data);

	if ($domain) {
		if ($domain['isbinddomain'] != '1') {
			standard_error('dns_domain_nodns');
		}
		return $idna_convert->decode($domain['domain']);
	}
	standard_error('dns_notfoundorallowed');
}
