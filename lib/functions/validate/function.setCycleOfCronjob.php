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

function setCycleOfCronjob($fieldname, $fielddata, $newfieldvalue, $allnewfieldvalues)
{
	global $settings, $db, $theme;

	switch($newfieldvalue)
	{
		case 0:
			$interval = 'DAY';
			break;
		case 1:
			$interval = 'WEEK';
			break;
		case 2:
			$interval = 'MONTH';
			break;
		case 3:
			$interval = 'YEAR';
			break;
		default:
			$interval = 'MONTH';
			break;
	}
	
	$db->query("UPDATE `cronjobs_run` SET `interval` = '1 ".$interval."' WHERE `cronfile` = 'cron_used_tickets_reset.php';");

	return array(FORMFIELDS_PLAUSIBILITY_CHECK_OK);
}
