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
		'image' => 'icons/domain_add.png',
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
						'value' => explode(',', Settings::Get('system.defaultip')),
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
						'value' => array()
					),
					'specialsettings' => array(
						'visible' => ($userinfo['change_serversettings'] == '1' ? true : false),
						'style' => 'align-top',
						'label' => $lng['admin']['ownvhostsettings'],
						'desc' => $lng['serversettings']['default_vhostconf']['description'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12
					)
				)
			),
			'section_bssl' => array(
				'title' => $lng['admin']['webserversettings_ssl'],
				'image' => 'icons/domain_add.png',
				'visible' => Settings::Get('system.use_ssl') == '1' ? true : false,
				'fields' => array(
					'ssl_ipandport' => array(
						'label' => $lng['domains']['ipandport_ssl_multi']['title'],
						'desc' => $lng['domains']['ipandport_ssl_multi']['description'],
						'type' => 'checkbox',
						'values' => $ssl_ipsandports,
						'value' => '',
						'is_array' => 1
					),
					'ssl_redirect' => array(
						'visible' => ($ssl_ipsandports != '' ? true : false),
						'label' => $lng['domains']['ssl_redirect']['title'],
						'desc' => $lng['domains']['ssl_redirect']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array()
					),
					'letsencrypt' => array(
						'visible' => (Settings::Get('system.leenabled') == '1' ? ($ssl_ipsandports != '' ? true : false) : false),
						'label' => $lng['admin']['letsencrypt']['title'],
						'desc' => $lng['admin']['letsencrypt']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array()
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
						'value' => 0
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
						'value' => array()
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
						'value' => array()
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
							'1'
						)
					),
					'phpsettingid' => array(
						'visible' => (((int) Settings::Get('system.mod_fcgid') == 1 || (int) Settings::Get('phpfpm.enabled') == 1) ? true : false),
						'label' => $lng['admin']['phpsettings']['title'],
						'type' => 'select',
						'select_var' => $phpconfigs
					),
					'mod_fcgid_starter' => array(
						'visible' => ((int) Settings::Get('system.mod_fcgid') == 1 ? true : false),
						'label' => $lng['admin']['mod_fcgid_starter']['title'],
						'type' => 'text'
					),
					'mod_fcgid_maxrequests' => array(
						'visible' => ((int) Settings::Get('system.mod_fcgid') == 1 ? true : false),
						'label' => $lng['admin']['mod_fcgid_maxrequests']['title'],
						'type' => 'text'
					)
				)
			),
			'section_d' => array(
				'title' => $lng['admin']['nameserversettings'],
				'image' => 'icons/domain_add.png',
				'visible' => (Settings::Get('system.bind_enable') == '1' && $userinfo['change_serversettings'] == '1' ? true : false),
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
							'1'
						)
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
					'email_only' => array(
						'label' => $lng['admin']['email_only'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array()
					),
					'subcanemaildomain' => array(
						'label' => $lng['admin']['subdomainforemail'],
						'type' => 'select',
						'select_var' => $subcanemaildomain
					),
					'dkim' => array(
						'visible' => (Settings::Get('dkim.use_dkim') == '1' ? true : false),
						'label' => 'DomainKeys',
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
					)
				)
			)
		)
	)
);
