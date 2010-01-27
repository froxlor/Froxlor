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

function includeCronjobs($debugHandler, $pathtophpfiles)
{
	$cronjobs = getNextCronjobs();
	
	$jobs_to_run = array();
	
	if($cronjobs !== false
	&& is_array($cronjobs)
	&& isset($cronjobs[0]))
	{
		$cron_path = makeCorrectDir($pathtophpfiles.'/scripts/jobs/');
		
		foreach($cronjobs as $cronjob)
		{
			$cron_file = makeCorrectFile($cron_path.$cronjob);
			$jobs_to_run[] = $cron_file;
		}
	}
	
	return $jobs_to_run;
}
