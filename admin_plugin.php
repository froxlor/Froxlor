<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Oskar Eisemuth
 * @author     Froxlor team <team@froxlor.org> (2016-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Classes
 *
 */

define('AREA', 'admin');
require './lib/init.php';


$plugin = '';
if (isset($_POST['plugin'])) {
	$plugin = $_POST['plugin'];
} elseif(isset($_GET['plugin'])) {
	$plugin = $_GET['plugin'];
}

$plugins = FroxlorPlugins::getInstance();
$plugins->getPlugins();
FroxlorEvent::PluginPage(array(
	'AREA' => AREA,
	'plugin' => $plugin,
	'page' => $page,
	'action' => $action
));

