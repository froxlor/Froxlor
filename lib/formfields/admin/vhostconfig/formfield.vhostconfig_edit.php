<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
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
	'vhostconfig_edit' => array(
		'title' => $lng['admin']['vhostsettings']['editsettings'],
		'image' => 'icons/vhostsettings_edit.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['admin']['vhostsettings']['editsettings'],
				'image' => 'icons/vhostsettings_edit.png',
				'fields' => array(
					'description' => array(
						'label' => $lng['admin']['phpsettings']['description'],
						'type' => 'text',
						'maxlength' => 50,
						'value' => $result['description']
					),
					'webserver' => array(
						'label' => $lng['admin']['webserver'],
						'type' => 'select',
						'select_var' => $webserver_options
					),
					'vhostsettings' => array(
						'style' => 'align-top',
						'label' => $lng['admin']['vhostsettings']['vhostsettings'],
						'type' => 'textarea',
						'cols' => 100,
						'rows' => 30,
						'value' => $result['vhostsettings']
					)
				)
			)
		)
	)
);
