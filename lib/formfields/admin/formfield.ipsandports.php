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
	'section_a' => array(
		'title' => $lng['admin']['ipsandports']['ipandport'],
		'fields' => array(
			'ip' => array(
				'label' => $lng['admin']['ipsandports']['ip'],
				'type' => 'text'
			),
			'port' => array(
				'label' => $lng['admin']['ipsandports']['port'],
				'type' => 'text',
				'size' => 5
			)
		)
	),
	'section_b' => array(
		'title' => $lng['admin']['ipsandports']['webserverdefaultconfig'],
		'fields' => array(
			'listen_statement' => array(
				'label' => $lng['admin']['ipsandports']['create_listen_statement'],
				'type' => 'checkbox',
				'value' => '1',
				'attributes' => array(
					'checked' => true
				)
			),
			'namevirtualhost_statement' => array(
				'label' => $lng['admin']['ipsandports']['create_namevirtualhost_statement'],
				'type' => 'checkbox',
				'value' => '1',
				'attributes' => array(
					'checked' => true
				)
			),
			'vhostcontainer' => array(
				'label' => $lng['admin']['ipsandports']['create_vhostcontainer'],
				'type' => 'checkbox',
				'value' => '1',
				'attributes' => array(
					'checked' => true
				)
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
				'attributes' => array(
					'cols' => 60,
					'rows' => 12
				)
			),
			'vhostcontainer_servername_statement' => array(
				'label' => $lng['admin']['ipsandports']['create_vhostcontainer_servername_statement'],
				'type' => 'checkbox',
				'value' => '1',
				'attributes' => array(
					'checked' => true
				)
			)
		)
	),
	'section_c' => array(
		'title' => $lng['admin']['ipsandports']['webserverdomainconfig'],
		'fields' => array(
			'default_vhostconf_domain' => array(
				'label' => $lng['admin']['ipsandports']['default_vhostconf_domain'],
				'desc' => $lng['serversettings']['default_vhostconf_domain']['description'],
				'type' => 'textarea',
				'attributes' => array(
					'cols' => 60,
					'rows' => 12
				)
			)
		)
	),
	'section_d' => array(
		'title' => $lng['admin']['ipsandports']['webserverssldomainconfig'],
		'visible' => (Settings::Get('system.use_ssl') == 1 ? true : false),
		'fields' => array(
			'ssl' => array(
				'label' => $lng['admin']['ipsandports']['enable_ssl'],
				'type' => 'checkbox',
				'value' => '1'
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
			)
		)
	)
);
