<?php

/**
 * Support-Tickets - Reset used tickets - Cronfile
 *
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version. This program is distributed in the
 * hope that it will be useful, but WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @license    http://www.gnu.org/licenses/gpl.txt
 * @package    Panel
 * @version    CVS: $Id$
 * @link       http://www.nutime.de/
 * @since      File available since Release 1.2.20
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