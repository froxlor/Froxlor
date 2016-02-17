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
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Daniel Reichelt <hacking@nachtgeist.net> (2016-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

function getLogLevelDesc($type) {
	switch($type) {
		case LOG_INFO:
			$_type = 'information';
			break;
		case LOG_NOTICE:
			$_type = 'notice';
			break;
		case LOG_WARNING:
			$_type = 'warning';
			break;
		case LOG_ERR:
			$_type = 'error';
			break;
		case LOG_CRIT:
			$_type = 'critical';
			break;
		case LOG_DEBUG:
			$_type = 'debug';
			break;
		default:
			$_type = 'unknown';
			break;
	}
	return $_type;
}
