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

if (!defined('AREA')) {
	header("Location: index.php");
	exit();
}

use Froxlor\Api\Commands\Certificates;
use Froxlor\Api\Commands\SubDomains;
use Froxlor\Database\Database;
use Froxlor\PhpHelper;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Response;

// This file is being included in admin_domains and customer_domains
// and therefore does not need to require lib/init.php

if ($action == '' || $action == 'view') {
	// get domain
	try {
		$json_result = SubDomains::getLocal($userinfo, [
			'id' => $id
		])->get();
	} catch (Exception $e) {
		Response::dynamicError($e->getMessage());
	}
	$result_domain = json_decode($json_result, true)['data'];

	if (isset($_POST['send']) && $_POST['send'] == 'send') {
		$do_insert = isset($_POST['do_insert']) && ((($_POST['do_insert'] == 1) ? true : false));
		try {
			if ($do_insert) {
				Certificates::getLocal($userinfo, $_POST)->add();
			} else {
				Certificates::getLocal($userinfo, $_POST)->update();
			}
		} catch (Exception $e) {
			Response::dynamicError($e->getMessage());
		}
		// back to domain overview
		Response::redirectTo($filename, [
			'page' => 'domains'
		]);
	}

	$stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "`
		WHERE `domainid`= :domainid");
	$result = Database::pexecute_first($stmt, [
		"domainid" => $id
	]);

	$do_insert = false;
	// if no entry can be found, behave like we have empty values
	if (!is_array($result) || !isset($result['ssl_cert_file'])) {
		$result = [
			'ssl_cert_file' => '',
			'ssl_key_file' => '',
			'ssl_ca_file' => '',
			'ssl_cert_chainfile' => ''
		];
		$do_insert = true;
	}

	$result = PhpHelper::htmlentitiesArray($result);

	$ssleditor_data = include_once dirname(__FILE__) . '/lib/formfields/formfield.domain_ssleditor.php';

	$title = ['title'];
	$image = $ssleditor_data['domain_ssleditor']['image'];

	UI::view('user/form.html.twig', [
		'formaction' => $linker->getLink(['section' => 'domains', 'page' => 'domainssleditor', 'id' => $id]),
		'formdata' => $ssleditor_data['domain_ssleditor'],
		'editid' => $id,
		'actions_links' => [
			[
				'class' => 'btn-outline-secondary',
				'href' => $linker->getLink([
					'section' => 'domains',
					'page' => 'domains',
					'action' => 'edit',
					'id' => $id
				]),
				'label' => lng('admin.domain_edit'),
				'icon' => 'fa-solid fa-pen'
			],
			[
				'class' => 'btn-outline-primary',
				'href' => $linker->getLink(['section' => 'domains', 'page' => 'overview']),
				'label' => lng('admin.domains'),
				'icon' => 'fa-solid fa-globe'
			]
		]
	]);
}
