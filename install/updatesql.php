<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    http://files.froxlor.org/misc/COPYING.txt GPLv2
 */

use Froxlor\FroxlorLogger;

require_once __DIR__ . '/lib/updateFunctions.php';

if (!defined('_CRON_UPDATE')) {
	if (!defined('AREA') || (defined('AREA') && AREA != 'admin') || !isset($userinfo['loginname']) || (isset($userinfo['loginname']) && $userinfo['loginname'] == '')) {
		header('Location: ../index.php');
		exit();
	}
}

$filelog = FroxlorLogger::getInstanceOf(array(
	'loginname' => 'updater'
));

// if first writing does not work we'll stop, tell the user to fix it
// and then let him try again.
try {
	$filelog->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_WARNING, '-------------- START LOG --------------');
} catch (Exception $e) {
	\Froxlor\UI\Response::standard_error('exception', $e->getMessage());
}

if (\Froxlor\Froxlor::isFroxlor()) {

	// will be filled and increased by the update include-files below
	$update_tasks = [];
	$task_counter = 0;

	include_once(\Froxlor\FileDir::makeCorrectFile(dirname(__FILE__) . '/updates/froxlor/0.11/update_0.11.inc.php'));

	// Check Froxlor - database integrity (only happens after all updates are done, so we know the db-layout is okay)
	showUpdateStep("Checking database integrity");

	$integrity = new \Froxlor\Database\IntegrityCheck();
	if (!$integrity->checkAll()) {
		lastStepStatus(1, 'Monkeys ate the integrity');
		showUpdateStep("Trying to remove monkeys, feeding bananas");
		if (!$integrity->fixAll()) {
			lastStepStatus(2, 'failed', 'Some monkeys just would not move, you should contact team@froxlor.org');
		} else {
			lastStepStatus(0, 'Integrity restored');
		}
	} else {
		lastStepStatus(0);
	}

	$filelog->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_WARNING, '--------------- END LOG ---------------');
	unset($filelog);
}
