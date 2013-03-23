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
						'mandatory' => true,
					),
					'customerid' => array(
						'label' => $lng['admin']['customer'],
						'type' => 'select',
						'select_var' => $customers,
						'mandatory' => true,
					),
					'adminid' => array(
						'visible' => ($userinfo['customers_see_all'] == '1' ? true : false),
						'label' => $lng['admin']['admin'],
						'type' => 'select',
						'select_var' => $admins,
						'mandatory' => true,
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
						'label' => $lng['admin']['domain_edit'],
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array('1')
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
						'value' => array('1')
					),
					'speciallogfile' => array(
						'label' => 'Speciallogfile',
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array()
					),
					'specialsettings' => array(
						'visible' => ($userinfo['change_serversettings'] == '1' ? true : false),
						'style' => 'vertical-align:top;',
						'label' => $lng['admin']['ownvhostsettings'],
						'desc' => $lng['serversettings']['default_vhostconf']['description'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12
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
				'image' => 'icons/domain_add.png',
				'visible' => (($userinfo['change_serversettings'] == '1' || $userinfo['caneditphpsettings'] == '1') ? true : false),
				'fields' => array(
					'openbasedir' => array(
						'label' => 'OpenBasedir',
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array('1')
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
						'type' => 'text'
					),
					'mod_fcgid_maxrequests' => array(
						'visible' => ((int)$settings['system']['mod_fcgid'] == 1 ? true : false),
						'label' => $lng['admin']['mod_fcgid_maxrequests']['title'],
						'type' => 'text'
					)
				)
			),
			'section_e' => array(
				'title' => $lng['admin']['nameserversettings'],
				'image' => 'icons/domain_add.png',
				'visible' => ($settings['system']['bind_enable'] == '1' && $userinfo['change_serversettings'] == '1' ? true : false),
				'fields' => array(
					'isbinddomain' => array(
						'label' => 'Nameserver',
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array('1')
					),
					'zonefile' => array(
						'label' => 'Zonefile',
						'desc' => $lng['panel']['emptyfordefault'],
						'type' => 'text'
					)
				)
			),
			'section_f' => array(
				'title' => $lng['admin']['mailserversettings'],
				'image' => 'icons/domain_add.png',
				'fields' => array(
					'isemaildomain' => array(
						'label' => $lng['admin']['emaildomain'],
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array('1')
					),
					'email_only' => array(
						'label' => $lng['admin']['email_only'],
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array()
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
						'value' => array('1')
					)
				)
			)
		)
	)
);
