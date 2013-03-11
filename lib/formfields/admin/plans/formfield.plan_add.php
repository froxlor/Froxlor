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
	'plan_add' => array(
		'title' => $lng['admin']['plans']['plan_add'],
		'image' => 'icons/domain_add.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['admin']['servicedata'],
				'image' => 'icons/user_add.png',
				'fields' => array(
					'plan_name' => array(
						'label' => $lng['admin']['plans']['plan_name'],
						'type' => 'text',
						'mandatory' => true
					),
					'change_serversettings' => array(
						'visible' => ($plan_type == 0 ? true : false),
						'label' => $lng['admin']['change_serversettings'],
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array()
					),
					'customers' => array(
						'visible' => ($plan_type == 0 ? true : false),
						'label' => $lng['admin']['customers'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $customers_ul
					),
					'customers_see_all' => array(
						'visible' => ($plan_type == 0 ? true : false),
						'label' => $lng['admin']['customers_see_all'],
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array()
					),
					'domains' => array(
						'visible' => ($plan_type == 0 ? true : false),
						'label' => $lng['admin']['domains'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $domains_ul
					),
					'domains_see_all' => array(
						'visible' => ($plan_type == 0 ? true : false),
						'label' => $lng['admin']['domains_see_all'],
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array()
					),
					'caneditphpsettings' => array(
						'visible' => ($plan_type == 0 ? true : false),
						'label' => $lng['admin']['caneditphpsettings'],
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array()
					),
					'diskspace' => array(
						'label' => $lng['customer']['diskspace'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 6,
						'mandatory' => true,
						'ul_field' => $diskspace_ul
					),
					'traffic' => array(
						'label' => $lng['customer']['traffic'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 4,
						'mandatory' => true,
						'ul_field' => $traffic_ul
					),
					'subdomains' => array(
						'label' => $lng['customer']['subdomains'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $subdomains_ul
					),
					'emails' => array(
						'label' => $lng['customer']['emails'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $emails_ul
					),
					'email_accounts' => array(
						'label' => $lng['customer']['accounts'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $email_accounts_ul
					),
					'email_forwarders' => array(
						'label' => $lng['customer']['forwarders'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $email_forwarders_ul
					),
					'email_quota' => array(
						'label' => $lng['customer']['email_quota'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'visible' => ($settings['system']['mail_quota_enabled'] == '1' ? true : false),
						'mandatory' => true,
						'ul_field' => $email_quota_ul
					),
					'email_autoresponder' => array(
						'label' => $lng['customer']['autoresponder'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'visible' => ($settings['autoresponder']['autoresponder_active'] == '1' ? true : false),
						'ul_field' => $email_autoresponder_ul
					),
					'email_imap' => array(
						'label' => $lng['customer']['email_imap'],
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array('1'),
						'mandatory' => true
					),
					'email_pop3' => array(
						'label' => $lng['customer']['email_pop3'],
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array('1'),
						'mandatory' => true
					),
					'ftps' => array(
						'label' => $lng['customer']['ftps'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'ul_field' => $ftps_ul
					),
					'tickets' => array(
						'label' => $lng['customer']['tickets'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'visible' => ($settings['ticket']['enabled'] == '1' ? true : false),
						'ul_field' => $tickets_ul
					),
					'mysqls' => array(
						'label' => $lng['customer']['mysqls'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'mandatory' => true,
						'ul_field' => $mysqls_ul
					),
					'phpenabled' => array(
						'label' => $lng['admin']['phpenabled'].'?',
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array('1')
					),
					'perlenabled' => array(
						'label' => $lng['admin']['perlenabled'].'?',
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									)
					),
					'backup_allowed' => array(
						'label' => $lng['backup_allowed'].'?',
						'type' => 'yesno',
						'value' => 0,
						'yesno_var' => $backup_allowed,
						'visible' => (($settings['system']['backup_enabled'] == '1' && $plan_type == 1) ? true : false)
					),
					'can_manage_aps_packages' => array(
						'label' => $lng['aps']['canmanagepackages'],
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array(),
						'visible' => (($settings['aps']['aps_active'] == '1' && $plan_type == 0) ? true : false)
					),
					'number_of_aps_packages' => array(
						'label' => $lng['aps']['numberofapspackages'],
						'type' => 'textul',
						'value' => 0,
						'maxlength' => 9,
						'visible' => ($settings['aps']['aps_active'] == '1' ? true : false),
						'ul_field' => $number_of_aps_packages_ul
					)
				)
			)
		)
	)
);
