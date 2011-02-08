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
 * @version    $Id: formfield.domains_add.php 112 2010-12-14 12:11:20Z d00p $
 */

return array(
	'domain_add' => array(
		'title' => $lng['admin']['domain_add'],
		'image' => 'icons/add_domain.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['domains']['domainsettings'],
				'image' => 'icons/add_domain.png',
				'fields' => array(
					'domain' => array(
						'label' => 'Domain',
						'type' => 'text'
					),
					'customerid' => array(
						'label' => $lng['admin']['customer'],
						'type' => 'select',
						'select_var' => $customers
					),
					'adminid' => array(
						'visible' => ($userinfo['customers_see_all'] == '1' ? true : false),
						'label' => $lng['admin']['admin'],
						'type' => 'select',
						'select_var' => $admins
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
						'type' => 'yesno',
						'yesno_var' => $caneditdomain
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
				'image' => 'icons/add_domain.png',
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
					),
					'ssl' => array(
						'visible' => ($settings['system']['use_ssl'] == '1' ? ($ssl_ipsandports != '' ? true : false) : false),
						'label' => 'SSL',
						'type' => 'yesno',
						'yesno_var' => $ssl
					),
					'ssl_redirect' => array(
						'visible' => ($settings['system']['use_ssl'] == '1' ? ($ssl_ipsandports != '' ? true : false) : false),
						'label' => 'SSL Redirect',
						'type' => 'yesno',
						'yesno_var' => $ssl_redirect
					),
					'ssl_ipandport' => array(
						'visible' => ($settings['system']['use_ssl'] == '1' ? ($ssl_ipsandports != '' ? true : false) : false),
						'label' => 'SSL IP/Port',
						'type' => 'select',
						'select_var' => $ssl_ipsandports
					),
					'no_ssl_available_info' => array(
						'visible' => ($settings['system']['use_ssl'] == '1' ? ($ssl_ipsandports == '' ? true : false) : false),
						'label' => 'SSL',
						'type' => 'label',
						'value' => $lng['panel']['nosslipsavailable']
					),
					'wwwserveralias' => array(
						'label' => $lng['admin']['wwwserveralias'],
						'type' => 'yesno',
						'yesno_var' => $wwwserveralias
					),
					'speciallogfile' => array(
						'label' => 'Speciallogfile',
						'type' => 'yesno',
						'yesno_var' => $speciallogfile
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
			'section_c' => array(
				'title' => $lng['admin']['phpserversettings'],
				'image' => 'icons/add_domain.png',
				'visible' => (($userinfo['change_serversettings'] == '1' || $userinfo['caneditphpsettings'] == '1') ? true : false),
				'fields' => array(
					'openbasedir' => array(
						'label' => 'OpenBasedir',
						'type' => 'yesno',
						'yesno_var' => $openbasedir
					),
					'safemode' => array(
						'label' => 'Safemode',
						'type' => 'yesno',
						'yesno_var' => $safemode
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
			'section_d' => array(
				'title' => $lng['admin']['nameserversettings'],
				'image' => 'icons/add_domain.png',
				'visible' => ($userinfo['change_serversettings'] == '1' ? true : false),
				'fields' => array(
					'isbinddomain' => array(
						'label' => 'Nameserver',
						'type' => 'yesno',
						'yesno_var' => $isbinddomain
					),
					'zonefile' => array(
						'label' => 'Zonefile',
						'desc' => $lng['panel']['emptyfordefault'],
						'type' => 'text'
					)
				)
			),
			'section_e' => array(
				'title' => $lng['admin']['mailserversettings'],
				'image' => 'icons/add_domain.png',
				'fields' => array(
					'isemaildomain' => array(
						'label' => $lng['admin']['emaildomain'],
						'type' => 'yesno',
						'yesno_var' => $isemaildomain
					),
					'email_only' => array(
						'label' => $lng['admin']['email_only'],
						'type' => 'yesno',
						'yesno_var' => $email_only
					),
					'subcanemaildomain' => array(
						'label' => $lng['admin']['subdomainforemail'],
						'type' => 'select',
						'select_var' => $subcanemaildomain
					),
					'dkim' => array(
						'visible' => ($settings['dkim']['use_dkim'] == '1' ? true : false),
						'label' => 'DomainKeys',
						'type' => 'yesno',
						'yesno_var' => $dkim
					)
				)
			)
		)
	)
);
