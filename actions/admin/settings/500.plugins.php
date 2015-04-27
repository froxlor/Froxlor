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
 * @package    Settings
 *
 */

return array(
	'groups' => array(
		'plugins' => array(
			'title' => $lng['plugins']['plugins'],
			'fields' => array(
					'plugins_active' => array(
						'label' => $lng['plugins']['active'],
						'settinggroup' => 'plugins',
						'varname' => 'active',
						'type' => 'option',
						'default' => '',
						'option_mode' => 'multiple',
						'option_mode_empty' => true,
						'option_options_method' => array('FroxlorPlugins', 'getOptionList'),
						'save_method' => 'storeSettingFieldOptional'
					),
				),
			),
		),
	);
?>