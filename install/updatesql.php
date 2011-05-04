<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Install
 *
 */

$updatelog = FroxlorLogger::getInstanceOf(array('loginname' => 'updater'), $db, $settings);

$updatelogfile = validateUpdateLogFile(makeCorrectFile(dirname(__FILE__).'/update.log'));
$filelog = FileLogger::getInstanceOf(array('loginname' => 'updater'), $settings);
$filelog->setLogFile($updatelogfile);

// if first writing does not work we'll stop, tell the user to fix it
// and then let him try again.
try {
	$filelog->logAction(ADM_ACTION, LOG_WARNING, '-------------- START LOG --------------');
} catch(Exception $e) {
	standard_error('exception', $e->getMessage());
}

/*
 * since froxlor, we have to check if there's still someone
 * out there using syscp and needs to upgrade
 */
if(!isFroxlor())
{
	/**
	 * First case: We are updating from a version < 1.0.10
	 */

	if(!isset($settings['panel']['version'])
	|| (substr($settings['panel']['version'], 0, 3) == '1.0' && $settings['panel']['version'] != '1.0.10'))
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.0 to 1.0.10");
		include_once (makeCorrectFile(dirname(__FILE__).'/updates/syscp/1.0/update_1.0_1.0.10.inc.php'));
	}

	/**
	 * Second case: We are updating from version = 1.0.10
	 */

	if($settings['panel']['version'] == '1.0.10')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.0.10 to 1.2-beta1");
		include_once (makeCorrectFile(dirname(__FILE__).'/updates/syscp/1.0/update_1.0.10_1.2-beta1.inc.php'));
	}

	/**
	 * Third case: We are updating from a version > 1.2-beta1
	 */

	if(substr($settings['panel']['version'], 0, 3) == '1.2')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2-beta1 to 1.2.19");
		include_once (makeCorrectFile(dirname(__FILE__).'/updates/syscp/1.2/update_1.2-beta1_1.2.19.inc.php'));
	}

	/**
	 * 4th case: We are updating from 1.2.19 to 1.2.20 (prolly the last from the 1.2.x series)
	 */

	if(substr($settings['panel']['version'], 0, 6) == '1.2.19')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19 to 1.4");
		include_once (makeCorrectFile(dirname(__FILE__).'/updates/syscp/1.2/update_1.2.19_1.4.inc.php'));
	}

	/**
	 * 5th case: We are updating from a version >= 1.4
	 */

	if(substr($settings['panel']['version'], 0, 3) == '1.4')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.4");
		include_once (makeCorrectFile(dirname(__FILE__).'/updates/syscp/1.4/update_1.4.inc.php'));
	}

	/**
	 * Upgrading SysCP to Froxlor-0.9
	 *
	 * when we reach this part, all necessary updates
	 * should have been installes automatically by the
	 * update scripts.
	 */
	include_once (makeCorrectFile(dirname(__FILE__).'/updates/froxlor/upgrade_syscp.inc.php'));

}

if(isFroxlor())
{
	include_once (makeCorrectFile(dirname(__FILE__).'/updates/froxlor/0.9/update_0.9.inc.php'));
	$filelog->logAction(ADM_ACTION, LOG_WARNING, '--------------- END LOG ---------------');
	unset($filelog);
}
