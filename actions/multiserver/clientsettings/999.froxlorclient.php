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
 * @version    $Id$
 */

return array(
	'groups' => array(
		'froxlorclient' => array(
			'title' => $lng['admin']['froxlorclient'],
			'fields' => array(
				'froxlorclient_enabled' => array(
					'label' => $lng['froxlorclient']['enabled'],
					'settinggroup' => 'client',
					'varname' => 'enabled',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					'overview_option' => true
				),
				'froxlorclient_ipaddress' => array(
					'label' => $lng['froxlorclient']['ipaddress'],
					'settinggroup' => 'client',
					'varname' => 'ipaddress',
					'type' => 'string',
					'default' => '',
					/* 'plausibility_check_method' => 'validateIP', */
					'save_method' => 'storeSettingField',
				),
				'froxlorclient_hostname' => array(
					'label' => $lng['froxlorclient']['hostname'],
					'settinggroup' => 'client',
					'varname' => 'hostname',
					'type' => 'string',
					'default' => '',
					'save_method' => 'storeSettingField'
				),
				'froxlorclient_deploy_mode' => array(
					'label' => $lng['froxlorclient']['deploy_mode'],
					'settinggroup' => 'client',
					'varname' => 'deploy_mode',
					'type' => 'option',
					'default' => 'pubkey',
					'option_mode' => 'one',
					'option_options' => array('pubkey' => 'PublicKey', 'plainpass' => 'Passphrase'),
					'save_method' => 'storeSettingField',
				),
				'froxlorclient_ssh_port' => array(
					'label' => $lng['froxlorclient']['ssh_port'],
					'settinggroup' => 'client',
					'varname' => 'ssh_port',
					'type' => 'int',
					'int_min' => 1,
					'int_max' => 65535,
					'default' => 22,
					'save_method' => 'storeSettingField',
				),
				'froxlorclient_ssh_user' => array(
					'label' => $lng['froxlorclient']['ssh_user'],
					'settinggroup' => 'client',
					'varname' => 'ssh_user',
					'type' => 'string',
					'default' => '',
					'save_method' => 'storeSettingField'
				),
				'froxlorclient_ssh_passphrase' => array(
					'label' => $lng['froxlorclient']['ssh_passphrase'],
					'settinggroup' => 'client',
					'varname' => 'ssh_passphrase',
					'type' => 'string',
					'default' => '',
					'save_method' => 'storeSettingField'
				),
				'froxlorclient_ssh_pubkey' => array(
					'label' => $lng['froxlorclient']['ssh_pubkey'],
					'settinggroup' => 'client',
					'varname' => 'ssh_pubkey',
					'type' => 'string',
					'string_type' => 'file',
					'default' => '',
					'string_emptyallowed' => true,
					'save_method' => 'storeSettingField'
				),
				'froxlorclient_ssh_privkey' => array(
					'label' => $lng['froxlorclient']['ssh_privkey'],
					'settinggroup' => 'client',
					'varname' => 'ssh_privkey',
					'type' => 'string',
					'string_type' => 'file',
					'default' => '',
					'string_emptyallowed' => true,
					'save_method' => 'storeSettingField'
				)
			)
		)
	)
);
