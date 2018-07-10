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
 * @package    Navigation
 *
 */
return array(
	'customer' => array(
		'index' => array(
			'url' => 'customer_index.php',
			'label' => $lng['admin']['overview'],
			'elements' => array(
				array(
					'label' => $lng['menue']['main']['username']
				),
				array(
					'url' => 'customer_index.php?page=change_password',
					'label' => $lng['menue']['main']['changepassword']
				),
				array(
					'url' => 'customer_index.php?page=change_language',
					'label' => $lng['menue']['main']['changelanguage']
				),
				array(
					'url' => 'customer_index.php?page=change_theme',
					'label' => $lng['menue']['main']['changetheme'],
					'show_element' => (Settings::Get('panel.allow_theme_change_customer') == true)
				),
				array(
					'url' => 'customer_index.php?page=apikeys',
					'label' => $lng['menue']['main']['apikeys'],
					'show_element' => (Settings::Get('api.enabled') == true)
				),
				array(
					'url' => 'customer_index.php?page=apihelp',
					'label' => $lng['menue']['main']['apihelp'],
					'show_element' => (Settings::Get('api.enabled') == true)
				),
				array(
					'url' => 'customer_index.php?action=logout',
					'label' => $lng['login']['logout']
				)
			)
		),
		'email' => array(
			'url' => 'customer_email.php',
			'label' => $lng['menue']['email']['email'],
			'show_element' => (! Settings::IsInList('panel.customer_hide_options', 'email')),
			'elements' => array(
				array(
					'url' => 'customer_email.php?page=emails',
					'label' => $lng['menue']['email']['emails'],
					'required_resources' => 'emails'
				),
				array(
					'url' => 'customer_email.php?page=emails&action=add',
					'label' => $lng['emails']['emails_add'],
					'required_resources' => 'emails'
				),
				array(
					'url' => Settings::Get('panel.webmail_url'),
					'new_window' => true,
					'label' => $lng['menue']['email']['webmail'],
					'required_resources' => 'emails_used',
					'show_element' => (Settings::Get('panel.webmail_url') != '')
				)
			)
		),
		'mysql' => array(
			'url' => 'customer_mysql.php',
			'label' => $lng['menue']['mysql']['mysql'],
			'show_element' => (! Settings::IsInList('panel.customer_hide_options', 'mysql')),
			'elements' => array(
				array(
					'url' => 'customer_mysql.php?page=mysqls',
					'label' => $lng['menue']['mysql']['databases'],
					'required_resources' => 'mysqls'
				),
				array(
					'url' => Settings::Get('panel.phpmyadmin_url'),
					'new_window' => true,
					'label' => $lng['menue']['mysql']['phpmyadmin'],
					'required_resources' => 'mysqls_used',
					'show_element' => (Settings::Get('panel.phpmyadmin_url') != '')
				)
			)
		),
		'domains' => array(
			'url' => 'customer_domains.php',
			'label' => $lng['menue']['domains']['domains'],
			'show_element' => (! Settings::IsInList('panel.customer_hide_options', 'domains')),
			'elements' => array(
				array(
					'url' => 'customer_domains.php?page=domains',
					'label' => $lng['menue']['domains']['settings']
				),
				array(
					'url' => 'customer_domains.php?page=sslcertificates',
					'label' => $lng['domains']['ssl_certificates']
				)
			)
		),
		'ftp' => array(
			'url' => 'customer_ftp.php',
			'label' => $lng['menue']['ftp']['ftp'],
			'show_element' => (! Settings::IsInList('panel.customer_hide_options', 'ftp')),
			'elements' => array(
				array(
					'url' => 'customer_ftp.php?page=accounts',
					'label' => $lng['menue']['ftp']['accounts']
				),
				array(
					'url' => Settings::Get('panel.webftp_url'),
					'new_window' => true,
					'label' => $lng['menue']['ftp']['webftp'],
					'show_element' => (Settings::Get('panel.webftp_url') != '')
				)
			)
		),
		'extras' => array(
			'url' => 'customer_extras.php',
			'label' => $lng['menue']['extras']['extras'],
			'show_element' => (! Settings::IsInList('panel.customer_hide_options', 'extras')),
			'elements' => array(
				array(
					'url' => 'customer_extras.php?page=htpasswds',
					'label' => $lng['menue']['extras']['directoryprotection'],
					'show_element' => (! Settings::IsInList('panel.customer_hide_options', 'extras.directoryprotection'))
				),
				array(
					'url' => 'customer_extras.php?page=htaccess',
					'label' => $lng['menue']['extras']['pathoptions'],
					'show_element' => (! Settings::IsInList('panel.customer_hide_options', 'extras.pathoptions'))
				),
				array(
					'url' => 'customer_logger.php?page=log',
					'label' => $lng['menue']['logger']['logger'],
					'show_element' => (Settings::Get('logger.enabled') == true) && (! Settings::IsInList('panel.customer_hide_options', 'extras.logger'))
				),
				array(
					'url' => 'customer_extras.php?page=backup',
					'label' => $lng['menue']['extras']['backup'],
					'show_element' => (Settings::Get('system.backupenabled') == true) && (! Settings::IsInList('panel.customer_hide_options', 'extras.backup'))
				)
			)
		),
		'traffic' => array(
			'url' => 'customer_traffic.php',
			'label' => $lng['menue']['traffic']['traffic'],
			'show_element' => (! Settings::IsInList('panel.customer_hide_options', 'traffic')),
			'elements' => array(
				array(
					'url' => 'customer_traffic.php?page=current',
					'label' => $lng['menue']['traffic']['current']
				)
			)
		)
	),
	'admin' => array(
		'index' => array(
			'url' => 'admin_index.php',
			'label' => $lng['admin']['overview'],
			'elements' => array(
				array(
					'label' => $lng['menue']['main']['username']
				),
				array(
					'url' => 'admin_index.php?page=change_password',
					'label' => $lng['menue']['main']['changepassword']
				),
				array(
					'url' => 'admin_index.php?page=change_language',
					'label' => $lng['menue']['main']['changelanguage']
				),
				array(
					'url' => 'admin_index.php?page=change_theme',
					'label' => $lng['menue']['main']['changetheme'],
					'show_element' => (Settings::Get('panel.allow_theme_change_admin') == true)
				),
				array(
					'url' => 'admin_index.php?page=apikeys',
					'label' => $lng['menue']['main']['apikeys'],
					'show_element' => (Settings::Get('api.enabled') == true)
				),
				array(
					'url' => 'admin_index.php?page=apihelp',
					'label' => $lng['menue']['main']['apihelp'],
					'show_element' => (Settings::Get('api.enabled') == true)
				),
				array(
					'url' => 'admin_index.php?action=logout',
					'label' => $lng['login']['logout']
				)
			)
		),
		'resources' => array(
			'label' => $lng['admin']['resources'],
			'required_resources' => 'customers',
			'elements' => array(
				array(
					'url' => 'admin_customers.php?page=customers',
					'label' => $lng['admin']['customers'],
					'required_resources' => 'customers'
				),
				array(
					'url' => 'admin_admins.php?page=admins',
					'label' => $lng['admin']['admins'],
					'required_resources' => 'change_serversettings'
				),
				array(
					'url' => 'admin_domains.php?page=domains',
					'label' => $lng['admin']['domains'],
					'required_resources' => 'domains'
				),
				array(
					'url' => 'admin_domains.php?page=sslcertificates',
					'label' => $lng['domains']['ssl_certificates'],
					'required_resources' => 'domains'
				),
				array(
					'url' => 'admin_ipsandports.php?page=ipsandports',
					'label' => $lng['admin']['ipsandports']['ipsandports'],
					'required_resources' => 'change_serversettings'
				),
				array(
					'url' => 'admin_plans.php?page=overview',
					'label' => $lng['admin']['plans']['plans'],
					'required_resources' => 'customers'
				),
				array(
					'url' => 'admin_settings.php?page=updatecounters',
					'label' => $lng['admin']['updatecounters'],
					'required_resources' => 'change_serversettings'
				)
			)
		),
		'traffic' => array(
			'label' => $lng['admin']['traffic'],
			'required_resources' => 'customers',
			'elements' => array(
				array(
					'url' => 'admin_traffic.php?page=customers',
					'label' => $lng['admin']['customertraffic'],
					'required_resources' => 'customers'
				)
			)
		),
		'server' => array(
			'label' => $lng['admin']['server'],
			'required_resources' => 'change_serversettings',
			'elements' => array(
				array(
					'url' => 'admin_configfiles.php?page=configfiles',
					'label' => $lng['admin']['configfiles']['serverconfiguration'],
					'required_resources' => 'change_serversettings'
				),
				array(
					'url' => 'admin_settings.php?page=overview',
					'label' => $lng['admin']['serversettings'],
					'required_resources' => 'change_serversettings'
				),
				array(
					'url' => 'admin_cronjobs.php?page=overview',
					'label' => $lng['admin']['cron']['cronsettings'],
					'required_resources' => 'change_serversettings'
				),
				array(
					'url' => 'admin_logger.php?page=log',
					'label' => $lng['menue']['logger']['logger'],
					'required_resources' => 'change_serversettings',
					'show_element' => (Settings::Get('logger.enabled') == true)
				),
				array(
					'url' => 'admin_settings.php?page=rebuildconfigs',
					'label' => $lng['admin']['rebuildconf'],
					'required_resources' => 'change_serversettings'
				),
				array(
					'url' => 'admin_autoupdate.php?page=overview',
					'label' => $lng['admin']['autoupdate'],
					'required_resources' => 'change_serversettings',
					'show_element' => extension_loaded('zip')
				),
				array(
					'url' => 'admin_settings.php?page=wipecleartextmailpws',
					'label' => $lng['admin']['wipecleartextmailpwd'],
					'required_resources' => 'change_serversettings',
					'show_element' => (Settings::Get('system.mailpwcleartext') == true)
				)
			)
		),
		'server_php' => array(
			'label' => $lng['admin']['server_php'],
			'required_resources' => 'change_serversettings',
			'elements' => array(
				array(
					'url' => 'admin_phpsettings.php?page=overview',
					'label' => $lng['menue']['phpsettings']['maintitle'],
					'show_element' => (Settings::Get('system.mod_fcgid') == true || Settings::Get('phpfpm.enabled') == true)
				),
				array(
					'url' => 'admin_phpsettings.php?page=fpmdaemons',
					'label' => $lng['menue']['phpsettings']['fpmdaemons'],
					'required_resources' => 'change_serversettings',
					'show_element' => Settings::Get('phpfpm.enabled') == true
				),
				array(
					'url' => 'admin_settings.php?page=phpinfo',
					'label' => $lng['admin']['phpinfo'],
					'required_resources' => 'change_serversettings'
				),
				array(
					'url' => 'admin_apcuinfo.php?page=showinfo',
					'label' => $lng['admin']['apcuinfo'],
					'required_resources' => 'change_serversettings',
					'show_element' => (function_exists('apcu_cache_info') === true)
				),
				array(
					'url' => 'admin_opcacheinfo.php?page=showinfo',
					'label' => $lng['admin']['opcacheinfo'],
					'required_resources' => 'change_serversettings',
					'show_element' => (function_exists('opcache_get_configuration') === true)
				)
			)
		),
		'misc' => array(
			'label' => $lng['admin']['misc'],
			'elements' => array(
				array(
					'url' => 'admin_settings.php?page=integritycheck',
					'label' => $lng['admin']['integritycheck'],
					'required_resources' => 'change_serversettings'
				),
				array(
					'url' => 'admin_templates.php?page=email',
					'label' => $lng['admin']['templates']['email']
				),
				array(
					'url' => 'admin_message.php?page=message',
					'label' => $lng['admin']['message']
				),
				array(
					'url' => 'admin_settings.php?page=testmail',
					'label' => $lng['admin']['testmail']
				)
			)
		)
	)
);
