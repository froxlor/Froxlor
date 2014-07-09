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
		'title' => $lng['domains']['subdomain_add'],
		'image' => 'icons/domain_add.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['domains']['subdomain_add'],
				'image' => 'icons/domain_add.png',
				'fields' => array(
					'subdomain' => array(
						'label' => $lng['domains']['domainname'],
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
						'label' => $lng['domains']['aliasdomain'],
						'type' => 'select',
						'select_var' => $aliasdomains
					),
					'path' => array(
						'label' => $lng['panel']['path'],
						'desc' => (Settings::Get('panel.pathedit') != 'Dropdown' ? $lng['panel']['pathDescriptionSubdomain'] : null).(isset($pathSelect['note']) ? $pathSelect['note'].'<br />'.$pathSelect['value'] : ''),
						'type' => $pathSelect['type'],
						'select_var' => $pathSelect['value'],
						'value' => $pathSelect['value']
					),
					'url' => array(
						'visible' => (Settings::Get('panel.pathedit') == 'Dropdown' ? true : false),
						'label' => $lng['panel']['urloverridespath'],
						'type' => 'text'
					),
					'redirectcode' => array(
						'visible' => ((Settings::Get('system.webserver') == 'apache2' && Settings::Get('customredirect.enabled') == '1') ? true : false),
						'label' => $lng['domains']['redirectifpathisurl'],
						'desc' => $lng['domains']['redirectifpathisurlinfo'],
						'type' => 'select',
						'select_var' => isset($redirectcode) ? $redirectcode : null
					),
					'ssl_redirect' => array(
						'visible' => (Settings::Get('system.use_ssl') == '1' ? ($ssl_ipsandports != '' ? true : false) : false),
						'label' => $lng['domains']['ssl_redirect']['title'],
						'desc' => $lng['domains']['ssl_redirect']['description'],
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array()
					),
					'openbasedir_path' => array(
						'label' => $lng['domain']['openbasedirpath'],
						'type' => 'select',
						'select_var' => $openbasedir
					)
				)
			)
		)
	)
);
