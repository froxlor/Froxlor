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
	'filetemplate_edit' => array(
		'title' => \Froxlor\I18N\Lang::getAll()['admin']['templates']['template_edit'],
		'image' => 'icons/templates_edit.png',
		'sections' => array(
			'section_a' => array(
				'title' => \Froxlor\I18N\Lang::getAll()['admin']['templates']['template_edit'],
				'image' => 'icons/templates_edit.png',
				'fields' => array(
					'template' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['templates']['action'],
						'type' => 'hidden',
						'value' => \Froxlor\I18N\Lang::getAll()['admin']['templates'][$row['varname']],
						'display' => \Froxlor\I18N\Lang::getAll()['admin']['templates'][$row['varname']]
					),
					'filecontent' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['templates']['filecontent'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12,
						'value' => $row['value']
					)
				)
			)
		)
	)
);
