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
 * @version    $Id$
 */

return array(
	'groups' => array(
		'accounts' => array(
			'title' => $lng['admin']['accountsettings'],
			'fields' => array(
				'session_sessiontimeout' => array(
					'label' => $lng['serversettings']['session_timeout'],
					'settinggroup' => 'session',
					'varname' => 'sessiontimeout',
					'type' => 'int',
					'default' => 600,
					'save_method' => 'storeSettingField',
					),
				'session_allow_multiple_login' => array(
					'label' => $lng['serversettings']['session_allow_multiple_login'],
					'settinggroup' => 'session',
					'varname' => 'allow_multiple_login',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					),
				'login_maxloginattempts' => array(
					'label' => $lng['serversettings']['maxloginattempts'],
					'settinggroup' => 'login',
					'varname' => 'maxloginattempts',
					'type' => 'int',
					'default' => 3,
					'save_method' => 'storeSettingField',
					),
				'login_deactivatetime' => array(
					'label' => $lng['serversettings']['deactivatetime'],
					'settinggroup' => 'login',
					'varname' => 'deactivatetime',
					'type' => 'int',
					'default' => 900,
					'save_method' => 'storeSettingField',
					),
				'customer_accountprefix' => array(
					'label' => $lng['serversettings']['accountprefix'],
					'settinggroup' => 'customer',
					'varname' => 'accountprefix',
					'type' => 'string',
					'default' => '',
					'plausibility_check_method' => 'checkUsername',
					'save_method' => 'storeSettingField',
					),
				'customer_mysqlprefix' => array(
					'label' => $lng['serversettings']['mysqlprefix'],
					'settinggroup' => 'customer',
					'varname' => 'mysqlprefix',
					'type' => 'string',
					'default' => '',
					'plausibility_check_method' => 'checkUsername',
					'save_method' => 'storeSettingField',
					),
				'customer_ftpprefix' => array(
					'label' => $lng['serversettings']['ftpprefix'],
					'settinggroup' => 'customer',
					'varname' => 'ftpprefix',
					'type' => 'string',
					'default' => '',
					'save_method' => 'storeSettingField',
					),
				'customer_ftpatdomain' => array(
					'label' => $lng['serversettings']['ftpdomain'],
					'settinggroup' => 'customer',
					'varname' => 'ftpatdomain',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					),
				'panel_allow_preset' => array(
					'label' => $lng['serversettings']['allow_password_reset'],
					'settinggroup' => 'panel',
					'varname' => 'allow_preset',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					),
				'panel_allow_preset_admin' => array(
					'label' => $lng['serversettings']['allow_password_reset_admin'],
					'settinggroup' => 'panel',
					'varname' => 'allow_preset_admin',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					),
				),
			),
		),
	);

?>