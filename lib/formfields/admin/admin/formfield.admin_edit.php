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
		'image' => 'icons/user_edit.png',
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
                        'values' => array(
                                        array ('label' => $lng['panel']['yes'], 'value' => '1')
                                    ),
                        'value' => array($result['deactivated']),
						'visible' => ($result['adminid'] == $userinfo['userid'] ? false : true)
					),
					'admin_password' => array(
						'label' => $lng['login']['password'].'&nbsp;('.$lng['panel']['emptyfornochanges'].')',
						'type' => 'password',
						'autocomplete' => 'off',
						'visible' => ($result['adminid'] == $userinfo['userid'] ? false : true)
					),
					'admin_password_suggestion' => array(
						'label' => $lng['customer']['generated_pwd'],
						'type' => 'text',
						'value' => generatePassword(),
						'visible' => ($result['adminid'] == $userinfo['userid'] ? false : true)
					),
					'def_language' => array(
						'label' => $lng['login']['language'],
						'type' => 'select',
						'select_var' => $language_options,
						'visible' => ($result['adminid'] == $userinfo['userid'] ? false : true)
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
						'select_var' => $ipaddress
					),
					'change_serversettings' => array(
						'label' => $lng['admin']['change_serversettings'],
						'type' => 'checkbox',
                        'values' => array(
                                        array ('label' => $lng['panel']['yes'], 'value' => '1')
                                    ),
                        'value' => array($result['change_serversettings'])
					),
					'customers' => array(
						'label' => $lng['admin']['customers'],
						'type' => 'textul',
						'value' => $result['customers'],
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $customers_ul
					),
					'customers_see_all' => array(
						'label' => $lng['admin']['customers_see_all'],
						'type' => 'checkbox',
                        'values' => array(
                                        array ('label' => $lng['panel']['yes'], 'value' => '1')
                                    ),
                        'value' => array($result['customers_see_all'])
					),
					'domains' => array(
						'label' => $lng['admin']['domains'],
						'type' => 'textul',
						'value' => $result['domains'],
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $domains_ul
					),
					'domains_see_all' => array(
						'label' => $lng['admin']['domains_see_all'],
						'type' => 'checkbox',
                        'values' => array(
                                        array ('label' => $lng['panel']['yes'], 'value' => '1')
                                    ),
                        'value' => array($result['domains_see_all'])
					),
					'caneditphpsettings' => array(
						'label' => $lng['admin']['caneditphpsettings'],
						'type' => 'checkbox',
                        'values' => array(
                                        array ('label' => $lng['panel']['yes'], 'value' => '1')
                                    ),
                        'value' => array($result['caneditphpsettings'])
					),
					'diskspace' => array(
						'label' => $lng['customer']['diskspace'],
						'type' => 'textul',
						'value' => $result['diskspace'],
						'maxlength' => 6,
						'mandatory' => true,
						'ul_field' => $diskspace_ul
					),
					'traffic' => array(
						'label' => $lng['customer']['traffic'],
						'type' => 'textul',
						'value' => $result['traffic'],
						'maxlength' => 4,
						'mandatory' => true,
						'ul_field' => $traffic_ul
					),
					'subdomains' => array(
						'label' => $lng['customer']['subdomains'],
						'type' => 'textul',
						'value' => $result['subdomains'],
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $subdomains_ul
					),
					'emails' => array(
						'label' => $lng['customer']['emails'],
						'type' => 'textul',
						'value' => $result['emails'],
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $emails_ul
					),
					'email_accounts' => array(
						'label' => $lng['customer']['accounts'],
						'type' => 'textul',
						'value' => $result['email_accounts'],
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $email_accounts_ul
					),
					'email_forwarders' => array(
						'label' => $lng['customer']['forwarders'],
						'type' => 'textul',
						'value' => $result['email_forwarders'],
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $email_forwarders_ul
					),
					'email_quota' => array(
						'label' => $lng['customer']['email_quota'],
						'type' => 'textul',
						'value' => $result['email_quota'],
						'maxlength' => 9,
						'visible' => ($settings['system']['mail_quota_enabled'] == '1' ? true : false),
						'mandatory' => true,
						'ul_field' => $email_quota_ul
					),
					'email_autoresponder' => array(
						'label' => $lng['customer']['autoresponder'],
						'type' => 'textul',
						'value' => $result['email_autoresponder'],
						'maxlength' => 9,
						'visible' => ($settings['autoresponder']['autoresponder_active'] == '1' ? true : false),
						'ul_field' => $email_autoresponder_ul
					),
					'ftps' => array(
						'label' => $lng['customer']['ftps'],
						'type' => 'textul',
						'value' => $result['ftps'],
						'maxlength' => 9,
						'ul_field' => $ftps_ul
					),
					'tickets' => array(
						'label' => $lng['customer']['tickets'],
						'type' => 'textul',
						'value' => $result['tickets'],
						'maxlength' => 9,
						'visible' => ($settings['ticket']['enabled'] == '1' ? true : false),
						'ul_field' => $tickets_ul
					),
					'tickets_see_all' => array(
							'label' => $lng['admin']['tickets_see_all'],
							'type' => 'checkbox',
							'values' => array(
									array ('label' => $lng['panel']['yes'], 'value' => '1')
							),
							'value' => array($result['tickets_see_all'])
					),
					'mysqls' => array(
						'label' => $lng['customer']['mysqls'],
						'type' => 'textul',
						'value' => $result['mysqls'],
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $mysqls_ul
					),
					'can_manage_aps_packages' => array(
						'label' => $lng['aps']['canmanagepackages'],
						'type' => 'checkbox',
                        'values' => array(
                                        array ('label' => $lng['panel']['yes'], 'value' => '1')
                                    ),
                        'value' => array($result['can_manage_aps_packages']),
						'visible' => ($settings['aps']['aps_active'] == '1' ? true : false)
					),
					'number_of_aps_packages' => array(
						'label' => $lng['aps']['numberofapspackages'],
						'type' => 'textul',
						'value' => $result['aps_packages'],
						'maxlength' => 9,
						'visible' => ($settings['aps']['aps_active'] == '1' ? true : false),
						'ul_field' => $number_of_aps_packages_ul
					)
				)
			)
		)
	)
);
