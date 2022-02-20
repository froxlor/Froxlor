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
	'admin_edit' => array(
		'title' => $lng['admin']['admin_edit'],
		'image' => 'fa-solid fa-user-pen',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['admin']['accountdata'],
				'image' => 'icons/user_edit.png',
				'fields' => array(
					'loginname' => array(
						'label' => $lng['login']['username'],
						'type' => 'label',
						'value' => $result['loginname']
					),
					'deactivated' => array(
						'label' => $lng['admin']['deactivated_user'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['deactivated'],
						'visible' => ($result['adminid'] == $userinfo['userid'] ? false : true)
					),
					'admin_password' => array(
						'label' => $lng['login']['password'] . '&nbsp;(' . $lng['panel']['emptyfornochanges'] . ')',
						'type' => 'password',
						'autocomplete' => 'off',
						'visible' => ($result['adminid'] == $userinfo['userid'] ? false : true),
						'next_to' => [
							'admin_password_suggestion' => array(
								'next_to_prefix' => $lng['customer']['generated_pwd'].':',
								'type' => 'text',
								'visible' => (\Froxlor\Settings::Get('panel.password_regex') == '' && ($result['adminid'] == $userinfo['userid'] ? false : true)),
								'value' => \Froxlor\System\Crypt::generatePassword(),
								'readonly' => true
							)
						]
					),
					'def_language' => array(
						'label' => $lng['login']['language'],
						'type' => 'select',
						'select_var' => $languages,
						'selected' => $result['def_language'],
						'visible' => ($result['adminid'] == $userinfo['userid'] ? false : true)
					),
					'api_allowed' => array(
						'label' => $lng['usersettings']['api_allowed']['title'],
						'desc' => $lng['usersettings']['api_allowed']['description'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['api_allowed'],
						'visible' => (\Froxlor\Settings::Get('api.enabled') == '1' ? true : false)
					)
				)
			),
			'section_b' => array(
				'title' => $lng['admin']['contactdata'],
				'image' => 'icons/user_edit.png',
				'fields' => array(
					'name' => array(
						'label' => $lng['customer']['name'],
						'type' => 'text',
						'mandatory' => true,
						'value' => $result['name']
					),
					'email' => array(
						'label' => $lng['customer']['email'],
						'type' => 'text',
						'mandatory' => true,
						'value' => $result['email']
					),
					'custom_notes' => array(
						'label' => $lng['usersettings']['custom_notes']['title'],
						'desc' => $lng['usersettings']['custom_notes']['description'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12,
						'value' => $result['custom_notes']
					),
					'custom_notes_show' => array(
						'label' => $lng['usersettings']['custom_notes']['show'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['custom_notes_show']
					)
				)
			),
			'section_c' => array(
				'title' => $lng['admin']['servicedata'],
				'image' => 'icons/user_add.png',
				'visible' => ($result['adminid'] != $userinfo['userid'] ? true : false),
				'fields' => array(
					'ipaddress' => array(
						'label' => $lng['serversettings']['ipaddress']['title'],
						'type' => 'select',
						'select_var' => $ipaddress,
						'selected' => $result['ip']
					),
					'change_serversettings' => array(
						'label' => $lng['admin']['change_serversettings'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['change_serversettings']
					),
					'customers' => array(
						'label' => $lng['admin']['customers'],
						'type' => 'textul',
						'value' => $result['customers'],
						'maxlength' => 9,
						'mandatory' => true
					),
					'customers_see_all' => array(
						'label' => $lng['admin']['customers_see_all'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['customers_see_all']
					),
					'domains' => array(
						'label' => $lng['admin']['domains'],
						'type' => 'textul',
						'value' => $result['domains'],
						'maxlength' => 9,
						'mandatory' => true
					),
					'domains_see_all' => array(
						'label' => $lng['admin']['domains_see_all'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['domains_see_all']
					),
					'caneditphpsettings' => array(
						'label' => $lng['admin']['caneditphpsettings'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => $result['caneditphpsettings']
					),
					'diskspace' => array(
						'label' => $lng['customer']['diskspace'] . ' (' . $lng['customer']['mib'] . ')',
						'type' => 'textul',
						'value' => $result['diskspace'],
						'maxlength' => 6,
						'mandatory' => true
					),
					'traffic' => array(
						'label' => $lng['customer']['traffic'] . ' (' . $lng['customer']['gib'] . ')',
						'type' => 'textul',
						'value' => $result['traffic'],
						'maxlength' => 4,
						'mandatory' => true
					),
					'subdomains' => array(
						'label' => $lng['customer']['subdomains'],
						'type' => 'textul',
						'value' => $result['subdomains'],
						'maxlength' => 9,
						'mandatory' => true
					),
					'emails' => array(
						'label' => $lng['customer']['emails'],
						'type' => 'textul',
						'value' => $result['emails'],
						'maxlength' => 9,
						'mandatory' => true
					),
					'email_accounts' => array(
						'label' => $lng['customer']['accounts'],
						'type' => 'textul',
						'value' => $result['email_accounts'],
						'maxlength' => 9,
						'mandatory' => true
					),
					'email_forwarders' => array(
						'label' => $lng['customer']['forwarders'],
						'type' => 'textul',
						'value' => $result['email_forwarders'],
						'maxlength' => 9,
						'mandatory' => true
					),
					'email_quota' => array(
						'label' => $lng['customer']['email_quota'] . ' (' . $lng['customer']['mib'] . ')',
						'type' => 'textul',
						'value' => $result['email_quota'],
						'maxlength' => 9,
						'visible' => (\Froxlor\Settings::Get('system.mail_quota_enabled') == '1' ? true : false),
						'mandatory' => true
					),
					'ftps' => array(
						'label' => $lng['customer']['ftps'],
						'type' => 'textul',
						'value' => $result['ftps'],
						'maxlength' => 9
					),
					'mysqls' => array(
						'label' => $lng['customer']['mysqls'],
						'type' => 'textul',
						'value' => $result['mysqls'],
						'maxlength' => 9,
						'mandatory' => true
					)
				)
			)
		)
	)
);
