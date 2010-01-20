<?php

/**
 * This file is part of the SysCP project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org>
 * @author     Florian Aders <eleras@syscp.org>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    System
 * @version    $Id: cron_shutdown.php 2692 2009-03-27 18:04:47Z flo $
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

