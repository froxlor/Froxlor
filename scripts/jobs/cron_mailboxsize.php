<?php if (!defined('MASTER_CRONJOB')) die('You cannot access this file directly!');

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
 * @package    Cron
 *
 * @since      0.9.29.1
 *
 */

fwrite($debugHandler, "calculating mailspace usage\n");

$maildirs = $db->query("SELECT `id`, CONCAT(`homedir`, `maildir`) AS `maildirpath` FROM `".TABLE_MAIL_USERS."` ORDER BY `id`");

while ($maildir = $db->fetch_array($maildirs)) {

	$_maildir = makeCorrectDir($maildir['maildirpath']);

	if (file_exists($_maildir) 
		&& is_dir($_maildir)
	) {
		$back = safe_exec('du -sb ' . escapeshellarg($_maildir) . '');
		foreach ($back as $backrow) {
			$emailusage = explode(' ', $backrow);
		}
		$emailusage = floatval($emailusage['0']);
		unset($back);
		$db->query("UPDATE `".TABLE_MAIL_USERS."` SET `mboxsize` = '".(int)$emailusage."' WHERE `id` ='".(int)$maildir['id']."'");
	} else {
		fwrite($debugHandler, 'maildir ' . $_maildir . ' does not exist' . "\n");
	}
}
