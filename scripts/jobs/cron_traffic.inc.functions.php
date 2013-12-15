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

function awstatsDoSingleDomain($domain, $outputdir) {

	global $cronlog, $theme;
	$returnval = 0;

	$domainconfig = makeCorrectFile(Settings::Get('system.awstats_conf').'/awstats.' . $domain . '.conf');

	if (file_exists($domainconfig)) {

		$outputdir = makeCorrectDir($outputdir . '/' . $domain);

		if (!is_dir($outputdir)) {
			safe_exec('mkdir -p ' . escapeshellarg($outputdir));
		}

		//check for correct path of awstats_buildstaticpages.pl
		$awbsp = makeCorrectFile(Settings::Get('system.awstats_path').'/awstats_buildstaticpages.pl');
		$awprog = makeCorrectFile(Settings::Get('system.awstats_awstatspath').'/awstats.pl');

		if (!file_exists($awbsp)) {
			echo "WANRING: Necessary awstats_buildstaticpages.pl script could not be found, no traffic is being calculated and no stats are generated. Please check your AWStats-Path setting";
			$cronlog->logAction(CRON_ACTION, LOG_WARNING, "Necessary awstats_buildstaticpages.pl script could not be found, no traffic is being calculated and no stats are generated. Please check your AWStats-Path setting");
			exit;
		}

		$cronlog->logAction(CRON_ACTION, LOG_INFO, "Running awstats_buildstaticpages.pl for domain '".$domain."' (Output: '".$outputdir."')");
		safe_exec($awbsp.' -awstatsprog='.escapeshellarg($awprog).' -update -month=' . date('n') . ' -year=' . date('Y') . ' -config=' . $domain . ' -dir='.escapeshellarg($outputdir));

		// index file is saved like 'awstats.[domain].html',
		// so link a index.html to it
		$original_index = makeCorrectFile($outputdir.'/awstats.'.$domain.'.html');
		$new_index = makeCorrectFile($outputdir.'/index.html');
		if (!file_exists($new_index)) {
			safe_exec('ln -s '.escapeshellarg($original_index).' '.escapeshellarg($new_index));
		}

		//statistics file looks like: 'awstats[month][year].[domain].txt'
		$file = makeCorrectFile($outputdir.'/awstats'.date('mY', time()).'.'.$domain.'.txt');
		$cronlog->logAction(CRON_ACTION, LOG_INFO, "Gathering traffic information from '".$file."'");

		if (file_exists($file)) {

			$content = @file_get_contents($file);
			if ($content !== false) {
				$content_array = explode("\n", $content);

				$count_bdw = false;
				foreach ($content_array as $line) {
					// skip empty lines and comments
					if (trim($line) == ''
						|| substr(trim($line), 0, 1) == '#'
					) {
						continue;
					}

					$parts = explode(' ', $line);

					if (isset($parts[0])
						&& strtoupper($parts[0]) == 'BEGIN_DOMAIN'
					) {
						$count_bdw = true;
					}

					if ($count_bdw) {
						if (isset($parts[0])
							&& strtoupper($parts[0]) == 'END_DOMAIN'
						) {
							$count_bdw = false;
							break;
						} elseif (isset($parts[3])) {
							$returnval += floatval($parts[3]);
						}
					}
				}
			}
		}
	}
	return $returnval;
}


function callAwstatsGetTraffic($customerid, $outputdir, $usersdomainlist) {

	global $cronlog;

	$returnval = 0;

	foreach ($usersdomainlist as $domainid => $singledomain) {
		// as we check for the config-model awstats will only parse
		// 'real' domains and no subdomains which are aliases in the
		// model-config-file.
		$returnval += awstatsDoSingleDomain($singledomain, $outputdir);
	}

	/**
	 * as of #124, awstats traffic is saved in bytes instead
	 * of kilobytes (like webalizer does)
	 */
	$returnval = floatval($returnval / 1024);

	/**
	 * now, because this traffic is being saved daily, we have to
	 * subtract the values  from all the month's values to return
	 * a sane value for our panel_traffic and to remain the whole stats
	 * (awstats overwrites the customers .html stats-files)
	 */
	if ($customerid !== false) {

		$result_stmt = Database::prepare("
			SELECT SUM(`http`) as `trafficmonth` FROM `" . TABLE_PANEL_TRAFFIC . "`
			WHERE `customerid` = :customerid
			AND `year` = :year AND `month` = :month
		");
		$result_data = array(
			'customerid' => $customerid,
			'year' => date('Y', time()),
			'month' => date('m', time())
		);
		$result = Database::pexecute_first($result_stmt, $result_data);

		if (is_array($result)
			&& isset($result['trafficmonth'])
		) {
			$returnval = ($returnval - floatval($result['trafficmonth']));
		}
	}

	return floatval($returnval);
}


/**
 * Function which make webalizer statistics and returns used traffic since last run
 *
 * @param string Name of logfile
 * @param string Place where stats should be build
 * @param string Caption for webalizer output
 * @return int Used traffic
 * @author Florian Lippert <flo@syscp.org>
 */
function callWebalizerGetTraffic($logfile, $outputdir, $caption, $usersdomainlist) {

	global $cronlog;

	$returnval = 0;

	$logfile = makeCorrectFile(Settings::Get('system.logfiles_directory') . $logfile . '-access.log');
	if (file_exists($logfile)) {
		$domainargs = '';
		foreach ($usersdomainlist as $domainid => $domain) {
			// hide referer
			$domainargs.= ' -r ' . escapeshellarg($domain);
		}

		$outputdir = makeCorrectDir($outputdir);
		if (!file_exists($outputdir)) {
			safe_exec('mkdir -p ' . escapeshellarg($outputdir));
		}

		if (file_exists($outputdir . 'webalizer.hist.1')) {
			@unlink($outputdir . 'webalizer.hist.1');
		}

		if (file_exists($outputdir . 'webalizer.hist')
			&& !file_exists($outputdir . 'webalizer.hist.1')
		) {
			safe_exec('cp ' . escapeshellarg($outputdir . 'webalizer.hist') . ' ' . escapeshellarg($outputdir . 'webalizer.hist.1'));
		}

		$verbosity = '';
		if (Settings::Get('system.webalizer_quiet') == '1') {
			$verbosity = '-q';
		} elseif (Settings::Get('system.webalizer_quiet') == '2') {
			$verbosity = '-Q';
		}

		$we = '/usr/bin/webalizer';

		// FreeBSD uses other paths, #140
		if (!file_exists($we)) {
			$we = '/usr/local/bin/webalizer';
		}

		$cronlog->logAction(CRON_ACTION, LOG_INFO, "Running webalizer for domain '".$caption."'");
		safe_exec($we . ' ' . $verbosity . ' -p -o ' . escapeshellarg($outputdir) . ' -n ' . escapeshellarg($caption) . $domainargs . ' ' . escapeshellarg($logfile));

		/**
		 * Format of webalizer.hist-files:
		 * Month: $webalizer_hist_row['0']
		 * Year:  $webalizer_hist_row['1']
		 * KB:    $webalizer_hist_row['5']
		 */
		$httptraffic = array();
		$webalizer_hist = @file_get_contents($outputdir . 'webalizer.hist');
		$cronlog->logAction(CRON_ACTION, LOG_INFO, "Gathering traffic information from '".$webalizer_hist."'");

		$webalizer_hist_rows = explode("\n", $webalizer_hist);
		foreach ($webalizer_hist_rows as $webalizer_hist_row) {
			if ($webalizer_hist_row != '') {

				$webalizer_hist_row = explode(' ', $webalizer_hist_row);

				if (isset($webalizer_hist_row['0'])
					&& isset($webalizer_hist_row['1'])
					&& isset($webalizer_hist_row['5'])
				) {
					$month = intval($webalizer_hist_row['0']);
					$year = intval($webalizer_hist_row['1']);
					$traffic = floatval($webalizer_hist_row['5']);

					if (!isset($httptraffic[$year])) {
						$httptraffic[$year] = array();
					}

					$httptraffic[$year][$month] = $traffic;
				}
			}
		}

		reset($httptraffic);
		$httptrafficlast = array();
		$webalizer_lasthist = @file_get_contents($outputdir . 'webalizer.hist.1');
		$cronlog->logAction(CRON_ACTION, LOG_INFO, "Gathering traffic information from '".$webalizer_lasthist."'");

		$webalizer_lasthist_rows = explode("\n", $webalizer_lasthist);
		foreach ($webalizer_lasthist_rows as $webalizer_lasthist_row) {
			if ($webalizer_lasthist_row != '') {

				$webalizer_lasthist_row = explode(' ', $webalizer_lasthist_row);

				if (isset($webalizer_lasthist_row['0'])
					&& isset($webalizer_lasthist_row['1'])
					&& isset($webalizer_lasthist_row['5'])
				) {
					$month = intval($webalizer_lasthist_row['0']);
					$year = intval($webalizer_lasthist_row['1']);
					$traffic = floatval($webalizer_lasthist_row['5']);

					if (!isset($httptrafficlast[$year])) {
						$httptrafficlast[$year] = array();
					}

					$httptrafficlast[$year][$month] = $traffic;
				}
			}
		}

		reset($httptrafficlast);
		foreach ($httptraffic as $year => $months) {
			foreach ($months as $month => $traffic) {
				if (!isset($httptrafficlast[$year][$month])) {
					$returnval+= $traffic;
				} elseif ($httptrafficlast[$year][$month] < $httptraffic[$year][$month]) {
					$returnval+= ($httptraffic[$year][$month] - $httptrafficlast[$year][$month]);
				}
			}
		}
	}

	return floatval($returnval);
}
