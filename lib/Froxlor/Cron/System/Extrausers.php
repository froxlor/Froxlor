<?php
namespace Froxlor\Cron\System;

use Froxlor\Database\Database;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2017 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2017-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Cron
 *         
 */
class Extrausers
{

	public static function generateFiles(&$cronlog)
	{
		// passwd
		$passwd = '/var/lib/extrausers/passwd';
		$sql = "SELECT customerid,username,'x' as password,uid,gid,'Froxlor User' as comment,homedir,shell, login_enabled FROM ftp_users ORDER BY uid ASC";
		self::generateFile($passwd, $sql, $cronlog);

		// group
		$group = '/var/lib/extrausers/group';
		$sql = "SELECT groupname,'x' as password,gid,members FROM ftp_groups ORDER BY gid ASC";
		self::generateFile($group, $sql, $cronlog);

		// shadow
		$shadow = '/var/lib/extrausers/shadow';
		$sql = "SELECT username,password FROM ftp_users ORDER BY gid ASC";
		self::generateFile($shadow, $sql, $cronlog);

		// set correct permissions
		@chmod('/var/lib/extrausers/', 0755);
		@chmod('/var/lib/extrausers/passwd', 0644);
		@chmod('/var/lib/extrausers/group', 0644);
		@chmod('/var/lib/extrausers/shadow', 0640);
	}

	private static function generateFile($file, $query, &$cronlog)
	{
		$type = basename($file);
		$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_NOTICE, 'Creating ' . $type . ' file');

		if (! file_exists($file)) {
			$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_NOTICE, $type . ' file does not yet exist');
			@mkdir(dirname($file), 0750, true);
			touch($file);
		}

		$data_sel_stmt = Database::query($query);
		$data_content = "";
		$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_NOTICE, 'Writing ' . $data_sel_stmt->rowCount() . ' entries to ' . $type . ' file');
		while ($u = $data_sel_stmt->fetch(\PDO::FETCH_ASSOC)) {
			switch ($type) {
				case 'passwd':
					// get user real name
					$salutation_array = array(
						'firstname' => \Froxlor\Customer\Customer::getCustomerDetail($u['customerid'], 'firstname'),
						'name' => \Froxlor\Customer\Customer::getCustomerDetail($u['customerid'], 'name'),
						'company' => \Froxlor\Customer\Customer::getCustomerDetail($u['customerid'], 'company')
					);
					$u['comment'] = \Froxlor\User::getCorrectUserSalutation($salutation_array);
					if ($u['login_enabled'] != 'Y') {
						$u['password'] = '*';
						$u['shell'] = '/bin/false';
						$u['comment'] = 'Locked Froxlor User';
					}
					$line = $u['username'] . ':' . $u['password'] . ':' . $u['uid'] . ':' . $u['gid'] . ':' . $u['comment'] . ':' . $u['homedir'] . ':' . $u['shell'] . PHP_EOL;
					break;
				case 'group':
					$line = $u['groupname'] . ':' . $u['password'] . ':' . $u['gid'] . ':' . $u['members'] . PHP_EOL;
					break;
				case 'shadow':
					$line = $u['username'] . ':' . $u['password'] . ':' . floor(time() / 86400 - 1) . ':0:99999:7:::' . PHP_EOL;
					break;
			}
			$data_content .= $line;
		}
		if (file_put_contents($file, $data_content) !== false) {
			$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_NOTICE, 'Succesfully wrote ' . $type . ' file');
		} else {
			$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_NOTICE, 'Error when writing ' . $type . ' file entries');
		}
	}
}
