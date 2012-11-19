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
 * @package    Language
 *
 */

/**
 * Function domainHasApsInstances
 *
 * Checks if a given domain id
 * is used for APS instances
 * (if APS enabled, else always false)
 *
 * @param int domain-id
 *
 * @return boolean
 */
function domainHasApsInstances($domainid = 0)
{
	global $db, $settings, $theme;
	
	if($settings['aps']['aps_active'] == '1')
	{
		if($domainid > 0)
		{
			$instances = $db->query_first("SELECT COUNT(`ID`) AS `count` FROM `" . TABLE_APS_SETTINGS . "` WHERE `Name`='main_domain' AND `Value`='" . (int)$domainid . "'");
			if((int)$instances['count'] != 0)
			{
				return true;
			}
		}
	}
	return false;
}
