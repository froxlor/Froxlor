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
				'value' => $result['loginname'],
				'visible' => 'edit'
			),
			'documentroot' => array(
				'label' => $lng['customer']['documentroot'],
				'type' => 'static',
				'value' => $result['documentroot'],
				'visible' => 'edit'
			),
			'createstdsubdomain' => array(
				'label' => $lng['admin']['stdsubdomain_add'].'?',
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => '1',
				'default' => true,
				'attributes' => array(
					'checked' => ($result['standardsubdomain'] != '0') ? true : false
				)
			),
			'store_defaultindex' => array(
				'label' => $lng['admin']['store_defaultindex'].'?',
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => '1',
				'default' => true,
				'visible' => 'new'
			),
			'deactivated' => array(
				'label' => $lng['admin']['deactivated_user'],
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => '1',
				'visible' => 'edit',
				'attributes' => array(
					'checked' => $result['deactivated']
				)
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
				'default' => generatePassword(),
				'attributes' => array(
					'readonly' => true
				)
			),
			'sendpassword' => array(
				'label' => $lng['admin']['sendpassword'],
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'default' => true,
				'visible' => 'new',
				'attributes' => array(
					'checked' => true
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
			'gender' => array(
				'label' => $lng['gender']['title'],
				'type' => 'select',
				'generate' => 'genders',
				'default' => '0',
				'selected' => $result['gender']
			),
			'name' => array(
				'label' => $lng['customer']['name'],
				'type' => 'text',
				'mandatory_ex' => true,
				'value' => $result['name']
			),
			'firstname' => array(
				'label' => $lng['customer']['firstname'],
				'type' => 'text',
				'mandatory_ex' => true,
				'value' => $result['firstname']
			),
			'company' => array(
				'label' => $lng['customer']['company'],
				'type' => 'text',
				'mandatory_ex' => true,
				'value' => $result['company']
			),
			'street' => array(
				'label' => $lng['customer']['street'],
				'type' => 'text',
				'value' => $result['street']
			),
			'zipcode' => array(
				'label' => $lng['customer']['zipcode'],
				'type' => 'text',
				'value' => $result['zipcode']
			),
			'city' => array(
				'label' => $lng['customer']['city'],
				'type' => 'text',
				'value' => $result['city']
			),
			'phone' => array(
				'label' => $lng['customer']['phone'],
				'type' => 'text',
				'value' => $result['phone']
			),
			'fax' => array(
				'label' => $lng['customer']['fax'],
				'type' => 'text',
				'value' => $result['fax']
			),
			'email' => array(
				'label' => $lng['customer']['email'],
				'type' => 'email',
				'mandatory' => true,
				'value' => $result['email']
			),
			'customernumber' => array(
				'label' => $lng['customer']['customernumber'],
				'type' => 'text',
				'value' => $result['customernumber']
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
				'attributes' => array(
					'checked' => ($result['custom_notes_show'] != '0') ? true : false
				)
			)
		)
	),
	'servicedata' => array(
		'title' => $lng['admin']['servicedata'],
		'fields' => array(
			'diskspace' => array(
				'label' => $lng['customer']['diskspace'],
				'type' => 'textul',
				'default' => 0,
				'value' => $result['diskspace'],
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 6,
				)
			),
			'traffic' => array(
				'label' => $lng['customer']['traffic'],
				'type' => 'textul',
				'default' => 0,
				'value' => $result['traffic'],
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 4,
				)
			),
			'subdomains' => array(
				'label' => $lng['customer']['subdomains'],
				'type' => 'textul',
				'default' => 0,
				'value' => $result['subdomains'],
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 9,
				)
			),
			'emails' => array(
				'label' => $lng['customer']['emails'],
				'type' => 'textul',
				'default' => 0,
				'value' => $result['emails'],
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 9,
				)
			),
			'email_accounts' => array(
				'label' => $lng['customer']['accounts'],
				'type' => 'textul',
				'default' => 0,
				'value' => $result['email_accounts'],
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 9,
				)
			),
			'email_forwarders' => array(
				'label' => $lng['customer']['forwarders'],
				'type' => 'textul',
				'default' => 0,
				'value' => $result['email_forwarders'],
				'mandatory' => true,
				'attributes' => array(
					'maxlength' => 9,
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
					'maxlength' => 9,
				)
			),
			'email_imap' => array(
				'label' => $lng['customer']['email_imap'],
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => '1',
				'default' => true,
				'attributes' => array(
					'checked' => ($result['imap'] != '0') ? true : false
				)
			),
			'email_pop3' => array(
				'label' => $lng['customer']['email_pop3'],
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => '1',
				'default' => true,
				'attributes' => array(
					'checked' => ($result['pop3'] != '0') ? true : false
				)
			),
			'ftps' => array(
				'label' => $lng['customer']['ftps'],
				'type' => 'textul',
				'default' => 0,
				'value' => $result['ftps'],
				'attributes' => array(
					'maxlength' => 9,
				)
			),
			'tickets' => array(
				'label' => $lng['customer']['tickets'],
				'type' => 'textul',
				'default' => 0,
				'value' => $result['tickets'],
				'visible' => (Settings::Get('ticket.enabled') == '1' ? true : false),
				'attributes' => array(
					'maxlength' => 9,
				)
			),
			'mysqls' => array(
				'label' => $lng['customer']['mysqls'],
				'type' => 'textul',
				'default' => 0,
				'value' => $result['mysqls'],
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
				'default' => true,
				'attributes' => array(
					'checked' => ($result['phpenabled'] != '0') ? true : false
				)
			),
			'perlenabled' => array(
				'label' => $lng['admin']['perlenabled'].'?',
				'type' => 'checkbox',
				'sublabel' => $lng['panel']['yes'],
				'value' => '1',
				'attributes' => array(
					'checked' => ($result['perlenabled'] != '0') ? true : false
				)
			)
		)
	),
	'movetoadmin' => array(
		'title' => $lng['admin']['movetoadmin'],
		'visible' => ($admin_select_cnt > 1 && isset($result['loginname'])),
		'fields' => array(
			'move_to_admin' => array(
				'label' => $lng['admin']['movecustomertoadmin'],
				'type' => 'select',
				'values' => $admin_select
			)
		)
	)
);
