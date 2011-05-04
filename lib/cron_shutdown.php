<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Cron
 *
 */

if($settings['logger']['log_cron'] == '1')
{
	$cronlog->setCronLog(0);
	fwrite($debugHandler, 'Logging for cron has been shutdown' . "\n");
}

$db->close();
fwrite($debugHandler, 'Closing database connection' . "\n");

if(isset($db_root))
{
	$db_root->close();
	fwrite($debugHandler, 'Closing database rootconnection' . "\n");
}

if($keepLockFile === true)
{
	fwrite($debugHandler, '=== Keep lockfile because of exception ===');
}

fclose($debugHandler);

if($keepLockFile === false
   && $cronscriptDebug === false)
{
	unlink($lockfile);
}

