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

/*
 * returns true or false whether a 
 * given domain id is the std-subdomain
 * of a customer
 *
 * @param	int		domain-id
 *
 * @return	boolean
 */
function isCustomerStdSubdomain($did = 0)
{
	global $db, $theme;

	if($did > 0)
	{
		$result = $db->query_first("SELECT `customerid` FROM `".TABLE_PANEL_CUSTOMERS."` WHERE `standardsubdomain` = '".(int)$did."'");
		if(is_array($result) 
			&& isset($result['customerid'])
			&& $result['customerid'] > 0
		) {
			return true;
		}
	}
	return false;
}
