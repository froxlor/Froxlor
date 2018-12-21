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
 * @package    Formfields
 *
 */
return array(
	'domain_edit' => array(
		'title' => \Froxlor\I18N\Lang::getAll()['admin']['domain_edit'],
		'image' => 'icons/domain_edit.png',
		'sections' => array(
			'section_a' => array(
				'title' => \Froxlor\I18N\Lang::getAll()['domains']['domainsettings'],
				'image' => 'icons/domain_edit.png',
				'fields' => array(
					'domain' => array(
						'label' => 'Domain',
						'type' => 'label',
						'value' => $result['domain'],
						'mandatory' => true
					),
					'customerid' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['customer'],
						'type' => (\Froxlor\Settings::Get('panel.allow_domain_change_customer') == '1' ? 'select' : 'label'),
						'select_var' => (isset($customers) ? $customers : null),
						'value' => (isset($result['customername']) ? $result['customername'] : null),
						'mandatory' => true
					),
					'adminid' => array(
						'visible' => (\Froxlor\User::getAll()['customers_see_all'] == '1' ? true : false),
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['admin'],
						'type' => (\Froxlor\Settings::Get('panel.allow_domain_change_admin') == '1' ? 'select' : 'label'),
						'select_var' => (isset($admins) ? $admins : null),
						'value' => (isset($result['adminname']) ? $result['adminname'] : null),
						'mandatory' => true
					),
					'alias' => array(
						'visible' => ($alias_check == '0' ? true : false),
						'label' => \Froxlor\I18N\Lang::getAll()['domains']['aliasdomain'],
						'type' => 'select',
						'select_var' => $domains
					),
					'issubof' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['domains']['issubof'],
						'desc' => \Froxlor\I18N\Lang::getAll()['domains']['issubofinfo'],
						'type' => 'select',
						'select_var' => $subtodomains
					),
					'associated_info' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['domains']['associated_with_domain'],
						'type' => 'label',
						'value' => $subdomains . ' ' . \Froxlor\I18N\Lang::getAll()['customer']['subdomains'] . ', ' . $alias_check . ' ' . \Froxlor\I18N\Lang::getAll()['domains']['aliasdomains'] . ', ' . $emails . ' ' . \Froxlor\I18N\Lang::getAll()['customer']['emails'] . ', ' . $email_accounts . ' ' . \Froxlor\I18N\Lang::getAll()['customer']['accounts'] . ', ' . $email_forwarders . ' ' . \Froxlor\I18N\Lang::getAll()['customer']['forwarders']
					),
					'caneditdomain' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['domain_editable']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['admin']['domain_editable']['desc'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['caneditdomain']
						)
					),
					'add_date' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['domains']['add_date'],
						'desc' => \Froxlor\I18N\Lang::getAll()['panel']['dateformat'],
						'type' => 'label',
						'value' => $result['add_date']
					),
					'registration_date' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['domains']['registration_date'],
						'desc' => \Froxlor\I18N\Lang::getAll()['panel']['dateformat'],
						'type' => 'text',
						'value' => $result['registration_date'],
						'size' => 10
					),
					'termination_date' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['domains']['termination_date'],
						'desc' => \Froxlor\I18N\Lang::getAll()['panel']['dateformat'],
						'type' => 'text',
						'value' => $result['termination_date'],
						'size' => 10
					)
				)
			),
			'section_b' => array(
				'title' => \Froxlor\I18N\Lang::getAll()['admin']['webserversettings'],
				'image' => 'icons/domain_edit.png',
				'fields' => array(
					'documentroot' => array(
						'visible' => (\Froxlor\User::getAll()['change_serversettings'] == '1' ? true : false),
						'label' => 'DocumentRoot',
						'desc' => \Froxlor\I18N\Lang::getAll()['panel']['emptyfordefault'],
						'type' => 'text',
						'value' => $result['documentroot']
					),
					'ipandport' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['domains']['ipandport_multi']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['domains']['ipandport_multi']['description'],
						'type' => 'checkbox',
						'values' => $ipsandports,
						'value' => $usedips,
						'is_array' => 1,
						'mandatory' => true
					),
					'selectserveralias' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['selectserveralias'],
						'desc' => \Froxlor\I18N\Lang::getAll()['admin']['selectserveralias_desc'],
						'type' => 'select',
						'select_var' => $serveraliasoptions
					),
					'speciallogfile' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['speciallogfile']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['admin']['speciallogfile']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['speciallogfile']
						)
					),
					'specialsettings' => array(
						'visible' => (\Froxlor\User::getAll()['change_serversettings'] == '1' ? true : false),
						'style' => 'align-top',
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['ownvhostsettings'],
						'desc' => \Froxlor\I18N\Lang::getAll()['serversettings']['default_vhostconf']['description'],
						'type' => 'textarea',
						'value' => $result['specialsettings'],
						'cols' => 60,
						'rows' => 12
					),
					'specialsettingsforsubdomains' => array(
						'visible' => (\Froxlor\User::getAll()['change_serversettings'] == '1' ? true : false),
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['specialsettingsforsubdomains'],
						'desc' => \Froxlor\I18N\Lang::getAll()['serversettings']['specialsettingsforsubdomains']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							'1'
						)
					),
					'notryfiles' => array(
						'visible' => (\Froxlor\Settings::Get('system.webserver') == 'nginx' && \Froxlor\User::getAll()['change_serversettings'] == '1'),
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['notryfiles']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['admin']['notryfiles']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['notryfiles']
						)
					),
					'writeaccesslog' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['writeaccesslog']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['admin']['writeaccesslog']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['writeaccesslog']
						)
					),
					'writeerrorlog' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['writeerrorlog']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['admin']['writeerrorlog']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['writeerrorlog']
						)
					)
				)
			),
			'section_bssl' => array(
				'title' => \Froxlor\I18N\Lang::getAll()['admin']['webserversettings_ssl'],
				'image' => 'icons/domain_edit.png',
				'visible' => \Froxlor\Settings::Get('system.use_ssl') == '1' ? true : false,
				'fields' => array(
					'ssl_ipandport' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['domains']['ipandport_ssl_multi']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['domains']['ipandport_ssl_multi']['description'],
						'type' => 'checkbox',
						'values' => $ssl_ipsandports,
						'value' => $usedips,
						'is_array' => 1
					),
					'ssl_redirect' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false),
						'label' => \Froxlor\I18N\Lang::getAll()['domains']['ssl_redirect']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['domains']['ssl_redirect']['description'] . ($result['temporary_ssl_redirect'] > 1 ? \Froxlor\I18N\Lang::getAll()['domains']['ssl_redirect_temporarilydisabled'] : ''),
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['ssl_redirect']
						)
					),
					'letsencrypt' => array(
						'visible' => (\Froxlor\Settings::Get('system.leenabled') == '1' ? ($ssl_ipsandports != '' ? true : false) : false),
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['letsencrypt']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['admin']['letsencrypt']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['letsencrypt']
						)
					),
					'http2' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false) && \Froxlor\Settings::Get('system.webserver') != 'lighttpd' && \Froxlor\Settings::Get('system.http2_support') == '1',
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['domain_http2']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['admin']['domain_http2']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['http2']
						)
					),
					'no_ssl_available_info' => array(
						'visible' => ($ssl_ipsandports == '' ? true : false),
						'label' => 'SSL',
						'type' => 'label',
						'value' => \Froxlor\I18N\Lang::getAll()['panel']['nosslipsavailable']
					),
					'hsts_maxage' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false),
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['domain_hsts_maxage']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['admin']['domain_hsts_maxage']['description'],
						'type' => 'int',
						'int_min' => 0,
						'int_max' => 94608000, // 3-years
						'value' => $result['hsts']
					),
					'hsts_sub' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false),
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['domain_hsts_incsub']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['admin']['domain_hsts_incsub']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['hsts_sub']
						)
					),
					'hsts_preload' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false),
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['domain_hsts_preload']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['admin']['domain_hsts_preload']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['hsts_preload']
						)
					),
					'ocsp_stapling' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false) && \Froxlor\Settings::Get('system.webserver') != 'lighttpd',
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['domain_ocsp_stapling']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['admin']['domain_ocsp_stapling']['description'] . (\Froxlor\Settings::Get('system.webserver') == 'nginx' ? \Froxlor\I18N\Lang::getAll()['admin']['domain_ocsp_stapling']['nginx_version_warning'] : ""),
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['ocsp_stapling']
						)
					)
				)
			),
			'section_c' => array(
				'title' => \Froxlor\I18N\Lang::getAll()['admin']['phpserversettings'],
				'image' => 'icons/domain_edit.png',
				'visible' => ((\Froxlor\User::getAll()['change_serversettings'] == '1' || \Froxlor\User::getAll()['caneditphpsettings'] == '1') ? true : false),
				'fields' => array(
					'openbasedir' => array(
						'label' => 'OpenBasedir',
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['openbasedir']
						)
					),
					'phpenabled' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['phpenabled'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['phpenabled']
						)
					),
					'phpsettingid' => array(
						'visible' => (((int) \Froxlor\Settings::Get('system.mod_fcgid') == 1 || (int) \Froxlor\Settings::Get('phpfpm.enabled') == 1) ? true : false),
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['phpsettings']['title'],
						'type' => 'select',
						'select_var' => $phpconfigs
					),
					'phpsettingsforsubdomains' => array(
						'visible' => (\Froxlor\User::getAll()['change_serversettings'] == '1' ? true : false),
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['phpsettingsforsubdomains'],
						'desc' => \Froxlor\I18N\Lang::getAll()['serversettings']['phpsettingsforsubdomains']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							'1'
						)
					),
					'mod_fcgid_starter' => array(
						'visible' => ((int) \Froxlor\Settings::Get('system.mod_fcgid') == 1 ? true : false),
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['mod_fcgid_starter']['title'],
						'type' => 'text',
						'value' => ((int) $result['mod_fcgid_starter'] != - 1 ? $result['mod_fcgid_starter'] : '')
					),
					'mod_fcgid_maxrequests' => array(
						'visible' => ((int) \Froxlor\Settings::Get('system.mod_fcgid') == 1 ? true : false),
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['mod_fcgid_maxrequests']['title'],
						'type' => 'text',
						'value' => ((int) $result['mod_fcgid_maxrequests'] != - 1 ? $result['mod_fcgid_maxrequests'] : '')
					)
				)
			),
			'section_d' => array(
				'title' => \Froxlor\I18N\Lang::getAll()['admin']['nameserversettings'],
				'image' => 'icons/domain_edit.png',
				'visible' => (\Froxlor\Settings::Get('system.bind_enable') == '1' && \Froxlor\User::getAll()['change_serversettings'] == '1' ? true : false),
				'fields' => array(
					'isbinddomain' => array(
						'label' => 'Nameserver',
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['isbinddomain']
						)
					),
					'zonefile' => array(
						'label' => 'Zonefile',
						'desc' => \Froxlor\I18N\Lang::getAll()['admin']['bindzonewarning'],
						'type' => 'text',
						'value' => $result['zonefile']
					)
				)
			),
			'section_e' => array(
				'title' => \Froxlor\I18N\Lang::getAll()['admin']['mailserversettings'],
				'image' => 'icons/domain_edit.png',
				'fields' => array(
					'isemaildomain' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['emaildomain'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['isemaildomain']
						)
					),
					'email_only' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['email_only'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['email_only']
						)
					),
					'subcanemaildomain' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['subdomainforemail'],
						'type' => 'select',
						'select_var' => $subcanemaildomain
					),
					'dkim' => array(
						'visible' => (\Froxlor\Settings::Get('dkim.use_dkim') == '1' ? true : false),
						'label' => 'DomainKeys',
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['dkim']
						)
					)
				)
			)
		)
	)
);
