<?php
namespace Froxlor\Cron\System;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Michael Kaufmann <mkaufmann@nutime.de>
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Cron
 *         
 * @since 0.9.29.1
 *       
 */
class MailboxsizeCron extends \Froxlor\Cron\FroxlorCron
{

	public static function run()
	{
		\Froxlor\FroxlorLogger::getInstanceOf()->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_NOTICE, 'calculating mailspace usage');

		$maildirs_stmt = \Froxlor\Database\Database::query("
			SELECT `id`, CONCAT(`homedir`, `maildir`) AS `maildirpath` FROM `" . TABLE_MAIL_USERS . "` ORDER BY `id`
		");

		$upd_stmt = \Froxlor\Database\Database::prepare("
			UPDATE `" . TABLE_MAIL_USERS . "` SET `mboxsize` = :size WHERE `id` = :id
		");

		while ($maildir = $maildirs_stmt->fetch(\PDO::FETCH_ASSOC)) {

			$_maildir = \Froxlor\FileDir::makeCorrectDir($maildir['maildirpath']);

			if (file_exists($_maildir) && is_dir($_maildir)) {
				$maildirsize = \Froxlor\FileDir::makeCorrectFile($_maildir . '/maildirsize');
				
				// When quota is enabled and maildirsize file exists, use that to calculate size
				if (\Froxlor\Settings::Get('system.mail_quota_enabled') == 1 && file_exists($maildirsize)) {
					\Froxlor\FroxlorLogger::getInstanceOf()->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_NOTICE, 'found maildirsize file in ' . $_maildir);
					$file = file($maildirsize, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
					// Remove header
					array_shift($file);
					$emailusage = 0;
					// Sum up all the changes (line 2 -> end)
					foreach ($file as $line) {
						$parts = explode(' ', $line);
						if (!empty($parts[0])) {
							$emailusage += floatval($parts[0]);
						}
					}
				} else {
					// if quota is disabled or maildirsize file does not exist, compute with du
					// mail-address allows many special characters, see http://en.wikipedia.org/wiki/Email_address#Local_part
					$return = false;
					$back = \Froxlor\FileDir::safe_exec('du -sk ' . escapeshellarg($_maildir), $return, array(
						'|',
						'&',
						'`',
						'$',
						'~',
						'?'
					));
					foreach ($back as $backrow) {
						$emailusage = explode(' ', $backrow);
					}
					$emailusage = floatval($emailusage['0']);

					// as freebsd does not have the -b flag for 'du' which gives
					// the size in bytes, we use "-sk" for all and calculate from KiB
					$emailusage *= 1024;

					unset($back);
				}
				\Froxlor\Database\Database::pexecute($upd_stmt, array(
					'size' => $emailusage,
					'id' => $maildir['id']
				));
			} else {
				\Froxlor\FroxlorLogger::getInstanceOf()->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_WARNING, 'maildir ' . $_maildir . ' does not exist');
			}
		}
	}
}
