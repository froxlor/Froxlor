<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2015 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Oskar Eisemuth
 * @author     Froxlor team <team@froxlor.org> (2015-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 *
 */

class FroxlorEventConstantsDeprecated {
	
}

/**
 * All current possible core events
 */
class FroxlorEventConstants extends FroxlorEventConstantsDeprecated {
	const LoadLanguage = 'LoadLanguage';
	const CreateNavigation = 'CreateNavigation';
	const ServerSettings = 'ServerSettings';
	const RebuildConfigs = 'RebuildConfigs';
	
	const GetServiceConfiguration = 'GetServiceConfiguration';

	const InitDone = 'InitDone';
	
	const CronInitDone = 'CronInitDone';
	const CronForce = 'CronForce';
	const CronTaskRunPre = 'CronTaskRunPre';
	const CronTaskRunPost = 'CronTaskRunPost';

	const ApacheVHost = 'ApacheVHost';
}