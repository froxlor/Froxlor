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
 * @package    Panel
 *
 * @since 0.9.34
 */
define('AREA', 'admin');
require './lib/init.php';

if ($userinfo['change_serversettings'] == '1') {

	$customer_tmpdir = '/tmp/';
	if (Settings::Get('system.mod_fcgid') == '1' && Settings::Get('system.mod_fcgid_tmpdir') != '')
	{
		$customer_tmpdir = Settings::Get('system.mod_fcgid_tmpdir');
	}
	elseif (Settings::Get('phpfpm.enabled') == '1' && Settings::Get('phpfpm.tmpdir') != '')
	{
		$customer_tmpdir = Settings::Get('phpfpm.tmpdir');
	}

	// try to convert namserver hosts to ip's
	$ns_ips = "";
	if (Settings::Get('system.nameservers') != '') {
		$nameservers = explode(',', Settings::Get('system.nameservers'));
		foreach ($nameservers as $nameserver) {
			$nameserver = trim($nameserver);
			$nameserver_ips = gethostbynamel6($nameserver);
			if (is_array($nameserver_ips) && count($nameserver_ips) > 0) {
				$ns_ips .= implode(",", $nameserver_ips);
			}
		}
	}

	$replace_arr = Array(
		'<SQL_UNPRIVILEGED_USER>' => $sql['user'],
		'<SQL_UNPRIVILEGED_PASSWORD>' => 'FROXLOR_MYSQL_PASSWORD',
		'<SQL_DB>' => $sql['db'],
		'<SQL_HOST>' => $sql['host'],
		'<SQL_SOCKET>' => isset($sql['socket']) ? $sql['socket'] : null,
		'<SERVERNAME>' => Settings::Get('system.hostname'),
		'<SERVERIP>' => Settings::Get('system.ipaddress'),
		'<NAMESERVERS>' => Settings::Get('system.nameservers'),
		'<NAMESERVERS_IP>' => $ns_ips,
		'<AXFRSERVERS>' => Settings::Get('system.axfrservers'),
		'<VIRTUAL_MAILBOX_BASE>' => Settings::Get('system.vmail_homedir'),
		'<VIRTUAL_UID_MAPS>' => Settings::Get('system.vmail_uid'),
		'<VIRTUAL_GID_MAPS>' => Settings::Get('system.vmail_gid'),
		'<SSLPROTOCOLS>' => (Settings::Get('system.use_ssl') == '1') ? 'imaps pop3s' : '',
		'<CUSTOMER_TMP>' => makeCorrectDir($customer_tmpdir),
		'<BASE_PATH>' => makeCorrectDir(FROXLOR_INSTALL_DIR),
		'<BIND_CONFIG_PATH>' => makeCorrectDir(Settings::Get('system.bindconf_directory')),
		'<WEBSERVER_RELOAD_CMD>' => Settings::Get('system.apachereload_command'),
		'<CUSTOMER_LOGS>' => makeCorrectDir(Settings::Get('system.logfiles_directory')),
		'<FPM_IPCDIR>' => makeCorrectDir(Settings::Get('phpfpm.fastcgi_ipcdir')),
		'<WEBSERVER_GROUP>' => Settings::Get('system.httpgroup')
	);

	// get distro from URL param
	$distribution = (isset($_GET['distribution']) && $_GET['distribution'] != 'choose') ? $_GET['distribution'] : "";
	$service = (isset($_GET['service']) && $_GET['service'] != 'choose') ? $_GET['service'] : "";
	$daemon = (isset($_GET['daemon']) && $_GET['daemon'] != 'choose') ? $_GET['daemon'] : "";
	$distributions_select = "";
	$services_select = "";
	$daemons_select = "";

	$configfiles = "";
	$services = "";
	$daemons = "";

	$config_dir = makeCorrectDir(FROXLOR_INSTALL_DIR . '/lib/configfiles/');

	if ($distribution != "") {

		if (!file_exists($config_dir . '/' . $distribution . ".xml")) {
			trigger_error("Unknown distribution, are you playing around with the URL?");
			exit;
		}

		// create configparser object
		$configfiles = new ConfigParser($config_dir . '/' . $distribution . ".xml");

		// get distro-info
		$dist_display = getCompleteDistroName($configfiles);

		// get all the services from the distro
		$services = $configfiles->getServices();

		if ($service != "") {

			if (!isset($services[$service])) {
				trigger_error("Unknown service, are you playing around with the URL?");
				exit;
			}

			$daemons = $services[$service]->getDaemons();

			if ($daemon == "") {
				foreach ($daemons as $di => $dd) {
					$title = $dd->title;
					if ($dd->default) {
						$title = $title . " (" . strtolower($lng['panel']['default']) . ")";
					}
					$daemons_select .= makeoption($title, $di);
				}
			}
		} else {
			foreach ($services as $si => $sd) {
				$services_select .= makeoption($sd->title, $si);
			}
		}
	} else {

		// show list of available distro's
		$distros = glob($config_dir . '*.xml');
		// tmp array
		$distributions_select_data = array();
		// read in all the distros
		foreach ($distros as $_distribution) {
			// get configparser object
			$dist = new ConfigParser($_distribution);
			// get distro-info
			$dist_display = getCompleteDistroName($dist);
			// store in tmp array
			$distributions_select_data[$dist_display] = str_replace(".xml", "", strtolower(basename($_distribution)));
		}

		// sort by distribution name
		ksort($distributions_select_data);

		foreach ($distributions_select_data as $dist_display => $dist_index) {
			// create select-box-option
			$distributions_select .= makeoption($dist_display, $dist_index);
		}
	}

	if ($distribution != "" && $service != "" && $daemon != "") {

		if (!isset($daemons[$daemon])) {
			trigger_error("Unknown daemon, are you playing around with the URL?");
			exit;
		}

		$confarr = $daemons[$daemon]->getConfig();

		$configpage = '';

		$distro_editor = $configfiles->distributionEditor;

		$commands_pre = "";
		$commands_file = "";
		$commands_post = "";

		$lasttype = '';
		$commands = '';
		foreach ($confarr as $idx => $action) {
			if ($lasttype != '' && $lasttype != $action['type']) {
				$commands = trim($commands);
				$numbrows = count(explode("\n", $commands));
				eval("\$configpage.=\"" . getTemplate("configfiles/configfiles_commands") . "\";");
				$lasttype = '';
				$commands = '';
			}
			switch ($action['type']) {
				case "install":
					$commands .= strtr($action['content'], $replace_arr) . "\n";
					$lasttype = "install";
					break;
				case "command":
					$commands .= strtr($action['content'], $replace_arr) . "\n";
					$lasttype = "command";
					break;
				case "file":
					if (array_key_exists('content', $action)) {
						$commands_file = getFileContentContainer($action['content'], $replace_arr, $action['name'], $distro_editor);
					} elseif (array_key_exists('subcommands', $action)) {
						foreach ($action['subcommands'] as $fileaction) {
							if (array_key_exists('execute', $fileaction) && $fileaction['execute'] == "pre") {
								$commands_pre .= $fileaction['content'] . "\n";
							} elseif (array_key_exists('execute', $fileaction) && $fileaction['execute'] == "post") {
								$commands_post .= $fileaction['content'] . "\n";
							} elseif ($fileaction['type'] == 'file') {
								$commands_file = getFileContentContainer($fileaction['content'], $replace_arr, $action['name'], $distro_editor);
							}
						}
					}
					$realname = $action['name'];
					$commands = trim($commands_pre);
					if ($commands != "") {
						$numbrows = count(explode("\n", $commands));
						eval("\$commands_pre=\"" . getTemplate("configfiles/configfiles_commands") . "\";");
					}
					$commands = trim($commands_post);
					if ($commands != "") {
						$numbrows = count(explode("\n", $commands));
						eval("\$commands_post=\"" . getTemplate("configfiles/configfiles_commands") . "\";");
					}
					eval("\$configpage.=\"" . getTemplate("configfiles/configfiles_subfileblock") . "\";");
					$commands = '';
					$commands_pre = '';
					$commands_post = '';
					break;
			}
		}
		$commands = trim($commands);
		if ($commands != '') {
			$numbrows = count(explode("\n", $commands));
			eval("\$configpage.=\"" . getTemplate("configfiles/configfiles_commands") . "\";");
		}
		eval("echo \"" . getTemplate("configfiles/configfiles") . "\";");
	} else {
		eval("echo \"" . getTemplate("configfiles/wizard") . "\";");
	}
} else {
	die('not allowed to see this page');
	// redirect or similar here
}

// helper functions
function getFileContentContainer($file_content, &$replace_arr, $realname, $distro_editor)
{
	$files = "";
	$file_content = trim($file_content);
	if ($file_content != '') {
		$file_content = strtr($file_content, $replace_arr);
		$file_content = htmlspecialchars($file_content);
		$numbrows = count(explode("\n", $file_content));
		eval("\$files=\"" . getTemplate("configfiles/configfiles_file") . "\";");
	}
	return $files;
}

function getCompleteDistroName($cparser)
{
	// get distro-info
	$dist_display = $cparser->distributionName;
	if ($cparser->distributionCodename != '') {
		$dist_display .= " " . $cparser->distributionCodename;
	}
	if ($cparser->distributionVersion != '') {
		$dist_display .= " (" . $cparser->distributionVersion . ")";
	}
	if ($cparser->deprecated) {
		$dist_display .= " [deprecated]";
	}
	return $dist_display;
}
