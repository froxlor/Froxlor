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
			'label' => \Froxlor\I18N\Lang::getAll()['admin']['overview'],
			'elements' => array(
				array(
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['main']['username'] . (isset(\Froxlor\User::getAll()['loginname']) && \Froxlor\User::getAll()['loginname'] != '' ? " " . \Froxlor\User::getAll()['loginname'] : "")
				),
				array(
					'url' => 'customer_index.php?page=change_password',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['main']['changepassword']
				),
				array(
					'url' => 'customer_index.php?page=change_language',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['main']['changelanguage']
				),
				array(
					'url' => 'customer_index.php?page=change_theme',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['main']['changetheme'],
					'show_element' => (\Froxlor\Settings::Get('panel.allow_theme_change_customer') == true)
				),
				array(
					'url' => 'customer_index.php?page=apikeys',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['main']['apikeys'],
					'show_element' => (\Froxlor\Settings::Get('api.enabled') == true)
				),
				array(
					'url' => 'customer_index.php?page=apihelp',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['main']['apihelp'],
					'show_element' => (\Froxlor\Settings::Get('api.enabled') == true)
				),
				array(
					'url' => 'customer_index.php?action=logout',
					'label' => \Froxlor\I18N\Lang::getAll()['login']['logout']
				)
			)
		),
		'email' => array(
			'url' => 'customer_email.php',
			'label' => \Froxlor\I18N\Lang::getAll()['menue']['email']['email'],
			'show_element' => (! \Froxlor\Settings::IsInList('panel.customer_hide_options', 'email')),
			'elements' => array(
				array(
					'url' => 'customer_email.php?page=emails',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['email']['emails'],
					'required_resources' => 'emails'
				),
				array(
					'url' => 'customer_email.php?page=emails&action=add',
					'label' => \Froxlor\I18N\Lang::getAll()['emails']['emails_add'],
					'required_resources' => 'emails'
				),
				array(
					'url' => \Froxlor\Settings::Get('panel.webmail_url'),
					'new_window' => true,
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['email']['webmail'],
					'required_resources' => 'emails_used',
					'show_element' => (\Froxlor\Settings::Get('panel.webmail_url') != '')
				)
			)
		),
		'mysql' => array(
			'url' => 'customer_mysql.php',
			'label' => \Froxlor\I18N\Lang::getAll()['menue']['mysql']['mysql'],
			'show_element' => (! \Froxlor\Settings::IsInList('panel.customer_hide_options', 'mysql')),
			'elements' => array(
				array(
					'url' => 'customer_mysql.php?page=mysqls',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['mysql']['databases'],
					'required_resources' => 'mysqls'
				),
				array(
					'url' => \Froxlor\Settings::Get('panel.phpmyadmin_url'),
					'new_window' => true,
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['mysql']['phpmyadmin'],
					'required_resources' => 'mysqls_used',
					'show_element' => (\Froxlor\Settings::Get('panel.phpmyadmin_url') != '')
				)
			)
		),
		'domains' => array(
			'url' => 'customer_domains.php',
			'label' => \Froxlor\I18N\Lang::getAll()['menue']['domains']['domains'],
			'show_element' => (! \Froxlor\Settings::IsInList('panel.customer_hide_options', 'domains')),
			'elements' => array(
				array(
					'url' => 'customer_domains.php?page=domains',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['domains']['settings']
				),
				array(
					'url' => 'customer_domains.php?page=sslcertificates',
					'label' => \Froxlor\I18N\Lang::getAll()['domains']['ssl_certificates']
				)
			)
		),
		'ftp' => array(
			'url' => 'customer_ftp.php',
			'label' => \Froxlor\I18N\Lang::getAll()['menue']['ftp']['ftp'],
			'show_element' => (! \Froxlor\Settings::IsInList('panel.customer_hide_options', 'ftp')),
			'elements' => array(
				array(
					'url' => 'customer_ftp.php?page=accounts',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['ftp']['accounts']
				),
				array(
					'url' => \Froxlor\Settings::Get('panel.webftp_url'),
					'new_window' => true,
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['ftp']['webftp'],
					'show_element' => (\Froxlor\Settings::Get('panel.webftp_url') != '')
				)
			)
		),
		'extras' => array(
			'url' => 'customer_extras.php',
			'label' => \Froxlor\I18N\Lang::getAll()['menue']['extras']['extras'],
			'show_element' => (! \Froxlor\Settings::IsInList('panel.customer_hide_options', 'extras')),
			'elements' => array(
				array(
					'url' => 'customer_extras.php?page=htpasswds',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['extras']['directoryprotection'],
					'show_element' => (! \Froxlor\Settings::IsInList('panel.customer_hide_options', 'extras.directoryprotection'))
				),
				array(
					'url' => 'customer_extras.php?page=htaccess',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['extras']['pathoptions'],
					'show_element' => (! \Froxlor\Settings::IsInList('panel.customer_hide_options', 'extras.pathoptions'))
				),
				array(
					'url' => 'customer_logger.php?page=log',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['logger']['logger'],
					'show_element' => (\Froxlor\Settings::Get('logger.enabled') == true) && (! \Froxlor\Settings::IsInList('panel.customer_hide_options', 'extras.logger'))
				),
				array(
					'url' => 'customer_extras.php?page=backup',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['extras']['backup'],
					'show_element' => (\Froxlor\Settings::Get('system.backupenabled') == true) && (! \Froxlor\Settings::IsInList('panel.customer_hide_options', 'extras.backup'))
				)
			)
		),
		'traffic' => array(
			'url' => 'customer_traffic.php',
			'label' => \Froxlor\I18N\Lang::getAll()['menue']['traffic']['traffic'],
			'show_element' => (! \Froxlor\Settings::IsInList('panel.customer_hide_options', 'traffic')),
			'elements' => array(
				array(
					'url' => 'customer_traffic.php?page=current',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['traffic']['current']
				)
			)
		)
	),
	'admin' => array(
		'index' => array(
			'url' => 'admin_index.php',
			'label' => \Froxlor\I18N\Lang::getAll()['admin']['overview'],
			'elements' => array(
				array(
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['main']['username']
				),
				array(
					'url' => 'admin_index.php?page=change_password',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['main']['changepassword']
				),
				array(
					'url' => 'admin_index.php?page=change_language',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['main']['changelanguage']
				),
				array(
					'url' => 'admin_index.php?page=change_theme',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['main']['changetheme'],
					'show_element' => (\Froxlor\Settings::Get('panel.allow_theme_change_admin') == true)
				),
				array(
					'url' => 'admin_index.php?page=apikeys',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['main']['apikeys'],
					'show_element' => (\Froxlor\Settings::Get('api.enabled') == true)
				),
				array(
					'url' => 'admin_index.php?page=apihelp',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['main']['apihelp'],
					'show_element' => (\Froxlor\Settings::Get('api.enabled') == true)
				),
				array(
					'url' => 'admin_index.php?action=logout',
					'label' => \Froxlor\I18N\Lang::getAll()['login']['logout']
				)
			)
		),
		'resources' => array(
			'label' => \Froxlor\I18N\Lang::getAll()['admin']['resources'],
			'required_resources' => 'customers',
			'elements' => array(
				array(
					'url' => 'admin_customers.php?page=customers',
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['customers'],
					'required_resources' => 'customers'
				),
				array(
					'url' => 'admin_admins.php?page=admins',
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['admins'],
					'required_resources' => 'change_serversettings'
				),
				array(
					'url' => 'admin_domains.php?page=domains',
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['domains'],
					'required_resources' => 'domains'
				),
				array(
					'url' => 'admin_domains.php?page=sslcertificates',
					'label' => \Froxlor\I18N\Lang::getAll()['domains']['ssl_certificates'],
					'required_resources' => 'domains'
				),
				array(
					'url' => 'admin_ipsandports.php?page=ipsandports',
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['ipsandports']['ipsandports'],
					'required_resources' => 'change_serversettings'
				),
				array(
					'url' => 'admin_plans.php?page=overview',
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['plans']['plans'],
					'required_resources' => 'customers'
				),
				array(
					'url' => 'admin_settings.php?page=updatecounters',
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['updatecounters'],
					'required_resources' => 'change_serversettings'
				)
			)
		),
		'traffic' => array(
			'label' => \Froxlor\I18N\Lang::getAll()['admin']['traffic'],
			'required_resources' => 'customers',
			'elements' => array(
				array(
					'url' => 'admin_traffic.php?page=customers',
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['customertraffic'],
					'required_resources' => 'customers'
				)
			)
		),
		'server' => array(
			'label' => \Froxlor\I18N\Lang::getAll()['admin']['server'],
			'required_resources' => 'change_serversettings',
			'elements' => array(
				array(
					'url' => 'admin_configfiles.php?page=configfiles',
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['configfiles']['serverconfiguration'],
					'required_resources' => 'change_serversettings'
				),
				array(
					'url' => 'admin_settings.php?page=overview',
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['serversettings'],
					'required_resources' => 'change_serversettings'
				),
				array(
					'url' => 'admin_cronjobs.php?page=overview',
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['cron']['cronsettings'],
					'required_resources' => 'change_serversettings'
				),
				array(
					'url' => 'admin_logger.php?page=log',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['logger']['logger'],
					'required_resources' => 'change_serversettings',
					'show_element' => (\Froxlor\Settings::Get('logger.enabled') == true)
				),
				array(
					'url' => 'admin_settings.php?page=rebuildconfigs',
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['rebuildconf'],
					'required_resources' => 'change_serversettings'
				),
				array(
					'url' => 'admin_autoupdate.php?page=overview',
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['autoupdate'],
					'required_resources' => 'change_serversettings',
					'show_element' => extension_loaded('zip')
				),
				array(
					'url' => 'admin_settings.php?page=wipecleartextmailpws',
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['wipecleartextmailpwd'],
					'required_resources' => 'change_serversettings',
					'show_element' => (\Froxlor\Settings::Get('system.mailpwcleartext') == true)
				)
			)
		),
		'server_php' => array(
			'label' => \Froxlor\I18N\Lang::getAll()['admin']['server_php'],
			'required_resources' => 'change_serversettings',
			'elements' => array(
				array(
					'url' => 'admin_phpsettings.php?page=overview',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['phpsettings']['maintitle'],
					'show_element' => (\Froxlor\Settings::Get('system.mod_fcgid') == true || \Froxlor\Settings::Get('phpfpm.enabled') == true)
				),
				array(
					'url' => 'admin_phpsettings.php?page=fpmdaemons',
					'label' => \Froxlor\I18N\Lang::getAll()['menue']['phpsettings']['fpmdaemons'],
					'required_resources' => 'change_serversettings',
					'show_element' => \Froxlor\Settings::Get('phpfpm.enabled') == true
				),
				array(
					'url' => 'admin_settings.php?page=phpinfo',
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['phpinfo'],
					'required_resources' => 'change_serversettings'
				),
				array(
					'url' => 'admin_apcuinfo.php?page=showinfo',
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['apcuinfo'],
					'required_resources' => 'change_serversettings',
					'show_element' => (function_exists('apcu_cache_info') === true)
				),
				array(
					'url' => 'admin_opcacheinfo.php?page=showinfo',
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['opcacheinfo'],
					'required_resources' => 'change_serversettings',
					'show_element' => (function_exists('opcache_get_configuration') === true)
				)
			)
		),
		'misc' => array(
			'label' => \Froxlor\I18N\Lang::getAll()['admin']['misc'],
			'elements' => array(
				array(
					'url' => 'admin_settings.php?page=integritycheck',
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['integritycheck'],
					'required_resources' => 'change_serversettings'
				),
				array(
					'url' => 'admin_templates.php?page=email',
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['templates']['email']
				),
				array(
					'url' => 'admin_message.php?page=message',
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['message']
				),
				array(
					'url' => 'admin_settings.php?page=testmail',
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['testmail']
				)
			)
		)
	)
);
