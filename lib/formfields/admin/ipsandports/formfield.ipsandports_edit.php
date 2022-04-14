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
	'ipsandports_edit' => array(
		'title' => $lng['admin']['ipsandports']['edit'],
		'image' => 'fa-solid fa-pen',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['admin']['ipsandports']['ipandport'],
				'image' => 'icons/ipsports_add.png',
				'fields' => array(
					'ip' => array(
						'label' => $lng['admin']['ipsandports']['ip'],
						'type' => 'text',
						'value' => $result['ip'],
						'mandatory' => true
					),
					'port' => array(
						'label' => $lng['admin']['ipsandports']['port'],
						'type' => 'number',
						'value' => $result['port'],
						'min' => 1,
						'max' => 65535,
						'mandatory' => true
					)
				)
			),
			'section_b' => array(
				'title' => $lng['admin']['ipsandports']['webserverdefaultconfig'],
				'image' => 'icons/ipsports_edit.png',
				'fields' => array(
					'listen_statement' => array(
						'visible' => ! \Froxlor\Settings::Get('system.webserver') == 'nginx',
						'label' => $lng['admin']['ipsandports']['create_listen_statement'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['listen_statement']
					),
					'namevirtualhost_statement' => array(
						'visible' => \Froxlor\Settings::Get('system.webserver') == 'apache2' && (int) \Froxlor\Settings::Get('system.apache24') == 0,
						'label' => $lng['admin']['ipsandports']['create_namevirtualhost_statement'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['namevirtualhost_statement']
					),
					'vhostcontainer' => array(
						'label' => $lng['admin']['ipsandports']['create_vhostcontainer'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['vhostcontainer']
					),
					'docroot' => array(
						'label' => $lng['admin']['ipsandports']['docroot']['title'],
						'desc' => $lng['admin']['ipsandports']['docroot']['description'],
						'type' => 'text',
						'value' => $result['docroot']
					),
					'specialsettings' => array(
						'label' => $lng['admin']['ownvhostsettings'],
						'desc' => $lng['serversettings']['default_vhostconf']['description'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12,
						'value' => $result['specialsettings']
					),
					'vhostcontainer_servername_statement' => array(
						'visible' => \Froxlor\Settings::Get('system.webserver') == 'apache2',
						'label' => $lng['admin']['ipsandports']['create_vhostcontainer_servername_statement'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['vhostcontainer_servername_statement']
					)
				)
			),
			'section_c' => array(
				'title' => $lng['admin']['ipsandports']['webserverdomainconfig'],
				'image' => 'icons/ipsports_edit.png',
				'fields' => array(
					'default_vhostconf_domain' => array(
						'label' => $lng['admin']['ipsandports']['default_vhostconf_domain'],
						'desc' => $lng['serversettings']['default_vhostconf_domain']['description'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12,
						'value' => $result['default_vhostconf_domain']
					),
					'ssl_default_vhostconf_domain' => array(
						'visible' => \Froxlor\Settings::Get('system.use_ssl') == 1,
						'label' => $lng['admin']['ipsandports']['ssl_default_vhostconf_domain'],
						'desc' => $lng['serversettings']['default_vhostconf_domain']['description'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12,
						'value' => $result['ssl_default_vhostconf_domain']
					),
					'include_default_vhostconf_domain' => array(
						'label' => $lng['admin']['include_ownvhostsettings'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['include_default_vhostconf_domain']
					)
				)
			),
			'section_d' => array(
				'title' => $lng['admin']['ipsandports']['webserverssldomainconfig'],
				'image' => 'icons/ipsports_edit.png',
				'visible' => \Froxlor\Settings::Get('system.use_ssl') == 1,
				'fields' => array(
					'ssl' => array(
						'label' => $lng['admin']['ipsandports']['enable_ssl'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['ssl']
					),
					'ssl_cert_file' => array(
						'label' => $lng['admin']['ipsandports']['ssl_cert_file'],
						'type' => 'text',
						'value' => $result['ssl_cert_file']
					),
					'ssl_key_file' => array(
						'label' => $lng['admin']['ipsandports']['ssl_key_file'],
						'type' => 'text',
						'value' => $result['ssl_key_file']
					),
					'ssl_ca_file' => array(
						'label' => $lng['admin']['ipsandports']['ssl_ca_file'],
						'type' => 'text',
						'value' => $result['ssl_ca_file']
					),
					'ssl_cert_chainfile' => array(
						'label' => $lng['admin']['ipsandports']['ssl_cert_chainfile']['title'],
						'desc' => $lng['admin']['ipsandports']['ssl_cert_chainfile']['description'],
						'type' => 'text',
						'value' => $result['ssl_cert_chainfile']
					),
					'ssl_specialsettings' => array(
						'label' => $lng['admin']['ownsslvhostsettings'],
						'desc' => $lng['serversettings']['default_vhostconf']['description'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12,
						'value' => $result['ssl_specialsettings']
					),
					'include_specialsettings' => array(
						'label' => $lng['admin']['include_ownvhostsettings'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['include_specialsettings']
					)
				)
			)
		)
	)
);
