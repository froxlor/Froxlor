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
// define default theme for configurehint, etc.
$_deftheme = 'Froxlor';

// validate correct php version
if (version_compare("7.1.0", PHP_VERSION, ">=")) {
	// get hint-template
	$wrongphp_hint = file_get_contents(dirname(__DIR__) . '/templates/' . $_deftheme . '/misc/phprequirementfailed.html.twig');
	// replace values
	$wrongphp_hint = str_replace("<FROXLOR_PHPMIN>", "7.1.0", $wrongphp_hint);
	$wrongphp_hint = str_replace("<CURRENT_VERSION>", PHP_VERSION, $wrongphp_hint);
	$wrongphp_hint = str_replace("<CURRENT_YEAR>", date('Y', time()), $wrongphp_hint);
	die($wrongphp_hint);
}

if (!file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
	// get hint-template
	$vendor_hint = file_get_contents(dirname(__DIR__) . '/templates/' . $_deftheme . '/misc/vendormissinghint.html.twig');
	// replace values
	$vendor_hint = str_replace("<FROXLOR_INSTALL_DIR>", dirname(__DIR__), $vendor_hint);
	$vendor_hint = str_replace("<CURRENT_YEAR>", date('Y', time()), $vendor_hint);
	die($vendor_hint);
}

require dirname(__DIR__) . '/vendor/autoload.php';
require __DIR__ . '/lib/class.FroxlorInstall.php';

use Froxlor\UI\Panel\UI;

UI::initTwig(true);
UI::Twig()->addGlobal('install_mode', '1');
UI::Twig()->addGlobal('basehref', '../');

$frxinstall = new FroxlorInstall();
$frxinstall->run();

UI::TwigOutputBuffer();
