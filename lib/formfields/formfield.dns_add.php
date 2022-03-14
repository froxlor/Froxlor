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
	'dns_add' => array(
		'title' => 'DNS Editor',
		'image' => 'fa-solid fa-globe',
		'sections' => array(
			'section_a' => array(
				'fields' => array(
					'dns_record' => array(
						'label' => 'Record',
						'type' => 'text',
						'value' => $record,
						'mandatory' => true
					),
					'dns_type' => array(
						'label' => 'Type',
						'type' => 'select',
						'select_var' => [
							'A' => 'A',
							'AAAA' => 'AAAA',
							'CAA' => 'CAA',
							'CNAME' => 'CNAME',
							'DNAME' => 'DNAME',
							'LOC' => 'LOC',
							'MX' => 'MX',
							'NS' => 'NS',
							'RP' => 'RP',
							'SRV' => 'SRV',
							'SSHFP' => 'SSHFP',
							'TXT' => 'TXT'
						],
						'selected' => $type
					),
					'dns_mxp' => array(
						'label' => 'Priority',
						'type' => 'number',
						'value' => $prio
					),
					'dns_content' => array(
						'label' => 'Content',
						'type' => 'text',
						'value' => $content
					),
					'dns_ttl' => array(
						'label' => 'TTL',
						'type' => 'number',
						'min' => 30,
						'value' => $ttl
					)
				)
			)
		)
	)
);
