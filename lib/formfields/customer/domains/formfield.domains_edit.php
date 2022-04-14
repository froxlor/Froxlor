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
		'title' => $lng['domains']['subdomain_edit'],
		'image' => 'fa-solid fa-pen',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['domains']['subdomain_edit'],
				'image' => 'icons/domain_edit.png',
				'fields' => array(
					'domain' => array(
						'label' => $lng['domains']['domainname'],
						'type' => 'label',
						'value' => $result['domain']
					),
					'dns' => array(
						'label' => $lng['dns']['destinationip'],
						'type' => 'itemlist',
						'values' => $domainips
					),
					'alias' => array(
						'visible' => $alias_check == '0',
						'label' => $lng['domains']['aliasdomain'],
						'type' => 'select',
						'select_var' => $domains,
						'selected' => $result['aliasdomain']
					),
					'path' => array(
						'label' => $lng['panel']['path'],
						'desc' => (\Froxlor\Settings::Get('panel.pathedit') != 'Dropdown' ? $lng['panel']['pathDescriptionSubdomain'] : null) . (isset($pathSelect['note']) ? '<br />' . $pathSelect['value'] : ''),
						'type' => $pathSelect['type'],
						'select_var' => $pathSelect['value'],
						'selected' => $pathSelect['value']
					),
					'url' => array(
						'visible' => \Froxlor\Settings::Get('panel.pathedit') == 'Dropdown',
						'label' => $lng['panel']['urloverridespath'],
						'type' => 'text',
						'value' => $urlvalue
					),
					'redirectcode' => array(
						'visible' => \Froxlor\Settings::Get('customredirect.enabled') == '1',
						'label' => $lng['domains']['redirectifpathisurl'],
						'desc' => $lng['domains']['redirectifpathisurlinfo'],
						'type' => 'select',
						'select_var' => $redirectcode,
						'selected' => $def_code
					),
					'selectserveralias' => array(
						'visible' => ($result['parentdomainid'] == '0' && $userinfo['subdomains'] != '0') || $result['parentdomainid'] != '0',
						'label' => $lng['admin']['selectserveralias'],
						'desc' => $lng['admin']['selectserveralias_desc'],
						'type' => 'select',
						'select_var' => $serveraliasoptions,
						'selected' => $serveraliasoptions_selected
					),
					'isemaildomain' => array(
						'visible' => ($result['subcanemaildomain'] == '1' || $result['subcanemaildomain'] == '2') && $result['parentdomainid'] != '0',
						'label' => 'Emaildomain',
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['isemaildomain']
					),
					'openbasedir_path' => array(
						'visible' => $result['openbasedir'] == '1',
						'label' => $lng['domain']['openbasedirpath'],
						'type' => 'select',
						'select_var' => $openbasedir,
						'selected' => $result['openbasedir_path']
					),
					'phpsettingid' => array(
						'visible' => ((int) \Froxlor\Settings::Get('system.mod_fcgid') == 1 || (int) \Froxlor\Settings::Get('phpfpm.enabled') == 1) && count($phpconfigs) > 0,
						'label' => $lng['admin']['phpsettings']['title'],
						'type' => 'select',
						'select_var' => $phpconfigs,
						'selected' => $result['phpsettingid']
					)
				)
			),
			'section_bssl' => array(
				'title' => $lng['admin']['webserversettings_ssl'],
				'image' => 'icons/domain_edit.png',
				'visible' => \Froxlor\Settings::Get('system.use_ssl') == '1' && $ssl_ipsandports && \Froxlor\Domain\Domain::domainHasSslIpPort($result['id']),
				'fields' => array(
					'sslenabled' => array(
						'label' => $lng['admin']['domain_sslenabled'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['ssl_enabled']
					),
					'ssl_redirect' => array(
						'label' => $lng['domains']['ssl_redirect']['title'],
						'desc' => $lng['domains']['ssl_redirect']['description'] . ($result['temporary_ssl_redirect'] > 1 ? $lng['domains']['ssl_redirect_temporarilydisabled'] : ''),
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['ssl_redirect']
					),
					'letsencrypt' => array(
						'visible' => \Froxlor\Settings::Get('system.leenabled') == '1',
						'label' => $lng['customer']['letsencrypt']['title'],
						'desc' => $lng['customer']['letsencrypt']['description'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['letsencrypt']
					),
					'http2' => array(
						'visible' => $ssl_ipsandports && \Froxlor\Settings::Get('system.webserver') != 'lighttpd' && \Froxlor\Settings::Get('system.http2_support') == '1',
						'label' => $lng['admin']['domain_http2']['title'],
						'desc' => $lng['admin']['domain_http2']['description'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['http2']
					),
					'hsts_maxage' => array(
						'label' => $lng['admin']['domain_hsts_maxage']['title'],
						'desc' => $lng['admin']['domain_hsts_maxage']['description'],
						'type' => 'number',
						'min' => 0,
						'max' => 94608000, // 3-years
						'value' => $result['hsts']
					),
					'hsts_sub' => array(
						'label' => $lng['admin']['domain_hsts_incsub']['title'],
						'desc' => $lng['admin']['domain_hsts_incsub']['description'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['hsts_sub']
					),
					'hsts_preload' => array(
						'label' => $lng['admin']['domain_hsts_preload']['title'],
						'desc' => $lng['admin']['domain_hsts_preload']['description'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['hsts_preload']
					)
				)
			)
		)
	)
);
