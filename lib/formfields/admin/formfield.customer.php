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
			'new_loginname' => array(
				'label' => $lng['login']['username'],
				'type' => 'text',
				'visible' => 'new'
			),
			'loginname' => array(
				'label' => $lng['login']['username'],
				'type' => 'static',
				'visible' => 'edit'
			),
			'documentroot' => array(
				'label' => $lng['customer']['documentroot'],
				'type' => 'static',
				'visible' => 'edit'
			),
			'createstdsubdomain' => array(
				'label' => $lng['admin']['stdsubdomain_add'].'?',
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => '1',
				'attributes' => array(
					'checked' => true
				)
			),
			'store_defaultindex' => array(
				'label' => $lng['admin']['store_defaultindex'].'?',
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => '1',
				'visible' => 'new',
				'attributes' => array(
					'checked' => true
				)
			),
			'deactivated' => array(
				'label' => $lng['admin']['deactivated_user'],
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => '1',
				'visible' => 'edit'
			),
			'new_customer_password' => array(
				'label' => $lng['login']['password'],
				'type' => 'password',
				'attributes' => array(
					'autocomplete' => 'off'
				)
			),
			'new_customer_password_suggestion' => array(
				'label' => $lng['customer']['generated_pwd'],
				'type' => 'text',
				'visible' => (Settings::Get('panel.password_regex') == ''),
				'value' => generatePassword(),
				'attributes' => array(
					'readonly' => true
				)
			),
			'sendpassword' => array(
				'label' => $lng['admin']['sendpassword'],
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'visible' => 'new',
				'attributes' => array(
					'checked' => true
				)
			),
			'def_language' => array(
				'label' => $lng['login']['language'],
				'type' => 'select',
				'generate' => 'languages',
				'selected' => Settings::Get('panel.standardlanguage'),
			)
		)
	),
	'contactdata' => array(
		'title' => $lng['admin']['contactdata'],
		'fields' => array(
			'gender' => array(
				'label' => $lng['gender']['title'],
				'type' => 'select',
				'generate' => 'genders',
				'selected' => '0'
			),
			'name' => array(
				'label' => $lng['customer']['name'],
				'type' => 'text',
				'mandatory_ex' => true
			),
			'firstname' => array(
				'label' => $lng['customer']['firstname'],
				'type' => 'text',
				'mandatory_ex' => true
			),
			'company' => array(
				'label' => $lng['customer']['company'],
				'type' => 'text',
				'mandatory_ex' => true
			),
			'street' => array(
				'label' => $lng['customer']['street'],
				'type' => 'text'
			),
			'zipcode' => array(
				'label' => $lng['customer']['zipcode'],
				'type' => 'text'
			),
			'city' => array(
				'label' => $lng['customer']['city'],
				'type' => 'text'
			),
			'phone' => array(
				'label' => $lng['customer']['phone'],
				'type' => 'text'
			),
			'fax' => array(
				'label' => $lng['customer']['fax'],
				'type' => 'text'
			),
			'email' => array(
				'label' => $lng['customer']['email'],
				'type' => 'email',
				'mandatory' => true
			),
			'customernumber' => array(
				'label' => $lng['customer']['customernumber'],
				'type' => 'text'
			),
			'custom_notes' => array(
				'label' => $lng['usersettings']['custom_notes']['title'],
				'desc' => $lng['usersettings']['custom_notes']['description'],
				'type' => 'textarea',
				'attributes' => array(
					'cols' => 60,
					'rows' => 12
				)
			),
			'custom_notes_show' => array(
				'label' => $lng['usersettings']['custom_notes']['show'],
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => '1'
			)
		)
	),
	'servicedata' => array(
		'title' => $lng['admin']['servicedata'],
		'fields' => array(
			'diskspace' => array(
				'label' => $lng['customer']['diskspace'],
				'type' => 'textul',
				'value' => 0,
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 6,
				)
			),
			'traffic' => array(
				'label' => $lng['customer']['traffic'],
				'type' => 'textul',
				'value' => 0,
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 4,
				)
			),
			'subdomains' => array(
				'label' => $lng['customer']['subdomains'],
				'type' => 'textul',
				'value' => 0,
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 9,
				)
			),
			'emails' => array(
				'label' => $lng['customer']['emails'],
				'type' => 'textul',
				'value' => 0,
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 9,
				)
			),
			'email_accounts' => array(
				'label' => $lng['customer']['accounts'],
				'type' => 'textul',
				'value' => 0,
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 9,
				)
			),
			'email_forwarders' => array(
				'label' => $lng['customer']['forwarders'],
				'type' => 'textul',
				'value' => 0,
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 9,
				)
			),
			'email_quota' => array(
				'label' => $lng['customer']['email_quota'],
				'type' => 'textul',
				'value' => 0,
				'visible' => (Settings::Get('system.mail_quota_enabled') == '1' ? true : false),
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 9,
				)
			),
			'email_imap' => array(
				'label' => $lng['customer']['email_imap'],
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => '1',
				'attributes' => array(
					'checked' => true
				)
			),
			'email_pop3' => array(
				'label' => $lng['customer']['email_pop3'],
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => '1',
				'attributes' => array(
					'checked' => true
				)
			),
			'ftps' => array(
				'label' => $lng['customer']['ftps'],
				'type' => 'textul',
				'value' => 0,
				'attributes' => array(
					'maxlength' => 9,
				)
			),
			'tickets' => array(
				'label' => $lng['customer']['tickets'],
				'type' => 'textul',
				'value' => 0,
				'visible' => (Settings::Get('ticket.enabled') == '1' ? true : false),
				'attributes' => array(
					'maxlength' => 9,
				)
			),
			'mysqls' => array(
				'label' => $lng['customer']['mysqls'],
				'type' => 'textul',
				'value' => 0,
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 9,
				)
			),
			'phpenabled' => array(
				'label' => $lng['admin']['phpenabled'].'?',
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => '1',
				'attributes' => array(
					'checked' => true
				)
			),
			'perlenabled' => array(
				'label' => $lng['admin']['perlenabled'].'?',
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => '1',
			)
		)
	),
	'movetoadmin' => array(
		'title' => $lng['admin']['movetoadmin'],
		'visible' => (isset($admin_select_cnt) && $admin_select_cnt > 1 && isset($result['loginname'])),
		'fields' => array(
			'move_to_admin' => array(
				'label' => $lng['admin']['movecustomertoadmin'],
				'type' => 'select',
				'values' => (isset($admin_select)) ? $admin_select : null
			)
		)
	)
);
