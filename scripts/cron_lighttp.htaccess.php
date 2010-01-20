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
 * @author     Michael Kaufmann <mk@syscp-help.org>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    System
 * @version    $Id: cron_lighttp.htaccess.php 2692 2009-03-27 18:04:47Z flo $
 */

/**
 * STARTING REDUNDANT CODE, WHICH IS SOME KINDA HEADER FOR EVERY CRON SCRIPT.
 * When using this "header" you have to change $lockFilename for your needs.
 * Don't forget to also copy the footer which closes database connections
 * and the lockfile!
 */

include (dirname(__FILE__) . '/../lib/cron_init.php');

/**
 * END REDUNDANT CODE (CRONSCRIPT "HEADER")
 */

/**
 * LOOK INTO EVERY CUSTOMER DIR TO SEE IF THERE ARE ANY .HTACCESS FILE TO "TRANSLATE"
 */

if($settings['system']['webserver'] == 'lighttpd')
{
	fwrite($debugHandler, '  cron_lighttp.htaccess: Searching for .htaccess files to translate' . "\n");
	$lpath = makeCorrectDir(strrchr($settings['system']['apacheconf_vhost'], '/'));
	$htaccessfh = @fopen($lpath . 'syscp-htaccess.conf', 'w');

	if($htaccessfh !== false)
	{
		read_directory($settings['system']['documentroot_prefix'], 25, $htaccessfh);
	}
	else
	{
		fwrite($debugHandler, '  ERROR: Cannot open file ' . $lpath . 'syscp-htaccess.conf' . "\n");
	}
}
else
{
	fwrite($debugHandler, '  cron_lighttp.htaccess: You don\'t use Lighttpd, you do not have to run this cronscript!' . "\n");
}

/**
 * STARTING CRONSCRIPT FOOTER
 */

include ($pathtophpfiles . '/lib/cron_shutdown.php');

/**
 * END CRONSCRIPT FOOTER
 */

/**
 * FUNCTIONS
 */

function read_directory($dir1 = null, $min_depth = 25, $htaccessfh = null)
{
	global $htaccessfh;

	if(!is_string($dir1))
	{
		return false;
	}

	$depth = explode("/", $dir1);
	$current_depth = sizeof($depth);

	if($current_depth < $min_depth)
	{
		$min_depth = $current_depth;
	}

	$dir = $dir1;
	$dh = opendir($dir);

	while($file = readdir($dh))
	{
		if(($file != ".")
		   && ($file != ".."))
		{
			$file = $dir . "/" . $file;
			for ($i = 0;$i <= ($current_depth - $min_depth);$i++)

			// $file is sub-directory

			if($ddh = @opendir($file))
			{
				read_directory($file);
			}
			else
			{
				if(strtolower($file) == '.htaccess')
				{
					parseHtaccess($file);
				}
			}
		}
	}

	closedir($dh);
	return true;
}

function parseHtaccess($file = null)
{
	global $debugHandler, $htaccessfh;
	$htacc = @file_get_contents($file);

	if($htacc != "")
	{
		$htlines = array();
		$htlines = explode("\n", $htacc);
		$userhasrewrites = false;
		$userrewrites = array();
		$rule = array();
		foreach($htlines as $htl)
		{
			if(preg_match('/^RewriteEngine\ on$/si', $htl) !== null)
			{
				$userhasrewrites = true;
			}
			elseif(preg_match('/^RewriteRule\ +\^(.*)\$\(.*)$/si', $htl, $rule) !== null)
			{
				$regex = isset($rule[0]) ? $rule[0] : '';
				$relativeuri = isset($rule[1]) ? $rule[1] : '';

				if($regex != ''
				   && $relativeuri != '')
				{
					$userrewrites[]['regex'] = $regex;
					$userrewrites[]['relativeuri'] = $relativeuri;
				}
			}
		}

		if($userhasrewrites)
		{
			fwrite($htaccessfh, '$PHYSICAL["path"] == "' . dirname($file) . '" {' . "\n");
			fwrite($htaccessfh, '   url.rewrite-once = (' . "\n");
			$count = 1;
			$max = count($userrewrites);
			foreach($userrewrites as $usrrw)
			{
				fwrite($htaccessfh, ' "^' . $usrrw['regex'] . '$" => "' . $usrrw['relativeuri'] . '"');

				if($count < $max)
				{
					fwrite($htaccessfh, ',' . "\n");
				}
				else
				{
					fwrite($htaccessfh, "\n");
				}

				$count++;
			}

			fwrite($htaccessfh, '   )' . "\n");
			fwrite($htaccessfh, '}' . "\n");
		}
	}
	else
	{
		fwrite($debugHandler, '  WARNING: file ' . $file . ' seems to be empty or there was an error' . "\n");
		return;
	}
}

?>
