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
 *
 */

/**
 * check whether a domain has subdomains added as full-domains
 * #329
 * 
 *  @param int $id domain-id
 *  
 *  @return boolean
 */
function domainHasMainSubDomains($id = 0) {
	
	$result_stmt = Database::prepare("
		SELECT COUNT(`id`) as `mainsubs` FROM `".TABLE_PANEL_DOMAINS."`
		WHERE `ismainbutsubto` = :id"
	);
	$result = Database::pexecute_first($result_stmt, array('id' => $id));

	if (isset($result['mainsubs'])
		&& $result['mainsubs'] > 0
	) {
		return true;
	}
	return false;
}

/**
 * check whether a subof-domain exists
 * #329
 * 
 *  @param int $id subof-domain-id
 *  
 *  @return boolean
 */
function domainMainToSubExists($id = 0) {
	
	$result_stmt = Database::prepare("
		SELECT `id` FROM `".TABLE_PANEL_DOMAINS."` WHERE `id` = :id"
	);
	Database::pexecute($result_stmt, array('id' => $id));
	$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

	if (isset($result['id'])
		&& $result['id'] > 0
	) {
		return true;
	}
	return false;
}
