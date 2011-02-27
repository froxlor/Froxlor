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
 * @version    $Id: formfield.ipsandports_edit.php 111 2010-12-14 07:48:33Z d00p $
 */

return array(
	'ipsandports_edit' => array(
		'title' => $lng['admin']['ipsandports']['edit'],
		'image' => 'icons/ipsports_edit.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['admin']['ipsandports']['ipandport'],
				'image' => 'icons/ipsports_add.png',
				'fields' => array(
					'ip' => array(
						'label' => $lng['admin']['ipsandports']['ip'],
						'type' => 'text',
						'value' => $result['ip']
					),
					'port' => array(
						'label' => $lng['admin']['ipsandports']['port'],
						'type' => 'text',
						'value' => $result['port'],
						'size' => 5
					)
				)
			),
			'section_b' => array(
				'title' => $lng['admin']['ipsandports']['webserverdefaultconfig'],
				'image' => 'icons/ipsports_edit.png',
				'fields' => array(
					'listen_statement' => array(
						'label' => $lng['admin']['ipsandports']['create_listen_statement'],
						'type' => 'yesno',
						'yesno_var' => $listen_statement
					),
					'namevirtualhost_statement' => array(
						'label' => $lng['admin']['ipsandports']['create_namevirtualhost_statement'],
						'type' => 'yesno',
						'yesno_var' => $namevirtualhost_statement,
					),
					'vhostcontainer' => array(
						'label' => $lng['admin']['ipsandports']['create_vhostcontainer'],
						'type' => 'yesno',
						'yesno_var' => $vhostcontainer
					),
					'docroot' => array(
						'label' => $lng['admin']['ipsandports']['docroot']['title'],
						'desc' => $lng['admin']['ipsandports']['docroot']['description'],
						'type' => 'text',
						'value' => $result['docroot']
					),
					'specialsettings' => array(
						'style' => 'vertical-align:top;',
						'label' => $lng['admin']['ownvhostsettings'],
						'desc' => $lng['serversettings']['default_vhostconf']['description'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12
					),
					'vhostcontainer_servername_statement' => array(
						'label' => $lng['admin']['ipsandports']['create_vhostcontainer_servername_statement'],
						'type' => 'yesno',
						'yesno_var' => $vhostcontainer_servername_statement,
						'value' => $result['specialsettings']
					)
				)
			),
			'section_c' => array(
				'title' => $lng['admin']['ipsandports']['webserverdomainconfig'],
				'image' => 'icons/ipsports_edit.png',
				'fields' => array(
					'default_vhostconf_domain' => array(
						'style' => 'vertical-align:top;',
						'label' => $lng['admin']['ipsandports']['default_vhostconf_domain'],
						'desc' => $lng['serversettings']['default_vhostconf']['description'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12,
						'value' => $result['default_vhostconf_domain']
					)
				)
			),
			'section_d' => array(
				'title' => $lng['admin']['ipsandports']['webserverssldomainconfig'],
				'image' => 'icons/ipsports_edit.png',
				'visible' => ($settings['system']['use_ssl'] == 1 ? true : false),
				'fields' => array(
					'ssl' => array(
						'label' => $lng['admin']['ipsandports']['enable_ssl'],
						'type' => 'yesno',
						'yesno_var' => $enable_ssl
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
						'label' => $lng['admin']['ipsandports']['ssl_cert_chainfile'],
						'type' => 'text',
						'value' => $result['ssl_cert_chainfile']
					)
				)
			)
		)
	)
);
