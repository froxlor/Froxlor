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

		$result_stmt = Database::prepare("SELECT `id`, `username`, `description`, `homedir` FROM `" . TABLE_FTP_USERS . "`
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
					$row['documentroot'] = substr($row['homedir'], strlen($userinfo['documentroot']));
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
		$result_stmt = Database::prepare("SELECT `id`, `username`, `homedir`, `up_count`, `up_bytes`, `down_count`, `down_bytes` FROM `" . TABLE_FTP_USERS . "`
			WHERE `customerid` = :customerid
			AND `id` = :id"
		);
		Database::pexecute($result_stmt, array("customerid" => $userinfo['customerid'], "id" => $id));
		$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($result['username']) && $result['username'] != $userinfo['loginname']) {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				$stmt = Database::prepare("UPDATE `" . TABLE_FTP_USERS . "`
					SET `up_count` = `up_count` + :up_count,
					`up_bytes` = `up_bytes` + :up_bytes,
					`down_count` = `down_count` + :down_count,
					`down_bytes` = `down_bytes` + :down_bytes
					WHERE `username` = :username"
				);
				$params = array(
					"up_count" => $result['up_count'],
					"up_bytes" => $result['up_bytes'],
					"down_count" => $result['down_count'],
					"down_bytes" => $result['down_bytes'],
					"username" => $userinfo['loginname']
				);
				Database::pexecute($stmt, $params);

				$result_stmt = Database::prepare("SELECT `username`, `homedir` FROM `" . TABLE_FTP_USERS . "`
					WHERE `customerid` = :customerid
					AND `id` = :id"
				);
				Database::pexecute($result_stmt, array("customerid" => $userinfo['customerid'], "id" => $id));
				$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

				$stmt = Database::prepare("DELETE FROM `" . TABLE_FTP_QUOTATALLIES . "` WHERE `name` = :name");
				Database::pexecute($stmt, array("name" => $result['username']));

				$stmt = Database::prepare("DELETE FROM `" . TABLE_FTP_USERS . "`
					WHERE `customerid` = :customerid
					AND `id` = :id"
				);
				Database::pexecute($stmt, array("customerid" => $userinfo['customerid'], "id" => $id));

				$stmt = Database::prepare("
					UPDATE `" . TABLE_FTP_GROUPS . "` SET
					`members` = REPLACE(`members`, :username,'')
					WHERE `customerid` = :customerid
				");
				Database::pexecute($stmt, array("username" => ",".$result['username'], "customerid" => $userinfo['customerid']));

				$log->logAction(USR_ACTION, LOG_INFO, "deleted ftp-account '" . $result['username'] . "'");

				$resetaccnumber = ($userinfo['ftps_used'] == '1') ? " , `ftp_lastaccountnumber`='0'" : '';

				// refs #293
				if (isset($_POST['delete_userfiles']) && (int)$_POST['delete_userfiles'] == 1) {
					inserttask('8', $userinfo['loginname'], $result['homedir']);
				}

				$stmt = Database::prepare("UPDATE `" . TABLE_PANEL_CUSTOMERS . "`
					SET `ftps_used` = `ftps_used` - 1 $resetaccnumber
					WHERE `customerid` = :customerid"
				);
				Database::pexecute($stmt, array("customerid" => $userinfo['customerid']));

				redirectTo($filename, array('page' => $page, 's' => $s));
			} else {
				ask_yesno_withcheckbox('ftp_reallydelete', 'admin_customer_alsoremoveftphomedir', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $result['username']);
			}
		} else {
			standard_error('ftp_cantdeletemainaccount');
		}
	} elseif ($action == 'add') {
		if ($userinfo['ftps_used'] < $userinfo['ftps'] || $userinfo['ftps'] == '-1') {
			if (isset($_POST['send'])
				&& $_POST['send'] == 'send') {
				$description = validate($_POST['ftp_description'], 'description');
				// @FIXME use a good path-validating regex here (refs #1231)
				$path = validate($_POST['path'], 'path');
				$password = validate($_POST['ftp_password'], 'password');
				$password = validatePassword($password);

				$sendinfomail = isset($_POST['sendinfomail']) ? 1 : 0;
				if ($sendinfomail != 1) {
					$sendinfomail = 0;
				}

				if (Settings::Get('customer.ftpatdomain') == '1') {
					$ftpusername = validate($_POST['ftp_username'], 'username', '/^[a-zA-Z0-9][a-zA-Z0-9\-_]+\$?$/');
					if ($ftpusername == '') {
						standard_error(array('stringisempty', 'username'));
					}
					$ftpdomain = $idna_convert->encode(validate($_POST['ftp_domain'], 'domain'));
					$ftpdomain_check_stmt = Database::prepare("SELECT `id`, `domain`, `customerid` FROM `" . TABLE_PANEL_DOMAINS . "`
						WHERE `domain` = :domain
						AND `customerid` = :customerid"
					);
					Database::pexecute($ftpdomain_check_stmt, array("domain" => $ftpdomain, "customerid" => $userinfo['customerid']));
					$ftpdomain_check = $ftpdomain_check_stmt->fetch(PDO::FETCH_ASSOC);

					if ($ftpdomain_check['domain'] != $ftpdomain) {
						standard_error('maindomainnonexist', $domain);
					}
					$username = $ftpusername . "@" . $ftpdomain;
				} else {
					$username = $userinfo['loginname'] . Settings::Get('customer.ftpprefix') . (intval($userinfo['ftp_lastaccountnumber']) + 1);
				}

				$username_check_stmt = Database::prepare("SELECT * FROM `" . TABLE_FTP_USERS . "`
					WHERE `username` = :username"
				);
				Database::pexecute($username_check_stmt, array("username" => $username));
				$username_check = $username_check_stmt->fetch(PDO::FETCH_ASSOC);

				if (!empty($username_check) && $username_check['username'] = $username) {
					standard_error('usernamealreadyexists', $username);
				} elseif ($password == '') {
					standard_error(array('stringisempty', 'mypassword'));
				} elseif ($path == '') {
					standard_error('patherror');
				} elseif ($username == $password) {
					standard_error('passwordshouldnotbeusername');
				} else {
					$path = makeCorrectDir($userinfo['documentroot'] . '/' . $path);

					$cryptPassword = makeCryptPassword($password);

					$stmt = Database::prepare("INSERT INTO `" . TABLE_FTP_USERS . "`
						(`customerid`, `username`, `description`, `password`, `homedir`, `login_enabled`, `uid`, `gid`)
						VALUES (:customerid, :username, :description, :password, :homedir, 'y', :guid, :guid)"
					);
					$params = array(
						"customerid" => $userinfo['customerid'],
						"username" => $username,
						"description" => $description,
						"password" => $cryptPassword,
						"homedir" => $path,
						"guid" => $userinfo['guid']
					);
					Database::pexecute($stmt, $params);

					$result_stmt = Database::prepare("SELECT `bytes_in_used` FROM `" . TABLE_FTP_QUOTATALLIES . "`
						WHERE `name` = :name"
					);
					Database::pexecute($result_stmt, array("name" => $userinfo['loginname']));

					while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
						$stmt = Database::prepare("INSERT INTO `" . TABLE_FTP_QUOTATALLIES . "`
							(`name`, `quota_type`, `bytes_in_used`, `bytes_out_used`, `bytes_xfer_used`, `files_in_used`, `files_out_used`, `files_xfer_used`)
							VALUES (:name, 'user', :bytes_in_used, '0', '0', '0', '0', '0')"
						);
						Database::pexecute($stmt, array("name" => $username, "bytes_in_used" => $row['bytes_in_used']));
					}

					$stmt = Database::prepare("UPDATE `" . TABLE_FTP_GROUPS . "`
						SET `members` = CONCAT_WS(',',`members`, :username)
						WHERE `customerid`= :customerid
						AND `gid`= :guid"
					);
					$params = array(
						"username" => $username,
						"customerid" => $userinfo['customerid'],
						"guid" => $userinfo['guid']
					);
					Database::pexecute($stmt, $params);

					$stmt = Database::prepare("UPDATE `" . TABLE_PANEL_CUSTOMERS . "`
						SET `ftps_used` = `ftps_used` + 1,
						`ftp_lastaccountnumber` = `ftp_lastaccountnumber` + 1
						WHERE `customerid` = :customerid"
					);
					Database::pexecute($stmt, array("customerid" => $userinfo['customerid']));

					$log->logAction(USR_ACTION, LOG_INFO, "added ftp-account '" . $username . " (" . $path . ")'");
					inserttask(5);

					if ($sendinfomail == 1) {
						$replace_arr = array(
							'SALUTATION' => getCorrectUserSalutation($userinfo),
							'CUST_NAME' => getCorrectUserSalutation($userinfo), // < keep this for compatibility
							'USR_NAME' => $username,
							'USR_PASS' => $password,
							'USR_PATH' => makeCorrectDir(substr($path, strlen($userinfo['documentroot'])))
						);

						$def_language = $userinfo['def_language'];
						$result_stmt = Database::prepare("SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
							WHERE `adminid` = :adminid
							AND `language` = :lang
							AND `templategroup`='mails'
							AND `varname`='new_ftpaccount_by_customer_subject'"
						);
						Database::pexecute($result_stmt, array("adminid" => $userinfo['adminid'], "lang" => $def_language));
						$result = $result_stmt->fetch(PDO::FETCH_ASSOC);
						$mail_subject = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $lng['customer']['ftp_add']['infomail_subject']), $replace_arr));

						$def_language = $userinfo['def_language'];
						$result_stmt = Database::prepare("SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
							WHERE `adminid` = :adminid
							AND `language` = :lang
							AND `templategroup`='mails'
							AND `varname`='new_ftpaccount_by_customer_mailbody'"
						);
						Database::pexecute($result_stmt, array("adminid" => $userinfo['adminid'], "lang" => $def_language));
						$result = $result_stmt->fetch(PDO::FETCH_ASSOC);
						$mail_body = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $lng['customer']['ftp_add']['infomail_body']['main']), $replace_arr));

						$_mailerror = false;
						try {
							$mail->Subject = $mail_subject;
							$mail->AltBody = $mail_body;
							$mail->MsgHTML(str_replace("\n", "<br />", $mail_body));
							$mail->AddAddress($userinfo['email'], getCorrectUserSalutation($userinfo));
							$mail->Send();
						} catch(phpmailerException $e) {
							$mailerr_msg = $e->errorMessage();
							$_mailerror = true;
						} catch (Exception $e) {
							$mailerr_msg = $e->getMessage();
							$_mailerror = true;
						}

						if ($_mailerror) {
							$log->logAction(USR_ACTION, LOG_ERR, "Error sending mail: " . $mailerr_msg);
							standard_error('errorsendingmail', $userinfo['email']);
						}

						$mail->ClearAddresses();
					}

					redirectTo($filename, array('page' => $page, 's' => $s));
				}
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

				//$sendinfomail = makeyesno('sendinfomail', '1', '0', '0');

				$ftp_add_data = include_once dirname(__FILE__).'/lib/formfields/customer/ftp/formfield.ftp_add.php';
				$ftp_add_form = htmlform::genHTMLForm($ftp_add_data);

				$title = $ftp_add_data['ftp_add']['title'];
				$image = $ftp_add_data['ftp_add']['image'];

				eval("echo \"" . getTemplate('ftp/accounts_add') . "\";");
			}
		}
	} elseif ($action == 'edit' && $id != 0) {
		$result_stmt = Database::prepare("SELECT `id`, `username`, `description`, `homedir`, `uid`, `gid` FROM `" . TABLE_FTP_USERS . "`
			WHERE `customerid` = :customerid
			AND `id` = :id"
		);
		Database::pexecute($result_stmt, array("customerid" => $userinfo['customerid'], "id" => $id));
		$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($result['username']) && $result['username'] != '') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				// @FIXME use a good path-validating regex here (refs #1231)
				$path = validate($_POST['path'], 'path');

				$_setnewpass = false;
				if (isset($_POST['ftp_password']) && $_POST['ftp_password'] != '') {
					$password = validate($_POST['ftp_password'], 'password');
					$password = validatePassword($password);
					$_setnewpass = true;
				}

				if ($_setnewpass) {
					if ($password == '') {
						standard_error(array('stringisempty', 'mypassword'));
						exit;
					} elseif ($result['username'] == $password) {
						standard_error('passwordshouldnotbeusername');
						exit;
					}
					$log->logAction(USR_ACTION, LOG_INFO, "updated ftp-account password for '" . $result['username'] . "'");
					$cryptPassword = makeCryptPassword($password);

					$stmt = Database::prepare("UPDATE `" . TABLE_FTP_USERS . "`
						SET `password` = :password
						WHERE `customerid` = :customerid
						AND `id` = :id"
					);
					Database::pexecute($stmt, array("customerid" => $userinfo['customerid'], "id" => $id, "password" => $cryptPassword));
				}

				if ($path != '') {
					$path = makeCorrectDir($userinfo['documentroot'] . '/' . $path);

					if ($path != $result['homedir']) {
						if (!file_exists($path)) {
							// it's the task for "new ftp" but that will
							// create all directories and correct their permissions
							inserttask(5);
						}

						$log->logAction(USR_ACTION, LOG_INFO, "updated ftp-account homdir for '" . $result['username'] . "'");

						$stmt = Database::prepare("UPDATE `" . TABLE_FTP_USERS . "`
							SET `homedir` = :homedir
							WHERE `customerid` = :customerid
							AND `id` = :id"
						);
						$params = array(
							"homedir" => $path,
							"customerid" => $userinfo['customerid'],
							"id" => $id
						);
						Database::pexecute($stmt, $params);
					}
				}

				$log->logAction(USR_ACTION, LOG_INFO, "edited ftp-account '" . $result['username'] . "'");
				$description = validate($_POST['ftp_description'], 'description');
				$stmt = Database::prepare("UPDATE `" . TABLE_FTP_USERS . "`
					SET `description` = :desc
					WHERE `customerid` = :customerid
					AND `id` = :id"
				);
				Database::pexecute($stmt, array("desc" => $description, "customerid" => $userinfo['customerid'], "id" => $id));

				redirectTo($filename, array('page' => $page, 's' => $s));
			} else {
				if (strpos($result['homedir'], $userinfo['documentroot']) === 0) {
					$homedir = substr($result['homedir'], strlen($userinfo['documentroot']));
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

				$ftp_edit_data = include_once dirname(__FILE__).'/lib/formfields/customer/ftp/formfield.ftp_edit.php';
				$ftp_edit_form = htmlform::genHTMLForm($ftp_edit_data);

				$title = $ftp_edit_data['ftp_edit']['title'];
				$image = $ftp_edit_data['ftp_edit']['image'];

				eval("echo \"" . getTemplate('ftp/accounts_edit') . "\";");
			}
		}
	}
}
