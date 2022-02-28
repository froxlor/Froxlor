<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Panel
 *
 */
const AREA = 'customer';
require __DIR__ . '/lib/init.php';

use Froxlor\Api\Commands\Ftps as Ftps;
use Froxlor\Database\Database;
use Froxlor\Settings;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;

// redirect if this customer page is hidden via settings
if (Settings::IsInList('panel.customer_hide_options', 'ftp')) {
	\Froxlor\UI\Response::redirectTo('customer_index.php');
}

$id = (int) Request::get('id', 0);

if ($page == 'overview' || $page == 'accounts') {
	if ($action == '') {
		$log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, "viewed customer_ftp::accounts");
		try {
			$ftp_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/customer/tablelisting.ftps.php';
			$collection = (new \Froxlor\UI\Collection(\Froxlor\Api\Commands\Ftps::class, $userinfo))
				->withPagination($ftp_list_data['ftp_list']['columns']);
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}

		$actions_links = false;
		if ($userinfo['ftps_used'] < $userinfo['ftps'] || $userinfo['ftps'] == '-1') {
			$actions_links = [[
				'href' => $linker->getLink(['section' => 'ftp', 'page' => 'accounts', 'action' => 'add']),
				'label' => $lng['ftp']['account_add']
			]];
		}

		UI::twigBuffer('user/table.html.twig', [
			'listing' => \Froxlor\UI\Listing::format($collection, $ftp_list_data['ftp_list']),
			'actions_links' => $actions_links,
			'entity_info' => $lng['ftp']['description']
		]);
		UI::twigOutputBuffer();
	} elseif ($action == 'delete' && $id != 0) {
		try {
			$json_result = Ftps::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['username']) && $result['username'] != $userinfo['loginname']) {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					Ftps::getLocal($userinfo, $_POST)->delete();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {
				\Froxlor\UI\HTML::askYesNoWithCheckbox('ftp_reallydelete', 'admin_customer_alsoremoveftphomedir', $filename, array(
					'id' => $id,
					'page' => $page,
					'action' => $action
				), $result['username']);
			}
		} else {
			\Froxlor\UI\Response::standard_error('ftp_cantdeletemainaccount');
		}
	} elseif ($action == 'add') {
		if ($userinfo['ftps_used'] < $userinfo['ftps'] || $userinfo['ftps'] == '-1') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					Ftps::getLocal($userinfo, $_POST)->add();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {
				$pathSelect = \Froxlor\FileDir::makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid'], '/');

				if (Settings::Get('customer.ftpatdomain') == '1') {
					$domainlist = [];
					$result_domains_stmt = Database::prepare("SELECT `domain` FROM `" . TABLE_PANEL_DOMAINS . "`
						WHERE `customerid`= :customerid");
					Database::pexecute($result_domains_stmt, array(
						"customerid" => $userinfo['customerid']
					));

					while ($row_domain = $result_domains_stmt->fetch(PDO::FETCH_ASSOC)) {
						$domainlist[$row_domain['domain']] = $idna_convert->decode($row_domain['domain']);
					}
					sort($domainlist);
				}

				if (Settings::Get('system.allow_customer_shell') == '1') {
					$shells['/bin/false'] = "/bin/false";
					$shells_avail = Settings::Get('system.available_shells');
					if (!empty($shells_avail)) {
						$shells_avail = explode(",", $shells_avail);
						$shells_avail = array_map("trim", $shells_avail);
					}
				}

				$ftp_add_data = include_once dirname(__FILE__) . '/lib/formfields/customer/ftp/formfield.ftp_add.php';

				UI::twigBuffer('user/form.html.twig', [
					'formaction' => $linker->getLink(array('section' => 'ftp')),
					'formdata' => $ftp_add_data['ftp_add']
				]);
				UI::twigOutputBuffer();
			}
		}
	} elseif ($action == 'edit' && $id != 0) {
		try {
			$json_result = Ftps::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['username']) && $result['username'] != '') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					Ftps::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {
				if (strpos($result['homedir'], $userinfo['documentroot']) === 0) {
					$homedir = str_replace($userinfo['documentroot'], "/", $result['homedir']);
				} else {
					$homedir = $result['homedir'];
				}
				$homedir = \Froxlor\FileDir::makeCorrectDir($homedir);

				$pathSelect = \Froxlor\FileDir::makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid'], $homedir);

				if (Settings::Get('system.allow_customer_shell') == '1') {
					$shells['/bin/false'] = "/bin/false";
					$shells_avail = Settings::Get('system.available_shells');
					if (!empty($shells_avail)) {
						$shells_avail = explode(",", $shells_avail);
						$shells_avail = array_map("trim", $shells_avail);
					}
				}

				$ftp_edit_data = include_once dirname(__FILE__) . '/lib/formfields/customer/ftp/formfield.ftp_edit.php';

				UI::twigBuffer('user/form.html.twig', [
					'formaction' => $linker->getLink(array('section' => 'ftp', 'id' => $id)),
					'formdata' => $ftp_edit_data['ftp_edit'],
					'editid' => $id
				]);
				UI::twigOutputBuffer();
			}
		}
	}
}
