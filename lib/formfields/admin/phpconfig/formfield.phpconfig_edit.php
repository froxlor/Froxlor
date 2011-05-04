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
	'phpconfig_edit' => array(
		'title' => $lng['admin']['phpsettings']['editsettings'],
		'image' => 'icons/phpsettings_edit.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['admin']['phpsettings']['editsettings'],
				'image' => 'icons/phpsettings_edit.png',
				'fields' => array(
					'description' => array(
						'label' => $lng['admin']['phpsettings']['description'],
						'type' => 'text',
						'maxlength' => 50,
						'value' => $result['description']
					),
					'binary' => array(
						'label' => $lng['admin']['phpsettings']['binary'],
						'type' => 'text',
						'maxlength' => 255,
						'value' => $result['binary']
					),
					'file_extensions' => array(
						'label' => $lng['admin']['phpsettings']['file_extensions'],
						'desc' => $lng['admin']['phpsettings']['file_extensions_note'],
						'type' => 'text',
						'maxlength' => 255,
						'value' => $result['file_extensions']
					),
					'mod_fcgid_starter' => array(
						'label' => $lng['admin']['mod_fcgid_starter']['title'],
						'type' => 'text',
						'value' => ((int)$result['mod_fcgid_starter'] != - 1 ? $result['mod_fcgid_starter'] : '')
					),
					'mod_fcgid_maxrequests' => array(
						'label' => $lng['admin']['mod_fcgid_maxrequests']['title'],
						'type' => 'text',
						'value' => ((int)$result['mod_fcgid_maxrequests'] != - 1 ? $result['mod_fcgid_maxrequests'] : '')
					),
					'phpsettings' => array(
						'style' => 'vertical-align:top;',
						'label' => $lng['admin']['phpsettings']['phpinisettings'],
						'type' => 'textarea',
						'cols' => 80,
						'rows' => 20,
						'value' => $result['phpsettings']
					)
				)
			)
		)
	)
);
