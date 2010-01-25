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
 * @version    $Id$
 */

/**
 * STARTING REDUNDANT CODE, WHICH IS SOME KINDA HEADER FOR EVERY CRON SCRIPT.
 * When using this "header" you have to change $lockFilename for your needs.
 * Don't forget to also copy the footer which closes database connections
 * and the lockfile! (Note: This "header" also establishes a mysql-root-
 * connection, if you don't need it, see for the header in cron_tasks.php)
 */

$needrootdb = false;
include (dirname(__FILE__) . '/../lib/cron_init.php');

/**
 * END REDUNDANT CODE (CRONSCRIPT "HEADER")
 */

/**
 * RESET USED TICKETS COUNTER
 */

fwrite($debugHandler, 'Used tickets reset run started...' . "\n");
$now = time();
$cycle = $settings['ticket']['reset_cycle'];

if($cycle == '0'
   || ($cycle == '1' && (date("j", $now) == '1' || date("j", $now) == '7' || date("j", $now) == '14' || date("j", $now) == '21'))
   || ($cycle == '2' && date("j", $now) == '1')
   || ($cycle == '3' && date("dm", $now) == '0101'))
{
	fwrite($debugHandler, 'Resetting customers used ticket counter' . "\n");
	$db->query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `tickets_used` = '0'");
}

/**
 * STARTING CRONSCRIPT FOOTER
 */

include ($pathtophpfiles . '/lib/cron_shutdown.php');

/**
 * END CRONSCRIPT FOOTER
 */

?>