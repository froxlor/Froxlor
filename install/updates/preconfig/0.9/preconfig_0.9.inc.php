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

/**
 * checks if the new-version has some updating to do
 *
 * @param boolean $has_preconfig   pointer to check if any preconfig has to be output
 * @param string  $return          pointer to output string
 * @param string  $current_version current froxlor version
 *
 * @return null
 */
function parseAndOutputPreconfig(&$has_preconfig, &$return, $current_version)
{
	global $settings, $lng, $db, $theme;

	if(versionInUpdate($current_version, '0.9.4-svn2'))
	{
		$has_preconfig = true;
		$description = 'Froxlor now enables the usage of a domain-wildcard entry and subdomains for this domain at the same time (subdomains are parsed before the main-domain vhost container).';
		$description.= 'This makes it possible to catch all non-existing subdomains with the main vhost but also have the ability to use subdomains for that domain.<br />';
		$description.= 'If you would like Froxlor to do so with your domains, the update script can set the correct values for existing domains for you. Note: future domains will have wildcard-entries enabled by default no matter how you decide here.';
		$question = '<strong>Do you want to use wildcard-entries for existing domains?:</strong>&nbsp;';
		$question.= makeyesno('update_domainwildcardentry', '1', '0', '1');

		eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
	}

	if(versionInUpdate($current_version, '0.9.6-svn2'))
	{
		if(!PHPMailer::ValidateAddress($settings['panel']['adminmail']))
		{
			$has_preconfig = true;
			$description = 'Froxlor uses a newer version of the phpMailerClass and determined that your current admin-mail address is invalid.';
			$question = '<strong>Please specify a new admin-email address:</strong>&nbsp;<input type="text" class="text" name="update_adminmail" value="'.$settings['panel']['adminmail'].'" />';
			eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
		}
	}

	if(versionInUpdate($current_version, '0.9.6-svn3'))
	{
		$has_preconfig = true;
		$description = 'You now have the possibility to define default error-documents for your webserver which replace the default webserver error-messages.';
		$question = '<strong>Do you want to enable default error-documents?:</strong>&nbsp;';
		$question .= makeyesno('update_deferr_enable', '1', '0', '0').'<br /><br />';
		if($settings['system']['webserver'] == 'apache2')
		{
			$question .= 'Path/URL for error 500:&nbsp;<input type="text" class="text" name="update_deferr_500" /><br /><br />';
			$question .= 'Path/URL for error 401:&nbsp;<input type="text" class="text" name="update_deferr_401" /><br /><br />';
			$question .= 'Path/URL for error 403:&nbsp;<input type="text" class="text" name="update_deferr_403" /><br /><br />';
		}
		$question .= 'Path/URL for error 404:&nbsp;<input type="text" class="text" name="update_deferr_404" />';
		eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
	}

	if(versionInUpdate($current_version, '0.9.6-svn4'))
	{
		$has_preconfig = true;
		$description = 'You can define a default support-ticket priority level which is pre-selected for new support-tickets.';
		$question = '<strong>Which should be the default ticket-priority?:</strong>&nbsp;';
		$question .= '<select name="update_deftic_priority">';
		$priorities = makeoption($lng['ticket']['high'], '1', '2');
		$priorities.= makeoption($lng['ticket']['normal'], '2', '2');
		$priorities.= makeoption($lng['ticket']['low'], '3', '2');
		$question .= $priorities.'</select>';
		eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
	}

	if(versionInUpdate($current_version, '0.9.6-svn5'))
	{
		$has_preconfig = true;
		$description = 'If you have more than one PHP configurations defined in Froxlor you can now set a default one which will be used for every domain.';
		$question = '<strong>Select default PHP configuration:</strong>&nbsp;';
		$question .= '<select name="update_defsys_phpconfig">';
		$configs_array = getPhpConfigs();
		$configs = '';
		foreach($configs_array as $idx => $desc)
		{
			$configs .= makeoption($desc, $idx, '1');
		}
		$question .= $configs.'</select>';
		eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
	}

	if(versionInUpdate($current_version, '0.9.6-svn6'))
	{
		$has_preconfig = true;
		$description = 'For the new FTP-quota feature, you can now chose the currently used ftpd-software.';
		$question = '<strong>Used FTPd-software:</strong>&nbsp;';
		$question .= '<select name="update_defsys_ftpserver">';
		$question .= makeoption('ProFTPd', 'proftpd', 'proftpd');
		$question .= makeoption('PureFTPd', 'pureftpd', 'proftpd');
		$question .= '</select>';
		eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
	}

	if(versionInUpdate($current_version, '0.9.7-svn1'))
	{
		$has_preconfig = true;
		$description = 'You can now choose whether customers can select the http-redirect code and which of them acts as default.';
		$question = '<strong>Allow customer chosen redirects?:</strong>&nbsp;';
		$question.= makeyesno('update_customredirect_enable', '1', '0', '1').'<br /><br />';
		$question.= '<strong>Select default redirect code (default: empty):</strong>&nbsp;';
		$question.= '<select name="update_customredirect_default">';
		$redirects = makeoption('--- ('.$lng['redirect_desc']['rc_default'].')', 1, '1');
		$redirects.= makeoption('301 ('.$lng['redirect_desc']['rc_movedperm'].')', 2, '1');
		$redirects.= makeoption('302 ('.$lng['redirect_desc']['rc_found'].')', 3, '1');
		$redirects.= makeoption('303 ('.$lng['redirect_desc']['rc_seeother'].')', 4, '1');
		$redirects.= makeoption('307 ('.$lng['redirect_desc']['rc_tempred'].')', 5, '1');
		$question .= $redirects.'</select>';
		eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
	}

	if(versionInUpdate($current_version, '0.9.7-svn2'))
	{
		$result = $db->query("SELECT `domain` FROM " . TABLE_PANEL_DOMAINS . " WHERE `documentroot` LIKE '%:%' AND `documentroot` NOT LIKE 'http://%' AND `openbasedir_path` = '0' AND `openbasedir` = '1'");
		$wrongOpenBasedirDomain = array();
		while($row = $db->fetch_array($result))
		{
			$wrongOpenBasedirDomain[] = $row['domain'];
		}

		if(count($wrongOpenBasedirDomain) > 0)
		{
			$has_preconfig = true;
			$description = 'Resetting the open_basedir to customer - root';
			$question = '<strong>Due to a security - issue regarding open_basedir, Froxlor will set the open_basedir for the following domains to the customers root instead of the chosen documentroot:</strong><br />&nbsp;';
			$question.= '<ul>';
			$idna_convert = new idna_convert_wrapper();
			foreach($wrongOpenBasedirDomain as $domain)
			{
				$question.= '<li>' . $idna_convert->decode($domain) . '</li>';
			}
			$question.= '</ul>';
			eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
		}
	}

	if(versionInUpdate($current_version, '0.9.9-svn1'))
	{
		$has_preconfig = true;
		$description = 'When entering MX servers to Froxlor there was no mail-, imap-, pop3- and smtp-"A record" created. You can now chose whether this should be done or not.';
		$question = '<strong>Do you want these A-records to be created even with MX servers given?:</strong>&nbsp;';
		$question.= makeyesno('update_defdns_mailentry', '1', '0', '0');
		eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
	}
	
	if(versionInUpdate($current_version, '0.9.10-svn1'))
	{
		$has_nouser = false;
		$has_nogroup = false;

		$result = $db->query_first("SELECT * FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'system' AND `varname` = 'httpuser'");
		if(!isset($result) || !isset($result['value']))
		{
			$has_preconfig = true;
			$has_nouser = true;
			$guessed_user = 'www-data';
			if(function_exists('posix_getuid')
				&& function_exists('posix_getpwuid')
			) {
				$_httpuser = posix_getpwuid(posix_getuid());
				$guessed_user = $_httpuser['name'];
			}
		}
		
		$result = $db->query_first("SELECT * FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'system' AND `varname` = 'httpgroup'");
		if(!isset($result) || !isset($result['value']))
		{
			$has_preconfig = true;
			$has_nogroup = true;
			$guessed_group = 'www-data';
			if(function_exists('posix_getgid')
				&& function_exists('posix_getgrgid')
			) {
				$_httpgroup = posix_getgrgid(posix_getgid());
				$guessed_group = $_httpgroup['name'];
			}
		}

		if($has_nouser || $has_nogroup)
		{
			$description = 'Please enter the correct username/groupname of the webserver on your system We\'re guessing the user but it might not be correct, so please check.';
			if($has_nouser)
			{
				$question = '<strong>Please enter the webservers username:</strong>&nbsp;<input type="text" class="text" name="update_httpuser" value="'.$guessed_user.'" />';
			} 
			elseif($has_nogroup) 
			{
				$question2 = '<strong>Please enter the webservers groupname:</strong>&nbsp;<input type="text" class="text" name="update_httpgroup" value="'.$guessed_group.'" />';
				if($has_nouser) {
					$question .= '<br /><br />'.$question2;
				} else {
					$question = $question2;
				}
			}
			eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
		}
	}

	if(versionInUpdate($current_version, '0.9.10'))
	{
		$has_preconfig = true;
		$description = 'you can now decide whether Froxlor should be reached via hostname/froxlor or directly via the hostname.';
		$question = '<strong>Do you want Froxlor to be reached directly via the hostname?:</strong>&nbsp;';
		$question.= makeyesno('update_directlyviahostname', '1', '0', '0');
		eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
	}

	if(versionInUpdate($current_version, '0.9.11-svn1'))
	{
		$has_preconfig = true;
		$description = 'It is possible to enhance security with setting a regular expression to force your customers to enter more complex passwords.';
		$question = '<strong>Enter a regular expression to force a higher password complexity (leave empty for none):</strong>&nbsp;';
		$question.= '<input type="text" class="text" name="update_pwdregex" value="" />';
		eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
	}

	if(versionInUpdate($current_version, '0.9.11-svn3'))
	{
		$has_preconfig = true;
		$description = 'As Froxlor can now handle perl, you have to specify where the perl executable is (only if you\'re running lighttpd, else just leave empty).';
		$question = '<strong>Path to perl (default \'/usr/bin/perl\'):</strong>&nbsp;';
		$question.= '<input type="text" class="text" name="update_perlpath" value="/usr/bin/perl" />';
		eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
	}
	
	if(versionInUpdate($current_version, '0.9.12-svn1'))
	{
		if($settings['system']['mod_fcgid'] == 1)
		{
			$has_preconfig = true;
			$description = 'You can chose whether you want Froxlor to use FCGID itself too now.';
			$question = '<strong>Use FCGID for the Froxlor Panel?:</strong>&nbsp;';
			$question.= makeyesno('update_fcgid_ownvhost', '1', '0', '0').'<br /><br />';
			$question.= '<strong>If \'yes\', please specify local user/group (have to exist, Froxlor does not add them automatically):</strong><br /><br />';
			$question.= 'Local user:&nbsp;';
			$question.= '<input type="text" class="text" name="update_fcgid_httpuser" value="froxlorlocal" /><br /><br />';
			$question.= 'Local group:&nbsp;';
			$question.= '<input type="text" class="text" name="update_fcgid_httpgroup" value="froxlorlocal" /><br />';
			eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
		}
	}

	if(versionInUpdate($current_version, '0.9.12-svn2'))
	{
		$has_preconfig = true;
		$description = 'Many apache user will have problems using perl/CGI as the customer docroots are not within the suexec path. Froxlor provides a simple workaround for that.';
		$question = '<strong>Enable Apache/SuExec/Perl workaround?:</strong>&nbsp;';
		$question.= makeyesno('update_perl_suexecworkaround', '1', '0', '0').'<br /><br />';
		$question.= '<strong>If \'yes\', please specify a path within the suexec path where Froxlor will create symlinks to customer perl-enabled paths:</strong><br /><br />';
		$question.= 'Path for symlinks (must be within suexec path):&nbsp;';
		$question.= '<input type="text" class="text" name="update_perl_suexecpath" value="/var/www/cgi-bin/" /><br />';
		eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
	}

	if(versionInUpdate($current_version, '0.9.12-svn4'))
	{
		if((int)$settings['system']['awstats_enabled'] == 1)
		{
			$has_preconfig = true;
			$description = 'Due to different paths of awstats_buildstaticpages.pl and awstats.pl you can set a different path for awstats.pl now.';
			$question = '<strong>Path to \'awstats.pl\'?:</strong>&nbsp;';
			$question.= '<input type="text" class="text" name="update_awstats_awstatspath" value="'.$settings['system']['awstats_path'].'" /><br />';
			eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
		}
	}

	if(versionInUpdate($current_version, '0.9.13-svn1'))
	{
		if((int)$settings['autoresponder']['autoresponder_active'] == 1)
		{
			$has_preconfig = true;
			$description = 'Froxlor can now limit the number of autoresponder-entries for each user. Here you can set the value which will be available for each customer (Of course you can change the value for each customer separately after the update).';
			$question = '<strong>How many autoresponders should your customers be able to add?:</strong>&nbsp;';
			$question.= '<input type="text" class="text" name="update_autoresponder_default" value="0" />&nbsp;'.makecheckbox('update_autoresponder_default', $lng['customer']['unlimited'], '-1', false, 0, true, true).'<br />';
			eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
		}
	}

	if(versionInUpdate($current_version, '0.9.13.1'))
	{
		if((int)$settings['system']['mod_fcgid_ownvhost'] == 1)
		{
			$has_preconfig = true;
			$description = 'You have FCGID for Froxlor itself activated. You can now specify a PHP-configuration for this.';
			$question = '<strong>Select Froxlor-vhost PHP configuration:</strong>&nbsp;';
			$question .= '<select name="update_defaultini_ownvhost">';
			$configs_array = getPhpConfigs();
			$configs = '';
			foreach($configs_array as $idx => $desc)
			{
				$configs .= makeoption($desc, $idx, '1');
			}
			$question .= $configs.'</select>';
			eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
		}
	}

	if(versionInUpdate($current_version, '0.9.14-svn3'))
	{
		if((int)$settings['system']['awstats_enabled'] == 1)
		{
			$has_preconfig = true;
			$description = 'To have icons in AWStats statistic-pages please enter the path to AWStats icons folder.';
			$question = '<strong>Path to AWSTats icons folder:</strong>&nbsp;';
			$question.= '<input type="text" class="text" name="update_awstats_icons" value="'.$settings['system']['awstats_icons'].'" />';
			eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
		}
	}

	if(versionInUpdate($current_version, '0.9.14-svn4'))
	{
		if((int)$settings['system']['use_ssl'] == 1)
		{
			$has_preconfig = true;
			$description = 'Froxlor now has the possibility to set \'SSLCertificateChainFile\' for the apache webserver.';
			$question = '<strong>Enter filename (leave empty for none):</strong>&nbsp;';
			$question.= '<input type="text" class="text" name="update_ssl_cert_chainfile" value="'.$settings['system']['ssl_cert_chainfile'].'" />';
			eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
		}
	}

	if(versionInUpdate($current_version, '0.9.14-svn6'))
	{
		$has_preconfig = true;
		$description = 'You can now allow customers to use any of their domains as username for the login.';
		$question = '<strong>Do you want to enable domain-login for all customers?:</strong>&nbsp;';
		$question.= makeyesno('update_allow_domain_login', '1', '0', '0');
		eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
	}

	if(versionInUpdate($current_version, '0.9.14-svn10'))
	{       
		$has_preconfig = true;
		$description = '<strong>This update removes the unsupported real-time option. Additionally the deprecated tables for navigation and cronscripts are removed, any modules using these tables need to be updated to the new structure!</strong>'; 
		$question = '';
		eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
	}
	
	if(versionInUpdate($current_version, '0.9.16-svn1'))
	{
		$has_preconfig = true;
		$description = 'Froxlor now features support for php-fpm.';
		$question = '<strong>Do you want to enable php-fpm?:</strong>&nbsp;';
		$question.= makeyesno('update_phpfpm_enabled', '1', '0', '0').'<br /><br />';
		$question.= 'If \'yes\', please specify the configuration directory:&nbsp;';
		$question.= '<input type="text" class="text" name="update_phpfpm_configdir" value="/etc/php-fpm.d/" /><br /><br />';
		$question.= 'Please specify the temporary files directory:&nbsp;';
		$question.= '<input type="text" class="text" name="update_phpfpm_tmpdir" value="/var/customers/tmp/" /><br /><br />';
		$question.= 'Please specify the PEAR directory:&nbsp;';
		$question.= '<input type="text" class="text" name="update_phpfpm_peardir" value="/usr/share/php/:/usr/share/php5/" /><br /><br />';
		$question.= 'Please specify the php-fpm restart-command:&nbsp;';
		$question.= '<input type="text" class="text" name="update_phpfpm_reload" value="/etc/init.d/php-fpm restart" /><br /><br />';
		$question.= 'Please specify the php-fpm rocess manager control:&nbsp;';
		$question.= '<select name="update_phpfpm_pm">';
		$redirects = makeoption('static', 'static', 'static');
		$redirects.= makeoption('dynamic', 'dynamic', 'static');
		$question .= $redirects.'</select><br /><br />';
		$question.= 'Please specify the number of child processes:&nbsp;';
		$question.= '<input type="text" class="text" name="update_phpfpm_max_children" value="1" /><br /><br />';
		$question.= 'Please specify the number of requests per child before respawning:&nbsp;';
		$question.= '<input type="text" class="text" name="update_phpfpm_max_requests" value="0" /><br /><br />';
		$question.= '<em>The following settings are only required if you chose process manager = dynamic</em><br /><br />';
		$question.= 'Please specify the number of child processes created on startup:&nbsp;';
		$question.= '<input type="text" class="text" name="update_phpfpm_start_servers" value="20" /><br /><br />';
		$question.= 'Please specify the desired minimum number of idle server processes:&nbsp;';
		$question.= '<input type="text" class="text" name="update_phpfpm_min_spare_servers" value="5" /><br /><br />';
		$question.= 'Please specify the desired maximum number of idle server processes:&nbsp;';
		$question.= '<input type="text" class="text" name="update_phpfpm_max_spare_servers" value="35" /><br />';
		eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
	}

	if(versionInUpdate($current_version, '0.9.16-svn2'))
	{
		if((int)$settings['phpfpm']['enabled'] == 1)
		{
			$has_preconfig = true;
			$description = 'You can chose whether you want Froxlor to use PHP-FPM itself too now.';
			$question = '<strong>Use PHP-FPM for the Froxlor Panel?:</strong>&nbsp;';
			$question.= makeyesno('update_phpfpm_enabled_ownvhost', '1', '0', '0').'<br /><br />';
			$question.= '<strong>If \'yes\', please specify local user/group (have to exist, Froxlor does not add them automatically):</strong><br /><br />';
			$question.= 'Local user:&nbsp;';
			$question.= '<input type="text" class="text" name="update_phpfpm_httpuser" value="'.$settings['system']['mod_fcgid_httpuser'].'" /><br /><br />';
			$question.= 'Local group:&nbsp;';
			$question.= '<input type="text" class="text" name="update_phpfpm_httpgroup" value="'.$settings['system']['mod_fcgid_httpgroup'].'" /><br />';
			eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
		}
	}

	if(versionInUpdate($current_version, '0.9.17-svn1'))
	{
		$has_preconfig = true;
		$description = 'Select if you want to enable the web- and traffic-reports';
		$question = '<strong>Enable?:</strong>&nbsp;';
		$question.= makeyesno('update_system_report_enable', '1', '0', '1').'<br /><br />';
		$question.= '<strong>If \'yes\', please specify a percentage value for web- and traffic when reports are to be sent:</strong><br /><br />';
		$question.= 'Webusage warning level:&nbsp;';
		$question.= '<input type="text" class="text" name="update_system_report_webmax" value="90" /><br /><br />';
		$question.= 'Traffic warning level:&nbsp;';
		$question.= '<input type="text" class="text" name="update_system_report_trafficmax" value="90" /><br />';
		eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
	}

	if(versionInUpdate($current_version, '0.9.18-svn2'))
	{
		$has_preconfig = true;
		$description = 'As you can (obviously) see, Froxlor now comes with a new theme. You also have the possibility to switch back to "Classic" if you want to.'; 
		$question = '<strong>Select default panel theme:</strong>&nbsp;';
		$question.= '<select name="update_default_theme">';
		$themes = getThemes();
		foreach($themes as $cur_theme) // $theme is already in use
		{
			$question.= makeoption($cur_theme, $cur_theme, 'Froxlor');
		}
		$question.= '</select>';
		eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
	}

	if(versionInUpdate($current_version, '0.9.28-svn4'))
	{
		$has_preconfig = true;
		$description = 'This version introduces a lot of profound changes:';
		$description .= '<br /><ul><li>Improving the whole template system</li><li>Full UTF-8 support</li><li><strong>Removing support for the former default theme \'Classic\'</strong></li></ul>';
		$description .= '<br /><br />Notice: This update will <strong>alter your Froxlor database to use UTF-8</strong> as default charset. ';
		$description .= 'Even though this is already tested, we <span style="color:#ff0000;font-weight:bold;">strongly recommend</span> to ';
		$description .= 'test this update in a testing environment using your existing data.<br /><br />';

		$question = '<strong>Select your preferred Classic Theme replacement:</strong>&nbsp;';
		$question.= '<select name="classic_theme_replacement">';
		$themes = getThemes();
		foreach($themes as $cur_theme)
		{
			$question.= makeoption($cur_theme, $cur_theme, 'Froxlor');
		}
		$question.= '</select>';

		eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
	}

	if (versionInUpdate($current_version, '0.9.28-svn6')) {
	
		if ($settings['system']['webserver'] == 'apache2') {
			$has_preconfig = true;
			$description = 'Froxlor now supports the new Apache 2.4. Please be aware that you need to load additional apache-modules in ordner to use it.<br />';
			$description.= '<pre>LoadModule authz_core_module modules/mod_authz_core.so
LoadModule authz_host_module modules/mod_authz_host.so</pre><br />';
			$question = '<strong>Do you want to enable the Apache-2.4 modification?:</strong>&nbsp;';
			$question.= makeyesno('update_system_apache24', '1', '0', '0');
			eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");
		} elseif ($settings['system']['webserver'] == 'nginx') {
			$has_preconfig = true;
			$description = 'The path to nginx\'s fastcgi_params file is now customizable.<br /><br />';
			$question = '<strong>Please enter full path to you nginx/fastcgi_params file (including filename):</strong>&nbsp;';
			$question.= '<input type="text" class="text" name="nginx_fastcgi_params" value="/etc/nginx/fastcgi_params" />';
			eval("\$return.=\"" . getTemplate("update/preconfigitem") . "\";");			
		}
	}

}
