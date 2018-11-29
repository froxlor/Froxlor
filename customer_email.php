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
if (Settings::IsInList('panel.customer_hide_options','email')) {
	redirectTo('customer_index.php');
}

if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
} elseif (isset($_GET['id'])) {
	$id = intval($_GET['id']);
}

if ($page == 'overview') {
	$log->logAction(USR_ACTION, LOG_NOTICE, "viewed customer_email");
	eval("echo \"" . getTemplate("email/email") . "\";");
} elseif ($page == 'emails') {
	if ($action == '') {
		$log->logAction(USR_ACTION, LOG_NOTICE, "viewed customer_email::emails");
		$fields = array(
			'd.domain' => $lng['domains']['domainname'],
			'm.email_full' => $lng['emails']['emailaddress'],
			'm.destination' => $lng['emails']['forwarders']
		);
		$paging = new paging($userinfo, TABLE_MAIL_VIRTUAL, $fields);
		$result_stmt = Database::prepare('SELECT `m`.`id`, `m`.`domainid`, `m`.`email`, `m`.`email_full`, `m`.`iscatchall`, `u`.`quota`, `m`.`destination`, `m`.`popaccountid`, `d`.`domain`, `u`.`mboxsize` FROM `' . TABLE_MAIL_VIRTUAL . '` `m`
			LEFT JOIN `' . TABLE_PANEL_DOMAINS . '` `d` ON (`m`.`domainid` = `d`.`id`)
			LEFT JOIN `' . TABLE_MAIL_USERS . '` `u` ON (`m`.`popaccountid` = `u`.`id`)
			WHERE `m`.`customerid`= :customerid ' . $paging->getSqlWhere(true) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit()
		);
		Database::pexecute($result_stmt, array("customerid" => $userinfo['customerid']));
		$emailscount = Database::num_rows();
		$paging->setEntries($emailscount);
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$emails = array();

		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			if (!isset($emails[$row['domain']]) || !is_array($emails[$row['domain']])) {
				$emails[$row['domain']] = array();
			}

			$emails[$row['domain']][$row['email_full']] = $row;
		}

		if ($paging->sortfield == 'd.domain' && $paging->sortorder == 'desc') {
			krsort($emails);
		} else {
			ksort($emails);
		}

		$i = 0;
		$count = 0;
		$accounts = '';
		$emails_count = 0;
		$domainname = '';
		foreach ($emails as $domainid => $emailaddresses) {
			if ($paging->sortfield == 'm.email_full' && $paging->sortorder == 'desc') {
				krsort($emailaddresses);
			} else {
				ksort($emailaddresses);
			}

			foreach ($emailaddresses as $row) {
				if ($paging->checkDisplay($i)) {
					if ($domainname != $idna_convert->decode($row['domain'])) {
						$domainname = $idna_convert->decode($row['domain']);
						eval("\$accounts.=\"" . getTemplate("email/emails_domain") . "\";");
					}

					$emails_count++;
					$row['email'] = $idna_convert->decode($row['email']);
					$row['email_full'] = $idna_convert->decode($row['email_full']);
					$row['destination'] = explode(' ', $row['destination']);
					uasort($row['destination'], 'strcasecmp');

					$dest_list = $row['destination'];
					foreach ($dest_list as $dest_id => $destination) {
						$row['destination'][$dest_id] = $idna_convert->decode($row['destination'][$dest_id]);

						if ($row['destination'][$dest_id] == $row['email_full']) {
							unset($row['destination'][$dest_id]);
						}
					}

					$destinations_count = count($row['destination']);
					$row['destination'] = implode(', ', $row['destination']);

					if (strlen($row['destination']) > 35) {
						$row['destination'] = substr($row['destination'], 0, 32) . '... (' . $destinations_count . ')';
					}

					$row['mboxsize'] = size_readable($row['mboxsize'], 'GiB', 'bi', '%01.' . (int)Settings::Get('panel.decimal_places') . 'f %s');

					$row = htmlentities_array($row);
					eval("\$accounts.=\"" . getTemplate("email/emails_email") . "\";");
					$count++;
				}

				$i++;
			}
		}

		$emaildomains_count_stmt = Database::prepare("SELECT COUNT(`id`) AS `count` FROM `" . TABLE_PANEL_DOMAINS . "`
			WHERE `customerid`= :customerid
			AND `isemaildomain`='1' ORDER BY `domain` ASC"
		);
		Database::pexecute($emaildomains_count_stmt, array("customerid" => $userinfo['customerid']));
		$emaildomains_count = $emaildomains_count_stmt->fetch(PDO::FETCH_ASSOC);
		$emaildomains_count = $emaildomains_count['count'];

		eval("echo \"" . getTemplate("email/emails") . "\";");
	} elseif ($action == 'delete' && $id != 0) {
		try {
			$json_result = Emails::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['email']) && $result['email'] != '') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					Emails::getLocal($userinfo, array(
						'id' => $id
					))->delete();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array('page' => $page, 's' => $s));
			} else {
				if ($result['popaccountid'] != '0') {
					$show_checkbox = true;
				} else {
					$show_checkbox = false;
				}
				ask_yesno_withcheckbox('email_reallydelete', 'admin_customer_alsoremovemail', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $idna_convert->decode($result['email_full']), $show_checkbox);
			}
		}
	} elseif ($action == 'add') {
		if ($userinfo['emails_used'] < $userinfo['emails'] || $userinfo['emails'] == '-1') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					$json_result = Emails::getLocal($userinfo, $_POST)->add();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				$result = json_decode($json_result, true)['data'];
				redirectTo($filename, array('page' => $page, 'action' => 'edit', 'id' => $result['id'], 's' => $s));
			} else {
				$result_stmt = Database::prepare("SELECT `id`, `domain`, `customerid` FROM `" . TABLE_PANEL_DOMAINS . "`
					WHERE `customerid`= :cid
					AND `isemaildomain`='1'
					ORDER BY `domain` ASC"
				);
				Database::pexecute($result_stmt, array("cid" => $userinfo['customerid']));
				$domains = '';

				while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
					$domains.= makeoption($idna_convert->decode($row['domain']), $row['domain']);
				}

				//$iscatchall = makeyesno('iscatchall', '1', '0', '0');

				$email_add_data = include_once dirname(__FILE__).'/lib/formfields/customer/email/formfield.emails_add.php';

				if (Settings::Get('catchall.catchall_enabled') != '1') {
					unset($email_add_data['emails_add']['sections']['section_a']['fields']['iscatchall']);
				}

				$email_add_form = htmlform::genHTMLForm($email_add_data);

				$title = $email_add_data['emails_add']['title'];
				$image = $email_add_data['emails_add']['image'];

				eval("echo \"" . getTemplate("email/emails_add") . "\";");
			}
		} else {
			standard_error('allresourcesused');
		}
	} elseif ($action == 'edit' && $id != 0) {
		try {
			$json_result = Emails::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['email']) && $result['email'] != '') {
			$result['email'] = $idna_convert->decode($result['email']);
			$result['email_full'] = $idna_convert->decode($result['email_full']);
			$result['destination'] = explode(' ', $result['destination']);
			uasort($result['destination'], 'strcasecmp');
			$forwarders = '';
			$forwarders_count = 0;

			foreach ($result['destination'] as $dest_id => $destination) {
				$destination = $idna_convert->decode($destination);

				if ($destination != $result['email_full'] && $destination != '') {
					eval("\$forwarders.=\"" . getTemplate("email/emails_edit_forwarder") . "\";");
					$forwarders_count++;
				}

				$result['destination'][$dest_id] = $destination;
			}

			$destinations_count = count($result['destination']);
			$result = htmlentities_array($result);

			$email_edit_data = include_once dirname(__FILE__).'/lib/formfields/customer/email/formfield.emails_edit.php';

			if (Settings::Get('catchall.catchall_enabled') != '1') {
				unset($email_edit_data['emails_edit']['sections']['section_a']['fields']['mail_catchall']);
			}

			$email_edit_form = htmlform::genHTMLForm($email_edit_data);

			$title = $email_edit_data['emails_edit']['title'];
			$image = $email_edit_data['emails_edit']['image'];

			eval("echo \"" . getTemplate("email/emails_edit") . "\";");
		}
	} elseif ($action == 'togglecatchall' && $id != 0) {
		try {
			$json_result = Emails::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		try {
			Emails::getLocal($userinfo, array(
				'id' => $id,
				'iscatchall' => ($result['iscatchall'] == '1' ? 0 : 1)
			))->update();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		redirectTo($filename, array('page' => $page, 'action' => 'edit', 'id' => $id, 's' => $s));
	}
} elseif ($page == 'accounts') {
	if ($action == 'add' && $id != 0) {
		if ($userinfo['email_accounts'] == '-1' || ($userinfo['email_accounts_used'] < $userinfo['email_accounts'])) {
			try {
				$json_result = Emails::getLocal($userinfo, array(
					'id' => $id
				))->get();
			} catch (Exception $e) {
				dynamic_error($e->getMessage());
			}
			$result = json_decode($json_result, true)['data'];

			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					EmailAccounts::getLocal($userinfo, $_POST)->add();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array('page' => 'emails', 'action' => 'edit', 'id' => $id, 's' => $s));
			} else {

				if (checkMailAccDeletionState($result['email_full'])) {
				   standard_error(array('mailaccistobedeleted'), $result['email_full']);
				}

				$result['email_full'] = $idna_convert->decode($result['email_full']);
				$result = htmlentities_array($result);
				$quota = Settings::Get('system.mail_quota');

				$account_add_data = include_once dirname(__FILE__) . '/lib/formfields/customer/email/formfield.emails_addaccount.php';
				$account_add_form = htmlform::genHTMLForm($account_add_data);

				$title = $account_add_data['emails_addaccount']['title'];
				$image = $account_add_data['emails_addaccount']['image'];

				eval("echo \"" . getTemplate("email/account_add") . "\";");
			}
		} else {
			standard_error(array('allresourcesused', 'allocatetoomuchquota'), $quota);
		}
	} elseif ($action == 'changepw' && $id != 0) {
		try {
			$json_result = Emails::getLocal($userinfo, array('id' => $id))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['popaccountid']) && $result['popaccountid'] != '') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					EmailAccounts::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array('page' => 'emails', 'action' => 'edit', 'id' => $id, 's' => $s));
			} else {
				$result['email_full'] = $idna_convert->decode($result['email_full']);
				$result = htmlentities_array($result);

				$account_changepw_data = include_once dirname(__FILE__).'/lib/formfields/customer/email/formfield.emails_accountchangepasswd.php';
				$account_changepw_form = htmlform::genHTMLForm($account_changepw_data);

				$title = $account_changepw_data['emails_accountchangepasswd']['title'];
				$image = $account_changepw_data['emails_accountchangepasswd']['image'];

				eval("echo \"" . getTemplate("email/account_changepw") . "\";");
			}
		}
	} elseif ($action == 'changequota' && Settings::Get('system.mail_quota_enabled') == '1' && $id != 0) {
		try {
			$json_result = Emails::getLocal($userinfo, array('id' => $id))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['popaccountid']) && $result['popaccountid'] != '') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					EmailAccounts::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array('page' => 'emails', 'action' => 'edit', 'id' => $id, 's' => $s));
			} else {
				$result['email_full'] = $idna_convert->decode($result['email_full']);
				$result = htmlentities_array($result);

				$quota_edit_data = include_once dirname(__FILE__).'/lib/formfields/customer/email/formfield.emails_accountchangequota.php';
				$quota_edit_form = htmlform::genHTMLForm($quota_edit_data);

				$title = $quota_edit_data['emails_accountchangequota']['title'];
				$image = $quota_edit_data['emails_accountchangequota']['image'];

				eval("echo \"" . getTemplate("email/account_changequota") . "\";");
			}
		}
	} elseif ($action == 'delete' && $id != 0) {
		try {
			$json_result = Emails::getLocal($userinfo, array('id' => $id))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['popaccountid']) && $result['popaccountid'] != '') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					EmailAccounts::getLocal($userinfo, $_POST)->delete();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array('page' => 'emails', 'action' => 'edit', 'id' => $id, 's' => $s));
			} else {
				ask_yesno_withcheckbox('email_reallydelete_account', 'admin_customer_alsoremovemail', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $idna_convert->decode($result['email_full']));
			}
		}
	}
} elseif ($page == 'forwarders') {
	if ($action == 'add' && $id != 0) {
		if ($userinfo['email_forwarders_used'] < $userinfo['email_forwarders'] || $userinfo['email_forwarders'] == '-1') {
			try {
				$json_result = Emails::getLocal($userinfo, array('id' => $id))->get();
			} catch (Exception $e) {
				dynamic_error($e->getMessage());
			}
			$result = json_decode($json_result, true)['data'];

			if (isset($result['email']) && $result['email'] != '') {
				if (isset($_POST['send']) && $_POST['send'] == 'send') {
					try {
						EmailForwarders::getLocal($userinfo, $_POST)->add();
					} catch (Exception $e) {
						dynamic_error($e->getMessage());
					}
					redirectTo($filename, array('page' => 'emails', 'action' => 'edit', 'id' => $id, 's' => $s));
				} else {
					$result['email_full'] = $idna_convert->decode($result['email_full']);
					$result = htmlentities_array($result);

					$forwarder_add_data = include_once dirname(__FILE__).'/lib/formfields/customer/email/formfield.emails_addforwarder.php';
					$forwarder_add_form = htmlform::genHTMLForm($forwarder_add_data);

					$title = $forwarder_add_data['emails_addforwarder']['title'];
					$image = $forwarder_add_data['emails_addforwarder']['image'];

					eval("echo \"" . getTemplate("email/forwarder_add") . "\";");
				}
			}
		} else {
			standard_error('allresourcesused');
		}
	} elseif ($action == 'delete' && $id != 0) {
		try {
			$json_result = Emails::getLocal($userinfo, array('id' => $id))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['destination']) && $result['destination'] != '') {
			if (isset($_POST['forwarderid'])) {
				$forwarderid = intval($_POST['forwarderid']);
			} elseif (isset($_GET['forwarderid'])) {
				$forwarderid = intval($_GET['forwarderid']);
			} else {
				$forwarderid = 0;
			}

			$result['destination'] = explode(' ', $result['destination']);

			if (isset($result['destination'][$forwarderid]) && $result['email'] != $result['destination'][$forwarderid]) {
				$forwarder = $result['destination'][$forwarderid];

				if (isset($_POST['send']) && $_POST['send'] == 'send') {
					try {
						EmailForwarders::getLocal($userinfo, $_POST)->delete();
					} catch (Exception $e) {
						dynamic_error($e->getMessage());
					}
					redirectTo($filename, array('page' => 'emails', 'action' => 'edit', 'id' => $id, 's' => $s));
				} else {
					ask_yesno('email_reallydelete_forwarder', $filename, array('id' => $id, 'forwarderid' => $forwarderid, 'page' => $page, 'action' => $action), $idna_convert->decode($result['email_full']) . ' -> ' . $idna_convert->decode($forwarder));
				}
			}
		}
	}
}
