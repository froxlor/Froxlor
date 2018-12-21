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
		'title' => \Froxlor\I18N\Lang::getAll()['emails']['emails_edit'],
		'image' => 'icons/email_edit.png',
		'sections' => array(
			'section_a' => array(
				'title' => \Froxlor\I18N\Lang::getAll()['emails']['emails_edit'],
				'image' => 'icons/email_edit.png',
				'nobuttons' => true,
				'fields' => array(
					'email_full' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['emails']['emailaddress'],
						'type' => 'label',
						'value' => $result['email_full']
					),
					'account_yes' => array(
						'visible' => ($result['popaccountid'] != 0 ? true : false),
						'label' => \Froxlor\I18N\Lang::getAll()['emails']['account'],
						'type' => 'label',
						'value' => \Froxlor\I18N\Lang::getAll()['panel']['yes'] . '&nbsp;[<a href="' . $filename . '?page=accounts&amp;action=changepw&amp;id=' . $result['id'] . '&amp;s=' . $s . '">' . \Froxlor\I18N\Lang::getAll()['menue']['main']['changepassword'] . '</a>] [<a href="' . $filename . '?page=accounts&amp;action=delete&amp;id=' . $result['id'] . '&amp;s=' . $s . '">' . \Froxlor\I18N\Lang::getAll()['emails']['account_delete'] . '</a>]'
					),
					'account_no' => array(
						'visible' => ($result['popaccountid'] == 0 ? true : false),
						'label' => \Froxlor\I18N\Lang::getAll()['emails']['account'],
						'type' => 'label',
						'value' => \Froxlor\I18N\Lang::getAll()['panel']['no'] . '&nbsp;[<a href="' . $filename . '?page=accounts&amp;action=add&amp;id=' . $result['id'] . '&amp;s=' . $s . '">' . \Froxlor\I18N\Lang::getAll()['emails']['account_add'] . '</a>]'
					),
					'mail_quota' => array(
						'visible' => ($result['popaccountid'] != 0 && \Froxlor\Settings::Get('system.mail_quota_enabled')),
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['email_quota'],
						'type' => 'label',
						'value' => $result['quota'] . ' MiB [<a href="' . $filename . '?page=accounts&amp;action=changequota&amp;id=' . $result['id'] . '&amp;s=' . $s . '">' . \Froxlor\I18N\Lang::getAll()['emails']['quota_edit'] . '</a>]'
					),
					'mail_catchall' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['emails']['catchall'],
						'type' => 'label',
						'value' => ($result['iscatchall'] == 0 ? \Froxlor\I18N\Lang::getAll()['panel']['no'] : \Froxlor\I18N\Lang::getAll()['panel']['yes']) . ' [<a href="' . $filename . '?page=' . $page . '&amp;action=togglecatchall&amp;id=' . $result['id'] . '&amp;s=' . $s . '">' . \Froxlor\I18N\Lang::getAll()['panel']['toggle'] . '</a>]'
					),
					'mail_fwds' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['emails']['forwarders'] . ' (' . $forwarders_count . ')',
						'type' => 'label',
						'value' => $forwarders . ' <a href="' . $filename . '?page=forwarders&amp;action=add&amp;id=' . $result['id'] . '&amp;s=' . $s . '">' . \Froxlor\I18N\Lang::getAll()['emails']['forwarder_add'] . '</a>'
					)
				)
			)
		)
	)
);
