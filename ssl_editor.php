<?php
if (!defined('AREA')) {
	header("Location: index.php");
	exit();
}

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2016-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Panel
 *
 */

use Froxlor\Database\Database;
use Froxlor\Api\Commands\Certificates;
use Froxlor\Api\Commands\SubDomains;
use Froxlor\UI\Panel\UI;

// This file is being included in admin_domains and customer_domains
// and therefore does not need to require lib/init.php

if ($action == '' || $action == 'view') {

	// get domain
	try {
		$json_result = SubDomains::getLocal($userinfo, array(
			'id' => $id
		))->get();
	} catch (Exception $e) {
		\Froxlor\UI\Response::dynamic_error($e->getMessage());
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
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		// back to domain overview
		\Froxlor\UI\Response::redirectTo($filename, array(
			'page' => 'domains'
		));
	}

	$stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "`
		WHERE `domainid`= :domainid");
	$result = Database::pexecute_first($stmt, array(
		"domainid" => $id
	));

	$do_insert = false;
	// if no entry can be found, behave like we have empty values
	if (!is_array($result) || !isset($result['ssl_cert_file'])) {
		$result = array(
			'ssl_cert_file' => '',
			'ssl_key_file' => '',
			'ssl_ca_file' => '',
			'ssl_cert_chainfile' => ''
		);
		$do_insert = true;
	}

	$result = \Froxlor\PhpHelper::htmlentitiesArray($result);

	$ssleditor_data = include_once dirname(__FILE__) . '/lib/formfields/formfield.domain_ssleditor.php';

	$title = ['title'];
	$image = $ssleditor_data['domain_ssleditor']['image'];

	UI::view('user/form.html.twig', [
		'formaction' => $linker->getLink(array('section' => 'domains', 'page' => 'domainssleditor', 'id' => $id)),
		'formdata' => $ssleditor_data['domain_ssleditor'],
		'editid' => $id,
		'actions_links' => [[
			'class' => 'btn-outline-primary',
			'href' => $linker->getLink(['section' => 'domains', 'page' => 'overview']),
			'label' => $lng['admin']['domains'],
			'icon' => 'fa fa-globe'
		]]
	]);
}
