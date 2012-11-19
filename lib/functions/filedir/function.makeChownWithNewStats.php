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
 * chowns either awstats or webalizer folder,
 * either with webserver-user or - if fcgid
 * is used - the customers name, #258
 *
 * @param array $row array if panel_customers
 *
 * @return void
 */
function makeChownWithNewStats($row)
{
	global $settings, $theme;

	// get correct user
	if($settings['system']['mod_fcgid'] == '1' && isset($row['deactivated']) && $row['deactivated'] == '0')
	{
		$user = $row['loginname'];
		$group = $row['loginname'];
	}
	else
	{
		$user = $row['guid'];
		$group = $row['guid'];
	}

	// get correct directory
	$dir = $row['documentroot'];
	if($settings['system']['awstats_enabled'] == '1')
	{
		$dir .= '/awstats/';
	} else {
		$dir .= '/webalizer/';
	}

	// only run chown if directory exists
	if (file_exists($dir))
	{
		// run chown
		safe_exec('chown -R '.escapeshellarg($user).':'.escapeshellarg($group).' '.escapeshellarg(makeCorrectDir($dir)));
	}
}
