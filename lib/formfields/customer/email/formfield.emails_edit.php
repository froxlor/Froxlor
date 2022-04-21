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
	'emails_edit' => array(
		'title' => $lng['emails']['emails_edit'],
		'image' => 'fa-solid fa-pen',
		'self_overview' => ['section' => 'email', 'page' => 'emails'],
		'sections' => array(
			'section_a' => array(
				'title' => $lng['emails']['emails_edit'],
				'image' => 'icons/email_edit.png',
				'nobuttons' => true,
				'fields' => array(
					'email_full' => array(
						'label' => $lng['emails']['emailaddress'],
						'type' => 'label',
						'value' => $result['email_full']
					),
					'account_yes' => array(
						'visible' => (int) $result['popaccountid'] != 0,
						'label' => $lng['emails']['account'],
						'type' => 'label',
						'value' => $lng['panel']['yes'],
						'next_to' => [
							'edit_link' => [
								'type' => 'link',
								'href' => $filename . '?page=accounts&amp;action=changepw&amp;id=' . $result['id'],
								'label' => $lng['menue']['main']['changepassword'],
								'classes' => 'btn btn-sm btn-secondary'
							],
							'del_link' => [
								'type' => 'link',
								'href' => $filename . '?page=accounts&amp;action=delete&amp;id=' . $result['id'],
								'label' => $lng['emails']['account_delete'],
								'classes' => 'btn btn-sm btn-danger'
							]
						]
					),
					'account_no' => array(
						'visible' => (int) $result['popaccountid'] == 0,
						'label' => $lng['emails']['account'],
						'type' => 'label',
						'value' => $lng['panel']['no'],
						'next_to' => [
							'add_link' => [
								'type' => 'link',
								'href' => $filename . '?page=accounts&amp;action=add&amp;id=' . $result['id'],
								'label' => $lng['emails']['account_add'],
								'classes' => 'btn btn-sm btn-primary'
							]
						]
					),
					'mail_quota' => array(
						'visible' => ((int) $result['popaccountid'] != 0 && \Froxlor\Settings::Get('system.mail_quota_enabled')),
						'label' => $lng['customer']['email_quota'],
						'type' => 'label',
						'value' => $result['quota'] . ' MiB',
						'next_to' => [
							'add_link' => [
								'visible' => ((int)$result['popaccountid'] != 0 && \Froxlor\Settings::Get('system.mail_quota_enabled')),
								'type' => 'link',
								'href' => $filename . '?page=accounts&amp;action=changequota&amp;id=' . $result['id'],
								'label' => $lng['emails']['quota_edit'],
								'classes' => 'btn btn-sm btn-secondary'
							]
						]
					),
					'mail_catchall' => array(
						'label' => $lng['emails']['catchall'],
						'type' => 'label',
						'value' => ((int)$result['iscatchall'] == 0 ? $lng['panel']['no'] : $lng['panel']['yes']),
						'next_to' => [
							'add_link' => [
								'type' => 'link',
								'href' => $filename . '?page=' . $page . '&amp;action=togglecatchall&amp;id=' . $result['id'],
								'label' => '<i class="fa-solid fa-arrow-right-arrow-left"></i> ' . $lng['panel']['toggle'],
								'classes' => 'btn btn-sm btn-secondary'
							]
						]
					),
					'mail_fwds' => array(
						'label' => $lng['emails']['forwarders'] . ' (' . $forwarders_count . ')',
						'type' => 'itemlist',
						'values' => $forwarders,
						'next_to' => [
							'add_link' => [
								'type' => 'link',
								'href' => $filename . '?page=forwarders&amp;action=add&amp;id=' . $result['id'],
								'label' => $lng['emails']['forwarder_add'],
								'classes' => 'btn btn-sm btn-primary'
							]
						]
					)
				)
			)
		)
	)
);
