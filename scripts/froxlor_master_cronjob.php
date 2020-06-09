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

// validate correct php version
if (version_compare("7.0.0", PHP_VERSION, ">=")) {
	die('Froxlor requires at least php-7.0. Please validate that your php-cli version and the cron execution command are correct.');
}

require dirname(__DIR__) . '/vendor/autoload.php';

\Froxlor\Cron\MasterCron::setArguments($argv);
\Froxlor\Cron\MasterCron::run();
