<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2013 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Cron
 *
 * @since      0.9.29.1-dev1
 *
 */

/**
 * Check whether a given domain has an ssl-ip/port assigned
 *
 * @param int $domainid
 *
 * @return boolean
 */
function domainHasSslIpPort($domainid = 0) {

	$result_stmt = Database::prepare("
			SELECT `dt`.* FROM `".TABLE_DOMAINTOIP."` `dt`, `".TABLE_PANEL_IPSANDPORTS."` `iap`
			WHERE `dt`.`id_ipandports` = `iap`.`id` AND `iap`.`ssl` = '1' AND `dt`.`id_domain` = :domainid;"
	);
	Database::pexecute($result_stmt, array('domainid' => $domainid));
	$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

	if (is_array($result)
			&& isset($result['id_ipandports'])
	) {
		return true;
	}
	return false;
}
