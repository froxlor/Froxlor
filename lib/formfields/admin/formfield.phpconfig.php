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
	'section_a' => array(
		'title' => $lng['admin']['phpsettings']['addsettings'],
		'fields' => array(
			'description' => array(
				'label' => $lng['admin']['phpsettings']['description'],
				'type' => 'text',
				'attributes' => array(
					'maxlength' => 50
				)
			),
			'binary' => array(
				'visible' => (Settings::Get('system.mod_fcgid') == 1 ? true : false),
				'label' => $lng['admin']['phpsettings']['binary'],
				'type' => 'text',
				'value' => '/usr/bin/php-cgi',
				'attributes' => array(
					'maxlength' => 255
				)
			),
			'file_extensions' => array(
				'visible' => (Settings::Get('system.mod_fcgid') == 1 ? true : false),
				'label' => $lng['admin']['phpsettings']['file_extensions'],
				'desc' => $lng['admin']['phpsettings']['file_extensions_note'],
				'type' => 'text',
				'value' => 'php',
				'attributes' => array(
					'maxlength' => 255
				)
			),
			'mod_fcgid_starter' => array(
				'visible' => (Settings::Get('system.mod_fcgid') == 1 ? true : false),
				'label' => $lng['admin']['mod_fcgid_starter']['title'],
				'type' => 'text'
			),
			'mod_fcgid_maxrequests' => array(
				'visible' => (Settings::Get('system.mod_fcgid') == 1 ? true : false),
				'label' => $lng['admin']['mod_fcgid_maxrequests']['title'],
				'type' => 'text'
			),
			'fpm_slowlog' => array(
				'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
				'label' => $lng['admin']['phpsettings']['enable_slowlog'],
				'type' => 'checkbox',
				'value' => '1'
			),
			'fpm_reqterm' => array(
				'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
				'label' => $lng['admin']['phpsettings']['request_terminate_timeout'],
				'type' => 'text',
				'value' => '60s',
				'attributes' => array(
					'maxlength' => 10
				)
			),
			'fpm_reqslow' => array(
				'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
				'label' => $lng['admin']['phpsettings']['request_slowlog_timeout'],
				'type' => 'text',
				'maxlength' => 10,
				'value' => '5s'
			),
			'phpsettings' => array(
				'style' => 'align-top',
				'label' => $lng['admin']['phpsettings']['phpinisettings'],
				'type' => 'textarea',
				'value' => $result['phpsettings'],
				'attributes' => array(
					'cols' => 80,
					'rows' => 20
				)
			)
		)
	)
);
