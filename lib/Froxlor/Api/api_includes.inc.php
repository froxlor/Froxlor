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
 * @package    API
 * @since      0.10.0
 *
 */
if (! defined('FROXLOR_INSTALL_DIR')) {
	define('FROXLOR_INSTALL_DIR', dirname(dirname(dirname(__DIR__))));
	// ensure that default timezone is set
	if (function_exists("date_default_timezone_set") && function_exists("date_default_timezone_get")) {
		@date_default_timezone_set(@date_default_timezone_get());
	}
	$installed = true;
	// check whether the userdata file exists
	if (! @file_exists(FROXLOR_INSTALL_DIR . '/lib/userdata.inc.php')) {
		$installed = false;
	}
	// check whether we can read the userdata file
	if ($installed && ! @is_readable(FROXLOR_INSTALL_DIR . '/lib/userdata.inc.php')) {
		$installed = false;
	}
	if ($installed) {
		// include userdata for content-check
		require FROXLOR_INSTALL_DIR . '/lib/userdata.inc.php';
		if (! isset($sql) || ! is_array($sql)) {
			$installed = false;
		}
	}
	// do not try to do anything if we have no installed/configured froxlor
	if (! $installed) {
		header("Status: 404 Not found", 404);
		header($_SERVER["SERVER_PROTOCOL"] . " 404 Not found", 404);
		exit();
	}
	require_once FROXLOR_INSTALL_DIR . '/lib/tables.inc.php';
	require_once FROXLOR_INSTALL_DIR . '/lib/functions.php';
}

$lng = array();
