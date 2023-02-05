<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

use Froxlor\Settings;

return [
	'emails_edit' => [
		'title' => lng('emails.emails_edit'),
		'image' => 'fa-solid fa-pen',
		'self_overview' => ['section' => 'email', 'page' => 'email_domain', 'domainid' => $result['domainid']],
		'sections' => [
			'section_a' => [
				'title' => lng('emails.emails_edit'),
				'image' => 'icons/email_edit.png',
				'fields' => [
					'email_full' => [
						'label' => lng('emails.emailaddress'),
						'type' => 'label',
						'value' => $result['email_full']
					],
					'account_yes' => [
						'visible' => (int)$result['popaccountid'] != 0,
						'label' => lng('emails.account'),
						'type' => 'label',
						'value' => lng('panel.yes'),
						'next_to' => [
							'edit_link' => [
								'type' => 'link',
								'href' => $filename . '?page=accounts&amp;domainid=' . $result['domainid'] . '&amp;action=changepw&amp;id=' . $result['id'],
								'label' => lng('menue.main.changepassword'),
								'classes' => 'btn btn-sm btn-secondary'
							],
							'del_link' => [
								'type' => 'link',
								'href' => $filename . '?page=accounts&amp;domainid=' . $result['domainid'] . '&amp;action=delete&amp;id=' . $result['id'],
								'label' => lng('emails.account_delete'),
								'classes' => 'btn btn-sm btn-danger'
							]
						]
					],
					'account_no' => [
						'visible' => (int)$result['popaccountid'] == 0,
						'label' => lng('emails.account'),
						'type' => 'label',
						'value' => lng('panel.no'),
						'next_to' => [
							'add_link' => [
								'type' => 'link',
								'href' => $filename . '?page=accounts&amp;domainid=' . $result['domainid'] . '&amp;action=add&amp;id=' . $result['id'],
								'label' => lng('emails.account_add'),
								'classes' => 'btn btn-sm btn-primary'
							]
						]
					],
					'mail_quota' => [
						'visible' => ((int)$result['popaccountid'] != 0 && Settings::Get('system.mail_quota_enabled')),
						'label' => lng('customer.email_quota'),
						'type' => 'label',
						'value' => $result['quota'] . ' MiB',
						'next_to' => [
							'add_link' => [
								'visible' => ((int)$result['popaccountid'] != 0 && Settings::Get('system.mail_quota_enabled')),
								'type' => 'link',
								'href' => $filename . '?page=accounts&amp;domainid=' . $result['domainid'] . '&amp;action=changequota&amp;id=' . $result['id'],
								'label' => lng('emails.quota_edit'),
								'classes' => 'btn btn-sm btn-secondary'
							]
						]
					],
					'mail_catchall' => [
						'label' => lng('emails.catchall'),
						'type' => 'label',
						'value' => ((int)$result['iscatchall'] == 0 ? lng('panel.no') : lng('panel.yes')),
						'next_to' => [
							'add_link' => [
								'type' => 'link',
								'href' => $filename . '?page=' . $page . '&amp;domainid=' . $result['domainid'] . '&amp;action=togglecatchall&amp;id=' . $result['id'],
								'label' => '<i class="fa-solid fa-arrow-right-arrow-left"></i> ' . lng('panel.toggle'),
								'classes' => 'btn btn-sm btn-secondary'
							]
						]
					],
					'mail_fwds' => [
						'label' => lng('emails.forwarders') . ' (' . $forwarders_count . ')',
						'type' => 'itemlist',
						'values' => $forwarders,
						'next_to' => [
							'add_link' => [
								'type' => 'link',
								'href' => $filename . '?page=forwarders&amp;domainid=' . $result['domainid'] . '&amp;action=add&amp;id=' . $result['id'],
								'label' => lng('emails.forwarder_add'),
								'classes' => 'btn btn-sm btn-primary'
							]
						]
					]
				]
			]
		],
		'buttons' => [
			/* none */
		]
	]
];
