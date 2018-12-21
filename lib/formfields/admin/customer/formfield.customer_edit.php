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
	'customer_edit' => array(
		'title' => \Froxlor\I18N\Lang::getAll()['admin']['customer_edit'],
		'image' => 'icons/user_edit.png',
		'sections' => array(
			'section_a' => array(
				'title' => \Froxlor\I18N\Lang::getAll()['admin']['accountdata'],
				'image' => 'icons/user_edit.png',
				'fields' => array(
					'loginname' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['login']['username'],
						'type' => 'label',
						'value' => $result['loginname']
					),
					'documentroot' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['documentroot'],
						'type' => 'label',
						'value' => $result['documentroot']
					),
					'createstdsubdomain' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['stdsubdomain_add'] . '?',
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							($result['standardsubdomain'] != '0') ? '1' : '0'
						)
					),
					'deactivated' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['deactivated_user'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['deactivated']
						)
					),
					'new_customer_password' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['login']['password'] . '&nbsp;(' . \Froxlor\I18N\Lang::getAll()['panel']['emptyfornochanges'] . ')',
						'type' => 'password',
						'autocomplete' => 'off'
					),
					'new_customer_password_suggestion' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['generated_pwd'],
						'type' => 'text',
						'visible' => (\Froxlor\Settings::Get('panel.password_regex') == ''),
						'value' => \Froxlor\System\Crypt::generatePassword()
					),
					'def_language' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['login']['language'],
						'type' => 'select',
						'select_var' => $language_options
					)
				)
			),
			'section_b' => array(
				'title' => \Froxlor\I18N\Lang::getAll()['admin']['contactdata'],
				'image' => 'icons/user_edit.png',
				'fields' => array(
					'name' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['name'],
						'type' => 'text',
						'mandatory_ex' => true,
						'value' => $result['name']
					),
					'firstname' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['firstname'],
						'type' => 'text',
						'mandatory_ex' => true,
						'value' => $result['firstname']
					),
					'gender' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['gender']['title'],
						'type' => 'select',
						'select_var' => $gender_options
					),
					'company' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['company'],
						'type' => 'text',
						'mandatory_ex' => true,
						'value' => $result['company']
					),
					'street' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['street'],
						'type' => 'text',
						'value' => $result['street']
					),
					'zipcode' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['zipcode'],
						'type' => 'text',
						'value' => $result['zipcode']
					),
					'city' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['city'],
						'type' => 'text',
						'value' => $result['city']
					),
					'phone' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['phone'],
						'type' => 'text',
						'value' => $result['phone']
					),
					'fax' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['fax'],
						'type' => 'text',
						'value' => $result['fax']
					),
					'email' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['email'],
						'type' => 'text',
						'mandatory' => true,
						'value' => $result['email']
					),
					'customernumber' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['customernumber'],
						'type' => 'text',
						'value' => $result['customernumber']
					),
					'custom_notes' => array(
						'style' => 'align-top',
						'label' => \Froxlor\I18N\Lang::getAll()['usersettings']['custom_notes']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['usersettings']['custom_notes']['description'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12,
						'value' => $result['custom_notes']
					),
					'custom_notes_show' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['usersettings']['custom_notes']['show'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['custom_notes_show']
						)
					)
				)
			),
			'section_cpre' => array(
				'visible' => ! empty($hosting_plans),
				'title' => \Froxlor\I18N\Lang::getAll()['admin']['plans']['use_plan'],
				'image' => 'icons/user_add.png',
				'fields' => array(
					'use_plan' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['plans']['use_plan'],
						'type' => 'select',
						'select_var' => $hosting_plans
					)
				)
			),
			'section_c' => array(
				'title' => \Froxlor\I18N\Lang::getAll()['admin']['servicedata'],
				'image' => 'icons/user_edit.png',
				'fields' => array(
					'diskspace' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['diskspace'],
						'type' => 'textul',
						'value' => $result['diskspace'],
						'maxlength' => 16,
						'mandatory' => true,
						'ul_field' => $diskspace_ul
					),
					'traffic' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['traffic'],
						'type' => 'textul',
						'value' => $result['traffic'],
						'maxlength' => 14,
						'mandatory' => true,
						'ul_field' => $traffic_ul
					),
					'subdomains' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['subdomains'],
						'type' => 'textul',
						'value' => $result['subdomains'],
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $subdomains_ul
					),
					'emails' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['emails'],
						'type' => 'textul',
						'value' => $result['emails'],
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $emails_ul
					),
					'email_accounts' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['accounts'],
						'type' => 'textul',
						'value' => $result['email_accounts'],
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $email_accounts_ul
					),
					'email_forwarders' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['forwarders'],
						'type' => 'textul',
						'value' => $result['email_forwarders'],
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $email_forwarders_ul
					),
					'email_quota' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['email_quota'],
						'type' => 'textul',
						'value' => $result['email_quota'],
						'maxlength' => 9,
						'visible' => (\Froxlor\Settings::Get('system.mail_quota_enabled') == '1' ? true : false),
						'mandatory' => true,
						'ul_field' => $email_quota_ul
					),
					'email_imap' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['email_imap'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['imap']
						),
						'mandatory' => true
					),
					'email_pop3' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['email_pop3'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['pop3']
						),
						'mandatory' => true
					),
					'ftps' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['ftps'],
						'type' => 'textul',
						'value' => $result['ftps'],
						'maxlength' => 9,
						'ul_field' => $ftps_ul
					),
					'mysqls' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['mysqls'],
						'type' => 'textul',
						'value' => $result['mysqls'],
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $mysqls_ul
					),
					'phpenabled' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['phpenabled'] . '?',
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['phpenabled']
						)
					),
					'allowed_phpconfigs' => array(
						'visible' => (((int) \Froxlor\Settings::Get('system.mod_fcgid') == 1 || (int) \Froxlor\Settings::Get('phpfpm.enabled') == 1) ? true : false),
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['phpsettings']['title'],
						'type' => 'checkbox',
						'values' => $phpconfigs,
						'value' => isset($result['allowed_phpconfigs']) && ! empty($result['allowed_phpconfigs']) ? json_decode($result['allowed_phpconfigs'], JSON_OBJECT_AS_ARRAY) : array(),
						'is_array' => 1
					),
					'perlenabled' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['perlenabled'] . '?',
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['perlenabled']
						)
					),
					'dnsenabled' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['dnsenabled'] . '?',
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['dnsenabled']
						),
						'visible' => (\Froxlor\Settings::Get('system.dnsenabled') == '1' ? true : false)
					),
					'logviewenabled' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['logviewenabled'] . '?',
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array(
							$result['logviewenabled']
						)
					)
				)
			),
			'section_d' => array(
				'title' => \Froxlor\I18N\Lang::getAll()['admin']['movetoadmin'],
				'image' => 'icons/user_edit.png',
				'visible' => ($admin_select_cnt > 1),
				'fields' => array(
					'move_to_admin' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['movecustomertoadmin'],
						'type' => 'select',
						'select_var' => $admin_select
					)
				)
			)
		)
	)
);
