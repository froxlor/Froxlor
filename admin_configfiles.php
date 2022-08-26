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

use Froxlor\Settings;

if ($userinfo['change_serversettings'] == '1') {

	if ($action == 'setconfigured') {
		Settings::Set('panel.is_configured', '1', true);
		\Froxlor\UI\Response::redirectTo('admin_configfiles.php', array(
			's' => $s
		));
	}

	$customer_tmpdir = '/tmp/';
	if (Settings::Get('system.mod_fcgid') == '1' && Settings::Get('system.mod_fcgid_tmpdir') != '') {
		$customer_tmpdir = Settings::Get('system.mod_fcgid_tmpdir');
	} elseif (Settings::Get('phpfpm.enabled') == '1' && Settings::Get('phpfpm.tmpdir') != '') {
		$customer_tmpdir = Settings::Get('phpfpm.tmpdir');
	}

	// try to convert namserver hosts to ip's
	$ns_ips = "";
	$known_ns_ips = [];
	if (Settings::Get('system.nameservers') != '') {
		$nameservers = explode(',', Settings::Get('system.nameservers'));
		foreach ($nameservers as $nameserver) {
			$nameserver = trim($nameserver);
			// DNS servers might be multi homed; allow transfer from all ip
			// addresses of the DNS server
			$nameserver_ips = \Froxlor\PhpHelper::gethostbynamel6($nameserver);
			// append dot to hostname
			if (substr($nameserver, - 1, 1) != '.') {
				$nameserver .= '.';
			}
			// ignore invalid responses
			if (! is_array($nameserver_ips)) {
				// act like \Froxlor\PhpHelper::gethostbynamel6() and return unmodified hostname on error
				$nameserver_ips = array(
					$nameserver
				);
			} else {
				$known_ns_ips = array_merge($known_ns_ips, $nameserver_ips);
			}
			if (!empty($ns_ips)) {
				$ns_ips .= ',';
			}
			$ns_ips .= implode(",", $nameserver_ips);
		}
	}

	// AXFR server
	if (Settings::Get('system.axfrservers') != '') {
		$axfrservers = explode(',', Settings::Get('system.axfrservers'));
		foreach ($axfrservers as $axfrserver) {
			if (!in_array(trim($axfrserver), $known_ns_ips)) {
				if (!empty($ns_ips)) {
					$ns_ips .= ',';
				}
				$ns_ips .= trim($axfrserver);
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
		'<VIRTUAL_MAILBOX_BASE>' => Settings::Get('system.vmail_homedir'),
		'<VIRTUAL_UID_MAPS>' => Settings::Get('system.vmail_uid'),
		'<VIRTUAL_GID_MAPS>' => Settings::Get('system.vmail_gid'),
		'<SSLPROTOCOLS>' => (Settings::Get('system.use_ssl') == '1') ? 'imaps pop3s' : '',
		'<CUSTOMER_TMP>' => \Froxlor\FileDir::makeCorrectDir($customer_tmpdir),
		'<BASE_PATH>' => \Froxlor\FileDir::makeCorrectDir(\Froxlor\Froxlor::getInstallDir()),
		'<BIND_CONFIG_PATH>' => \Froxlor\FileDir::makeCorrectDir(Settings::Get('system.bindconf_directory')),
		'<WEBSERVER_RELOAD_CMD>' => Settings::Get('system.apachereload_command'),
		'<CUSTOMER_LOGS>' => \Froxlor\FileDir::makeCorrectDir(Settings::Get('system.logfiles_directory')),
		'<FPM_IPCDIR>' => \Froxlor\FileDir::makeCorrectDir(Settings::Get('phpfpm.fastcgi_ipcdir')),
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

	$config_dir = \Froxlor\FileDir::makeCorrectDir(\Froxlor\Froxlor::getInstallDir() . '/lib/configfiles/');

	if ($distribution != "") {

		if (! file_exists($config_dir . '/' . $distribution . ".xml")) {
			trigger_error("Unknown distribution, are you playing around with the URL?");
			exit();
		}

		// create configparser object
		$configfiles = new \Froxlor\Config\ConfigParser($config_dir . '/' . $distribution . ".xml");

		// get distro-info
		$dist_display = getCompleteDistroName($configfiles);

		// get all the services from the distro
		$services = $configfiles->getServices();

		if ($service != "") {

			if (! isset($services[$service])) {
				trigger_error("Unknown service, are you playing around with the URL?");
				exit();
			}

			$daemons = $services[$service]->getDaemons();

			if ($daemon == "") {
				foreach ($daemons as $di => $dd) {
					$title = $dd->title;
					if ($dd->default) {
						$title = $title . " (" . strtolower($lng['panel']['default']) . ")";
					}
					$daemons_select .= \Froxlor\UI\HTML::makeoption($title, $di);
				}
			}
		} else {
			foreach ($services as $si => $sd) {
				$services_select .= \Froxlor\UI\HTML::makeoption($sd->title, $si);
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
			$dist = new \Froxlor\Config\ConfigParser($_distribution);
			// get distro-info
			$dist_display = getCompleteDistroName($dist);
			// store in tmp array
			$distributions_select_data[$dist_display] = str_replace(".xml", "", strtolower(basename($_distribution)));
		}

		// sort by distribution name
		ksort($distributions_select_data);

		foreach ($distributions_select_data as $dist_display => $dist_index) {
			// create select-box-option
			$distributions_select .= \Froxlor\UI\HTML::makeoption($dist_display, $dist_index);
		}
	}

	if ($distribution != "" && $service != "" && $daemon != "") {

		if (! isset($daemons[$daemon])) {
			trigger_error("Unknown daemon, are you playing around with the URL?");
			exit();
		}

		$confarr = $daemons[$daemon]->getConfig();

		$configpage = '';

		$distro_editor = $configfiles->distributionEditor;

		$commands_pre = "";
		$commands_file = "";
		$commands_post = "";

		$lasttype = '';
		$commands = '';
		foreach ($confarr as $_action) {
			if ($lasttype != '' && $lasttype != $_action['type']) {
				$commands = trim($commands);
				$numbrows = count(explode("\n", $commands));
				eval("\$configpage.=\"" . \Froxlor\UI\Template::getTemplate("configfiles/configfiles_commands") . "\";");
				$lasttype = '';
				$commands = '';
			}
			switch ($_action['type']) {
				case "install":
					$commands .= strtr($_action['content'], $replace_arr) . "\n";
					$lasttype = "install";
					break;
				case "command":
					$commands .= strtr($_action['content'], $replace_arr) . "\n";
					$lasttype = "command";
					break;
				case "file":
					if (array_key_exists('content', $_action)) {
						$commands_file = getFileContentContainer($_action['content'], $replace_arr, $_action['name'], $distro_editor);
					} elseif (array_key_exists('subcommands', $_action)) {
						foreach ($_action['subcommands'] as $fileaction) {
							if (array_key_exists('execute', $fileaction) && $fileaction['execute'] == "pre") {
								$commands_pre .= $fileaction['content'] . "\n";
							} elseif (array_key_exists('execute', $fileaction) && $fileaction['execute'] == "post") {
								$commands_post .= $fileaction['content'] . "\n";
							} elseif ($fileaction['type'] == 'file') {
								$commands_file = getFileContentContainer($fileaction['content'], $replace_arr, $_action['name'], $distro_editor);
							}
						}
					}
					$realname = $_action['name'];
					$commands = trim($commands_pre);
					if ($commands != "") {
						$numbrows = count(explode("\n", $commands));
						eval("\$commands_pre=\"" . \Froxlor\UI\Template::getTemplate("configfiles/configfiles_commands") . "\";");
					}
					$commands = trim($commands_post);
					if ($commands != "") {
						$numbrows = count(explode("\n", $commands));
						eval("\$commands_post=\"" . \Froxlor\UI\Template::getTemplate("configfiles/configfiles_commands") . "\";");
					}
					eval("\$configpage.=\"" . \Froxlor\UI\Template::getTemplate("configfiles/configfiles_subfileblock") . "\";");
					$commands = '';
					$commands_pre = '';
					$commands_post = '';
					break;
			}
		}
		$commands = trim($commands);
		if ($commands != '') {
			$numbrows = count(explode("\n", $commands));
			eval("\$configpage.=\"" . \Froxlor\UI\Template::getTemplate("configfiles/configfiles_commands") . "\";");
		}
		eval("echo \"" . \Froxlor\UI\Template::getTemplate("configfiles/configfiles") . "\";");
	} else {
		$basedir = \Froxlor\Froxlor::getInstallDir();
		eval("echo \"" . \Froxlor\UI\Template::getTemplate("configfiles/wizard") . "\";");
	}
} else {
	\Froxlor\UI\Response::redirectTo('admin_index.php', array(
		's' => $s
	));
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
		eval("\$files=\"" . \Froxlor\UI\Template::getTemplate("configfiles/configfiles_file") . "\";");
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
