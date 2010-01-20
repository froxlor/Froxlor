<?php

/**
 * Support-Tickets - Cronfile
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
 * @version    CVS: $Id: cron_ticketarchive.php 2724 2009-06-07 14:18:02Z flo $
 * @link       http://www.nutime.de/
 * @since      File available since Release 1.2.18
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
 * ARCHIVING CLOSED TICKETS
 */

fwrite($debugHandler, 'Ticket-archiving run started...' . "\n");
$result_tickets = $db->query("SELECT `id`, `lastchange`, `subject` FROM `" . TABLE_PANEL_TICKETS . "` 
                              WHERE `status` = '3' AND `answerto` = '0';");
$archiving_count = 0;

while($row_ticket = $db->fetch_array($result_tickets))
{
	$lastchange = $row_ticket['lastchange'];
	$now = time();
	$days = (int)(($now - $lastchange) / 86400);

	if($days >= $settings['ticket']['archiving_days'])
	{
		fwrite($debugHandler, 'archiving ticket "' . $row_ticket['subject'] . '" (ID #' . $row_ticket['id'] . ')' . "\n");
		$mainticket = ticket::getInstanceOf($userinfo, $db, $settings, (int)$row_ticket['id']);
		$mainticket->Set('lastchange', $now, true, true);
		$mainticket->Set('lastreplier', '1', true, true);
		$mainticket->Set('status', '3', true, true);
		$mainticket->Update();
		$mainticket->Archive();
		$archiving_count++;
	}
}

fwrite($debugHandler, 'Archived ' . $archiving_count . ' tickets' . "\n");
$db->query('UPDATE `' . TABLE_PANEL_SETTINGS . '` SET `value` = UNIX_TIMESTAMP() WHERE `settinggroup` = \'system\'   AND `varname`      = \'last_archive_run\' ');

/**
 * STARTING CRONSCRIPT FOOTER
 */

include ($pathtophpfiles . '/lib/cron_shutdown.php');

/**
 * END CRONSCRIPT FOOTER
 */

?>