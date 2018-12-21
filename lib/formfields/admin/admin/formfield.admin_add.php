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
	'admin_add' => array(
		'title' => \Froxlor\I18N\Lang::getAll()['admin']['admin_add'],
		'image' => 'icons/user_add.png',
		'sections' => array(
			'section_a' => array(
				'title' => \Froxlor\I18N\Lang::getAll()['admin']['accountdata'],
				'image' => 'icons/user_add.png',
				'fields' => array(
					'new_loginname' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['login']['username'],
						'type' => 'text',
						'mandatory' => true
					),
					'admin_password' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['login']['password'],
						'type' => 'password',
						'mandatory' => true,
						'autocomplete' => 'off'
					),
					'admin_password_suggestion' => array(
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
				'image' => 'icons/user_add.png',
				'fields' => array(
					'name' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['name'],
						'type' => 'text',
						'mandatory' => true
					),
					'email' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['email'],
						'type' => 'text',
						'mandatory' => true
					),
					'custom_notes' => array(
						'style' => 'align-top',
						'label' => \Froxlor\I18N\Lang::getAll()['usersettings']['custom_notes']['title'],
						'desc' => \Froxlor\I18N\Lang::getAll()['usersettings']['custom_notes']['description'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12
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
						'value' => array()
					)
				)
			),
			'section_c' => array(
				'title' => \Froxlor\I18N\Lang::getAll()['admin']['servicedata'],
				'image' => 'icons/user_add.png',
				'fields' => array(
					'ipaddress' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['ipaddress']['title'],
						'type' => 'select',
						'select_var' => $ipaddress
					),
					'change_serversettings' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['change_serversettings'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array()
					),
					'customers' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['customers'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $customers_ul
					),
					'customers_see_all' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['customers_see_all'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array()
					),
					'domains' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['domains'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $domains_ul
					),
					'domains_see_all' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['domains_see_all'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array()
					),
					'caneditphpsettings' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['admin']['caneditphpsettings'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array()
					),
					'diskspace' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['diskspace'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 6,
						'mandatory' => true,
						'ul_field' => $diskspace_ul
					),
					'traffic' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['traffic'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 4,
						'mandatory' => true,
						'ul_field' => $traffic_ul
					),
					'subdomains' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['subdomains'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $subdomains_ul
					),
					'emails' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['emails'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $emails_ul
					),
					'email_accounts' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['accounts'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $email_accounts_ul
					),
					'email_forwarders' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['forwarders'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $email_forwarders_ul
					),
					'email_quota' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['email_quota'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'visible' => (\Froxlor\Settings::Get('system.mail_quota_enabled') == '1' ? true : false),
						'mandatory' => true,
						'ul_field' => $email_quota_ul
					),
					'ftps' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['ftps'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'ul_field' => $ftps_ul
					),
					'mysqls' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['mysqls'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $mysqls_ul
					)
				)
			)
		)
	)
);
