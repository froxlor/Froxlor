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
		$mainticket = ticket::getInstanceOf(null, $db, $settings, (int)$row_ticket['id']);
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

?>