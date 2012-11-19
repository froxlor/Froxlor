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

//Check Traffic-Lock
if(function_exists('pcntl_fork')) {
	$TrafficLock = dirname($lockfile)."/froxlor_cron_traffic.lock";
	if(file_exists($TrafficLock) &&  is_numeric($TrafficPid=file_get_contents($TrafficLock))) {
		if(function_exists('posix_kill')) {
			$TrafficPidStatus = @posix_kill($TrafficPid,0);
		}
		else {
			system("kill -CHLD " . $TrafficPid . " 1> /dev/null 2> /dev/null", $TrafficPidStatus);
			$TrafficPidStatus = $TrafficPidStatus ? false : true;
		}
		if($TrafficPidStatus) {
			fwrite($debugHandler,"Traffic Run already in progress\n");
			return 1;
		}
	}
	//Create Traffic Log and Fork
	// We close the database - connection before we fork, so we don't share resources with the child
	$db->close();
	unset($db);
	$TrafficPid = pcntl_fork();
	if($TrafficPid) { //Parent
		file_put_contents($TrafficLock,$TrafficPid);
		// Recreate the database - connection
		require ($pathtophpfiles . '/lib/userdata.inc.php');
		if(isset($sql['root_user']) && isset($sql['root_password']) && (!isset($sql_root) || !is_array($sql_root))) {
			$sql_root = array(0 => array('caption' => 'Default', 'host' => $sql['host'], 'user' => $sql['root_user'], 'password' => $sql['root_password']));
			unset($sql['root_user']);
			unset($sql['root_password']);
		}
		$db = new db($sql['host'], $sql['user'], $sql['password'], $sql['db']);
		return 0;
	}
	elseif($TrafficPid == 0) { //Child
		posix_setsid();
		fclose($debugHandler);
		$debugHandler = fopen("/tmp/froxlor_traffic.log","w");
		require ($pathtophpfiles . '/lib/userdata.inc.php'); //There is no bloody reason not to have sql values in the backend ready!
		if(isset($sql['root_user']) && isset($sql['root_password']) && (!isset($sql_root) || !is_array($sql_root))) {
			$sql_root = array(0 => array('caption' => 'Default', 'host' => $sql['host'], 'user' => $sql['root_user'], 'password' => $sql['root_password']));
			unset($sql['root_user']);
			unset($sql['root_password']);
		}
		$db = new db($sql['host'], $sql['user'], $sql['password'], $sql['db']); //database handler renewal after fork()
	}
	else { //Fork failed
		return 1;
	}
}
else {
	fwrite($debugHandler,"PHP compiled without pcntl. Not forking traffic-cron, this may take a long time!");
}

openRootDB($debugHandler, $lockfile);
require_once(makeCorrectFile(dirname(__FILE__) . '/cron_traffic.inc.functions.php'));

/**
 * TRAFFIC AND DISKUSAGE MESSURE
 */

fwrite($debugHandler, 'Traffic run started...' . "\n");
$admin_traffic = array();
$domainlist = array();
$speciallogfile_domainlist = array();
$result_domainlist = $db->query("SELECT `id`, `domain`, `customerid`, `parentdomainid`, `speciallogfile` FROM `" . TABLE_PANEL_DOMAINS . "` ;");

while($row_domainlist = $db->fetch_array($result_domainlist))
{
	if(!isset($domainlist[$row_domainlist['customerid']]))
	{
		$domainlist[$row_domainlist['customerid']] = array();
	}

	$domainlist[$row_domainlist['customerid']][$row_domainlist['id']] = $row_domainlist['domain'];

	if($row_domainlist['parentdomainid'] == '0'
	   && $row_domainlist['speciallogfile'] == '1')
	{
		if(!isset($speciallogfile_domainlist[$row_domainlist['customerid']]))
		{
			$speciallogfile_domainlist[$row_domainlist['customerid']] = array();
		}

		$speciallogfile_domainlist[$row_domainlist['customerid']][$row_domainlist['id']] = $row_domainlist['domain'];
	}
}

$mysqlusage_all = array();
$databases = $db->query("SELECT * FROM " . TABLE_PANEL_DATABASES . " ORDER BY `dbserver`");
$db_root = new db($sql_root[0]['host'], $sql_root[0]['user'], $sql_root[0]['password'], '');
$last_dbserver = 0;

$databases_list = array();
$databases_list_result = $db_root->query("show databases");
while($databases_list_row = $db->fetch_array($databases_list_result))
{
	$databases_list[] = strtolower($databases_list_row['Database']);
}

while($row_database = $db->fetch_array($databases))
{
	if($last_dbserver != $row_database['dbserver'])
	{
		$db_root->close();
		$db_root = new db($sql_root[$row_database['dbserver']]['host'], $sql_root[$row_database['dbserver']]['user'], $sql_root[$row_database['dbserver']]['password'], '');
		$last_dbserver = $row_database['dbserver'];

		$database_list = array();
		$databases_list_result = $db_root->query("show databases");
		while($databases_list_row = $db->fetch_array($databases_list_result))
		{
			$databases_list[] = strtolower($databases_list_row['Database']);
		}
	}

	if(in_array(strtolower($row_database['databasename']), $databases_list))
	{
		$mysql_usage_result = $db_root->query("SHOW TABLE STATUS FROM `" . $db_root->escape($row_database['databasename']) . "`");

		while($mysql_usage_row = $db_root->fetch_array($mysql_usage_result))
		{
			if(!isset($mysqlusage_all[$row_database['customerid']]))
			{
				$mysqlusage_all[$row_database['customerid']] = 0;
			}
			$mysqlusage_all[$row_database['customerid']] += floatval($mysql_usage_row['Data_length'] + $mysql_usage_row['Index_length']);
		}
	}
	else
	{
		echo "Seems like the database " . $row_database['databasename'] . " had been removed manually.\n";
	}
}

$db_root->close();

# We are using the file-system quota, this will speed up the diskusage - collection
if ($settings['system']['diskquota_enabled'])
{
	$usedquota = getFilesystemQuota();
}

$result = $db->query("SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "` ORDER BY `customerid` ASC");

while($row = $db->fetch_array($result))
{
	/**
	 * HTTP-Traffic
	 */

	fwrite($debugHandler, 'http traffic for ' . $row['loginname'] . ' started...' . "\n");
	$httptraffic = 0;

	if(isset($domainlist[$row['customerid']])
	   && is_array($domainlist[$row['customerid']])
	   && count($domainlist[$row['customerid']]) != 0)
	{
		// Examining which caption to use for default webalizer stats...

		if($row['standardsubdomain'] != '0')
		{
			// ... of course we'd prefer to use the standardsubdomain ...

			$caption = $domainlist[$row['customerid']][$row['standardsubdomain']];
		}
		else
		{
			// ... but if there is no standardsubdomain, we have to use the loginname ...

			$caption = $row['loginname'];

			// ... which results in non-usable links to files in the stats, so lets have a look if we find a domain which is not speciallogfiledomain

			foreach($domainlist[$row['customerid']] as $domainid => $domain)
			{
				if(!isset($speciallogfile_domainlist[$row['customerid']])
				   || !isset($speciallogfile_domainlist[$row['customerid']][$domainid]))
				{
					$caption = $domain;
					break;
				}
			}
		}

		$httptraffic = 0;
		reset($domainlist[$row['customerid']]);

		if(isset($speciallogfile_domainlist[$row['customerid']])
		   && is_array($speciallogfile_domainlist[$row['customerid']])
		   && count($speciallogfile_domainlist[$row['customerid']]) != 0)
		{
			reset($speciallogfile_domainlist[$row['customerid']]);
			foreach($speciallogfile_domainlist[$row['customerid']] as $domainid => $domain)
			{
				if($settings['system']['mod_log_sql'] == 1)
				{
					safeSQLLogfile($domain, $row['loginname']);

					// Remove this domain from the domainlist - it's already analysed
					// and doesn't need to be selected twice

					unset($domainlist[$row['customerid']][$domainid]);
				}

				if($settings['system']['awstats_enabled'] == '0')
				{
					$httptraffic+= floatval(callWebalizerGetTraffic($row['loginname'] . '-' . $domain, $row['documentroot'] . '/webalizer/' . $domain . '/', $domain, $domainlist[$row['customerid']]));
				}
			}
		}

		// logrotate speciallogfiles
		if(isset($speciallogfile_domainlist[$row['customerid']])
				&& is_array($speciallogfile_domainlist[$row['customerid']])
				&& count($speciallogfile_domainlist[$row['customerid']]) != 0)
		{
			reset($speciallogfile_domainlist[$row['customerid']]);
			foreach($speciallogfile_domainlist[$row['customerid']] as $domainid => $domain)
			{
				
				$logrotatefile = '/tmp/froxlor_logrotate_tmpfile.conf';
				$fh = fopen($logrotatefile, 'w');

				$logconf = '# ' . basename($logrotatefile) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" .
						$settings['system']['logfiles_directory'] . $row['loginname'] .'-' . $domain . '-access.log ' .
						$settings['system']['logfiles_directory'] . $row['loginname'] .'-' . $domain . '-error.log {' . "\n" .
						$settings['system']['logrotate_interval'] . "\n" .
						'missingok' . "\n" .
						'rotate ' . $settings['system']['logrotate_keep'] . "\n" .
						'compress' . "\n" .
						'delaycompress' . "\n" .
						'notifempty' . "\n" .
						'create' . "\n" .
						'}' . "\n";

				fwrite($fh, $logconf);
				fclose($fh);

				safe_exec(escapeshellcmd($settings['system']['logrotate_binary']) . ' ' . $logrotatefile);

				fwrite($debugHandler, '   apache::reload: reloading apache' . "\n");
				safe_exec(escapeshellcmd($settings['system']['apachereload_command']));
			}
		}

		reset($domainlist[$row['customerid']]);

		if($settings['system']['mod_log_sql'] == 1)
		{
			safeSQLLogfile($domainlist[$row['customerid']], $row['loginname']);
		}

		// callAwstatsGetTraffic is called ONLY HERE and
		// *not* also in the special-logfiles-loop, because the function
		// will iterate through all customer-domains and the awstats-configs
		// know the logfile-name, #246
		if($settings['system']['awstats_enabled'] == '1')
		{
			$httptraffic+= floatval(callAwstatsGetTraffic($row['customerid'], $row['documentroot'] . '/awstats/', $domainlist[$row['customerid']]));
		}
		else
		{
			$httptraffic+= floatval(callWebalizerGetTraffic($row['loginname'], $row['documentroot'] . '/webalizer/', $caption, $domainlist[$row['customerid']]));
		}

		// make the stuff readable for the customer, #258
		makeChownWithNewStats($row);
		
		// logrotate
		if($settings['system']['logrotate_enabled'] == '1')
		{
			fwrite($debugHandler, '   logrotate customers logs' . "\n");

			$logrotatefile = '/tmp/froxlor_logrotate_tmpfile.conf';
			$fh = fopen($logrotatefile, 'w');

			$logconf = '# ' . basename($logrotatefile) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" .
				$settings['system']['logfiles_directory'] . $row['loginname'] . '-access.log ' .
				$settings['system']['logfiles_directory'] . $row['loginname'] . '-error.log {' . "\n" .
				$settings['system']['logrotate_interval'] . "\n" .
				'missingok' . "\n" .
				'rotate ' . $settings['system']['logrotate_keep'] . "\n" .
				'compress' . "\n" .
				'delaycompress' . "\n" .
				'notifempty' . "\n" .
				'create' . "\n" .
				'}' . "\n";

			fwrite($fh, $logconf);
			fclose($fh);

			safe_exec(escapeshellcmd($settings['system']['logrotate_binary']) . ' ' . $logrotatefile);

			fwrite($debugHandler, '   apache::reload: reloading apache' . "\n");
			safe_exec(escapeshellcmd($settings['system']['apachereload_command']));
		}

		/**
		 * Webalizer/AWStats might run for some time, so we'd better check if our database is still present
		 */
		if (empty($db->link_id)
		   || $db->link_id === false)
		{
			fwrite($debugHandler, 'Database-connection seems to be down, trying to reconnect' . "\n");

			// just in case
			$db->close();
			require_once ($pathtophpfiles . '/lib/userdata.inc.php');
			$db = new db($sql['host'], $sql['user'], $sql['password'], $sql['db']);

			if ($db->link_id == 0) {
				fclose($debugHandler);
				unlink($lockfile);
				$cronlog->logAction(CRON_ACTION, LOG_ERR, 'Database-connection crashed during traffic-cronjob, could not reconnect!');
				die('Froxlor can\'t connect to mysqlserver. Exiting...');
			}

			fwrite($debugHandler, 'Database-connection re-established' . "\n");
			unset($sql);
			$cronlog->logAction(CRON_ACTION, LOG_WARNING, 'Database-connection crashed during traffic-cronjob, reconnected!');
		}

	}

	/**
	 * FTP-Traffic
	 */

	fwrite($debugHandler, 'ftp traffic for ' . $row['loginname'] . ' started...' . "\n");
	$ftptraffic = $db->query_first("SELECT SUM(`up_bytes`) AS `up_bytes_sum`, SUM(`down_bytes`) AS `down_bytes_sum` FROM `" . TABLE_FTP_USERS . "` WHERE `customerid`='" . (int)$row['customerid'] . "'");

	if(!is_array($ftptraffic))
	{
		$ftptraffic = array(
			'up_bytes_sum' => 0,
			'down_bytes_sum' => 0
		);
	}

	$db->query("UPDATE `" . TABLE_FTP_USERS . "` SET `up_bytes`='0', `down_bytes`='0' WHERE `customerid`='" . (int)$row['customerid'] . "'");

	/**
	 * Mail-Traffic
	 */

	$mailtraffic = 0;

	/**
	 * Total Traffic
	 */

	fwrite($debugHandler, 'total traffic for ' . $row['loginname'] . ' started' . "\n");
	$current_traffic = array();
	$current_traffic['http'] = floatval($httptraffic);
	$current_traffic['ftp_up'] = floatval(($ftptraffic['up_bytes_sum'] / 1024));
	$current_traffic['ftp_down'] = floatval(($ftptraffic['down_bytes_sum'] / 1024));
	$current_traffic['mail'] = floatval($mailtraffic);
	$current_traffic['all'] = $current_traffic['http'] + $current_traffic['ftp_up'] + $current_traffic['ftp_down'] + $current_traffic['mail'];
	$db->query("INSERT INTO `" . TABLE_PANEL_TRAFFIC . "` (`customerid`, `year`, `month`, `day`, `stamp`, `http`, `ftp_up`, `ftp_down`, `mail`) VALUES('" . (int)$row['customerid'] . "', '" . date('Y') . "', '" . date('m') . "', '" . date('d') . "', '" . time() . "', '" . (float)$current_traffic['http'] . "', '" . (float)$current_traffic['ftp_up'] . "', '" . (float)$current_traffic['ftp_down'] . "', '" . (float)$current_traffic['mail'] . "')");
	$sum_month_traffic = $db->query_first("SELECT SUM(`http`) AS `http`, SUM(`ftp_up`) AS `ftp_up`, SUM(`ftp_down`) AS `ftp_down`, SUM(`mail`) AS `mail` FROM `" . TABLE_PANEL_TRAFFIC . "` WHERE `year`='" . date('Y') . "' AND `month`='" . date('m') . "' AND `customerid`='" . (int)$row['customerid'] . "'");
	$sum_month_traffic['all'] = $sum_month_traffic['http'] + $sum_month_traffic['ftp_up'] + $sum_month_traffic['ftp_down'] + $sum_month_traffic['mail'];

	if(!isset($admin_traffic[$row['adminid']])
	   || !is_array($admin_traffic[$row['adminid']]))
	{
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

	fwrite($debugHandler, 'calculating webspace usage for ' . $row['loginname'] . "\n");
	$webspaceusage = 0;

	# Using repquota, it's faster using this tool than using du traversing the complete directory
	if ($settings['system']['diskquota_enabled'] && isset($usedquota[$row['guid']]['block']['used']) && $usedquota[$row['guid']]['block']['used'] >= 1)
	{
		# We may use the array we created earlier, the used diskspace is stored in [<guid>][block][used]
		$webspaceusage = floatval($usedquota[$row['guid']]['block']['used']);
	}
	else
	{
		# Use the old fashioned way with "du"
		if(file_exists($row['documentroot']) && is_dir($row['documentroot']))
		{
			$back = safe_exec('du -sk ' . escapeshellarg($row['documentroot']) . '');
			foreach($back as $backrow)
			{
				$webspaceusage = explode(' ', $backrow);
			}

			$webspaceusage = floatval($webspaceusage['0']);
			unset($back);
		}
		else
		{
			fwrite($debugHandler, 'documentroot ' . $row['documentroot'] . ' does not exist' . "\n");
		}
	}

	/**
	 * MailSpace-Usage
	 */

	fwrite($debugHandler, 'calculating mailspace usage for ' . $row['loginname'] . "\n");
	$emailusage = 0;

	$maildir = makeCorrectDir($settings['system']['vmail_homedir'] . $row['loginname']);
	if(file_exists($maildir) && is_dir($maildir))
	{
		$back = safe_exec('du -sk ' . escapeshellarg($maildir) . '');
		foreach($back as $backrow)
		{
			$emailusage = explode(' ', $backrow);
		}

		$emailusage = floatval($emailusage['0']);
		unset($back);
	}
	else
	{
		fwrite($debugHandler, 'maildir ' . $maildir . ' does not exist' . "\n");
	}

	/**
	 * MySQLSpace-Usage
	 */

	fwrite($debugHandler, 'calculating mysqlspace usage for ' . $row['loginname'] . "\n");
	$mysqlusage = 0;

	if(isset($mysqlusage_all[$row['customerid']]))
	{
		$mysqlusage = floatval($mysqlusage_all[$row['customerid']] / 1024);
	}

	$current_diskspace = array();
	$current_diskspace['webspace'] = floatval($webspaceusage);
	$current_diskspace['mail'] = floatval($emailusage);
	$current_diskspace['mysql'] = floatval($mysqlusage);
	$current_diskspace['all'] = $current_diskspace['webspace'] + $current_diskspace['mail'] + $current_diskspace['mysql'];
	$db->query("INSERT INTO `" . TABLE_PANEL_DISKSPACE . "` (`customerid`, `year`, `month`, `day`, `stamp`, `webspace`, `mail`, `mysql`) VALUES('" . (int)$row['customerid'] . "', '" . date('Y') . "', '" . date('m') . "', '" . date('d') . "', '" . time() . "', '" . (float)$current_diskspace['webspace'] . "', '" . (float)$current_diskspace['mail'] . "', '" . (float)$current_diskspace['mysql'] . "')");

	if(!isset($admin_diskspace[$row['adminid']])
	   || !is_array($admin_diskspace[$row['adminid']]))
	{
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

	if($settings['system']['backup_count'] == 0 && file_exists($settings['system']['backup_dir'] . $row['loginname'])){
		$backupsize = exec('du -s ' . escapeshellarg($settings['system']['backup_dir']) . $row['loginname'] . '');
                $diskusage = floatval($webspaceusage + $emailusage + $mysqlusage - $backupsize);
        }
        else{
		$diskusage = floatval($webspaceusage + $emailusage + $mysqlusage);
        }

	$db->query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `diskspace_used`='" . (float)$current_diskspace['all'] . "', `traffic_used`='" . (float)$sum_month_traffic['all'] . "' WHERE `customerid`='" . (int)$row['customerid'] . "'");

	/**
	 * Proftpd Quota
	 */

	$db->query("UPDATE `" . TABLE_FTP_QUOTATALLIES . "` SET `bytes_in_used`='" . (float)$current_diskspace['all'] . "'*1024 WHERE `name` = '" . $row['loginname'] . "' OR `name` LIKE '" . $row['loginname'] . $settings['customer']['ftpprefix'] . "%'");

	/**
	 * Pureftpd Quota
	 */

	if($settings['system']['ftpserver'] == "pureftpd")
	{
		$result_quota = $db->query("SELECT homedir FROM `" . TABLE_FTP_USERS . "` WHERE customerid = '" . $row['customerid'] . "'");

	        // get correct user
	        if($settings['system']['mod_fcgid'] == 1 && $row['deactivated'] == '0')
	        {
        	        $user = $row['loginname'];
	                $group = $row['loginname'];
	        }
	        else
	        {
	                $user = $row['guid'];
	                $group = $row['guid'];
	        }

		while($row_quota = $db->fetch_array($result_quota))
		{
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

$result = $db->query("SELECT `adminid` FROM `" . TABLE_PANEL_ADMINS . "` ORDER BY `adminid` ASC");

while($row = $db->fetch_array($result))
{
	if(isset($admin_traffic[$row['adminid']]))
	{
		$db->query("INSERT INTO `" . TABLE_PANEL_TRAFFIC_ADMINS . "` (`adminid`, `year`, `month`, `day`, `stamp`, `http`, `ftp_up`, `ftp_down`, `mail`) VALUES('" . (int)$row['adminid'] . "', '" . date('Y') . "', '" . date('m') . "', '" . date('d') . "', '" . time() . "', '" . (float)$admin_traffic[$row['adminid']]['http'] . "', '" . (float)$admin_traffic[$row['adminid']]['ftp_up'] . "', '" . (float)$admin_traffic[$row['adminid']]['ftp_down'] . "', '" . (float)$admin_traffic[$row['adminid']]['mail'] . "')");
		$db->query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `traffic_used`='" . (float)$admin_traffic[$row['adminid']]['sum_month'] . "' WHERE `adminid`='" . (float)$row['adminid'] . "'");
	}

	if(isset($admin_diskspace[$row['adminid']]))
	{
		$db->query("INSERT INTO `" . TABLE_PANEL_DISKSPACE_ADMINS . "` (`adminid`, `year`, `month`, `day`, `stamp`, `webspace`, `mail`, `mysql`) VALUES('" . (int)$row['adminid'] . "', '" . date('Y') . "', '" . date('m') . "', '" . date('d') . "', '" . time() . "', '" . (float)$admin_diskspace[$row['adminid']]['webspace'] . "', '" . (float)$admin_diskspace[$row['adminid']]['mail'] . "', '" . (float)$admin_diskspace[$row['adminid']]['mysql'] . "')");
		$db->query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `diskspace_used`='" . (float)$admin_diskspace[$row['adminid']]['all'] . "' WHERE `adminid`='" . (float)$row['adminid'] . "'");
	}
}

$db->query('UPDATE `' . TABLE_PANEL_SETTINGS . '` SET `value` = UNIX_TIMESTAMP() WHERE `settinggroup` = \'system\'   AND `varname`      = \'last_traffic_run\' ');

closeRootDB();

if(function_exists('pcntl_fork')) {
	die();
}

?>
