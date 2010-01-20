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
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    Panel
 * @version    $Id: configfiles_index.inc.php 2692 2009-03-27 18:04:47Z flo $
 */

$configcommand = array();

if(isConfigDir($settings['system']['apacheconf_vhost']))
{
	$configcommand['vhost'] = 'mkdir -p ' . $settings['system']['apacheconf_vhost'];
	$configcommand['include'] = 'echo -e "\\nInclude ' . makeCorrectDir($settings['system']['apacheconf_vhost']) . '*.conf" >> ' . makeCorrectFile(makeCorrectDir($settings['system']['apacheconf_vhost']) . '/httpd.conf');
	$configcommand['v_inclighty'] = 'echo -e \'\\ninclude_shell "find ' . makeCorrectDir($settings['system']['apacheconf_vhost']) . ' -maxdepth 1 -name \'*.conf\' -exec cat {} \;"\' >> /etc/lighttpd/lighttpd.conf';
}
else
{
	$configcommand['vhost'] = 'touch ' . $settings['system']['apacheconf_vhost'];
	$configcommand['include'] = 'echo -e "\\nInclude ' . $settings['system']['apacheconf_vhost'] . '" >> ' . makeCorrectFile(dirname($settings['system']['apacheconf_vhost']) . '/httpd.conf');
	$configcommand['v_inclighty'] = 'echo -e \'\\ninclude "' . $settings['system']['apacheconf_vhost'] . '"\' >> /etc/lighttpd/lighttpd.conf';
}

if(isConfigDir($settings['system']['apacheconf_diroptions']))
{
	$configcommand['diroptions'] = 'mkdir -p ' . $settings['system']['apacheconf_diroptions'];
	$configcommand['d_inclighty'] = 'echo -e \'\\ninclude_shell "find ' . makeCorrectDir($settings['system']['apacheconf_diroptions']) . ' -maxdepth 1 -name \'*.conf\' -exec cat {} \;"\' >> /etc/lighttpd/lighttpd.conf';
}
else
{
	$configcommand['diroptions'] = 'touch ' . $settings['system']['apacheconf_diroptions'];
	$configcommand['d_inclighty'] = 'echo -e \'\\ninclude "' . $settings['system']['apacheconf_diroptions'] . '"\' >> /etc/lighttpd/lighttpd.conf';
}

$cfgPath = 'lib/configfiles/';
$configfiles = Array();
$configfiles = array_merge(include $cfgPath . 'lenny.inc.php', include $cfgPath . 'etch.inc.php', include $cfgPath . 'hardy.inc.php', include $cfgPath . 'gentoo.inc.php', include $cfgPath . 'suse10.inc.php');

?>