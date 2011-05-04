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
 * @package    Functions
 *
 */

/**
 * This function generates the VHost configuration for AWStats
 * This will enable the /awstats url and enable security on these folders
 * @param siteDomain Name of the domain we want stats for
 * @return String with configuration for use in vhost file
 * @author Berend Dekens
 */

function createAWStatsVhost($siteDomain, $settings = null)
{
	if($settings['system']['mod_fcgid'] != '1')
	{
		$vhosts_file = '  # AWStats statistics' . "\n";
		$vhosts_file.= '  RewriteEngine On' . "\n";
		$vhosts_file.= '  RewriteRule ^/awstats(/.*)?$ /awstats/awstats.pl?config=' . $siteDomain . ' [L,PT]' . "\n";
		$vhosts_file.= '  RewriteRule ^/awstats.pl(.*)$ /awstats/awstats.pl$1 [QSA,L,PT]' . "\n";
	}
	else
	{
		$vhosts_file = '  <IfModule mod_proxy.c>' . "\n";
		$vhosts_file.= '    RewriteEngine On' . "\n";
		$vhosts_file.= '    RewriteRule awstats.pl(.*)$	http://' . $settings['system']['hostname'] . '/cgi-bin/awstats.pl$1 [R,P]' . "\n";
		$vhosts_file.= '    RewriteRule awstats$	http://' . $settings['system']['hostname'] . '/cgi-bin/awstats.pl?config=' . $siteDomain . ' [R,P]' . "\n";
		$vhosts_file.= '  </IfModule>' . "\n";
	}

	return $vhosts_file;
}
