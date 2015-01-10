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
	'domain_import' => array(
		'title' => $lng['domains']['domain_import'],
		'image' => 'icons/domain_add.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['domains']['domain_import'],
				'image' => 'icons/domain_add.png',
				'fields' => array(
					'customerid' => array(
						'label' => $lng['admin']['customer'],
						'type' => 'select',
						'select_var' => $customers,
						'mandatory' => true,
					),
					'separator' => array(
						'label' => $lng['domains']['import_separator'],
						'type' => 'text',
						'mandatory' => true,
						'size' => 5,
						'value' => ';'
					),
					'offset' => array(
						'label' => $lng['domains']['import_offset'],
						'type' => 'text',
						'mandatory' => true,
						'size' => 10,
						'value' => '0'
					),
					'file' => array(
						'label' => $lng['domains']['import_file'],
						'type' => 'file',
						'mandatory' => true
					)
				)
			)
		)
	)
);
