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
	'template_edit' => array(
		'title' => $lng['admin']['templates']['template_edit'],
		'image' => 'icons/templates_edit.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['admin']['templates']['template_edit'],
				'image' => 'icons/templates_edit.png',
				'fields' => array(
					'language' => array(
						'label' => $lng['login']['language'],
						'type' => 'hidden',
						'value' => $language,
						'display' => $language
					),
					'template' => array(
						'label' => $lng['admin']['templates']['action'],
						'type' => 'hidden',
						'value' => $template,
						'display' => $template
					),
					'subject' => array(
						'label' => $lng['admin']['templates']['subject'],
						'type' => 'text',
						'value' => $subject
					),
					'mailbody' => array(
						'label' => $lng['admin']['templates']['mailbody'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12,
						'value' => $mailbody
                                        )
				 )
			)
		)
	)
);
