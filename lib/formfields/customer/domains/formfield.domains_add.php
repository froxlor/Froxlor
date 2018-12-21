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
		'title' => \Froxlor\I18N\Lang::getAll()['domains']['subdomain_add'],
		'image' => 'icons/domain_add.png',
		'sections' => array(
			'section_a' => array(
				'title' => \Froxlor\I18N\Lang::getAll()['domains']['subdomain_add'],
				'image' => 'icons/domain_add.png',
				'fields' => array(
					'subdomain' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['domains']['domainname'],
						'type' => 'textul',
						'ul_field' => '',
						'has_nextto' => true
					),
					'domain' => array(
						'next_to' => 'subdomain',
						'next_to_prefix' => '&nbsp;.&nbsp;',
						'type' => 'select',
						'select_var' => $domains
					),
					'alias' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['domains']['aliasdomain'],
						'type' => 'select',
						'select_var' => $aliasdomains
					),
					'path' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['panel']['path'],
						'desc' => (\Froxlor\Settings::Get('panel.pathedit') != 'Dropdown' ? \Froxlor\I18N\Lang::getAll()['panel']['pathDescriptionSubdomain'] : null) . (isset($pathSelect['note']) ? $pathSelect['note'] . '<br />' . $pathSelect['value'] : ''),
						'type' => $pathSelect['type'],
						'select_var' => $pathSelect['value'],
						'value' => $pathSelect['value']
					),
					'url' => array(
						'visible' => (\Froxlor\Settings::Get('panel.pathedit') == 'Dropdown' ? true : false),
						'label' => \Froxlor\I18N\Lang::getAll()['panel']['urloverridespath'],
						'type' => 'text'
					),
					'redirectcode' => array(
						'visible' => (\Froxlor\Settings::Get('customredirect.enabled') == '1' ? true : false),
						'label' => \Froxlor\I18N\Lang::getAll()['domains']['redirectifpathisurl'],
						'desc' => \Froxlor\I18N\Lang::getAll()['domains']['redirectifpathisurlinfo'],
						'type' => 'select',
						'select_var' => isset($redirectcode) ? $redirectcode : null
					),
					'selectserveralias' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['selectserveralias'],
						'desc' => \Froxlor\I18N\Lang::getAll()['admin']['selectserveralias_desc'],
						'type' => 'label',
						'value' => \Froxlor\I18N\Lang::getAll()['customer']['selectserveralias_addinfo']
					),
					'openbasedir_path' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['domain']['openbasedirpath'],
						'type' => 'select',
						'select_var' => $openbasedir
					),
					'phpsettingid' => array(
						'visible' => (((int) \Froxlor\Settings::Get('system.mod_fcgid') == 1 || (int) \Froxlor\Settings::Get('phpfpm.enabled') == 1) && $has_phpconfigs ? true : false),
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['phpsettings']['title'],
						'type' => 'select',
						'select_var' => $phpconfigs
					)
				)
			),
			'section_bssl' => array(
				'title' => \Froxlor\I18N\Lang::getAll()['admin']['webserversettings_ssl'],
				'image' => 'icons/domain_add.png',
				'visible' => \Froxlor\Settings::Get('system.use_ssl') == '1' ? ($ssl_ipsandports != '' ? true : false) : false,
				'fields' => array(
					'ssl_redirect' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['domains']['ssl_redirect']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['domains']['ssl_redirect']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array()
					),
					'letsencrypt' => array(
						'visible' => (\Froxlor\Settings::Get('system.leenabled') == '1' ? true : false),
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['letsencrypt']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['customer']['letsencrypt']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array()
					),
					'hsts_maxage' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['domain_hsts_maxage']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['admin']['domain_hsts_maxage']['description'],
						'type' => 'int',
						'int_min' => 0,
						'int_max' => 94608000, // 3-years
						'value' => 0
					),
					'hsts_sub' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['domain_hsts_incsub']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['admin']['domain_hsts_incsub']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array()
					),
					'hsts_preload' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['domain_hsts_preload']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['admin']['domain_hsts_preload']['description'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array()
					)
				)
			)
		)
	)
);
