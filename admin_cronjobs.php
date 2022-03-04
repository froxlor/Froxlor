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
 * @package    Panel
 *
 */

const AREA = 'admin';
require __DIR__ . '/lib/init.php';

use Froxlor\Api\Commands\Cronjobs;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;

$id = (int) Request::get('id');

if ($page == 'cronjobs' || $page == 'overview') {
	if ($action == '') {
		$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, 'viewed admin_cronjobs');

		try {
			$cron_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/admin/tablelisting.cronjobs.php';
			$collection = (new \Froxlor\UI\Collection(\Froxlor\Api\Commands\Cronjobs::class, $userinfo))
				->withPagination($cron_list_data['cron_list']['columns']);
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}

		UI::twigBuffer('user/table-note.html.twig', [
			'listing' => \Froxlor\UI\Listing::format($collection, $cron_list_data['cron_list']),
			// alert-box
			'type' => 'warning',
			'alert_msg' => $lng['cron']['changewarning']
		]);
		UI::twigOutputBuffer();
	} elseif ($action == 'new') {
		/*
		 * @TODO later
		 */
	} elseif ($action == 'edit' && $id != 0) {
		try {
			$json_result = Cronjobs::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];
		if ($result['cronfile'] != '') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					Cronjobs::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {

				$cronjobs_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/cronjobs/formfield.cronjobs_edit.php';

				UI::twigBuffer('user/form.html.twig', [
					'formaction' => $linker->getLink(array('section' => 'cronjobs', 'id' => $id)),
					'formdata' => $cronjobs_edit_data['cronjobs_edit'],
					'editid' => $id
				]);
				UI::twigOutputBuffer();
			}
		}
	} elseif ($action == 'delete' && $id != 0) {
		/*
		 * @TODO later
		 */
	}
}
