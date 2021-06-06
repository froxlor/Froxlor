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
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Install
 *
 */
if (! file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
	// get hint-template
	$vendor_hint = file_get_contents(dirname(__DIR__) . '/templates/Sparkle/misc/vendormissinghint.tpl');
	// replace values
	$vendor_hint = str_replace("<FROXLOR_INSTALL_DIR>", dirname(__DIR__), $vendor_hint);
	$vendor_hint = str_replace("<CURRENT_YEAR>", date('Y', time()), $vendor_hint);
	die($vendor_hint);
}
require dirname(__DIR__) . '/vendor/autoload.php';
require __DIR__ . '/lib/class.FroxlorInstall.php';

$frxinstall = new FroxlorInstall();
$frxinstall->run();
