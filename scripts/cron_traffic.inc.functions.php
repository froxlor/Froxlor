<?php

/**
 * This file is part of the SysCP project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org>
 * @author     Florian Aders <eleras@syscp.org>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    System
 * @version    $Id$
 */

/**
 * Function which make webalizer statistics and returns used traffic since last run
 *
 * @param string Name of logfile
 * @param string Place where stats should be build
 * @param string Caption for webalizer output
 * @return int Used traffic
 * @author Florian Lippert <flo@syscp.org>
 */

function callWebalizerGetTraffic($logfile, $outputdir, $caption, $usersdomainlist)
{
	global $settings;
	$returnval = 0;

	if(file_exists($settings['system']['logfiles_directory'] . $logfile . '-access.log'))
	{
		$domainargs = '';
		foreach($usersdomainlist as $domainid => $domain)
		{
			$domainargs.= ' -r ' . escapeshellarg($domain);
		}

		$outputdir = makeCorrectDir($outputdir);

		if(!file_exists($outputdir))
		{
			safe_exec('mkdir -p ' . escapeshellarg($outputdir));
		}

		if(file_exists($outputdir . 'webalizer.hist.1'))
		{
			unlink($outputdir . 'webalizer.hist.1');
		}

		if(file_exists($outputdir . 'webalizer.hist')
		   && !file_exists($outputdir . 'webalizer.hist.1'))
		{
			safe_exec('cp ' . escapeshellarg($outputdir . 'webalizer.hist') . ' ' . escapeshellarg($outputdir . 'webalizer.hist.1'));
		}

		$verbosity = '';

		if($settings['system']['webalizer_quiet'] == '1')
		{
			$verbosity = '-q';
		}
		elseif($settings['system']['webalizer_quiet'] == '2')
		{
			$verbosity = '-Q';
		}

		safe_exec('webalizer ' . $verbosity . ' -p -o ' . escapeshellarg($outputdir) . ' -n ' . escapeshellarg($caption) . $domainargs . ' ' . escapeshellarg($settings['system']['logfiles_directory'] . $logfile . '-access.log'));

		/**
		 * Format of webalizer.hist-files:
		 * Month: $webalizer_hist_row['0']
		 * Year:  $webalizer_hist_row['1']
		 * KB:    $webalizer_hist_row['5']
		 */

		$httptraffic = array();
		$webalizer_hist = @file_get_contents($outputdir . 'webalizer.hist');
		$webalizer_hist_rows = explode("\n", $webalizer_hist);
		foreach($webalizer_hist_rows as $webalizer_hist_row)
		{
			if($webalizer_hist_row != '')
			{
				$webalizer_hist_row = explode(' ', $webalizer_hist_row);

				if(isset($webalizer_hist_row['0'])
				   && isset($webalizer_hist_row['1'])
				   && isset($webalizer_hist_row['5']))
				{
					$month = intval($webalizer_hist_row['0']);
					$year = intval($webalizer_hist_row['1']);
					$traffic = floatval($webalizer_hist_row['5']);

					if(!isset($httptraffic[$year]))
					{
						$httptraffic[$year] = array();
					}

					$httptraffic[$year][$month] = $traffic;
				}
			}
		}

		reset($httptraffic);
		$httptrafficlast = array();
		$webalizer_lasthist = @file_get_contents($outputdir . 'webalizer.hist.1');
		$webalizer_lasthist_rows = explode("\n", $webalizer_lasthist);
		foreach($webalizer_lasthist_rows as $webalizer_lasthist_row)
		{
			if($webalizer_lasthist_row != '')
			{
				$webalizer_lasthist_row = explode(' ', $webalizer_lasthist_row);

				if(isset($webalizer_lasthist_row['0'])
				   && isset($webalizer_lasthist_row['1'])
				   && isset($webalizer_lasthist_row['5']))
				{
					$month = intval($webalizer_lasthist_row['0']);
					$year = intval($webalizer_lasthist_row['1']);
					$traffic = floatval($webalizer_lasthist_row['5']);

					if(!isset($httptrafficlast[$year]))
					{
						$httptrafficlast[$year] = array();
					}

					$httptrafficlast[$year][$month] = $traffic;
				}
			}
		}

		reset($httptrafficlast);
		foreach($httptraffic as $year => $months)
		{
			foreach($months as $month => $traffic)
			{
				if(!isset($httptrafficlast[$year][$month]))
				{
					$returnval+= $traffic;
				}
				elseif($httptrafficlast[$year][$month] < $httptraffic[$year][$month])
				{
					$returnval+= ($httptraffic[$year][$month] - $httptrafficlast[$year][$month]);
				}
			}
		}
	}

	return floatval($returnval);
}

/**
 * This function saves the logfile written by mod_log_sql
 * into a logfile webalizer can parse
 *
 * @param string $domain        The "speciallogfile" - domain(s)
 * @param string $loginname     The loginname of the customer
 * @return bool
 *
 * @author Florian Aders <eleras@syscp.org>
 */

function safeSQLLogfile($domains, $loginname)
{
	global $db, $settings;
	$sql = "SELECT * FROM access_log ";
	$where = "WHERE virtual_host = ";

	if(!is_array($domains))
	{
		// If it isn't an array, it's a speciallogfile-domain

		$logname = $settings['system']['logfiles_directory'] . $loginname . '-' . $domains . '-access.log';
		$where.= "'$domains' OR virtual_host = 'www.$domains'";
	}
	else
	{
		// If we have an array, these are all domains aggregated into a single logfile

		if(count($domains) == 0)
		{
			// If the $omains-array is empty, this customer has only speciallogfile-
			// domains, so just return, all logfiles are already written to disk

			return true;
		}

		$logname = $settings['system']['logfiles_directory'] . $loginname . '-access.log';

		// Build the "WHERE" - part of the sql-query

		foreach($domains as $domain)
		{
			// A domain may be reached with or without the "www" in front.

			$where.= "'$domain' OR virtual_host = 'www.$domain' OR virtual_host = ";
		}

		$where = substr($where, 0, -19);
	}

	// We want clean, ordered logfiles

	$sql.= $where . " ORDER BY time_stamp;";
	$logs = $db->query($sql);

	// Don't overwrite the logfile - append the new stuff

	file_put_contents($logname, "", FILE_APPEND);

	while($logline = $db->fetch_array($logs))
	{
		// Create a "CustomLog" - line

		$writelog = $logline['remote_host'] . " " . $logline['virtual_host'] . " " . $logline['remote_user'] . " ";
		$writelog.= date("[d/M/Y:H:i:s O]", $logline['time_stamp']);
		$writelog.= " \"" . $logline['request_method'] . " " . $logline['request_uri'] . " " . $logline['request_protocol'] . "\" ";
		$writelog.= $logline['status'];
		$writelog.= " " . $logline['bytes_sent'] . " \"" . $logline['referer'] . "\" \"" . $logline['agent'] . "\"\n";
		file_put_contents($logname, $writelog, FILE_APPEND);
	}

	// Remove the just written stuff

	$db->query("DELETE FROM access_log " . $where);
	return true;
}

