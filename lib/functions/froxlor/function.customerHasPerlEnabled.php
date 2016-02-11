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
 * Function customerHasPerlEnabled
 *
 * returns true or false whether perl is
 * enabled for the given customer
 *
 * @param int customer-id
 *
 * @return boolean
 */
function customerHasPerlEnabled($cid = 0) {

	if ($cid > 0) {
		$result_stmt = Database::prepare("
				SELECT `perlenabled` FROM `".TABLE_PANEL_CUSTOMERS."` WHERE `customerid` = :cid"
		);
		Database::pexecute($result_stmt, array('cid' => $cid));
		$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

		if (is_array($result)
				&& isset($result['perlenabled'])
		) {
			return ($result['perlenabled'] == '1') ? true : false;
		}
	}
	return false;
}
