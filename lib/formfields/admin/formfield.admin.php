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
	'accountdata' => array(
		'title' => $lng['admin']['accountdata'],
		'fields' => array(
			'loginname' => array(
				'label' => $lng['login']['username'],
				'type' => (isset($result['loginname'])) ? 'static' : 'text',
				'mandatory' => true,
				'value' => $result['loginname'],
			),
			'deactivated' => array(
				'label' => $lng['admin']['deactivated_user'],
				'type' => 'checkbox',
				'value' => '1',
				'sublabel' => $lng['panel']['yes'],
				'visible' => (isset($result['loginname']) && $result['adminid'] != $userinfo['userid']) ? true : false,
				'attributes' => array(
					'checked' => ($result['deactivated'] != 0)
				)
			),
			'admin_password' => array(
				'label' => $lng['login']['password'],
				'type' => 'password',
				'mandatory' => true,
				'autocomplete' => 'off'
			),
			'admin_password_suggestion' => array(
				'label' => $lng['customer']['generated_pwd'],
				'type' => 'text',
				'visible' => (Settings::Get('panel.password_regex') == ''),
				'value' => generatePassword(),
				'default' => generatePassword(),
				'attributes' => array(
					'readonly' => true
				)
			),
			'def_language' => array(
				'label' => $lng['login']['language'],
				'type' => 'select',
				'generate' => 'languages',
				'default' => Settings::Get('panel.standardlanguage'),
				'selected' => $result['def_language']
			)
		)
	),
	'contactdata' => array(
		'title' => $lng['admin']['contactdata'],
		'fields' => array(
			'name' => array(
				'label' => $lng['customer']['name'],
				'type' => 'text',
				'mandatory' => true,
				'value' => $result['name']
			),
			'email' => array(
				'label' => $lng['customer']['email'],
				'type' => 'email',
				'mandatory' => true,
				'value' => $result['email']
			),
			'custom_notes' => array(
				'label' => $lng['usersettings']['custom_notes']['title'],
				'desc' => $lng['usersettings']['custom_notes']['description'],
				'type' => 'textarea',
				'value' => $result['custom_notes'],
				'attributes' => array(
					'cols' => 60,
					'rows' => 12
				)
			),
			'custom_notes_show' => array(
				'label' => $lng['usersettings']['custom_notes']['show'],
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => '1',
				'default' => false,
				'attributes' => array(
					'checked' => ($result['custom_notes_show'] != '0')
				)
			)
		)
	),
	'servicedata' => array(
		'title' => $lng['admin']['servicedata'],
		'visible' => ($result['adminid'] != $userinfo['userid']),
		'fields' => array(
			'ipaddress' => array(
				'label' => $lng['serversettings']['ipaddress']['title'],
				'type' => 'select',
				'values' => $ipaddress
			),
			'change_serversettings' => array(
				'label' => $lng['admin']['change_serversettings'],
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => 1,
				'attributes' => array(
					'checked' => ($result['change_serversettings'] != '0')
				)
			),
			'customers' => array(
				'label' => $lng['admin']['customers'],
				'type' => 'textul',
				'default' => 0,
				'value' => $result['customers'],
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 9
				)
			),
			'customers_see_all' => array(
				'label' => $lng['admin']['customers_see_all'],
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => '1',
				'attributes' => array(
					'checked' => ($result['customers_see_all'] != 0)
				)
			),
			'domains' => array(
				'label' => $lng['admin']['domains'],
				'type' => 'textul',
				'default' => 0,
				'value' => $result['domains'],
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 9
				)
			),
			'domains_see_all' => array(
				'label' => $lng['admin']['domains_see_all'],
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => '1',
				'attributes' => array(
					'checked' => ($result['domains_see_all'] != 0)
				)
			),
			'caneditphpsettings' => array(
				'label' => $lng['admin']['caneditphpsettings'],
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => '1',
				'attributes' => array(
					'checked' => ($result['caneditphpsettings'] != 0)
				)
			),
			'diskspace' => array(
				'label' => $lng['customer']['diskspace'],
				'type' => 'textul',
				'value' => $result['diskspace'],
				'default' => 0,
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 6
				)
			),
			'traffic' => array(
				'label' => $lng['customer']['traffic'],
				'type' => 'textul',
				'value' => $result['traffic'],
				'default' => 0,
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 4
				)
			),
			'subdomains' => array(
				'label' => $lng['customer']['subdomains'],
				'type' => 'textul',
				'default' => 0,
				'value' => $result['subdomains'],
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 9
				)
			),
			'emails' => array(
				'label' => $lng['customer']['emails'],
				'type' => 'textul',
				'default' => 0,
				'value' => $result['emails'],
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 9
				)
			),
			'email_accounts' => array(
				'label' => $lng['customer']['accounts'],
				'type' => 'textul',
				'default' => 0,
				'value' => $result['email_accounts'],
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 9
				)
			),
			'email_forwarders' => array(
				'label' => $lng['customer']['forwarders'],
				'type' => 'textul',
				'default' => 0,
				'value' => $result['email_forwarders'],
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 9
				)
			),
			'email_quota' => array(
				'label' => $lng['customer']['email_quota'],
				'type' => 'textul',
				'default' => 0,
				'value' => $result['email_quota'],
				'visible' => (Settings::Get('system.mail_quota_enabled') == '1' ? true : false),
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 9
				)
			),
			'ftps' => array(
				'label' => $lng['customer']['ftps'],
				'type' => 'textul',
				'default' => 0,
				'value' => $result['ftps'],
				'attributes' => array(
					'maxlength' => 9
				)
			),
			'tickets' => array(
				'label' => $lng['customer']['tickets'],
				'type' => 'textul',
				'default' => 0,
				'value' => $result['tickets'],
				'visible' => (Settings::Get('ticket.enabled') == '1' ? true : false),
				'attributes' => array(
					'maxlength' => 9
				)
			),
			'tickets_see_all' => array(
				'label' => $lng['admin']['tickets_see_all'],
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => '1',
				'attributes' => array(
					'checked' => ($result['tickets_see_all'] != '0')
				)
			),
			'mysqls' => array(
				'label' => $lng['customer']['mysqls'],
				'type' => 'textul',
				'default' => 0,
				'value' => $result['mysqls'],
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 9
				)
			)
		)
	)
);
