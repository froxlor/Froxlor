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
	'domain_ssleditor' => array(
		'title' => $lng['panel']['ssleditor'],
		'image' => 'icons/ssl.png',
		'sections' => array(
			'section_a' => array(
				'title' => 'SSL certificates',
				'image' => 'icons/ssl.png',
				'fields' => array(
					'ssl_cert_file' => array(
						'style' => 'align-top',
						'label' => $lng['admin']['ipsandports']['ssl_cert_file_path'],
						'desc' => $lng['admin']['ipsandports']['ssl_path_description'],
						'type' => 'text',
						'value' => $result['ssl_cert_file']
					),
					'ssl_key_file' => array(
						'style' => 'align-top',
						'label' => $lng['admin']['ipsandports']['ssl_key_file_path'],
						'desc' => $lng['admin']['ipsandports']['ssl_path_description'],
						'type' => 'text',
						'value' => $result['ssl_key_file']
					),
					'ssl_cert_chainfile' => array(
						'style' => 'align-top',
						'label' => $lng['admin']['ipsandports']['ssl_cert_chainfile_path'],
						'desc' => $lng['admin']['ipsandports']['ssl_path_description'].$lng['admin']['ipsandports']['ssl_cert_chainfile_path_desc'],
						'type' => 'text',
						'value' => $result['ssl_cert_chainfile']
					),
					'ssl_ca_file' => array(
						'style' => 'align-top',
						'label' => $lng['admin']['ipsandports']['ssl_ca_file_path'],
						'desc' => $lng['admin']['ipsandports']['ssl_path_description'].$lng['admin']['ipsandports']['ssl_ca_file_path_desc'],
						'type' => 'text',
						'value' => $result['ssl_ca_file']
					)
				)
			)
		)
	)
);
