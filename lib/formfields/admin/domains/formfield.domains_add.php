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
	'domain_add' => array(
		'title' => $lng['admin']['domain_add'],
		'image' => 'fa-solid fa-globe',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['domains']['domainsettings'],
				'image' => 'icons/domain_add.png',
				'fields' => array(
					'domain' => array(
						'label' => 'Domain',
						'type' => 'text',
						'mandatory' => true
					),
					'customerid' => array(
						'label' => $lng['admin']['customer'],
						'type' => 'select',
						'select_var' => $customers,
						'mandatory' => true
					),
					'adminid' => array(
						'visible' => ($userinfo['customers_see_all'] == '1' ? true : false),
						'label' => $lng['admin']['admin'],
						'type' => 'select',
						'select_var' => $admins,
						'mandatory' => true
					),
					'alias' => array(
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
					'caneditdomain' => array(
						'label' => $lng['admin']['domain_editable']['title'],
						'desc' => $lng['admin']['domain_editable']['desc'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => true
					),
					'add_date' => array(
						'label' => $lng['domains']['add_date'],
						'desc' => $lng['panel']['dateformat'],
						'type' => 'label',
						'value' => $add_date
					),
					'registration_date' => array(
						'label' => $lng['domains']['registration_date'],
						'desc' => $lng['panel']['dateformat'],
						'type' => 'text',
						'size' => 10
					),
					'termination_date' => array(
						'label' => $lng['domains']['termination_date'],
						'desc' => $lng['panel']['dateformat'],
						'type' => 'text',
						'size' => 10
					)
				)
			),
			'section_b' => array(
				'title' => $lng['admin']['webserversettings'],
				'image' => 'icons/domain_add.png',
				'fields' => array(
					'documentroot' => array(
						'visible' => ($userinfo['change_serversettings'] == '1' ? true : false),
						'label' => 'DocumentRoot',
						'desc' => $lng['panel']['emptyfordefault'],
						'type' => 'text'
					),
					'ipandport' => array(
						'label' => $lng['domains']['ipandport_multi']['title'],
						'desc' => $lng['domains']['ipandport_multi']['description'],
						'type' => 'checkbox',
						'values' => $ipsandports,
						'value' => explode(',', \Froxlor\Settings::Get('system.defaultip')),
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
						'value' => '1',
						'checked' => false
					),
					'specialsettings' => array(
						'visible' => ($userinfo['change_serversettings'] == '1' ? true : false),
						'label' => $lng['admin']['ownvhostsettings'],
						'desc' => $lng['serversettings']['default_vhostconf']['description'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12
					),
					'notryfiles' => array(
						'visible' => (\Froxlor\Settings::Get('system.webserver') == 'nginx' && $userinfo['change_serversettings'] == '1'),
						'label' => $lng['admin']['notryfiles']['title'],
						'desc' => $lng['admin']['notryfiles']['description'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					),
					'writeaccesslog' => array(
						'label' => $lng['admin']['writeaccesslog']['title'],
						'desc' => $lng['admin']['writeaccesslog']['description'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => true
					),
					'writeerrorlog' => array(
						'label' => $lng['admin']['writeerrorlog']['title'],
						'desc' => $lng['admin']['writeerrorlog']['description'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => true
					)
				)
			),
			'section_bssl' => array(
				'title' => $lng['admin']['webserversettings_ssl'],
				'image' => 'icons/domain_add.png',
				'visible' => \Froxlor\Settings::Get('system.use_ssl') == '1' ? true : false,
				'fields' => array(
					'sslenabled' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false),
						'label' => $lng['admin']['domain_sslenabled'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => true
					),
					'no_ssl_available_info' => array(
						'visible' => ($ssl_ipsandports == '' ? true : false),
						'label' => 'SSL',
						'type' => 'label',
						'value' => $lng['panel']['nosslipsavailable']
					),
					'ssl_ipandport' => array(
						'label' => $lng['domains']['ipandport_ssl_multi']['title'],
						'desc' => $lng['domains']['ipandport_ssl_multi']['description'],
						'type' => 'checkbox',
						'values' => $ssl_ipsandports,
						'value' => explode(',', \Froxlor\Settings::Get('system.defaultsslip')),
						'is_array' => 1
					),
					'ssl_redirect' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false),
						'label' => $lng['domains']['ssl_redirect']['title'],
						'desc' => $lng['domains']['ssl_redirect']['description'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					),
					'letsencrypt' => array(
						'visible' => (\Froxlor\Settings::Get('system.leenabled') == '1' ? ($ssl_ipsandports != '' ? true : false) : false),
						'label' => $lng['admin']['letsencrypt']['title'],
						'desc' => $lng['admin']['letsencrypt']['description'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					),
					'http2' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false) && \Froxlor\Settings::Get('system.webserver') != 'lighttpd' && \Froxlor\Settings::Get('system.http2_support') == '1',
						'label' => $lng['admin']['domain_http2']['title'],
						'desc' => $lng['admin']['domain_http2']['description'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					),
					'override_tls' => array(
						'visible' => (($ssl_ipsandports != '' ? true : false) && $userinfo['change_serversettings'] == '1' ? true : false),
						'label' => $lng['admin']['domain_override_tls'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					),
					'ssl_protocols' => array(
						'visible' => (($ssl_ipsandports != '' ? true : false) && $userinfo['change_serversettings'] == '1' && \Froxlor\Settings::Get('system.webserver') != 'lighttpd' ? true : false),
						'label' => $lng['serversettings']['ssl']['ssl_protocols']['title'],
						'desc' => $lng['serversettings']['ssl']['ssl_protocols']['description'],
						'type' => 'checkbox',
						'value' => array(
							'TLSv1.2'
						),
						'values' => array(
							array(
								'value' => 'TLSv1',
								'label' => 'TLSv1'
							),
							array(
								'value' => 'TLSv1.1',
								'label' => 'TLSv1.1'
							),
							array(
								'value' => 'TLSv1.2',
								'label' => 'TLSv1.2'
							),
							array(
								'value' => 'TLSv1.3',
								'label' => 'TLSv1.3<'
							)
						),
						'is_array' => 1
					),
					'ssl_cipher_list' => array(
						'visible' => (($ssl_ipsandports != '' ? true : false) && $userinfo['change_serversettings'] == '1' ? true : false),
						'label' => $lng['serversettings']['ssl']['ssl_cipher_list']['title'],
						'desc' => $lng['serversettings']['ssl']['ssl_cipher_list']['description'],
						'type' => 'text',
						'value' => \Froxlor\Settings::Get('system.ssl_cipher_list')
					),
					'tlsv13_cipher_list' => array(
						'visible' => (($ssl_ipsandports != '' ? true : false) && $userinfo['change_serversettings'] == '1' && \Froxlor\Settings::Get('system.webserver') == "apache2" && \Froxlor\Settings::Get('system.apache24') == 1 ? true : false),
						'label' => $lng['serversettings']['ssl']['tlsv13_cipher_list']['title'],
						'desc' => $lng['serversettings']['ssl']['tlsv13_cipher_list']['description'],
						'type' => 'text',
						'value' => \Froxlor\Settings::Get('system.tlsv13_cipher_list')
					),
					'ssl_specialsettings' => array(
						'visible' => (($ssl_ipsandports != '' ? true : false) && $userinfo['change_serversettings'] == '1' ? true : false),
						'label' => $lng['admin']['ownsslvhostsettings'],
						'desc' => $lng['serversettings']['default_vhostconf']['description'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12
					),
					'include_specialsettings' => array(
						'visible' => (($ssl_ipsandports != '' ? true : false) && $userinfo['change_serversettings'] == '1' ? true : false),
						'label' => $lng['admin']['include_ownvhostsettings'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					),
					'hsts_maxage' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false),
						'label' => $lng['admin']['domain_hsts_maxage']['title'],
						'desc' => $lng['admin']['domain_hsts_maxage']['description'],
						'type' => 'number',
						'min' => 0,
						'max' => 94608000, // 3-years
						'value' => 0
					),
					'hsts_sub' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false),
						'label' => $lng['admin']['domain_hsts_incsub']['title'],
						'desc' => $lng['admin']['domain_hsts_incsub']['description'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					),
					'hsts_preload' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false),
						'label' => $lng['admin']['domain_hsts_preload']['title'],
						'desc' => $lng['admin']['domain_hsts_preload']['description'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					),
					'ocsp_stapling' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false) && \Froxlor\Settings::Get('system.webserver') != 'lighttpd',
						'label' => $lng['admin']['domain_ocsp_stapling']['title'],
						'desc' => $lng['admin']['domain_ocsp_stapling']['description'] . (\Froxlor\Settings::Get('system.webserver') == 'nginx' ? $lng['admin']['domain_ocsp_stapling']['nginx_version_warning'] : ""),
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					),
					'honorcipherorder' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false),
						'label' => $lng['admin']['domain_honorcipherorder'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					),
					'sessiontickets' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false) && \Froxlor\Settings::Get('system.webserver') != 'lighttpd' && \Froxlor\Settings::Get('system.sessionticketsenabled' != '1'),
						'label' => $lng['admin']['domain_sessiontickets'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => true
					)
				)
			),
			'section_c' => array(
				'title' => $lng['admin']['phpserversettings'],
				'image' => 'icons/domain_add.png',
				'visible' => (($userinfo['change_serversettings'] == '1' || $userinfo['caneditphpsettings'] == '1') ? true : false),
				'fields' => array(
					'openbasedir' => array(
						'label' => 'OpenBasedir',
						'type' => 'checkbox',
						'value' => '1',
						'checked' => true
					),
					'phpenabled' => array(
						'label' => $lng['admin']['phpenabled'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => true
					),
					'phpsettingid' => array(
						'visible' => (((int) \Froxlor\Settings::Get('system.mod_fcgid') == 1 || (int) \Froxlor\Settings::Get('phpfpm.enabled') == 1) ? true : false),
						'label' => $lng['admin']['phpsettings']['title'],
						'type' => 'select',
						'select_var' => $phpconfigs,
						'selected' => '@TODO'
					),
					'mod_fcgid_starter' => array(
						'visible' => ((int) \Froxlor\Settings::Get('system.mod_fcgid') == 1 ? true : false),
						'label' => $lng['admin']['mod_fcgid_starter']['title'],
						'type' => 'number'
					),
					'mod_fcgid_maxrequests' => array(
						'visible' => ((int) \Froxlor\Settings::Get('system.mod_fcgid') == 1 ? true : false),
						'label' => $lng['admin']['mod_fcgid_maxrequests']['title'],
						'type' => 'number'
					)
				)
			),
			'section_d' => array(
				'title' => $lng['admin']['nameserversettings'],
				'image' => 'icons/domain_add.png',
				'visible' => (\Froxlor\Settings::Get('system.bind_enable') == '1' && $userinfo['change_serversettings'] == '1' ? true : false),
				'fields' => array(
					'isbinddomain' => array(
						'label' => 'Nameserver',
						'type' => 'checkbox',
						'value' => '1',
						'checked' => true
					),
					'zonefile' => array(
						'label' => 'Zonefile',
						'desc' => $lng['admin']['bindzonewarning'],
						'type' => 'text'
					)
				)
			),
			'section_e' => array(
				'title' => $lng['admin']['mailserversettings'],
				'image' => 'icons/domain_add.png',
				'fields' => array(
					'isemaildomain' => array(
						'label' => $lng['admin']['emaildomain'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => true
					),
					'email_only' => array(
						'label' => $lng['admin']['email_only'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					),
					'subcanemaildomain' => array(
						'label' => $lng['admin']['subdomainforemail'],
						'type' => 'select',
						'select_var' => $subcanemaildomain,
						'selected' => '@TODO'
					),
					'dkim' => array(
						'visible' => (\Froxlor\Settings::Get('dkim.use_dkim') == '1' ? true : false),
						'label' => 'DomainKeys',
						'type' => 'checkbox',
						'value' => '1',
						'checked' => true
					)
				)
			)
		)
	)
);
