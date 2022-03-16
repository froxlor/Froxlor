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
	'settings_import' => array(
		'title' => $lng['admin']['configfiles']['importexport'],
		'image' => 'fa-solid fa-file-import',
		'sections' => array(
			'section_a' => array(
				'fields' => array(
					'import_file' => array(
						'label' => 'Chose file for import',
						'type' => 'file',
						'mandatory' => true
					)
				)
			)
		)
	)
);
