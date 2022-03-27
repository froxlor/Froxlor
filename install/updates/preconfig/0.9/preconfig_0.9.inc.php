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
 * @package    Language
 *
 */

use Froxlor\Database\Database;
use Froxlor\Settings;
use PHPMailer\PHPMailer;
use Froxlor\UI\Panel\UI;

/**
 * checks if the new-version has some updating to do
 *
 * @param boolean $has_preconfig
 *        	pointer to check if any preconfig has to be output
 * @param string $return
 *        	pointer to output string
 * @param string $current_version
 *        	current froxlor version
 *        	
 * @return void
 */
function parseAndOutputPreconfig(&$has_preconfig, &$return, $current_version, $current_db_version)
{
	global $lng;

	if (versionInUpdate($current_version, '0.9.4-svn2')) {
		$has_preconfig = true;
		$description = 'Froxlor now enables the usage of a domain-wildcard entry and subdomains for this domain at the same time (subdomains are parsed before the main-domain vhost container).';
		$description .= 'This makes it possible to catch all non-existing subdomains with the main vhost but also have the ability to use subdomains for that domain.<br />';
		$description .= 'If you would like Froxlor to do so with your domains, the update script can set the correct values for existing domains for you. Note: future domains will have wildcard-entries enabled by default no matter how you decide here.';
		$question = '<strong>Do you want to use wildcard-entries for existing domains?:</strong>';

		$return['update_domainwildcardentry_note'] = ['type' => 'infotext', 'value' => $description];
		$return['update_domainwildcardentry'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.6-svn2')) {
		if (!PHPMailer::ValidateAddress(Settings::Get('panel.adminmail'))) {
			$has_preconfig = true;
			$description = 'Froxlor uses a newer version of the PHPMailer-Class and determined that your current admin-mail address is invalid.';
			$question = '<strong>Please specify a new admin-email address:</strong>';

			$return['update_adminmail_note'] = ['type' => 'infotext', 'value' => $description];
			$return['update_adminmail'] = ['type' => 'text', 'value' => Settings::Get('panel.adminmail'), 'label' => $question];
		}
	}

	if (versionInUpdate($current_version, '0.9.6-svn3')) {
		$has_preconfig = true;
		$description = 'You now have the possibility to define default error-documents for your webserver which replace the default webserver error-messages.';
		$question = '<strong>Do you want to enable default error-documents?:</strong>';

		$return['update_deferr_note'] = ['type' => 'infotext', 'value' => $description];
		$return['update_deferr_enable'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];
		if (Settings::Get('system.webserver') == 'apache2') {
			$return['update_deferr_500'] = ['type' => 'text', 'value' => "", 'label' => 'Path/URL for error 500:'];
			$return['update_deferr_401'] = ['type' => 'text', 'value' => "", 'label' => 'Path/URL for error 401:'];
			$return['update_deferr_403'] = ['type' => 'text', 'value' => "", 'label' => 'Path/URL for error 403:'];
		}
		$return['update_deferr_404'] = ['type' => 'text', 'value' => "", 'label' => 'Path/URL for error 404:'];
	}

	if (versionInUpdate($current_version, '0.9.6-svn4')) {
		$has_preconfig = true;
		$description = 'You can define a default support-ticket priority level which is pre-selected for new support-tickets.';
		$question = '<strong>Which should be the default ticket-priority?:</strong>';

		$return['update_deftic_priority_note'] = ['type' => 'infotext', 'value' => $description];
		$return['update_deftic_priority'] = ['type' => 'select', 'select_var' => [1 => $lng['ticket']['high'], 2 => $lng['ticket']['normal'], 3 => $lng['ticket']['low']], 'selected' => 2, 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.6-svn5')) {
		$has_preconfig = true;
		$description = 'If you have more than one PHP configurations defined in Froxlor you can now set a default one which will be used for every domain.';
		$question = '<strong>Select default PHP configuration:</strong>';

		$return['update_defsys_phpconfig_note'] = ['type' => 'infotext', 'value' => $description];
		$configs_array = \Froxlor\Http\PhpConfig::getPhpConfigs();
		$configs = '';
		foreach ($configs_array as $idx => $desc) {
			$configs[$idx] = $desc;
		}
		$return['update_defsys_phpconfig'] = ['type' => 'select', 'select_var' => $configs, 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.6-svn6')) {
		$has_preconfig = true;
		$description = 'For the new FTP-quota feature, you can now chose the currently used ftpd-software.';
		$question = '<strong>Used FTPd-software:</strong>';

		$return['update_defsys_ftpserver_note'] = ['type' => 'infotext', 'value' => $description];
		$return['update_defsys_ftpserver'] = ['type' => 'select', 'select_var' => ['proftpd' => 'ProFTPd', 'pureftpd' => 'PureFTPd'], 'selected' => 'proftpd', 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.7-svn1')) {
		$has_preconfig = true;
		$description = 'You can now choose whether customers can select the http-redirect code and which of them acts as default.';
		$question = '<strong>Allow customer chosen redirects?:</strong>';
		$return['update_customredirect_enable_note'] = ['type' => 'infotext', 'value' => $description];
		$return['update_customredirect_enable'] = ['type' => 'checkbox', 'value' => 1, 'checked' => 1, 'label' => $question];

		$question = '<strong>Select default redirect code (default: empty):</strong>';
		$return['update_customredirect_default'] = [
			'type' => 'select',
			'select_var' => [
				1 => '--- (' . $lng['redirect_desc']['rc_default'] . ')',
				2 => '301 (' . $lng['redirect_desc']['rc_movedperm'] . ')',
				3 => '302 (' . $lng['redirect_desc']['rc_found'] . ')',
				4 => '303 (' . $lng['redirect_desc']['rc_seeother'] . ')',
				5 => '307 (' . $lng['redirect_desc']['rc_tempred'] . ')'
			],
			'selected' => 1,
			'label' => $question
		];
	}

	if (versionInUpdate($current_version, '0.9.7-svn2')) {
		$result = Database::query("SELECT `domain` FROM " . TABLE_PANEL_DOMAINS . " WHERE `documentroot` LIKE '%:%' AND `documentroot` NOT LIKE 'http://%' AND `openbasedir_path` = '0' AND `openbasedir` = '1'");
		$wrongOpenBasedirDomain = array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$wrongOpenBasedirDomain[] = $row['domain'];
		}

		if (count($wrongOpenBasedirDomain) > 0) {
			$has_preconfig = true;
			$description = '<strong>Due to a security - issue regarding open_basedir, Froxlor will set the open_basedir for the following domains to the customers root instead of the chosen documentroot:</strong><br />&nbsp;';
			$description .= '<ul>';
			$idna_convert = new \Froxlor\Idna\IdnaWrapper();
			foreach ($wrongOpenBasedirDomain as $domain) {
				$description .= '<li>' . $idna_convert->decode($domain) . '</li>';
			}
			$description .= '</ul>';
			$return['update_reset_openbasedirpath_note'] = ['type' => 'infotext', 'value' => $description];
		}
	}

	if (versionInUpdate($current_version, '0.9.9-svn1')) {
		$has_preconfig = true;
		$description = 'When entering MX servers to Froxlor there was no mail-, imap-, pop3- and smtp-"A record" created. You can now chose whether this should be done or not.';
		$question = '<strong>Do you want these A-records to be created even with MX servers given?:</strong>';

		$return['update_defdns_mailentry_note'] = ['type' => 'infotext', 'value' => $description];
		$return['update_defdns_mailentry'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.10-svn1')) {
		$has_nouser = false;
		$has_nogroup = false;

		$result_stmt = Database::query("SELECT * FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'system' AND `varname` = 'httpuser'");
		$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

		if (!isset($result) || !isset($result['value'])) {
			$has_preconfig = true;
			$has_nouser = true;
			$guessed_user = 'www-data';
			if (function_exists('posix_getuid') && function_exists('posix_getpwuid')) {
				$_httpuser = posix_getpwuid(posix_getuid());
				$guessed_user = $_httpuser['name'];
			}
		}

		$result_stmt = Database::query("SELECT * FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'system' AND `varname` = 'httpgroup'");
		$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

		if (!isset($result) || !isset($result['value'])) {
			$has_preconfig = true;
			$has_nogroup = true;
			$guessed_group = 'www-data';
			if (function_exists('posix_getgid') && function_exists('posix_getgrgid')) {
				$_httpgroup = posix_getgrgid(posix_getgid());
				$guessed_group = $_httpgroup['name'];
			}
		}

		if ($has_nouser || $has_nogroup) {
			$description = 'Please enter the correct username/groupname of the webserver on your system We\'re guessing the user but it might not be correct, so please check.';
			$return['update_httpusergroup_note'] = ['type' => 'infotext', 'value' => $description];
			if ($has_nouser) {
				$question = '<strong>Please enter the webservers username:</strong>';
				$return['update_httpuser'] = ['type' => 'text', 'value' => $guessed_user, 'label' => $question];
			}
			if ($has_nogroup) {
				$question = '<strong>Please enter the webservers groupname:</strong>';
				$return['update_httpgroup'] = ['type' => 'text', 'value' => $guessed_group, 'label' => $question];
			}
		}
	}

	if (versionInUpdate($current_version, '0.9.10')) {
		$has_preconfig = true;
		$description = 'you can now decide whether Froxlor should be reached via hostname/froxlor or directly via the hostname.';
		$question = '<strong>Do you want Froxlor to be reached directly via the hostname?:</strong>';
		$return['update_directlyviahostname_note'] = ['type' => 'infotext', 'value' => $description];
		$return['update_directlyviahostname'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.11-svn1')) {
		$has_preconfig = true;
		$description = 'It is possible to enhance security with setting a regular expression to force your customers to enter more complex passwords.';
		$question = '<strong>Enter a regular expression to force a higher password complexity (leave empty for none):</strong>';
		$return['update_pwdregex_note'] = ['type' => 'infotext', 'value' => $description];
		$return['update_pwdregex'] = ['type' => 'text', 'value' => '', 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.11-svn3')) {
		if (Settings::Get('system.webserver') == 'lighttpd') {
			$has_preconfig = true;
			$description = 'As Froxlor can now handle perl, you have to specify where the perl executable is.';
			$question = '<strong>Path to perl (default \'/usr/bin/perl\'):</strong>';
			$return['update_perlpath_note'] = ['type' => 'infotext', 'value' => $description];
			$return['update_perlpath'] = ['type' => 'text', 'value' => '/usr/bin/perl', 'label' => $question];
		}
	}

	if (versionInUpdate($current_version, '0.9.12-svn1')) {
		if (Settings::Get('system.mod_fcgid') == 1) {
			$has_preconfig = true;
			$description = 'You can chose whether you want Froxlor to use FCGID itself too now.';
			$question = '<strong>Use FCGID for the Froxlor Panel?:</strong>';
			$return['update_fcgid_ownvhost_note'] = ['type' => 'infotext', 'value' => $description];
			$return['update_fcgid_ownvhost'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];

			$question = '<strong>If \'yes\', please specify local user (has to exist, Froxlor does not add it automatically):</strong>';
			$return['update_fcgid_httpuser'] = ['type' => 'text', 'value' => 'froxlorlocal', 'label' => $question];
			$question = '<strong>If \'yes\', please specify local group (has to exist, Froxlor does not add it automatically):</strong>';
			$return['update_fcgid_httpgroup'] = ['type' => 'text', 'value' => 'froxlorlocal', 'label' => $question];
		}
	}

	if (versionInUpdate($current_version, '0.9.12-svn2')) {
		$has_preconfig = true;
		$description = 'Many apache user will have problems using perl/CGI as the customer docroots are not within the suexec path. Froxlor provides a simple workaround for that.';
		$question = '<strong>Enable Apache/SuExec/Perl workaround?:</strong>';
		$return['update_perl_suexecworkaround_note'] = ['type' => 'infotext', 'value' => $description];
		$return['update_perl_suexecworkaround'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];

		$description = '<strong>If \'yes\', please specify a path within the suexec path where Froxlor will create symlinks to customer perl-enabled paths:</strong>';
		$question = 'Path for symlinks (must be within suexec path):';
		$return['update_perl_suexecpath_note'] = ['type' => 'infotext', 'value' => $description];
		$return['update_perl_suexecpath'] = ['type' => 'text', 'value' => '/var/www/cgi-bin/', 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.12-svn4')) {
		if ((int) Settings::Get('system.awstats_enabled') == 1) {
			$has_preconfig = true;
			$description = 'Due to different paths of awstats_buildstaticpages.pl and awstats.pl you can set a different path for awstats.pl now.';
			$question = '<strong>Path to \'awstats.pl\'?:</strong>';
			$return['update_awstats_awstatspath_note'] = ['type' => 'infotext', 'value' => $description];
			$return['update_awstats_awstatspath'] = ['type' => 'text', 'value' => Settings::Get('system.awstats_path'), 'label' => $question];
		}
	}

	if (versionInUpdate($current_version, '0.9.13-svn1')) {
		if ((int) Settings::Get('autoresponder.autoresponder_active') == 1) {
			$has_preconfig = true;
			$description = 'Froxlor can now limit the number of autoresponder-entries for each user. Here you can set the value which will be available for each customer (Of course you can change the value for each customer separately after the update).';
			$question = '<strong>How many autoresponders should your customers be able to add?:</strong><br><small>-1 equals no limit</small>';
			$return['update_autoresponder_default_note'] = ['type' => 'infotext', 'value' => $description];
			$return['update_autoresponder_default'] = ['type' => 'number', 'value' => -1, 'min' => -1, 'label' => $question];
		}
	}

	if (versionInUpdate($current_version, '0.9.13.1')) {
		if ((int) Settings::Get('system.mod_fcgid_ownvhost') == 1) {
			$has_preconfig = true;
			$description = 'You have FCGID for Froxlor itself activated. You can now specify a PHP-configuration for this.';
			$question = '<strong>Select Froxlor-vhost PHP configuration:</strong>';
			$return['update_defaultini_ownvhost_note'] = ['type' => 'infotext', 'value' => $description];
			$configs_array = \Froxlor\Http\PhpConfig::getPhpConfigs();
			$configs = '';
			foreach ($configs_array as $idx => $desc) {
				$configs[$idx] = $desc;
			}
			$return['update_defaultini_ownvhost'] = [
				'type' => 'select',
				'select_var' => $configs,
				'selected' => 1,
				'label' => $question
			];
		}
	}

	if (versionInUpdate($current_version, '0.9.14-svn3')) {
		if ((int) Settings::Get('system.awstats_enabled') == 1) {
			$has_preconfig = true;
			$description = 'To have icons in AWStats statistic-pages please enter the path to AWStats icons folder.';
			$question = '<strong>Path to AWSTats icons folder:</strong>';
			$return['update_awstats_icons_note'] = ['type' => 'infotext', 'value' => $description];
			$return['update_awstats_icons'] = ['type' => 'text', 'value' => Settings::Get('system.awstats_icons'), 'label' => $question];
		}
	}

	if (versionInUpdate($current_version, '0.9.14-svn4')) {
		if ((int) Settings::Get('system.use_ssl') == 1) {
			$has_preconfig = true;
			$description = 'Froxlor now has the possibility to set \'SSLCertificateChainFile\' for the apache webserver.';
			$question = '<strong>Enter filename (leave empty for none):</strong>';
			$return['update_ssl_cert_chainfile_note'] = ['type' => 'infotext', 'value' => $description];
			$return['update_ssl_cert_chainfile'] = ['type' => 'text', 'value' => Settings::Get('system.ssl_cert_chainfile'), 'label' => $question];
		}
	}

	if (versionInUpdate($current_version, '0.9.14-svn6')) {
		$has_preconfig = true;
		$description = 'You can now allow customers to use any of their domains as username for the login.';
		$question = '<strong>Do you want to enable domain-login for all customers?:</strong>';
		$return['update_allow_domain_login_note'] = ['type' => 'infotext', 'value' => $description];
		$return['update_allow_domain_login'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.14-svn10')) {
		$has_preconfig = true;
		$description = '<strong>This update removes the unsupported real-time option. Additionally the deprecated tables for navigation and cronscripts are removed, any modules using these tables need to be updated to the new structure!</strong>';
		$return['update_unsported_realtime_option_note'] = ['type' => 'infotext', 'value' => $description];
	}

	if (versionInUpdate($current_version, '0.9.16-svn1')) {
		$has_preconfig = true;
		$description = 'Froxlor now features support for php-fpm.';
		$question = '<strong>Do you want to enable php-fpm?:</strong>';
		$return['update_phpfpm_enabled_note'] = ['type' => 'infotext', 'value' => $description];
		$return['update_phpfpm_enabled'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];

		$question = 'If \'yes\', please specify the configuration directory:';
		$return['update_phpfpm_configdir'] = ['type' => 'text', 'value' => "/etc/php-fpm.d/", 'label' => $question];
		$question = 'Please specify the temporary files directory:';
		$return['update_phpfpm_tmpdir'] = ['type' => 'text', 'value' => "/var/customers/tmp/", 'label' => $question];
		$question = 'Please specify the PEAR directory:';
		$return['update_phpfpm_peardir'] = ['type' => 'text', 'value' => "/usr/share/php/:/usr/share/php5/", 'label' => $question];
		$question = 'Please specify the php-fpm restart-command:';
		$return['update_phpfpm_reload'] = ['type' => 'text', 'value' => "/etc/init.d/php-fpm restart", 'label' => $question];
		$question = 'Please specify the php-fpm rocess manager control:';
		$return['update_phpfpm_pm'] = [
			'type' => 'select',
			'select_var' => [
				'static' => 'static',
				'dynamic' => 'dynamic'
			],
			'selected' => 'dynamic',
			'label' => $question
		];
		$question = 'Please specify the number of child processes:';
		$return['update_phpfpm_max_children'] = ['type' => 'number', 'value' => "2", 'label' => $question];
		$question = 'Please specify the number of requests per child before respawning:';
		$return['update_phpfpm_max_requests'] = ['type' => 'number', 'value' => "0", 'label' => $question];
		$description = '<em>The following settings are only required if you chose process manager = dynamic</em>';
		$return['update_phpfpm_dynamic_pm_note'] = ['type' => 'infotext', 'value' => $description];
		$question = 'Please specify the number of child processes created on startup:';
		$return['update_phpfpm_start_servers'] = ['type' => 'number', 'value' => "20", 'label' => $question];
		$question = 'Please specify the desired minimum number of idle server processes:';
		$return['update_phpfpm_min_spare_servers'] = ['type' => 'number', 'value' => "5", 'label' => $question];
		$question = 'Please specify the desired maximum number of idle server processes:';
		$return['update_phpfpm_max_spare_servers'] = ['type' => 'number', 'value' => "35", 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.16-svn2')) {
		if ((int) Settings::Get('phpfpm.enabled') == 1) {
			$has_preconfig = true;
			$description = 'You can chose whether you want Froxlor to use PHP-FPM itself too now.';
			$question = '<strong>Use PHP-FPM for the Froxlor Panel?:</strong>';
			$return['update_phpfpm_enabled_ownvhost_note'] = ['type' => 'infotext', 'value' => $description];
			$return['update_phpfpm_enabled_ownvhost'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];

			$question = '<strong>If \'yes\', please specify local user (has to exist, Froxlor does not add it automatically):</strong>';
			$return['update_phpfpm_httpuser'] = ['type' => 'text', 'value' => Settings::Get('system.mod_fcgid_httpuser'), 'label' => $question];
			$question = '<strong>If \'yes\', please specify local group (has to exist, Froxlor does not add it automatically):</strong>';
			$return['update_phpfpm_httpgroup'] = ['type' => 'text', 'value' => Settings::Get('system.mod_fcgid_httpgroup'), 'label' => $question];
		}
	}

	if (versionInUpdate($current_version, '0.9.17-svn1')) {
		$has_preconfig = true;
		$description = 'Select if you want to enable the web- and traffic-reports';
		$question = '<strong>Enable?:</strong>';
		$return['update_system_report_enable_note'] = ['type' => 'infotext', 'value' => $description];
		$return['update_system_report_enable'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];

		$question = '<strong>If \'yes\', please specify a percentage value for web-usage when reports are to be sent:</strong>';
		$return['update_system_report_webmax'] = ['type' => 'number', 'value' => '90', 'label' => $question];
		$question = '<strong>If \'yes\', please specify a percentage value for traffic-usage when reports are to be sent:</strong>';
		$return['update_system_report_trafficmax'] = ['type' => 'number', 'value' => '90', 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.18-svn2')) {
		$has_preconfig = true;
		$description = 'As you can (obviously) see, Froxlor now comes with a new theme. You also have the possibility to switch back to "Classic" if you want to.';
		$return['update_default_theme_note'] = ['type' => 'infotext', 'value' => $description];
		$question = '<strong>Select default panel theme:</strong>';
		$themes = UI::getThemes();
		$sel_themes = [];
		foreach ($themes as $cur_theme) {
			$sel_themes[$cur_theme] = $cur_theme;
		}
		$return['update_default_theme'] = [
			'type' => 'select',
			'select_var' => $sel_themes,
			'selected' => 'Froxlor',
			'label' => $question
		];
	}

	if (versionInUpdate($current_version, '0.9.28-svn4')) {
		$has_preconfig = true;
		$description = 'This version introduces a lot of profound changes:';
		$description .= '<br /><ul><li>Improving the whole template system</li><li>Full UTF-8 support</li><li><strong>Removing support for the former default theme \'Classic\'</strong></li></ul>';
		$description .= '<br /><br />Notice: This update will <strong>alter your Froxlor database to use UTF-8</strong> as default charset. ';
		$description .= 'Even though this is already tested, we <span class="red">strongly recommend</span> to ';
		$description .= 'test this update in a testing environment using your existing data.<br /><br />';
		$return['classic_theme_replacement_note'] = ['type' => 'infotext', 'value' => $description];
		$question = '<strong>Select your preferred Classic Theme replacement:</strong>';
		$themes = UI::getThemes();
		$sel_themes = [];
		foreach ($themes as $cur_theme) {
			$sel_themes[$cur_theme] = $cur_theme;
		}
		$return['classic_theme_replacement'] = [
			'type' => 'select',
			'select_var' => $sel_themes,
			'selected' => 'Froxlor',
			'label' => $question
		];
	}

	if (versionInUpdate($current_version, '0.9.28-svn6')) {

		if (Settings::Get('system.webserver') == 'apache2') {
			$has_preconfig = true;
			$description = 'Froxlor now supports the new Apache 2.4. Please be aware that you need to load additional apache-modules in order to use it.<br />';
			$description .= '<pre>LoadModule authz_core_module modules/mod_authz_core.so
					LoadModule authz_host_module modules/mod_authz_host.so</pre>';
			$question = '<strong>Do you want to enable the Apache-2.4 modification?:</strong>';
			$return['update_system_apache24_note'] = ['type' => 'infotext', 'value' => $description];
			$return['update_system_apache24'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];
		} elseif (Settings::Get('system.webserver') == 'nginx') {
			$has_preconfig = true;
			$description = 'The path to nginx\'s fastcgi_params file is now customizable.';
			$question = '<strong>Please enter full path to you nginx/fastcgi_params file (including filename):</strong>';
			$return['nginx_fastcgi_params_note'] = ['type' => 'infotext', 'value' => $description];
			$return['nginx_fastcgi_params'] = ['type' => 'text', 'value' => "/etc/nginx/fastcgi_params", 'label' => $question];
		}
	}

	if (versionInUpdate($current_version, '0.9.28-rc2')) {

		$has_preconfig = true;

		$description = 'This version adds an option to append the domain-name to the document-root for domains and subdomains.<br />';
		$description .= 'You can enable or disable this feature anytime from settings -> system settings.';
		$question = '<strong>Do you want to automatically append the domain-name to the documentroot of newly created domains?:</strong>';
		$return['update_system_documentroot_use_default_value_note'] = ['type' => 'infotext', 'value' => $description];
		$return['update_system_documentroot_use_default_value'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.28')) {

		$has_preconfig = true;
		// just an information about the new sendmail parameter (#1134)
		$description = 'Froxlor changed the default parameter-set of sendmail (php.ini)<br />';
		$description .= 'sendmail_path = "/usr/sbin/sendmail -t <strong>-i</strong> -f {CUSTOMER_EMAIL}"<br /><br />';
		$description .= 'If you don\'t have any problems with sending mails, you don\'t need to change this';
		if (Settings::Get('system.mod_fcgid') == '1' || Settings::Get('phpfpm.enabled') == '1') {
			// information about removal of php's safe_mode
			$description .= '<br /><br />The php safe_mode flag has been removed as current versions of PHP do not support it anymore.<br /><br />';
			$description .= 'Please check your php-configurations and remove safe_mode-directives to avoid php notices/warnings.';
		}
		$return['update_default_sendmail_params_note'] = ['type' => 'infotext', 'value' => $description];
	}

	if (versionInUpdate($current_version, '0.9.29-dev1')) {
		// we only need to ask if fcgid|php-fpm is enabled
		if (Settings::Get('system.mod_fcgid') == '1' || Settings::Get('phpfpm.enabled') == '1') {
			$has_preconfig = true;
			$description = 'Standard-subdomains can now be hidden from the php-configuration overview.';
			$question = '<strong>Do you want to hide the standard-subdomains (this can be changed in the settings any time)?:</strong>';
			$return['hide_stdsubdomains_note'] = ['type' => 'infotext', 'value' => $description];
			$return['hide_stdsubdomains'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];
		}
	}

	if (versionInUpdate($current_version, '0.9.29-dev2')) {
		$has_preconfig = true;
		$description = 'You can now decide whether admins/customers are able to change the theme<br />';
		$return['allow_themechange_ac_note'] = ['type' => 'infotext', 'value' => $description];
		$question = '<strong>Allow theme-changing for admins:</strong>';
		$return['allow_themechange_a'] = ['type' => 'checkbox', 'value' => 1, 'checked' => 1, 'label' => $question];
		$question = '<strong>Allow theme-changing for customers:</strong>';
		$return['allow_themechange_c'] = ['type' => 'checkbox', 'value' => 1, 'checked' => 1, 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.29-dev3')) {
		$has_preconfig = true;
		$description = 'There is now a possibility to specify AXFR servers for your bind zone-configuration';
		$question = '<strong>Enter a comma-separated list of AXFR servers or leave empty (default):</strong>';
		$return['system_afxrservers_note'] = ['type' => 'infotext', 'value' => $description];
		$return['system_afxrservers'] = ['type' => 'text', 'value' => '', 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.29-dev4')) {
		$has_preconfig = true;
		$description = 'As customers can now specify ssl-certificate data for their domains, you need to specify where the generated files are stored';
		$question = '<strong>Specify the directory for customer ssl-certificates:</strong>';
		$return['system_customersslpath_note'] = ['type' => 'infotext', 'value' => $description];
		$return['system_customersslpath'] = ['type' => 'text', 'value' => '/etc/ssl/froxlor-custom/', 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.29.1-dev3')) {
		$has_preconfig = true;
		$description = 'The build in logrotation-feature has been removed. Please follow the configuration-instructions for your system to enable logrotating again.';
		$return['update_removed_builtin_logrotate_note'] = ['type' => 'infotext', 'value' => $description];
	}

	// let the apache+fpm users know that they MUST change their config
	// for the domains / webserver to work after the update
	if (versionInUpdate($current_version, '0.9.30-dev1')) {
		if (Settings::Get('system.webserver') == 'apache2' && Settings::Get('phpfpm.enabled') == '1') {
			$has_preconfig = true;
			$description = 'The PHP-FPM implementation for apache2 has changed. Please look for the "<b>fastcgi.conf</b>" (Debian/Ubuntu) or "<b>70_fastcgi.conf</b>" (Gentoo) within /etc/apache2/ and change it as shown below:<br /><br />';
			$description .= '<pre class="code-block">&lt;IfModule mod_fastcgi.c&gt;
    FastCgiIpcDir /var/lib/apache2/fastcgi/
    &lt;Location "/fastcgiphp"&gt;
        Order Deny,Allow
        Deny from All
        # Prevent accessing this path directly
        Allow from env=REDIRECT_STATUS
    &lt;/Location&gt;
&lt;/IfModule&gt;</pre>';
			$return['update_fpm_implementation_changed_note'] = ['type' => 'infotext', 'value' => $description];
		}
	}

	if (versionInUpdate($current_version, '0.9.31-dev2')) {
		if (Settings::Get('system.webserver') == 'apache2' && Settings::Get('phpfpm.enabled') == '1') {
			$has_preconfig = true;
			$description = 'The FPM socket directory is now a setting in froxlor. Its default is <b>/var/lib/apache2/fastcgi/</b>.<br/>If you are using <b>/var/run/apache2</b> in the "<b>fastcgi.conf</b>" (Debian/Ubuntu) or "<b>70_fastcgi.conf</b>" (Gentoo) please correct this path accordingly';
			$return['update_fpm_socket_directory_changed_note'] = ['type' => 'infotext', 'value' => $description];
		}
	}

	if (versionInUpdate($current_version, '0.9.31-dev4')) {
		$has_preconfig = true;
		$description = 'The template-variable {PASSWORD} has been replaced with {LINK}. Please update your password reset templates!';
		$return['update_template_var_password_changed_note'] = ['type' => 'infotext', 'value' => $description];
	}

	if (versionInUpdate($current_version, '0.9.31-dev5')) {
		$has_preconfig = true;
		$description = 'You can enable/disable error-reporting for admins and customers!';
		$return['update_error_report_admin_customer_note'] = ['type' => 'infotext', 'value' => $description];

		$question = '<strong>Do you want to enable error-reporting for admins? (default: yes):</strong>';
		$return['update_error_report_admin'] = ['type' => 'checkbox', 'value' => 1, 'checked' => 1, 'label' => $question];
		$question = '<strong>Do you want to enable error-reporting for customers? (default: no):</strong>';
		$return['update_error_report_customer'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.31-rc2')) {
		$has_preconfig = true;
		$description = 'You can enable/disable the display/usage of the news-feed for admins';
		$question = '<strong>Do you want to enable the news-feed for admins? (default: yes):</strong>';
		$return['update_admin_news_feed_note'] = ['type' => 'infotext', 'value' => $description];
		$return['update_admin_news_feed'] = ['type' => 'checkbox', 'value' => 1, 'checked' => 1, 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.32-dev2')) {
		$has_preconfig = true;
		$description = 'To enable logging of the mail-traffic, you need to set the following settings accordingly';
		$question = '<strong>Do you want to enable the traffic collection for mail? (default: yes):</strong>';
		$return['mailtraffic_enabled_note'] = ['type' => 'infotext', 'value' => $description];
		$return['mailtraffic_enabled'] = ['type' => 'checkbox', 'value' => 1, 'checked' => 1, 'label' => $question];

		$question = '<strong>Mail Transfer Agent</strong>';
		$return['mtaserver'] = [
			'type' => 'select',
			'select_var' => [
				'postfix' => 'Postfix',
				'exim4' => 'Exim4'
			],
			'selected' => 'postfix',
			'label' => $question
		];

		$question = 'Logfile for your MTA:';
		$return['mtalog'] = ['type' => 'text', 'value' => "/var/log/mail.log", 'label' => $question];

		$question = '<strong>Mail Delivery Agent</strong>';
		$return['mdaserver'] = [
			'type' => 'select',
			'select_var' => [
				'dovecot' => 'Dovecot',
				'courier' => 'Courier'
			],
			'selected' => 'dovecot',
			'label' => $question
		];

		$question = 'Logfile for your MDA:';
		$return['mdalog'] = ['type' => 'text', 'value' => "/var/log/mail.log", 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.32-dev5')) {
		$has_preconfig = true;
		$description = 'Froxlor now generates a cron-configuration file for the cron-daemon. Please set a filename which will be included automatically by your crond (e.g. files in /etc/cron.d/)';
		$question = '<strong>Path to the cron-service configuration-file.</strong> This file will be updated regularly and automatically by froxlor.<br />Note: please <b>be sure</b> to use the same filename as for the main froxlor cronjob (default: /etc/cron.d/froxlor)!';
		$return['crondfile_note'] = ['type' => 'infotext', 'value' => $description];
		$return['crondfile'] = ['type' => 'text', 'value' => "/etc/cron.d/froxlor", 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.32-dev6')) {
		$has_preconfig = true;
		$description = 'In order for the new cron.d file to work properly, we need to know about the cron-service reload command.';
		$question = '<strong>Please specify the reload-command of your cron-daemon</strong> (default: /etc/init.d/cron reload)';
		$return['crondreload_note'] = ['type' => 'infotext', 'value' => $description];
		$return['crondreload'] = ['type' => 'text', 'value' => "/etc/init.d/cron reload", 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.32-rc2')) {
		$has_preconfig = true;
		$description = 'To customize the command which executes the cronjob (php - basically) change the path below according to your system.';
		$question = '<strong>Please specify the command to execute cronscripts</strong> (default: "/usr/bin/nice -n 5 /usr/bin/php -q")';
		$return['croncmdline_note'] = ['type' => 'infotext', 'value' => $description];
		$return['croncmdline'] = ['type' => 'text', 'value' => "/usr/bin/nice -n 5 /usr/bin/php -q", 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.33-dev1')) {
		$has_preconfig = true;
		$description = 'You can enable/disable the display/usage of the custom newsfeed for customers.';
		$question = '<strong>Do you want to enable the custom newsfeed for customer? (default: no):</strong>';
		$return['customer_show_news_feed_note'] = ['type' => 'infotext', 'value' => $description];
		$return['customer_show_news_feed'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];

		$question = '<strong>You have to set the URL for your RSS-feed here, if you have chosen to enable the custom newsfeed on the customer-dashboard:</strong>';
		$return['customer_news_feed_url'] = ['type' => 'text', 'value' => "", 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.33-dev2')) {
		// only if bind is used - if not the default will be set, which is '0' (off)
		if (Settings::get('system.bind_enable') == 1) {
			$has_preconfig = true;
			$description = 'You can enable/disable the generation of the bind-zone / config for the system hostname.';
			$question = '<strong>Do you want to generate a bind-zone for the system-hostname? (default: no):</strong>';
			$return['dns_createhostnameentry_note'] = ['type' => 'infotext', 'value' => $description];
			$return['dns_createhostnameentry'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];
		}
	}

	if (versionInUpdate($current_version, '0.9.33-rc2')) {
		$has_preconfig = true;
		$description = 'You can chose whether you want to receive an e-mail on cronjob errors. Keep in mind that this can lead to an e-mail being sent every 5 minutes.';
		$question = '<strong>Do you want to receive cron-errors via mail? (default: no):</strong>';
		$return['system_send_cron_errors_note'] = ['type' => 'infotext', 'value' => $description];
		$return['system_send_cron_errors'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];
	}

	if (versionInUpdate($current_version, '0.9.34-dev3')) {
		$has_preconfig = true;
		$description = 'Froxlor now requires the PHP mbstring-extension as we need to be multibyte-character safe in some cases<br><br>';
		$description .= '<strong>PHP mbstring</strong> is currently: ';
		if (!extension_loaded('mbstring')) {
			$description .= '<span class="red">not installed/loaded</span>';
			$description .= '<br>Please install the PHP mbstring extension in order to finish the update';
		} else {
			$description .= '<span class="green">installed/loaded</span>';
		}
		$return['update_php_mbstring_extension_installed_note'] = ['type' => 'infotext', 'value' => $description];
	}

	if (versionInUpdate($current_db_version, '201603070')) {
		$has_preconfig = true;
		$description = 'You can chose whether you want to enable or disable our Let\'s Encrypt implementation.<br />Please remember that you need to go through the webserver-configuration when enabled because this feature needs a special configuration.';
		$question = '<strong>Do you want to enable Let\'s Encrypt? (default: yes):</strong>';
		$return['enable_letsencrypt_note'] = ['type' => 'infotext', 'value' => $description];
		$return['enable_letsencrypt'] = ['type' => 'checkbox', 'value' => 1, 'checked' => 1, 'label' => $question];
	}

	if (versionInUpdate($current_db_version, '201604270')) {
		$has_preconfig = true;
		$description = 'You can chose whether you want to enable or disable our backup function.';
		$question = '<strong>Do you want to enable Backup? (default: no):</strong>';
		$return['enable_backup_note'] = ['type' => 'infotext', 'value' => $description];
		$return['enable_backup'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];
	}

	if (versionInUpdate($current_db_version, '201605090')) {
		$has_preconfig = true;
		$description = 'You can chose whether you want to enable or disable our DNS editor';
		$question = '<strong>Do you want to enable the DNS editor? (default: no):</strong>';
		$return['enable_dns_note'] = ['type' => 'infotext', 'value' => $description];
		$return['enable_dns'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];
	}

	if (versionInUpdate($current_db_version, '201605170')) {
		$has_preconfig = true;
		$description = 'Froxlor now supports the dns-daemon Power-DNS, you can chose between bind and powerdns now.';
		$return['new_dns_daemon_note'] = ['type' => 'infotext', 'value' => $description];
		$question = '<strong>Select dns-daemon you want to use:</strong>';
		$return['new_dns_daemon'] = [
			'type' => 'select',
			'select_var' => [
				'bind' => 'Bind9',
				'pdns' => 'PowerDNS'
			],
			'selected' => 'bind',
			'label' => $question
		];
	}

	if (versionInUpdate($current_db_version, '201609120')) {
		if (Settings::Get('system.leenabled') == 1) {
			$has_preconfig = true;
			$description = 'You can now customize the path to your acme.conf file (global alias for Let\'s Encrypt). If you already set up Let\'s Encrypt and the acme.conf file, please set this to the complete path to the file!';
			$question = '<strong>Path to the acme.conf alias-file.</strong>';
			$return['acmeconffile_note'] = ['type' => 'infotext', 'value' => $description];
			$return['acmeconffile'] = ['type' => 'text', 'value' => "/etc/apache2/conf-enabled/acme.conf", 'label' => $question];
		}
	}

	if (versionInUpdate($current_db_version, '201609200')) {
		$has_preconfig = true;
		$description = 'Specify SMTP settings which froxlor should use to send mail (optional)';
		$return['update_mail_via_smtp_note'] = ['type' => 'infotext', 'value' => $description];
		$question = '<strong>Enable sending mails via SMTP?</strong>';
		$return['smtp_enable'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];
		$question .= '<strong>Enable sending mails via SMTP?</strong>';
		$return['smtp_host'] = ['type' => 'text', 'value' => 'localhost', 'label' => $question];
		$question .= '<strong>TCP port to connect to?</strong>';
		$return['smtp_port'] = ['type' => 'number', 'value' => '25', 'label' => $question];
		$question .= '<strong>Enable TLS encryption?</strong>';
		$return['smtp_usetls'] = ['type' => 'checkbox', 'value' => 1, 'checked' => 1, 'label' => $question];
		$question .= '<strong>Enable SMTP authentication?</strong>';
		$return['smtp_auth'] = ['type' => 'checkbox', 'value' => 1, 'checked' => 1, 'label' => $question];
		$question .= '<strong>SMTP user?</strong>';
		$return['smtp_user'] = ['type' => 'text', 'value' => '', 'label' => $question];
		$question .= '<strong>SMTP password?</strong>';
		$return['smtp_user'] = ['type' => 'password', 'value' => '', 'label' => $question];
	}

	if (versionInUpdate($current_db_version, '201705050')) {
		$has_preconfig = true;
		$description = 'DEBIAN/UBUNTU ONLY: Enable usage of libnss-extrausers as alternative to libnss-mysql (NOTE: if enabled, go through the configuration steps right after the update!!!)';
		$question = '<strong>Enable usage of libnss-extrausers?</strong>';
		$return['system_nssextrausers_note'] = ['type' => 'infotext', 'value' => $description];
		$return['system_nssextrausers'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];
	}

	if (versionInUpdate($current_db_version, '201712310')) {
		if (Settings::Get('system.leenabled') == 1) {
			$has_preconfig = true;
			$description = 'Chose whether you want to disable the Let\'s Encrypt selfcheck as it causes false positives for some configurations.';
			$question = '<strong>Disable Let\'s Encrypt self-check?</strong>';
			$return['system_disable_le_selfcheck_note'] = ['type' => 'infotext', 'value' => $description];
			$return['system_disable_le_selfcheck'] = ['type' => 'checkbox', 'value' => 1, 'label' => $question];
		}
	}
}
