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
						'mandatory' => true,
					),
					'customerid' => array(
						'label' => $lng['admin']['customer'],
						'type' => ($settings['panel']['allow_domain_change_customer'] == '1' ? 'select' : 'label'),
						'select_var' => (isset($customers) ? $customers : null),
						'value' => (isset($result['customername']) ? $result['customername'] : null),
						'mandatory' => true,
					),
					'adminid' => array(
						'visible' => ($userinfo['customers_see_all'] == '1' ? true : false),
						'label' => $lng['admin']['admin'],
						'type' => ($settings['panel']['allow_domain_change_admin'] == '1' ? 'select' : 'label'),
						'select_var' => (isset($admins) ? $admins : null),
						'value' => (isset($result['adminname']) ? $result['adminname'] : null),
						'mandatory' => true,
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
						'value' => $subdomains.' '.$lng['customer']['subdomains'].', '.$alias_check.' '.$lng['domains']['aliasdomains'].', '.$emails.' '.$lng['customer']['emails'].', '.$email_accounts.' '.$lng['customer']['accounts'].', '.$email_forwarders.' '.$lng['customer']['forwarders']
					),
					'caneditdomain' => array(
						'label' => $lng['admin']['domain_edit'],
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array($result['caneditdomain'])
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
						'label' => 'IP/Port',
						'type' => 'select',
						'select_var' => $ipsandports,
						'mandatory' => true,
					),

					'wwwserveralias' => array(
						'label' => $lng['admin']['wwwserveralias'],
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array($result['wwwserveralias'])
					),
					'speciallogfile' => array(
						'label' => 'Speciallogfile',
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array($result['speciallogfile'])
					),
					'specialsettings' => array(
						'visible' => ($userinfo['change_serversettings'] == '1' ? true : false),
						'style' => 'vertical-align:top;',
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
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array('1')
					)
				)
			),

			// Begin: SSL-Settings
			'section_c' => array(

			  'title' => $lng['admin']['ssl_settings'],

			  'image' => 'icons/domain_edit.png',

			  'visible' => $settings['use_ssl'],

			  'fields' => array(

			    'no_ssl_available_info' => array(
			      'visible' => !$ssl_ipsandports,
			      'label' => 'SSL',
			      'type' => 'label',
			      'value' => $lng['panel']['nosslipsavailable']
			      ),

			    'ssl_domain_yesno' => array(
			      'visible' => $ssl_ipsandports,
			      'label' => 'SSL Domain',
			      'type' => 'checkbox',
			      'values' => array( array('label' => $lng['panel']['yes'], 'value' => true) ),
			      'value' => array($result['ssl'])
			    ),

			    'ssl_redirect' => array(
			      'visible' => $ssl_ipsandports,
			      'label' => 'SSL Redirect',
			      'type' => 'checkbox',
			      'values' => array( array('label' => $lng['panel']['yes'], 'value' => true) ),
			      'value' => array($result['ssl_redirect'])
			    ),

			    'ssl_ipandport' => array(
			      'visible' => $ssl_ipsandports,
			      'label' => 'SSL IP/Port',
			      'type' => 'select',
			      'select_var' => $ssl_ipsandports
			    ),

			    'ssl_ca' => array(
			      'visible' => $ssl_ipsandports,
			      'label' => 'Certificate Authority',
			      'desc' => 'Path to Certificate Authority file',
			      'type' => 'text',
			      'value' => ( $result['ssl_ca'] ) ? $result['ssl_ca'] : ( $settings['ssl_ca_file'] ) ? $settings['ssl_ca_file'] : null
			    ),

			    'ssl_chain' => array(
			      'visible' => $ssl_ipsandports,
			      'label' => 'Certificate Chain',
			      'desc' => 'Path to Certificate Chain file',
			      'type' => 'text',
			      'value' => ( $result['ssl_chain'] ) ? $result['ssl_chain'] : ( $settings['ssl_cert_chainfile'] ) ? $settings['ssl_cert_chainfile'] : null
			    ),

			    'ssl_cert' => array(
			      'visible' => $ssl_ipsandports,
			      'label' => 'Domain Certificate',
			      'desc' => 'Path to Domain Certificate file',
			      'type' => 'text',
			      'value' => ( $result['ssl_cert'] ) ? $result['ssl_cert'] : ( $settings['ssl_cert_file'] ) ? $settings['ssl_cert_file'] : null
			    ),

			    'ssl_key' => array(
			      'visible' => $ssl_ipsandports,
			      'label' => 'Certificate Key',
			      'desc' => 'Path to Certificate Key file',
			      'type' => 'text',
			      'value' => ( $result['ssl_key'] ) ? $result['ssl_key'] : ( $settings['ssl_key_file'] ) ? $settings['ssl_key_file'] : null
			    )

			  )

			),
			// End: SSL-Settings

			'section_d' => array(
				'title' => $lng['admin']['phpserversettings'],
				'image' => 'icons/domain_edit.png',
				'visible' => (($userinfo['change_serversettings'] == '1' || $userinfo['caneditphpsettings'] == '1') ? true : false),
				'fields' => array(
					'openbasedir' => array(
						'label' => 'OpenBasedir',
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array($result['openbasedir'])
					),
					'phpsettingid' => array(
						'visible' => ((int)$settings['system']['mod_fcgid'] == 1 ? true : false),
						'label' => $lng['admin']['phpsettings']['title'],
						'type' => 'select',
						'select_var' => $phpconfigs
					),
					'mod_fcgid_starter' => array(
						'visible' => ((int)$settings['system']['mod_fcgid'] == 1 ? true : false),
						'label' => $lng['admin']['mod_fcgid_starter']['title'],
						'type' => 'text',
						'value' => ((int)$result['mod_fcgid_starter'] != - 1 ? $result['mod_fcgid_starter'] : '')
					),
					'mod_fcgid_maxrequests' => array(
						'visible' => ((int)$settings['system']['mod_fcgid'] == 1 ? true : false),
						'label' => $lng['admin']['mod_fcgid_maxrequests']['title'],
						'type' => 'text',
						'value' => ((int)$result['mod_fcgid_maxrequests'] != - 1 ? $result['mod_fcgid_maxrequests'] : '')
					)
				)
			),
			'section_e' => array(
				'title' => $lng['admin']['nameserversettings'],
				'image' => 'icons/domain_edit.png',
				'visible' => ($settings['system']['bind_enable'] == '1' && $userinfo['change_serversettings'] == '1' ? true : false),
				'fields' => array(
					'isbinddomain' => array(
						'label' => 'Nameserver',
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array($result['isbinddomain'])
					),
					'zonefile' => array(
						'label' => 'Zonefile',
						'desc' => $lng['panel']['emptyfordefault'],
						'type' => 'text',
						'value' => $result['zonefile']
					)
				)
			),
			'section_f' => array(
				'title' => $lng['admin']['mailserversettings'],
				'image' => 'icons/domain_edit.png',
				'fields' => array(
					'isemaildomain' => array(
						'label' => $lng['admin']['emaildomain'],
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array($result['isemaildomain'])
					),
					'email_only' => array(
						'label' => $lng['admin']['email_only'],
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array($result['email_only'])
					),
					'subcanemaildomain' => array(
						'label' => $lng['admin']['subdomainforemail'],
						'type' => 'select',
						'select_var' => $subcanemaildomain
					),
					'dkim' => array(
						'visible' => ($settings['dkim']['use_dkim'] == '1' ? true : false),
						'label' => 'DomainKeys',
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array($result['dkim'])
					)
				)
			)
		)
	)
);
