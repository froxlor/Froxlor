<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Settings
 *
 */

return array(
	'groups' => array(
		'security' => array(
			'title' => $lng['admin']['security_settings'],
			'fields' => array(
				'panel_unix_names' => array(
					'label' => $lng['serversettings']['unix_names'],
					'settinggroup' => 'panel',
					'varname' => 'unix_names',
					'type' => 'bool',
					'default' => true,
					'save_method' => 'storeSettingField',
					),
				'system_mailpwcleartext' => array(
					'label' => $lng['serversettings']['mailpwcleartext'],
					'settinggroup' => 'system',
					'varname' => 'mailpwcleartext',
					'type' => 'bool',
					'default' => true,
					'save_method' => 'storeSettingField',
					),
				),
			),
		),
	);

?>