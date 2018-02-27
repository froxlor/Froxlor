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

// redirect if this customer page is hidden via settings
if (Settings::IsInList('panel.customer_hide_options','ftp')) {
	redirectTo('customer_index.php');
}

$id = 0;
if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
} elseif (isset($_GET['id'])) {
	$id = intval($_GET['id']);
}

if ($page == 'overview') {
	$log->logAction(USR_ACTION, LOG_NOTICE, "viewed customer_ftp");
	eval("echo \"" . getTemplate('ftp/ftp') . "\";");
} elseif ($page == 'accounts') {
	if ($action == '') {
		$log->logAction(USR_ACTION, LOG_NOTICE, "viewed customer_ftp::accounts");
		$fields = array(
			'username' => $lng['login']['username'],
			'homedir' => $lng['panel']['path'],
			'description' => $lng['panel']['ftpdesc']
		);
		$paging = new paging($userinfo, TABLE_FTP_USERS, $fields);

		$result_stmt = Database::prepare("SELECT `id`, `username`, `description`, `homedir`, `shell` FROM `" . TABLE_FTP_USERS . "`
			WHERE `customerid`= :customerid " . $paging->getSqlWhere(true) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit()
		);
		Database::pexecute($result_stmt, array("customerid" => $userinfo['customerid']));
		$ftps_count = Database::num_rows();
		$paging->setEntries($ftps_count);
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$i = 0;
		$count = 0;
		$accounts = '';

		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			if ($paging->checkDisplay($i)) {
				if (strpos($row['homedir'], $userinfo['documentroot']) === 0) {
					$row['documentroot'] = str_replace($userinfo['documentroot'], "/", $row['homedir']);
				} else {
					$row['documentroot'] = $row['homedir'];
				}

				$row['documentroot'] = makeCorrectDir($row['documentroot']);

				$row = htmlentities_array($row);
				eval("\$accounts.=\"" . getTemplate('ftp/accounts_account') . "\";");
				$count++;
			}

			$i++;
		}

		eval("echo \"" . getTemplate('ftp/accounts') . "\";");
	} elseif ($action == 'delete' && $id != 0) {
		try {
			$json_result = Ftps::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['username']) && $result['username'] != $userinfo['loginname']) {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					Ftps::getLocal($userinfo, $_POST)->delete();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array('page' => $page, 's' => $s));
			} else {
				ask_yesno_withcheckbox('ftp_reallydelete', 'admin_customer_alsoremoveftphomedir', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $result['username']);
			}
		} else {
			standard_error('ftp_cantdeletemainaccount');
		}
	} elseif ($action == 'add') {
		if ($userinfo['ftps_used'] < $userinfo['ftps'] || $userinfo['ftps'] == '-1') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					Ftps::getLocal($userinfo, $_POST)->add();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array('page' => $page, 's' => $s));
			} else {
				$pathSelect = makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid'], '/');

				if (Settings::Get('customer.ftpatdomain') == '1') {
					$domainlist = array();
					$domains = '';

					$result_domains_stmt = Database::prepare("SELECT `domain` FROM `" . TABLE_PANEL_DOMAINS . "`
						WHERE `customerid`= :customerid"
					);
					Database::pexecute($result_domains_stmt, array("customerid" => $userinfo['customerid']));

					while ($row_domain = $result_domains_stmt->fetch(PDO::FETCH_ASSOC)) {
						$domainlist[] =  $row_domain['domain'];
					}

					sort($domainlist);

					if (isset($domainlist[0]) && $domainlist[0] != '') {
						foreach ($domainlist as $dom) {
							$domains .= makeoption($idna_convert->decode($dom), $dom);
						}
					}
				}

				if (Settings::Get('system.allow_customer_shell') == '1') {
					$shells = makeoption("/bin/false", "/bin/false", "/bin/false");
					$shells_avail = Settings::Get('system.available_shells');
					if (!empty($shells_avail)) {
						$shells_avail = explode(",", $shells_avail);
						$shells_avail = array_map("trim", $shells_avail);
						foreach ($shells_avail as $_shell) {
							$shells .= makeoption($_shell, $_shell, "/bin/false");
						}
					}
				}

				//$sendinfomail = makeyesno('sendinfomail', '1', '0', '0');

				$ftp_add_data = include_once dirname(__FILE__).'/lib/formfields/customer/ftp/formfield.ftp_add.php';
				$ftp_add_form = htmlform::genHTMLForm($ftp_add_data);

				$title = $ftp_add_data['ftp_add']['title'];
				$image = $ftp_add_data['ftp_add']['image'];

				eval("echo \"" . getTemplate('ftp/accounts_add') . "\";");
			}
		}
	} elseif ($action == 'edit' && $id != 0) {
		try {
			$json_result = Ftps::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['username']) && $result['username'] != '') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					Ftps::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array('page' => $page, 's' => $s));
			} else {
				if (strpos($result['homedir'], $userinfo['documentroot']) === 0) {
					$homedir = str_replace($userinfo['documentroot'], "/", $result['homedir']);
				} else {
					$homedir = $result['homedir'];
				}
				$homedir = makeCorrectDir($homedir);

				$pathSelect = makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid'], $homedir);

				if (Settings::Get('customer.ftpatdomain') == '1') {
					$domains = '';

					$result_domains_stmt = Database::prepare("SELECT `domain` FROM `" . TABLE_PANEL_DOMAINS . "`
						WHERE `customerid` = :customerid"
					);
					Database::pexecute($result_domains_stmt, array("customerid" => $userinfo['customerid']));

					while ($row_domain = $result_domains_stmt->fetch(PDO::FETCH_ASSOC)) {
						$domains .= makeoption($idna_convert->decode($row_domain['domain']), $row_domain['domain']);
					}
				}

				if (Settings::Get('system.allow_customer_shell') == '1') {
					$shells = makeoption("/bin/false", "/bin/false", $result['shell']);
					$shells_avail = Settings::Get('system.available_shells');
					if (!empty($shells_avail)) {
						$shells_avail = explode(",", $shells_avail);
						$shells_avail = array_map("trim", $shells_avail);
						foreach ($shells_avail as $_shell) {
							$shells .= makeoption($_shell, $_shell, $result['shell']);
						}
					}
				}

				$ftp_edit_data = include_once dirname(__FILE__).'/lib/formfields/customer/ftp/formfield.ftp_edit.php';
				$ftp_edit_form = htmlform::genHTMLForm($ftp_edit_data);

				$title = $ftp_edit_data['ftp_edit']['title'];
				$image = $ftp_edit_data['ftp_edit']['image'];

				eval("echo \"" . getTemplate('ftp/accounts_edit') . "\";");
			}
		}
	}
}
