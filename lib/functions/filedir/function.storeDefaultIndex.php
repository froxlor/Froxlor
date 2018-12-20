<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

/**
 * store the default index-file in a given destination folder
 * 
 * @param string  $loginname   customers loginname
 * @param string  $destination path where to create the file
 * @param object  $logger      FroxlorLogger object
 * @param boolean $force       force creation whatever the settings say (needed for task #2, create new user)
 * 
 * @return null
 */
function storeDefaultIndex($loginname = null, $destination = null, $logger = null, $force = false) {

	if ($force
		|| (int)\Froxlor\Settings::Get('system.store_index_file_subs') == 1
	) {
		$result_stmt = \Froxlor\Database\Database::prepare("
			SELECT `t`.`value`, `c`.`email` AS `customer_email`, `a`.`email` AS `admin_email`, `c`.`loginname` AS `customer_login`, `a`.`loginname` AS `admin_login`
			FROM `" . TABLE_PANEL_CUSTOMERS . "` AS `c` INNER JOIN `" . TABLE_PANEL_ADMINS . "` AS `a`
			ON `c`.`adminid` = `a`.`adminid`
			INNER JOIN `" . TABLE_PANEL_TEMPLATES . "` AS `t`
			ON `a`.`adminid` = `t`.`adminid`
			WHERE `varname` = 'index_html' AND `c`.`loginname` = :loginname");
		\Froxlor\Database\Database::pexecute($result_stmt, array('loginname' => $loginname));

		if (\Froxlor\Database\Database::num_rows() > 0) {

			$template = $result_stmt->fetch(PDO::FETCH_ASSOC);

			$replace_arr = array(
				'SERVERNAME' => \Froxlor\Settings::Get('system.hostname'),
				'CUSTOMER' => $template['customer_login'],
				'ADMIN' => $template['admin_login'],
				'CUSTOMER_EMAIL' => $template['customer_email'],
				'ADMIN_EMAIL' => $template['admin_email']
			);

			$htmlcontent = \Froxlor\PhpHelper::replace_variables($template['value'], $replace_arr);
			$indexhtmlpath = \Froxlor\FileDir::makeCorrectFile($destination . '/index.' . \Froxlor\Settings::Get('system.index_file_extension'));
			$index_html_handler = fopen($indexhtmlpath, 'w');
			fwrite($index_html_handler, $htmlcontent);
			fclose($index_html_handler);
			if ($logger !== null) {
				$logger->logAction(CRON_ACTION, LOG_NOTICE, 'Creating \'index.' . \Froxlor\Settings::Get('system.index_file_extension') . '\' for Customer \'' . $template['customer_login'] . '\' based on template in directory ' . escapeshellarg($indexhtmlpath));
			}

		} else {
			$destination = \Froxlor\FileDir::makeCorrectDir($destination);
			if ($logger !== null) {
				$logger->logAction(CRON_ACTION, LOG_NOTICE, 'Running: cp -a ' . \Froxlor\Froxlor::getInstallDir() . '/templates/misc/standardcustomer/* ' . escapeshellarg($destination));
			}
		 \Froxlor\FileDir::safe_exec('cp -a ' . \Froxlor\Froxlor::getInstallDir() . '/templates/misc/standardcustomer/* ' . escapeshellarg($destination));
		}
	}
	return;
}
