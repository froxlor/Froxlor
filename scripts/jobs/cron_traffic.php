<?php if (!defined('MASTER_CRONJOB')) die('You cannot access this file directly!');

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

// Check Traffic-Lock
if (function_exists('pcntl_fork') && !defined('CRON_NOFORK_FLAG')) {
	$TrafficLock = makeCorrectFile(dirname($lockfile)."/froxlor_cron_traffic.lock");
	if (file_exists($TrafficLock)
		&& is_numeric($TrafficPid=file_get_contents($TrafficLock))
	) {
		if (function_exists('posix_kill')) {
			$TrafficPidStatus = @posix_kill($TrafficPid,0);
		} else {
			system("kill -CHLD " . $TrafficPid . " 1> /dev/null 2> /dev/null", $TrafficPidStatus);
			$TrafficPidStatus = $TrafficPidStatus ? false : true;
		}
		if ($TrafficPidStatus) {
			$cronlog->logAction(CRON_ACTION, LOG_INFO, 'Traffic Run already in progress');
			return 1;
		}
	}
	// Create Traffic Log and Fork
	// We close the database - connection before we fork, so we don't share resources with the child
	Database::needRoot(false); // this forces the connection to be set to null
	$TrafficPid = pcntl_fork();
	// Parent
	if ($TrafficPid) {
		file_put_contents($TrafficLock, $TrafficPid);
		// unnecessary to recreate database connection here
		return 0;

	}
	//Child
	elseif ($TrafficPid == 0) {
		posix_setsid();
		fclose($debugHandler);
		// re-create db
		Database::needRoot(false);
	}
	//Fork failed
	else {
		return 1;
	}

} else {
	if (extension_loaded('pcntl')) {
		$msg = "PHP compiled with pcntl but pcntl_fork function is not available.";
	} else {
		$msg = "PHP compiled without pcntl.";
	}
	$cronlog->logAction(CRON_ACTION, LOG_INFO, $msg." Not forking traffic-cron, this may take a long time!");
}

require_once makeCorrectFile(dirname(__FILE__) . '/cron_traffic.inc.functions.php');

/**
 * TRAFFIC AND DISKUSAGE MESSURE
 */
$cronlog->logAction(CRON_ACTION, LOG_INFO, 'Traffic run started...');
$admin_traffic = array();
$domainlist = array();
$speciallogfile_domainlist = array();
$result_domainlist_stmt = Database::query("
	SELECT `id`, `domain`, `customerid`, `parentdomainid`, `speciallogfile`
	FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `aliasdomain` IS NULL AND `email_only` <> '1';
");

while ($row_domainlist = $result_domainlist_stmt->fetch(PDO::FETCH_ASSOC)) {

	if (!isset($domainlist[$row_domainlist['customerid']])) {
		$domainlist[$row_domainlist['customerid']] = array();
	}

	$domainlist[$row_domainlist['customerid']][$row_domainlist['id']] = $row_domainlist['domain'];

	if ($row_domainlist['parentdomainid'] == '0'
		&& $row_domainlist['speciallogfile'] == '1'
	) {
		if (!isset($speciallogfile_domainlist[$row_domainlist['customerid']])) {
			$speciallogfile_domainlist[$row_domainlist['customerid']] = array();
		}
		$speciallogfile_domainlist[$row_domainlist['customerid']][$row_domainlist['id']] = $row_domainlist['domain'];
	}
}

$mysqlusage_all = array();
$databases_stmt = Database::query("SELECT * FROM " . TABLE_PANEL_DATABASES . " ORDER BY `dbserver`");
$last_dbserver = 0;

$databases_list = array();
Database::needRoot(true);
$databases_list_result_stmt = Database::query("SHOW DATABASES");
while ($databases_list_row = $databases_list_result_stmt->fetch(PDO::FETCH_ASSOC)) {
	$databases_list[] = strtolower($databases_list_row['Database']);
}

while ($row_database = $databases_stmt->fetch(PDO::FETCH_ASSOC)) {

	if ($last_dbserver != $row_database['dbserver']) {
		Database::needRoot(true, $row_database['dbserver']);
		$last_dbserver = $row_database['dbserver'];

		$databases_list = array();
		$databases_list_result_stmt = Database::query("SHOW DATABASES");
		while ($databases_list_row = $databases_list_result_stmt->fetch(PDO::FETCH_ASSOC)) {
			$databases_list[] = strtolower($databases_list_row['Database']);
		}
	}

	if (in_array(strtolower($row_database['databasename']), $databases_list)) {
		// sum up data_length and index_length
		$mysql_usage_result_stmt = Database::prepare("
			SELECT SUM(data_length + index_length) AS customerusage
			FROM information_schema.TABLES
			WHERE table_schema = :database
			GROUP BY table_schema;
		");
		// get the result
		$mysql_usage_row = Database::pexecute_first($mysql_usage_result_stmt, array('database' => $row_database['databasename']));
		// initialize counter for customer
		if (!isset($mysqlusage_all[$row_database['customerid']])) {
			$mysqlusage_all[$row_database['customerid']] = 0;
		}
		// sum up result
		$mysqlusage_all[$row_database['customerid']] += floatval($mysql_usage_row['customerusage']);
	} else {
		$cronlog->logAction(CRON_ACTION, LOG_WARNING, "Seems like the database " . $row_database['databasename'] . " had been removed manually.");
	}
}

Database::needRoot(false);

// We are using the file-system quota, this will speed up the diskusage - collection
if (Settings::Get('system.diskquota_enabled')) {
	$usedquota = getFilesystemQuota();
}

/**
 * MAIL-Traffic
 */
if (Settings::Get("system.mailtraffic_enabled")) {
	$mailTrafficCalc = new MailLogParser(Settings::Get("system.last_traffic_run"));
}

$result_stmt = Database::query("SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "` ORDER BY `customerid` ASC");

while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
	/**
	 * HTTP-Traffic
	 */
	$cronlog->logAction(CRON_ACTION, LOG_INFO, 'http traffic for ' . $row['loginname'] . ' started...');
	$httptraffic = 0;

	if (isset($domainlist[$row['customerid']])
		&& is_array($domainlist[$row['customerid']])
		&& count($domainlist[$row['customerid']]) != 0
	) {
		// Examining which caption to use for default webalizer stats...
		if ($row['standardsubdomain'] != '0') {
			// ... of course we'd prefer to use the standardsubdomain ...
			$caption = $domainlist[$row['customerid']][$row['standardsubdomain']];
		} else {
			// ... but if there is no standardsubdomain, we have to use the loginname ...
			$caption = $row['loginname'];

			// ... which results in non-usable links to files in the stats, so lets have a look if we find a domain which is not speciallogfiledomain
			foreach ($domainlist[$row['customerid']] as $domainid => $domain) {

				if (!isset($speciallogfile_domainlist[$row['customerid']])
					|| !isset($speciallogfile_domainlist[$row['customerid']][$domainid])
				) {
					$caption = $domain;
					break;
				}
			}
		}

		$httptraffic = 0;
		reset($domainlist[$row['customerid']]);

		if (isset($speciallogfile_domainlist[$row['customerid']])
			&& is_array($speciallogfile_domainlist[$row['customerid']])
			&& count($speciallogfile_domainlist[$row['customerid']]) != 0
		) {
			reset($speciallogfile_domainlist[$row['customerid']]);
			if (Settings::Get('system.awstats_enabled') == '0') {
				foreach ($speciallogfile_domainlist[$row['customerid']] as $domainid => $domain) {
					$httptraffic+= floatval(callWebalizerGetTraffic($row['loginname'] . '-' . $domain, $row['documentroot'] . '/webalizer/' . $domain . '/', $domain, $domainlist[$row['customerid']]));
				}
			}
		}

		reset($domainlist[$row['customerid']]);

		// callAwstatsGetTraffic is called ONLY HERE and
		// *not* also in the special-logfiles-loop, because the function
		// will iterate through all customer-domains and the awstats-configs
		// know the logfile-name, #246
		if (Settings::Get('system.awstats_enabled') == '1') {
			$httptraffic+= floatval(callAwstatsGetTraffic($row['customerid'], $row['documentroot'] . '/awstats/', $domainlist[$row['customerid']]));
		} else {
			$httptraffic+= floatval(callWebalizerGetTraffic($row['loginname'], $row['documentroot'] . '/webalizer/', $caption, $domainlist[$row['customerid']]));
		}

		// make the stuff readable for the customer, #258
		makeChownWithNewStats($row);
	}

	/**
	 * FTP-Traffic
	 */
	$cronlog->logAction(CRON_ACTION, LOG_INFO, 'ftp traffic for ' . $row['loginname'] . ' started...');
	$ftptraffic_stmt = Database::prepare("
		SELECT SUM(`up_bytes`) AS `up_bytes_sum`, SUM(`down_bytes`) AS `down_bytes_sum`
		FROM `" . TABLE_FTP_USERS . "` WHERE `customerid` = :customerid
	");
	$ftptraffic = Database::pexecute_first($ftptraffic_stmt, array('customerid' => $row['customerid']));

	if (!is_array($ftptraffic)) {
		$ftptraffic = array(
			'up_bytes_sum' => 0,
			'down_bytes_sum' => 0
		);
	}

	$upd_stmt = Database::prepare("
		UPDATE `" . TABLE_FTP_USERS . "` SET `up_bytes` = '0', `down_bytes` = '0' WHERE `customerid` = :customerid
	");
	Database::pexecute($upd_stmt, array('customerid' => $row['customerid']));

	/**
	 * Mail-Traffic
	 */
	$mailtraffic = 0;
	if (Settings::Get("system.mailtraffic_enabled")) {
		$cronlog->logAction(CRON_ACTION, LOG_INFO, 'mail traffic usage for ' . $row['loginname'] . " started...");

		$currentDate = date("Y-m-d");

		$domains_stmt = Database::prepare("SELECT domain FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `customerid` = :cid");
		Database::pexecute($domains_stmt, array("cid" => $row['customerid']));
		while ($domainRow = $domains_stmt->fetch(PDO::FETCH_ASSOC)) {
			$domainMailTraffic = $mailTrafficCalc->getDomainTraffic($domainRow["domain"]);
			if (!is_array($domainMailTraffic)) { continue; }

			foreach ($domainMailTraffic as $dateTraffic => $dayTraffic) {
				$dayTraffic = floatval($dayTraffic / 1024);

				list($year, $month, $day) = explode("-", $dateTraffic);
				if ($dateTraffic == $currentDate) {
					$mailtraffic = $dayTraffic;
				} else {
					// Check if an entry for the given day exists
					$stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_TRAFFIC . "`
						WHERE `customerid` = :cid
						AND `year` = :year
						AND `month` = :month
						AND `day` = :day");
					$params = array(
						"cid" => $row['customerid'],
						"year" => $year,
						"month" => $month,
						"day" => $day
					);
					Database::pexecute($stmt, $params);
					if ($stmt->rowCount() > 0) {
						$updRow = $stmt->fetch(PDO::FETCH_ASSOC);
						$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_TRAFFIC . "` SET
							`mail` = :mail
							WHERE `id` = :id");
						Database::pexecute($upd_stmt, array("mail" => $updRow['mail'] + $dayTraffic, "id" => $updRow['id']));
					}
				}
			}
		}
	}

	/**
	 * Total Traffic
	 */
	$cronlog->logAction(CRON_ACTION, LOG_INFO, 'total traffic for ' . $row['loginname'] . ' started');
	$current_traffic = array();
	$current_traffic['http'] = floatval($httptraffic);
	$current_traffic['ftp_up'] = floatval(($ftptraffic['up_bytes_sum'] / 1024));
	$current_traffic['ftp_down'] = floatval(($ftptraffic['down_bytes_sum'] / 1024));
	$current_traffic['mail'] = floatval($mailtraffic);
	$current_traffic['all'] = $current_traffic['http'] + $current_traffic['ftp_up'] + $current_traffic['ftp_down'] + $current_traffic['mail'];

	$ins_data = array(
		'customerid' => $row['customerid'],
		'year' => date('Y', time()),
		'month' => date('m', time()),
		'day' => date('d', time()),
		'stamp' => time(),
		'http' => $current_traffic['http'],
		'ftp_up' => $current_traffic['ftp_up'],
		'ftp_down' => $current_traffic['ftp_down'],
		'mail' => $current_traffic['mail']
	);
	$ins_stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_TRAFFIC . "` SET
		`customerid` = :customerid,
		`year` = :year,
		`month` = :month,
		`day` = :day,
		`stamp` = :stamp,
		`http` = :http,
		`ftp_up` = :ftp_up,
		`ftp_down` = :ftp_down,
		`mail` = :mail
	");
	Database::pexecute($ins_stmt, $ins_data);

	$sum_month_traffic_stmt = Database::prepare("
		SELECT SUM(`http`) AS `http`, SUM(`ftp_up`) AS `ftp_up`, SUM(`ftp_down`) AS `ftp_down`, SUM(`mail`) AS `mail`
		FROM `" . TABLE_PANEL_TRAFFIC . "` WHERE `year` = :year AND `month` = :month AND `customerid` = :customerid
	");
	$sum_month_traffic = Database::pexecute_first($sum_month_traffic_stmt, array('year' => date('Y', time()), 'month' => date('m', time()), 'customerid' => $row['customerid']));
	$sum_month_traffic['all'] = $sum_month_traffic['http'] + $sum_month_traffic['ftp_up'] + $sum_month_traffic['ftp_down'] + $sum_month_traffic['mail'];

	if (!isset($admin_traffic[$row['adminid']])
		|| !is_array($admin_traffic[$row['adminid']])
	) {
		$admin_traffic[$row['adminid']]['http'] = 0;
		$admin_traffic[$row['adminid']]['ftp_up'] = 0;
		$admin_traffic[$row['adminid']]['ftp_down'] = 0;
		$admin_traffic[$row['adminid']]['mail'] = 0;
		$admin_traffic[$row['adminid']]['all'] = 0;
		$admin_traffic[$row['adminid']]['sum_month'] = 0;
	}

	$admin_traffic[$row['adminid']]['http']+= $current_traffic['http'];
	$admin_traffic[$row['adminid']]['ftp_up']+= $current_traffic['ftp_up'];
	$admin_traffic[$row['adminid']]['ftp_down']+= $current_traffic['ftp_down'];
	$admin_traffic[$row['adminid']]['mail']+= $current_traffic['mail'];
	$admin_traffic[$row['adminid']]['all']+= $current_traffic['all'];
	$admin_traffic[$row['adminid']]['sum_month']+= $sum_month_traffic['all'];

	/**
	 * WebSpace-Usage
	 */
	$cronlog->logAction(CRON_ACTION, LOG_INFO, 'calculating webspace usage for ' . $row['loginname']);
	$webspaceusage = 0;

	// Using repquota, it's faster using this tool than using du traversing the complete directory
	if (Settings::Get('system.diskquota_enabled')
		&& isset($usedquota[$row['guid']]['block']['used'])
		&& $usedquota[$row['guid']]['block']['used'] >= 1
	) {
		// We may use the array we created earlier, the used diskspace is stored in [<guid>][block][used]
		$webspaceusage = floatval($usedquota[$row['guid']]['block']['used']);

	} else {

		// Use the old fashioned way with "du"
		if (file_exists($row['documentroot'])
			&& is_dir($row['documentroot'])
		) {
			$back = safe_exec('du -sk ' . escapeshellarg($row['documentroot']) . '');
			foreach ($back as $backrow) {
				$webspaceusage = explode(' ', $backrow);
			}

			$webspaceusage = floatval($webspaceusage['0']);
			unset($back);

		} else {
			$cronlog->logAction(CRON_ACTION, LOG_WARNING, 'documentroot ' . $row['documentroot'] . ' does not exist');
		}
	}

	/**
	 * MailSpace-Usage
	 */
	$cronlog->logAction(CRON_ACTION, LOG_INFO, 'calculating mailspace usage for ' . $row['loginname']);
	$emailusage = 0;

	$maildir = makeCorrectDir(Settings::Get('system.vmail_homedir') . $row['loginname']);
	if (file_exists($maildir) && is_dir($maildir)) {
		$back = safe_exec('du -sk ' . escapeshellarg($maildir) . '');
		foreach ($back as $backrow) {
			$emailusage = explode(' ', $backrow);
		}

		$emailusage = floatval($emailusage['0']);
		unset($back);

	} else {
		$cronlog->logAction(CRON_ACTION, LOG_WARNING, 'maildir ' . $maildir . ' does not exist');
	}

	/**
	 * MySQLSpace-Usage
	 */
	$cronlog->logAction(CRON_ACTION, LOG_INFO, 'calculating mysqlspace usage for ' . $row['loginname']);
	$mysqlusage = 0;

	if (isset($mysqlusage_all[$row['customerid']])) {
		$mysqlusage = floatval($mysqlusage_all[$row['customerid']] / 1024);
	}

	$current_diskspace = array();
	$current_diskspace['webspace'] = floatval($webspaceusage);
	$current_diskspace['mail'] = floatval($emailusage);
	$current_diskspace['mysql'] = floatval($mysqlusage);
	$current_diskspace['all'] = $current_diskspace['webspace'] + $current_diskspace['mail'] + $current_diskspace['mysql'];

	$ins_data = array(
		'customerid' => $row['customerid'],
		'year' => date('Y', time()),
		'month' => date('m', time()),
		'day' => date('d', time()),
		'stamp' => time(),
		'webspace' => $current_diskspace['webspace'],
		'mail' => $current_diskspace['mail'],
		'mysql' => $current_diskspace['mysql']
	);
	$ins_stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_DISKSPACE . "` SET
		`customerid` = :customerid,
		`year` = :year,
		`month` = :month,
		`day` = :day,
		`stamp` = :stamp,
		`webspace` = :webspace,
		`mail` = :mail,
		`mysql` = :mysql
	");
	Database::pexecute($ins_stmt, $ins_data);

	if (!isset($admin_diskspace[$row['adminid']])
		|| !is_array($admin_diskspace[$row['adminid']])
	) {
		$admin_diskspace[$row['adminid']] = array();
		$admin_diskspace[$row['adminid']]['webspace'] = 0;
		$admin_diskspace[$row['adminid']]['mail'] = 0;
		$admin_diskspace[$row['adminid']]['mysql'] = 0;
		$admin_diskspace[$row['adminid']]['all'] = 0;
	}

	$admin_diskspace[$row['adminid']]['webspace']+= $current_diskspace['webspace'];
	$admin_diskspace[$row['adminid']]['mail']+= $current_diskspace['mail'];
	$admin_diskspace[$row['adminid']]['mysql']+= $current_diskspace['mysql'];
	$admin_diskspace[$row['adminid']]['all']+= $current_diskspace['all'];

	/**
	 * Total Usage
	 */
	$diskusage = floatval($webspaceusage + $emailusage + $mysqlusage);

	$upd_data = array(
		'diskspace' => $current_diskspace['all'],
		'traffic' => $sum_month_traffic['all'],
		'customerid' => $row['customerid']
	);
	$upd_stmt = Database::prepare("
		UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET
		`diskspace_used` = :diskspace,
		`traffic_used` = :traffic
		WHERE `customerid` = :customerid
	");
	Database::pexecute($upd_stmt, $upd_data);

	/**
	 * Proftpd Quota
	 */
	$upd_data = array(
		'biu' => ($current_diskspace['all'] * 1024),
		'loginname' => $row['loginname'],
		'loginnamelike' => $row['loginname'] . Settings::Get('customer.ftpprefix') . "%"
	);
	$upd_stmt = Database::prepare("
		UPDATE `" . TABLE_FTP_QUOTATALLIES . "` SET
		`bytes_in_used` = :biu WHERE `name` = :loginname OR `name` LIKE :loginnamelike
	");
	Database::pexecute($upd_stmt, $upd_data);

	/**
	 * Pureftpd Quota
	 */
	if (Settings::Get('system.ftpserver') == "pureftpd") {

		$result_quota_stmt = Database::prepare("
			SELECT homedir FROM `" . TABLE_FTP_USERS . "` WHERE customerid = :customerid
		");
		Database::pexecute($result_quota_stmt, array('customerid' => $row['customerid']));

		// get correct user
		if ((Settings::Get('system.mod_fcgid') == 1 || Settings::Get('phpfpm.enabled') == 1) && $row['deactivated'] == '0') {
			$user = $row['loginname'];
			$group = $row['loginname'];
		} else {
			$user = $row['guid'];
			$group = $row['guid'];
		}

		while ($row_quota = $result_quota_stmt->fetch(PDO::FETCH_ASSOC)) {
			$quotafile = "" . $row_quota['homedir'] . ".ftpquota";
			$fh = fopen($quotafile, 'w');
			$stringdata = "0 " . $current_diskspace['all']*1024 . "";
			fwrite($fh, $stringdata);
			fclose($fh);
			safe_exec('chown ' . $user . ':' . $group . ' ' . escapeshellarg($quotafile) . '');
		}
	}
}

/**
 * Admin Usage
 */
$result_stmt = Database::query("SELECT `adminid` FROM `" . TABLE_PANEL_ADMINS . "` ORDER BY `adminid` ASC");

while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {

	if (isset($admin_traffic[$row['adminid']])) {

		$ins_data = array(
			'adminid' => $row['adminid'],
			'year' => date('Y', time()),
			'month' => date('m', time()),
			'day' => date('d', time()),
			'stamp' => time(),
			'http' => $admin_traffic[$row['adminid']]['http'],
			'ftp_up' => $admin_traffic[$row['adminid']]['ftp_up'],
			'ftp_down' => $admin_traffic[$row['adminid']]['ftp_down'],
			'mail' => $admin_traffic[$row['adminid']]['mail']
		);
		$ins_stmt = Database::prepare("
			INSERT INTO `" . TABLE_PANEL_TRAFFIC_ADMINS . "` SET
			`adminid` = :adminid,
			`year` = :year,
			`month` = :month,
			`day` = :day,
			`stamp` = :stamp,
			`http` = :http,
			`ftp_up` = :ftp_up,
			`ftp_down` = :ftp_down,
			`mail` = :mail
		");
		Database::pexecute($ins_stmt, $ins_data);

		$upd_data = array(
			'traffic' => $admin_traffic[$row['adminid']]['sum_month'],
			'adminid' => $row['adminid']
		);
		$upd_stmt = Database::prepare("
			UPDATE `" . TABLE_PANEL_ADMINS . "` SET
			`traffic_used` = :traffic
			WHERE `adminid` = :adminid
		");
		Database::pexecute($upd_stmt, $upd_data);
	}

	if (isset($admin_diskspace[$row['adminid']])) {

		$ins_data = array(
			'adminid' => $row['adminid'],
			'year' => date('Y', time()),
			'month' => date('m', time()),
			'day' => date('d', time()),
			'stamp' => time(),
			'webspace' => $admin_diskspace[$row['adminid']]['webspace'],
			'mail' => $admin_diskspace[$row['adminid']]['mail'],
			'mysql' => $admin_diskspace[$row['adminid']]['mysql']
		);
		$ins_stmt = Database::prepare("
			INSERT INTO `" . TABLE_PANEL_DISKSPACE_ADMINS . "` SET
			`adminid` = :adminid,
			`year` = :year,
			`month` = :month,
			`day` = :day,
			`stamp` = :stamp,
			`webspace` = :webspace,
			`mail` = :mail,
			`mysql` = :mysql
		");

		$upd_data = array(
			'diskspace' => $admin_diskspace[$row['adminid']]['all'],
			'adminid' => $row['adminid']
		);
		$upd_stmt = Database::prepare("
			UPDATE `" . TABLE_PANEL_ADMINS . "` SET
			`diskspace_used` = :diskspace
			WHERE `adminid` = :adminid
		");
		Database::pexecute($upd_stmt, $upd_data);

	}
}

Database::query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = UNIX_TIMESTAMP() WHERE `settinggroup` = 'system' AND `varname` = 'last_traffic_run'");

if (function_exists('pcntl_fork') && !defined('CRON_NOFORK_FLAG')) {
	@unlink($TrafficLock);
	die();
}
