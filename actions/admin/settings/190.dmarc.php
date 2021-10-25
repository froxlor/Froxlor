<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2021 the Froxlor Team (see authors).
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
		'dmarc' => array(
			'title' => $lng['admin']['dmarcsettings'],
			'fields' => array(
				'use_dmarc' => array(
					'label' => $lng['dmarc']['use_dmarc'],
					'settinggroup' => 'dmarc',
					'varname' => 'use_dmarc',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					'overview_option' => true
				),
				'dmarc_entry' => array(
					'label' => $lng['dmarc']['dmarc_entry'],
					'settinggroup' => 'dmarc',
					'varname' => 'dmarc_entry',
					'type' => 'string',
					'default' => '"v=DMARC1; p=none;"',
					'save_method' => 'storeSettingField'
				)
			)
		)
	)
);

?>
