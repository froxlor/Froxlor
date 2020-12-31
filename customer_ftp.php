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
define('AREA', 'customer');
require './lib/init.php';

use Froxlor\Database\Database;
use Froxlor\Settings;
use Froxlor\Api\Commands\Ftps as Ftps;

// redirect if this customer page is hidden via settings
if (Settings::IsInList('panel.customer_hide_options', 'ftp')) {
	\Froxlor\UI\Response::redirectTo('customer_index.php');
}

$id = 0;
if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
} elseif (isset($_GET['id'])) {
	$id = intval($_GET['id']);
}

if ($page == 'overview') {
	$log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, "viewed customer_ftp");
	eval("echo \"" . \Froxlor\UI\Template::getTemplate('ftp/ftp') . "\";");
} elseif ($page == 'accounts') {
	if ($action == '') {
		$log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, "viewed customer_ftp::accounts");
		$fields = array(
			'username' => $lng['login']['username'],
			'homedir' => $lng['panel']['path'],
			'description' => $lng['panel']['ftpdesc']
		);
		try {
			// get total count
			$json_result = Ftps::getLocal($userinfo)->listingCount();
			$result = json_decode($json_result, true)['data'];
			// initialize pagination and filtering
			$paging = new \Froxlor\UI\Pagination($userinfo, $fields, $result);
			// get list
			$json_result = Ftps::getLocal($userinfo, $paging->getApiCommandParams())->listing();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];
		$ftps_count = $paging->getEntries();
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$count = 0;
		$accounts = '';

		foreach ($result['list'] as $row) {
			if (strpos($row['homedir'], $userinfo['documentroot']) === 0) {
				$row['documentroot'] = str_replace($userinfo['documentroot'], "/", $row['homedir']);
			} else {
				$row['documentroot'] = $row['homedir'];
			}
			$row['documentroot'] = \Froxlor\FileDir::makeCorrectDir($row['documentroot']);
			$row = \Froxlor\PhpHelper::htmlentitiesArray($row);
			eval("\$accounts.=\"" . \Froxlor\UI\Template::getTemplate('ftp/accounts_account') . "\";");
			$count ++;
		}

		eval("echo \"" . \Froxlor\UI\Template::getTemplate('ftp/accounts') . "\";");
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
					$domainlist = array();
					$domains = '';

					$result_domains_stmt = Database::prepare("SELECT `domain` FROM `" . TABLE_PANEL_DOMAINS . "`
						WHERE `customerid`= :customerid");
					Database::pexecute($result_domains_stmt, array(
						"customerid" => $userinfo['customerid']
					));

					while ($row_domain = $result_domains_stmt->fetch(PDO::FETCH_ASSOC)) {
						$domainlist[] = $row_domain['domain'];
					}

					sort($domainlist);

					if (isset($domainlist[0]) && $domainlist[0] != '') {
						foreach ($domainlist as $dom) {
							$domains .= \Froxlor\UI\HTML::makeoption($idna_convert->decode($dom), $dom);
						}
					}
				}

				if (Settings::Get('system.allow_customer_shell') == '1') {
					$shells = \Froxlor\UI\HTML::makeoption("/bin/false", "/bin/false", "/bin/false");
					$shells_avail = Settings::Get('system.available_shells');
					if (! empty($shells_avail)) {
						$shells_avail = explode(",", $shells_avail);
						$shells_avail = array_map("trim", $shells_avail);
						foreach ($shells_avail as $_shell) {
							$shells .= \Froxlor\UI\HTML::makeoption($_shell, $_shell, "/bin/false");
						}
					}
				}

				// $sendinfomail = \Froxlor\UI\HTML::makeyesno('sendinfomail', '1', '0', '0');

				$ftp_add_data = include_once dirname(__FILE__) . '/lib/formfields/customer/ftp/formfield.ftp_add.php';
				$ftp_add_form = \Froxlor\UI\HtmlForm::genHTMLForm($ftp_add_data);

				$title = $ftp_add_data['ftp_add']['title'];
				$image = $ftp_add_data['ftp_add']['image'];

				eval("echo \"" . \Froxlor\UI\Template::getTemplate('ftp/accounts_add') . "\";");
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

				if (Settings::Get('customer.ftpatdomain') == '1') {
					$domains = '';

					$result_domains_stmt = Database::prepare("SELECT `domain` FROM `" . TABLE_PANEL_DOMAINS . "`
						WHERE `customerid` = :customerid");
					Database::pexecute($result_domains_stmt, array(
						"customerid" => $userinfo['customerid']
					));

					while ($row_domain = $result_domains_stmt->fetch(PDO::FETCH_ASSOC)) {
						$domains .= \Froxlor\UI\HTML::makeoption($idna_convert->decode($row_domain['domain']), $row_domain['domain']);
					}
				}

				if (Settings::Get('system.allow_customer_shell') == '1') {
					$shells = \Froxlor\UI\HTML::makeoption("/bin/false", "/bin/false", $result['shell']);
					$shells_avail = Settings::Get('system.available_shells');
					if (! empty($shells_avail)) {
						$shells_avail = explode(",", $shells_avail);
						$shells_avail = array_map("trim", $shells_avail);
						foreach ($shells_avail as $_shell) {
							$shells .= \Froxlor\UI\HTML::makeoption($_shell, $_shell, $result['shell']);
						}
					}
				}

				$ftp_edit_data = include_once dirname(__FILE__) . '/lib/formfields/customer/ftp/formfield.ftp_edit.php';
				$ftp_edit_form = \Froxlor\UI\HtmlForm::genHTMLForm($ftp_edit_data);

				$title = $ftp_edit_data['ftp_edit']['title'];
				$image = $ftp_edit_data['ftp_edit']['image'];

				eval("echo \"" . \Froxlor\UI\Template::getTemplate('ftp/accounts_edit') . "\";");
			}
		}
	}
}
