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
		'spf' => array(
			'title' => $lng['admin']['spfsettings'],
			'fields' => array(
				'spf_enabled' => array(
					'label' => $lng['spf']['use_spf'],
					'settinggroup' => 'spf',
					'varname' => 'use_spf',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					'overview_option' => true
					),
				'spf_entry' => array(
					'label' => $lng['spf']['spf_entry'],
					'settinggroup' => 'spf',
					'varname' => 'spf_entry',
					'type' => 'string',
					'default' => '@	IN	TXT	"v=spf1 a mx -all"',
					'save_method' => 'storeSettingField'
					)
				)
			)
		)
	);

?>
