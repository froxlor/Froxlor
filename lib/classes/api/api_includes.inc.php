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
	require_once FROXLOR_INSTALL_DIR . '/lib/tables.inc.php';
	require_once FROXLOR_INSTALL_DIR . '/lib/functions.php';
}

$lng = array();
