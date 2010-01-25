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

/*
 * Function getNextCronjobs
 *
 * checks which cronjobs have to be executed 
 *
 * @return	array	array of cron-files which are to be executed
 */
function getNextCronjobs()
{
	// SELECT `interval`, `lastrun` FROM `".PANEL_TABLE_CRONRUNS."`
}
