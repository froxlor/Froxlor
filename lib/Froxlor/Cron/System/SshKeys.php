<?php

/**
 * This file is part of the froxlor project.
 * Copyright (c) 2010 the froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

namespace Froxlor\Cron\System;

use Froxlor\Database\Database;
use Froxlor\FileDir;
use Froxlor\FroxlorLogger;
use Froxlor\Settings;
use PDO;

class SshKeys
{
	public static function generateFiles(&$cronlog)
	{
		if (intval(Settings::Get('system.allow_customer_shell')) == 0) {
			return;
		}

		// authorized_keys
		$sel_stmt = Database::prepare("
			SELECT id,customerid,username,homedir,uid,gid,shell,login_enabled
			FROM `" . TABLE_FTP_USERS . "`
			ORDER BY uid, LENGTH(username) ASC
		");
		Database::pexecute($sel_stmt);
		$sshkeys_sel_stmt = Database::prepare("
			SELECT `id`, `ssh_pubkey` FROM `" . TABLE_PANEL_USER_SSHKEYS . "` WHERE `ftp_user_id` = :fuid AND `customerid` = :cid
		");
		while ($usr = $sel_stmt->fetch(PDO::FETCH_ASSOC)) {
			$authkeysfile = FileDir::makeCorrectFile($usr['homedir'] . '/.ssh/authorized_keys');
			$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_NOTICE, 'Creating file ' . $authkeysfile);
			// remove all entries with 'froxlor:id=...'
			self::removeFroxlorKeys($authkeysfile, $cronlog);
			// get keys
			Database::pexecute($sshkeys_sel_stmt, ['fuid' => $usr['id'], 'cid' => $usr['customerid']]);
			if ($sshkeys_sel_stmt->rowCount() > 0) {
				if (!file_exists(dirname($authkeysfile))) {
					@mkdir(dirname($authkeysfile), 0700);
				}
				if (!file_exists($authkeysfile)) {
					@touch($authkeysfile);
				}

				while ($sshkey = $sshkeys_sel_stmt->fetch(PDO::FETCH_ASSOC)) {
					// normalize: Algo + Base64 part (remove comment)
					$parts = preg_split('/\s+/', trim($sshkey['ssh_pubkey']), 3);
					if (count($parts) < 2) {
						// Invalid public key format
						continue;
					}
					$normalized = $parts[0] . ' ' . $parts[1];

					// Datei lesen (falls sie schon existiert)
					$existing = [];
					if (file_exists($authkeysfile)) {
						$lines = file($authkeysfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
						foreach ($lines as $line) {
							$lineParts = preg_split('/\s+/', trim($line), 3);
							if (count($lineParts) >= 2) {
								$existing[] = $lineParts[0] . ' ' . $lineParts[1];
							}
						}
					}

					// does the key exist already?
					if (in_array($normalized, $existing, true)) {
						// skip
						continue;
					}

					// add key
					$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_NOTICE, 'Adding ssh-key for user ' . $usr['username']);
					file_put_contents($authkeysfile, trim($sshkey['ssh_pubkey']) . " froxlor:id=" . $sshkey['id'] . "\n", FILE_APPEND | LOCK_EX);
				}
			}
			@chmod(dirname($authkeysfile), 0700);
			@chown(dirname($authkeysfile), $usr['uid']);
			@chgrp(dirname($authkeysfile), $usr['gid']);
			@chmod($authkeysfile, 0600);
			@chown($authkeysfile, $usr['uid']);
			@chgrp($authkeysfile, $usr['gid']);
		}
	}

	private static function removeFroxlorKeys(string $authFile, &$cronlog): bool
	{
		if (!file_exists($authFile)) {
			return false;
		}

		$lines = file($authFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		$newLines = [];

		foreach ($lines as $line) {
			// kill whitespaces
			$trim = trim($line);

			// if comment 'froxlor:id=' skip line
			$matches = [];
			if (preg_match('/\bfroxlor:id=(.+)/', $trim, $matches)) {
				$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'Removing ' . $matches[0]);
				continue;
			}

			if (!empty($trim)) {
				$newLines[] = $line;
			}
		}

		// use LOCK_EX to avoid race
		if (empty($newLines)) {
			// empty file, we can safely remove it
			@unlink($authFile);
		} else {
			// keep existing (non-froxlor-managed entries)
			file_put_contents($authFile, implode("\n", $newLines) . "\n", LOCK_EX);
		}
		return true;
	}
}
