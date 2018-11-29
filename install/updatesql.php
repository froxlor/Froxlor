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

if (!defined('_CRON_UPDATE')) {
	if (!defined('AREA')
		|| (defined('AREA') && AREA != 'admin')
		|| !isset($userinfo['loginname'])
		|| (isset($userinfo['loginname']) && $userinfo['loginname'] == '')
	) {
		header('Location: ../index.php');
		exit;
	}
}

$updatelog = FroxlorLogger::getInstanceOf(array('loginname' => 'updater'));

$updatelogfile = validateUpdateLogFile(makeCorrectFile(dirname(__FILE__).'/update.log'));
$filelog = FileLogger::getInstanceOf(array('loginname' => 'updater'));
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
if(!isFroxlor()) {
	/**
	 * Upgrading SysCP to Froxlor-0.9
	 */
	include_once (makeCorrectFile(dirname(__FILE__).'/updates/froxlor/upgrade_syscp.inc.php'));
}

if (isFroxlor()) {
	include_once (makeCorrectFile(dirname(__FILE__).'/updates/froxlor/0.9/update_0.9.inc.php'));
	include_once (makeCorrectFile(dirname(__FILE__).'/updates/froxlor/0.10/update_0.10.inc.php'));

	// Check Froxlor - database integrity (only happens after all updates are done, so we know the db-layout is okay)
	showUpdateStep("Checking database integrity");

	$integrity = new IntegrityCheck();
	if (!$integrity->checkAll()) {
		lastStepStatus(1, 'Monkeys ate the integrity');
		showUpdateStep("Trying to remove monkeys, feeding bananas");
		if(!$integrity->fixAll()) {
			lastStepStatus(2, 'Some monkeys just would not move, you should contact team@froxlor.org');
		} else {
			lastStepStatus(0, 'Integrity restored');
		}
	} else {
		lastStepStatus(0);
	}

	$filelog->logAction(ADM_ACTION, LOG_WARNING, '--------------- END LOG ---------------');
	unset($filelog);
}
