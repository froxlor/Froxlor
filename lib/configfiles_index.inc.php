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
 * @package    Lib
 *
 */

$configcommand = array();

if (isConfigDir(Settings::Get('system.apacheconf_vhost'))) {
	$configcommand['vhost'] = 'mkdir -p ' . Settings::Get('system.apacheconf_vhost');
	$configcommand['include'] = 'echo -e "\\nInclude ' . makeCorrectDir(Settings::Get('system.apacheconf_vhost')) . '*.conf" >> ' . makeCorrectFile(makeCorrectDir('/etc/apache2/httpd.conf'));
	$configcommand['v_inclighty'] = 'echo -e \'\\ninclude_shell "cat ' . makeCorrectDir(Settings::Get('system.apacheconf_vhost')) . '*.conf"\' >> /etc/lighttpd/lighttpd.conf';
} else {
	$configcommand['vhost'] = 'touch ' . Settings::Get('system.apacheconf_vhost');
	$configcommand['include'] = 'echo -e "\\nInclude ' . Settings::Get('system.apacheconf_vhost') . '" >> ' . makeCorrectFile('/etc/apache2/httpd.conf');
	$configcommand['v_inclighty'] = 'echo -e \'\\ninclude "' . Settings::Get('system.apacheconf_vhost') . '"\' >> /etc/lighttpd/lighttpd.conf';
}

if (isConfigDir(Settings::Get('system.apacheconf_diroptions'))) {
	$configcommand['diroptions'] = 'mkdir -p ' . Settings::Get('system.apacheconf_diroptions');
	$configcommand['d_inclighty'] = 'echo -e \'\\ninclude_shell "cat ' . makeCorrectDir(Settings::Get('system.apacheconf_diroptions')) . '*.conf"\' >> /etc/lighttpd/lighttpd.conf';
} else {
	$configcommand['diroptions'] = 'touch ' . Settings::Get('system.apacheconf_diroptions');
	$configcommand['d_inclighty'] = 'echo -e \'\\ninclude "' . Settings::Get('system.apacheconf_diroptions') . '"\' >> /etc/lighttpd/lighttpd.conf';
}

$cfgPath = 'lib/configfiles/';
$configfiles = array();
$configfiles = array_merge(
	include $cfgPath . 'wheezy.inc.php',
	include $cfgPath . 'squeeze.inc.php',
	include $cfgPath . 'precise.inc.php',
	include $cfgPath . 'lucid.inc.php',
	include $cfgPath . 'gentoo.inc.php',
	include $cfgPath . 'sle11.inc.php',
	include $cfgPath . 'sle10.inc.php',
	include $cfgPath . 'freebsd.inc.php'
);
