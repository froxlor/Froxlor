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
	'htaccess_add' => array(
		'title' => \Froxlor\I18N\Lang::getAll()['extras']['pathoptions_add'],
		'image' => 'icons/htpasswd_add.png',
		'sections' => array(
			'section_a' => array(
				'title' => \Froxlor\I18N\Lang::getAll()['extras']['pathoptions_add'],
				'image' => 'icons/htpasswd_add.png',
				'fields' => array(
					'path' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['panel']['path'],
						'desc' => (\Froxlor\Settings::Get('panel.pathedit') != 'Dropdown' ? \Froxlor\I18N\Lang::getAll()['panel']['pathDescription'] : null) . (isset($pathSelect['note']) ? '<br />' . $pathSelect['value'] : ''),
						'type' => $pathSelect['type'],
						'select_var' => $pathSelect['value'],
						'value' => $pathSelect['value']
					),
					'options_indexes' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['extras']['directory_browsing'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array()
					),
					'error404path' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['extras']['errordocument404path'],
						'desc' => \Froxlor\I18N\Lang::getAll()['panel']['descriptionerrordocument'],
						'type' => 'text'
					),
					'error403path' => array(
						'visible' => (\Froxlor\Settings::Get('system.webserver') == 'apache2'),
						'label' => \Froxlor\I18N\Lang::getAll()['extras']['errordocument403path'],
						'desc' => \Froxlor\I18N\Lang::getAll()['panel']['descriptionerrordocument'],
						'type' => 'text'
					),
					'error500path' => array(
						'visible' => (\Froxlor\Settings::Get('system.webserver') == 'apache2'),
						'label' => \Froxlor\I18N\Lang::getAll()['extras']['errordocument500path'],
						'desc' => \Froxlor\I18N\Lang::getAll()['panel']['descriptionerrordocument'],
						'type' => 'text'
					),
					'options_cgi' => array(
						'visible' => ($cperlenabled == 1),
						'label' => \Froxlor\I18N\Lang::getAll()['extras']['execute_perl'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array()
					)
				)
			)
		)
	)
);
