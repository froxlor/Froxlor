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
 * @package    Cron
 *
 */



// -- helper function
function getCronFile($cronname) {
	return makeCorrectFile(FROXLOR_INSTALL_DIR.'/scripts/jobs/cron_'.$cronname.'.php');
}

function addToQueue(&$jobs_to_run, $cronname) {
	if (!in_array($cronname, $jobs_to_run)) {
		$cronfile = getCronFile($cronname);
		if (file_exists($cronfile)) {
			array_unshift($jobs_to_run, $cronname);
		}
	}
}

