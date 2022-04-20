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
	'ipsandports_add' => array(
		'title' => $lng['admin']['ipsandports']['add'],
		'image' => 'fa-solid fa-plus',
		'self_overview' => ['section' => 'ipsandports', 'page' => 'ipsandports'],
		'sections' => array(
			'section_a' => array(
				'title' => $lng['admin']['ipsandports']['ipandport'],
				'image' => 'icons/ipsports_add.png',
				'fields' => array(
					'ip' => array(
						'label' => $lng['admin']['ipsandports']['ip'],
						'type' => 'text',
						'mandatory' => true
					),
					'port' => array(
						'label' => $lng['admin']['ipsandports']['port'],
						'type' => 'number',
						'min' => 1,
						'max' => 65535,
						'value' => 80,
						'mandatory' => true
					)
				)
			),
			'section_b' => array(
				'title' => $lng['admin']['ipsandports']['webserverdefaultconfig'],
				'image' => 'icons/ipsports_add.png',
				'fields' => array(
					'listen_statement' => array(
						'visible' => ! \Froxlor\Settings::Get('system.webserver') == 'nginx',
						'label' => $lng['admin']['ipsandports']['create_listen_statement'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					),
					'namevirtualhost_statement' => array(
						'visible' => \Froxlor\Settings::Get('system.webserver') == 'apache2' && (int) \Froxlor\Settings::Get('system.apache24') == 0,
						'label' => $lng['admin']['ipsandports']['create_namevirtualhost_statement'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => \Froxlor\Settings::Get('system.webserver') == 'apache2' && (int) \Froxlor\Settings::Get('system.apache24') == 0
					),
					'vhostcontainer' => array(
						'label' => $lng['admin']['ipsandports']['create_vhostcontainer'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => true
					),
					'docroot' => array(
						'label' => $lng['admin']['ipsandports']['docroot']['title'],
						'desc' => $lng['admin']['ipsandports']['docroot']['description'],
						'type' => 'text'
					),
					'specialsettings' => array(
						'label' => $lng['admin']['ownvhostsettings'],
						'desc' => $lng['serversettings']['default_vhostconf']['description'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12
					),
					'vhostcontainer_servername_statement' => array(
						'visible' => \Froxlor\Settings::Get('system.webserver') == 'apache2',
						'label' => $lng['admin']['ipsandports']['create_vhostcontainer_servername_statement'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => true
					)
				)
			),
			'section_c' => array(
				'title' => $lng['admin']['ipsandports']['webserverdomainconfig'],
				'image' => 'icons/ipsports_add.png',
				'fields' => array(
					'default_vhostconf_domain' => array(
						'label' => $lng['admin']['ipsandports']['default_vhostconf_domain'],
						'desc' => $lng['serversettings']['default_vhostconf_domain']['description'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12
					),
					'ssl_default_vhostconf_domain' => array(
						'visible' => \Froxlor\Settings::Get('system.use_ssl') == 1,
						'label' => $lng['admin']['ipsandports']['ssl_default_vhostconf_domain'],
						'desc' => $lng['serversettings']['default_vhostconf_domain']['description'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12
					),
					'include_default_vhostconf_domain' => array(
						'label' => $lng['admin']['include_ownvhostsettings'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					)
				)
			),
			'section_d' => array(
				'title' => $lng['admin']['ipsandports']['webserverssldomainconfig'],
				'image' => 'icons/ipsports_add.png',
				'visible' => \Froxlor\Settings::Get('system.use_ssl') == 1,
				'fields' => array(
					'ssl' => array(
						'label' => $lng['admin']['ipsandports']['enable_ssl'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					),
					'ssl_cert_file' => array(
						'label' => $lng['admin']['ipsandports']['ssl_cert_file'],
						'type' => 'text'
					),
					'ssl_key_file' => array(
						'label' => $lng['admin']['ipsandports']['ssl_key_file'],
						'type' => 'text'
					),
					'ssl_ca_file' => array(
						'label' => $lng['admin']['ipsandports']['ssl_ca_file'],
						'type' => 'text'
					),
					'ssl_cert_chainfile' => array(
						'label' => $lng['admin']['ipsandports']['ssl_cert_chainfile']['title'],
						'desc' => $lng['admin']['ipsandports']['ssl_cert_chainfile']['description'],
						'type' => 'text'
					),
					'ssl_specialsettings' => array(
						'label' => $lng['admin']['ownsslvhostsettings'],
						'desc' => $lng['serversettings']['default_vhostconf']['description'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12
					),
					'include_specialsettings' => array(
						'label' => $lng['admin']['include_ownvhostsettings'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					)
				)
			)
		)
	)
);
