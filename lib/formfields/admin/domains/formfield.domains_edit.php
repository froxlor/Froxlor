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
		'title' => $lng['admin']['domain_edit'],
		'image' => 'icons/domain_edit.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['domains']['domainsettings'],
				'image' => 'icons/domain_edit.png',
				'fields' => array(
					'domain' => array(
						'label' => 'Domain',
						'type' => 'label',
						'value' => $result['domain'],
						'mandatory' => true
					),
					'customerid' => array(
						'label' => $lng['admin']['customer'],
						'type' => (\Froxlor\Settings::Get('panel.allow_domain_change_customer') == '1' ? 'select' : 'label'),
						'select_var' => (isset($customers) ? $customers : null),
						'value' => (isset($result['customername']) ? $result['customername'] : null),
						'mandatory' => true
					),
					'adminid' => array(
						'visible' => ($userinfo['customers_see_all'] == '1' ? true : false),
						'label' => $lng['admin']['admin'],
						'type' => (\Froxlor\Settings::Get('panel.allow_domain_change_admin') == '1' ? 'select' : 'label'),
						'select_var' => (isset($admins) ? $admins : null),
						'value' => (isset($result['adminname']) ? $result['adminname'] : null),
						'mandatory' => true
					),
					'alias' => array(
						'visible' => ($alias_check == '0' ? true : false),
						'label' => $lng['domains']['aliasdomain'],
						'type' => 'select',
						'select_var' => $domains
					),
					'issubof' => array(
						'label' => $lng['domains']['issubof'],
						'desc' => $lng['domains']['issubofinfo'],
						'type' => 'select',
						'select_var' => $subtodomains
					),
					'associated_info' => array(
						'label' => $lng['domains']['associated_with_domain'],
						'type' => 'label',
						'value' => $subdomains . ' ' . $lng['customer']['subdomains'] . ', ' . $alias_check . ' ' . $lng['domains']['aliasdomains'] . ', ' . $emails . ' ' . $lng['customer']['emails'] . ', ' . $email_accounts . ' ' . $lng['customer']['accounts'] . ', ' . $email_forwarders . ' ' . $lng['customer']['forwarders']
					),
					'caneditdomain' => array(
						'label' => $lng['admin']['domain_editable']['title'],
						'desc' => $lng['admin']['domain_editable']['desc'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['caneditdomain']
						)
					),
					'add_date' => array(
						'label' => $lng['domains']['add_date'],
						'desc' => $lng['panel']['dateformat'],
						'type' => 'label',
						'value' => $result['add_date']
					),
					'registration_date' => array(
						'label' => $lng['domains']['registration_date'],
						'desc' => $lng['panel']['dateformat'],
						'type' => 'text',
						'value' => $result['registration_date'],
						'size' => 10
					),
					'termination_date' => array(
						'label' => $lng['domains']['termination_date'],
						'desc' => $lng['panel']['dateformat'],
						'type' => 'text',
						'value' => $result['termination_date'],
						'size' => 10
					)
				)
			),
			'section_b' => array(
				'title' => $lng['admin']['webserversettings'],
				'image' => 'icons/domain_edit.png',
				'fields' => array(
					'documentroot' => array(
						'visible' => ($userinfo['change_serversettings'] == '1' ? true : false),
						'label' => 'DocumentRoot',
						'desc' => $lng['panel']['emptyfordefault'],
						'type' => 'text',
						'value' => $result['documentroot']
					),
					'ipandport' => array(
						'label' => $lng['domains']['ipandport_multi']['title'],
						'desc' => $lng['domains']['ipandport_multi']['description'],
						'type' => 'checkbox',
						'values' => $ipsandports,
						'value' => $usedips,
						'is_array' => 1,
						'mandatory' => true
					),
					'selectserveralias' => array(
						'label' => $lng['admin']['selectserveralias'],
						'desc' => $lng['admin']['selectserveralias_desc'],
						'type' => 'select',
						'select_var' => $serveraliasoptions
					),
					'speciallogfile' => array(
						'label' => $lng['admin']['speciallogfile']['title'],
						'desc' => $lng['admin']['speciallogfile']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['speciallogfile']
						)
					),
					'specialsettings' => array(
						'visible' => ($userinfo['change_serversettings'] == '1' ? true : false),
						'style' => 'align-top',
						'label' => $lng['admin']['ownvhostsettings'],
						'desc' => $lng['serversettings']['default_vhostconf']['description'],
						'type' => 'textarea',
						'value' => $result['specialsettings'],
						'cols' => 60,
						'rows' => 12
					),
					'specialsettingsforsubdomains' => array(
						'visible' => ($userinfo['change_serversettings'] == '1' ? true : false),
						'label' => $lng['admin']['specialsettingsforsubdomains'],
						'desc' => $lng['serversettings']['specialsettingsforsubdomains']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							'1'
						)
					),
					'notryfiles' => array(
						'visible' => (\Froxlor\Settings::Get('system.webserver') == 'nginx' && $userinfo['change_serversettings'] == '1'),
						'label' => $lng['admin']['notryfiles']['title'],
						'desc' => $lng['admin']['notryfiles']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['notryfiles']
						)
					),
					'writeaccesslog' => array(
						'label' => $lng['admin']['writeaccesslog']['title'],
						'desc' => $lng['admin']['writeaccesslog']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['writeaccesslog']
						)
					),
					'writeerrorlog' => array(
						'label' => $lng['admin']['writeerrorlog']['title'],
						'desc' => $lng['admin']['writeerrorlog']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
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
				'title' => $lng['admin']['webserversettings_ssl'],
				'image' => 'icons/domain_edit.png',
				'visible' => \Froxlor\Settings::Get('system.use_ssl') == '1' ? true : false,
				'fields' => array(
					'ssl_ipandport' => array(
						'label' => $lng['domains']['ipandport_ssl_multi']['title'],
						'desc' => $lng['domains']['ipandport_ssl_multi']['description'],
						'type' => 'checkbox',
						'values' => $ssl_ipsandports,
						'value' => $usedips,
						'is_array' => 1
					),
					'ssl_redirect' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false),
						'label' => $lng['domains']['ssl_redirect']['title'],
						'desc' => $lng['domains']['ssl_redirect']['description'] . ($result['temporary_ssl_redirect'] > 1 ? $lng['domains']['ssl_redirect_temporarilydisabled'] : ''),
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['ssl_redirect']
						)
					),
					'letsencrypt' => array(
						'visible' => (\Froxlor\Settings::Get('system.leenabled') == '1' ? ($ssl_ipsandports != '' ? true : false) : false),
						'label' => $lng['admin']['letsencrypt']['title'],
						'desc' => $lng['admin']['letsencrypt']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['letsencrypt']
						)
					),
					'http2' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false) && \Froxlor\Settings::Get('system.webserver') != 'lighttpd' && \Froxlor\Settings::Get('system.http2_support') == '1',
						'label' => $lng['admin']['domain_http2']['title'],
						'desc' => $lng['admin']['domain_http2']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
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
						'value' => $lng['panel']['nosslipsavailable']
					),
					'hsts_maxage' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false),
						'label' => $lng['admin']['domain_hsts_maxage']['title'],
						'desc' => $lng['admin']['domain_hsts_maxage']['description'],
						'type' => 'int',
						'int_min' => 0,
						'int_max' => 94608000, // 3-years
						'value' => $result['hsts']
					),
					'hsts_sub' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false),
						'label' => $lng['admin']['domain_hsts_incsub']['title'],
						'desc' => $lng['admin']['domain_hsts_incsub']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['hsts_sub']
						)
					),
					'hsts_preload' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false),
						'label' => $lng['admin']['domain_hsts_preload']['title'],
						'desc' => $lng['admin']['domain_hsts_preload']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['hsts_preload']
						)
					),
					'ocsp_stapling' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false) && \Froxlor\Settings::Get('system.webserver') != 'lighttpd',
						'label' => $lng['admin']['domain_ocsp_stapling']['title'],
						'desc' => $lng['admin']['domain_ocsp_stapling']['description'] . (\Froxlor\Settings::Get('system.webserver') == 'nginx' ? $lng['admin']['domain_ocsp_stapling']['nginx_version_warning'] : ""),
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
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
				'title' => $lng['admin']['phpserversettings'],
				'image' => 'icons/domain_edit.png',
				'visible' => (($userinfo['change_serversettings'] == '1' || $userinfo['caneditphpsettings'] == '1') ? true : false),
				'fields' => array(
					'openbasedir' => array(
						'label' => 'OpenBasedir',
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['openbasedir']
						)
					),
					'phpenabled' => array(
						'label' => $lng['admin']['phpenabled'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['phpenabled']
						)
					),
					'phpsettingid' => array(
						'visible' => (((int) \Froxlor\Settings::Get('system.mod_fcgid') == 1 || (int) \Froxlor\Settings::Get('phpfpm.enabled') == 1) ? true : false),
						'label' => $lng['admin']['phpsettings']['title'],
						'type' => 'select',
						'select_var' => $phpconfigs
					),
					'phpsettingsforsubdomains' => array(
						'visible' => ($userinfo['change_serversettings'] == '1' ? true : false),
						'label' => $lng['admin']['phpsettingsforsubdomains'],
						'desc' => $lng['serversettings']['phpsettingsforsubdomains']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							'1'
						)
					),
					'mod_fcgid_starter' => array(
						'visible' => ((int) \Froxlor\Settings::Get('system.mod_fcgid') == 1 ? true : false),
						'label' => $lng['admin']['mod_fcgid_starter']['title'],
						'type' => 'text',
						'value' => ((int) $result['mod_fcgid_starter'] != - 1 ? $result['mod_fcgid_starter'] : '')
					),
					'mod_fcgid_maxrequests' => array(
						'visible' => ((int) \Froxlor\Settings::Get('system.mod_fcgid') == 1 ? true : false),
						'label' => $lng['admin']['mod_fcgid_maxrequests']['title'],
						'type' => 'text',
						'value' => ((int) $result['mod_fcgid_maxrequests'] != - 1 ? $result['mod_fcgid_maxrequests'] : '')
					)
				)
			),
			'section_d' => array(
				'title' => $lng['admin']['nameserversettings'],
				'image' => 'icons/domain_edit.png',
				'visible' => (\Froxlor\Settings::Get('system.bind_enable') == '1' && $userinfo['change_serversettings'] == '1' ? true : false),
				'fields' => array(
					'isbinddomain' => array(
						'label' => 'Nameserver',
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['isbinddomain']
						)
					),
					'zonefile' => array(
						'label' => 'Zonefile',
						'desc' => $lng['admin']['bindzonewarning'],
						'type' => 'text',
						'value' => $result['zonefile']
					)
				)
			),
			'section_e' => array(
				'title' => $lng['admin']['mailserversettings'],
				'image' => 'icons/domain_edit.png',
				'fields' => array(
					'isemaildomain' => array(
						'label' => $lng['admin']['emaildomain'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['isemaildomain']
						)
					),
					'email_only' => array(
						'label' => $lng['admin']['email_only'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['email_only']
						)
					),
					'subcanemaildomain' => array(
						'label' => $lng['admin']['subdomainforemail'],
						'type' => 'select',
						'select_var' => $subcanemaildomain
					),
					'dkim' => array(
						'visible' => (\Froxlor\Settings::Get('dkim.use_dkim') == '1' ? true : false),
						'label' => 'DomainKeys',
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
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
