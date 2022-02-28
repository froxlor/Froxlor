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
 * @author     Maurice Preuß <hello@envoyr.com>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Tabellisting
 *
 */

use Froxlor\Settings;
use Froxlor\UI\Callbacks\Email;
use Froxlor\UI\Callbacks\Text;
use Froxlor\UI\Listing;

return [
	'email_list' => [
		'title' => $lng['menue']['email']['emails'],
		'icon' => 'fa-solid fa-envelope',
		'columns' => [
			'm.email_full' => [
				'label' => $lng['emails']['emailaddress'],
				'field' => 'email_full',
			],
			'm.destination' => [
				'label' => $lng['emails']['forwarders'],
				'field' => 'destination',
				// @todo formatting
			],
			'm.popaccountid' => [
				'label' => $lng['emails']['account'],
				'field' => 'popaccountid',
				'format_callback' => [Email::class, 'account'],
			],
			'm.iscatchall' => [
				'label' => $lng['emails']['catchall'],
				'field' => 'iscatchall',
				'format_callback' => [Text::class, 'boolean'],
				'visible' => Settings::Get('catchall.catchall_enabled') == '1'
			],
			'm.quota' => [
				'label' => $lng['emails']['quota'],
				'field' => 'quota',
				'visible' => Settings::Get('system.mail_quota_enabled') == '1'
			]
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('email_list', [
			'm.email_full',
			'm.destination',
			'm.popaccountid',
			'm.iscatchall',
			'm.quota'
		]),
		'actions' => [
			'edit' => [
				'icon' => 'fa fa-edit',
				'title' => $lng['panel']['edit'],
				'href' => [
					'section' => 'email',
					'page' => 'emails',
					'action' => 'edit',
					'id' => ':id'
				],
			],
			'delete' => [
				'icon' => 'fa fa-trash',
				'title' => $lng['panel']['delete'],
				'class' => 'text-danger',
				'href' => [
					'section' => 'email',
					'page' => 'emails',
					'action' => 'delete',
					'id' => ':id'
				],
			]
		]
	]
];
