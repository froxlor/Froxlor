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
 * @version    $Id: $
 */

function includeCronjobs($debugHandler)
{
	$cronjobs = getNextCronjobs();
	
	if($cronjobs !== false
	&& is_array($cronjobs)
	&& isset($cronjobs[0]))
	{
		/*
		 * @TODO find a better way for the path
		 */
		$cron_path = dirname(__FILE__).'/../../../scripts/jobs/';
		
		foreach($cronjobs as $cronjob)
		{
			$cron_file = makeCorrectFile($cron_path.$cronjob);
			include_once($cron_file);
		}
	}
}
