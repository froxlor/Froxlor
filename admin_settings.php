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

define('AREA', 'admin');
require './lib/init.php';

// get sql-root access data
Database::needRoot(true);
Database::needSqlData();
$sql_root = Database::getSqlData();
Database::needRoot(false);

if ($page == 'overview' && $userinfo['change_serversettings'] == '1') {
	$settings_data = loadConfigArrayDir('./actions/admin/settings/');
	$settings = loadSettings($settings_data);

	if (isset($_POST['send'])
		&& $_POST['send'] == 'send'
	) {

		$_part = isset($_GET['part']) ? $_GET['part'] : '';
		if ($_part == '') {
			$_part = isset($_POST['part']) ? $_POST['part'] : '';
		}

		if ($_part != '') {
			if ($_part == 'all') {
				$settings_all = true;
				$settings_part = false;
			} else {
				$settings_all = false;
				$settings_part = true;
			}
			$only_enabledisable = false;

		} else {
			$settings_all = false;
			$settings_part = false;
			$only_enabledisable = true;
		}

		// check if the session timeout is too low #815
		if (isset($_POST['session_sessiontimeout'])
			&& $_POST['session_sessiontimeout'] < 60
		) {
			standard_error($lng['error']['session_timeout'], $lng['error']['session_timeout_desc']);
		}

		if (processFormEx(
			$settings_data,
			$_POST,
			array('filename' => $filename, 'action' => $action, 'page' => $page),
			$_part,
			$settings_all,
			$settings_part,
			$only_enabledisable
			)
		) {
			$log->logAction(ADM_ACTION, LOG_INFO, "rebuild configfiles due to changed setting");
			inserttask('1');
			// Using nameserver, insert a task which rebuilds the server config
			inserttask('4');

			standard_success('settingssaved', '', array('filename' => $filename, 'action' => $action, 'page' => $page));
		}

	} else {

		$_part = isset($_GET['part']) ? $_GET['part'] : '';
		if ($_part == '') {
			$_part = isset($_POST['part']) ? $_POST['part'] : '';
		}

		$fields = buildFormEx($settings_data, $_part);

		$settings_page = '';
		if ($_part == '') {
			eval("\$settings_page .= \"" . getTemplate("settings/settings_overview") . "\";");
		} else {
			eval("\$settings_page .= \"" . getTemplate("settings/settings") . "\";");
		}

		eval("echo \"" . getTemplate("settings/settings_form_begin") . "\";");
		eval("echo \$settings_page;");
		eval("echo \"" . getTemplate("settings/settings_form_end") . "\";");

	}

} elseif($page == 'phpinfo'
	&& $userinfo['change_serversettings'] == '1'
) {
	ob_start();
	phpinfo();
	$phpinfo = array('phpinfo' => array());
	if (preg_match_all(
			'#(?:<h2>(?:<a name=".*?">)?(.*?)(?:</a>)?</h2>)|(?:<tr(?: class=".*?")?><t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>)?)?</tr>)#s',
			ob_get_clean(), $matches, PREG_SET_ORDER
		)
	) {
		foreach ($matches as $match) {
			$end = array_keys($phpinfo);
			$end = end($end);
			if (strlen($match[1])) {
				$phpinfo[$match[1]] = array();
			} elseif (isset($match[3])) {
				$phpinfo[$end][$match[2]] = isset($match[4]) ? array($match[3], $match[4]) : $match[3];
			} else {
				$phpinfo[$end][] = $match[2];
			}
		}
		$phpinfohtml = '';
		foreach ($phpinfo as $name => $section) {
			$phpinfoentries = "";
			foreach ($section as $key => $val) {
				if (is_array($val)) {
					eval("\$phpinfoentries .= \"" . getTemplate("settings/phpinfo/phpinfo_3") . "\";");
				} elseif (is_string($key)) {
					eval("\$phpinfoentries .= \"" . getTemplate("settings/phpinfo/phpinfo_2") . "\";");
				} else {
					eval("\$phpinfoentries .= \"" . getTemplate("settings/phpinfo/phpinfo_1") . "\";");
				}
			}
			// first header -> show actual php version
			if (strtolower($name) == "phpinfo") {
				$name = "PHP ".PHP_VERSION;
			}
			eval("\$phpinfohtml .= \"" . getTemplate("settings/phpinfo/phpinfo_table") . "\";");
		}
		$phpinfo = $phpinfohtml;
	} else {
		standard_error($lng['error']['no_phpinfo']);
	}
	eval("echo \"" . getTemplate("settings/phpinfo") . "\";");

} elseif($page == 'rebuildconfigs'
	&& $userinfo['change_serversettings'] == '1'
) {
	if (isset($_POST['send'])
		&& $_POST['send'] == 'send'
	) {

		$log->logAction(ADM_ACTION, LOG_INFO, "rebuild configfiles");
		inserttask('1');
		inserttask('10');
		// Using nameserver, insert a task which rebuilds the server config
		inserttask('4');
		// cron.d file
		inserttask('99');

		standard_success('rebuildingconfigs', '', array('filename' => 'admin_index.php'));

	} else {
		ask_yesno('admin_configs_reallyrebuild', $filename, array('page' => $page));
	}

} elseif($page == 'updatecounters'
	&& $userinfo['change_serversettings'] == '1'
) {

	if (isset($_POST['send'])
		&& $_POST['send'] == 'send'
	) {

		$log->logAction(ADM_ACTION, LOG_INFO, "updated resource-counters");
		$updatecounters = updateCounters(true);
		$customers = '';
		foreach ($updatecounters['customers'] as $customerid => $customer) {
			eval("\$customers.=\"" . getTemplate("settings/updatecounters_row_customer") . "\";");
		}

		$admins = '';
		foreach ($updatecounters['admins'] as $adminid => $admin) {
			eval("\$admins.=\"" . getTemplate("settings/updatecounters_row_admin") . "\";");
		}

		eval("echo \"" . getTemplate("settings/updatecounters") . "\";");

	} else {
		ask_yesno('admin_counters_reallyupdate', $filename, array('page' => $page));
	}

} elseif ($page == 'wipecleartextmailpws'
	&& $userinfo['change_serversettings'] == '1'
) {

	if (isset($_POST['send'])
		&& $_POST['send'] == 'send'
	) {

		$log->logAction(ADM_ACTION, LOG_WARNING, "wiped all cleartext mail passwords");
		Database::query("UPDATE `" . TABLE_MAIL_USERS . "` SET `password` = '';");
		Database::query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '0' WHERE `settinggroup` = 'system' AND `varname` = 'mailpwcleartext'");
		redirectTo($filename, array('s' => $s));

	} else {
		ask_yesno('admin_cleartextmailpws_reallywipe', $filename, array('page' => $page));
	}

} elseif($page == 'wipequotas'
	&& $userinfo['change_serversettings'] == '1'
) {

	if (isset($_POST['send'])
		&& $_POST['send'] == 'send'
	) {

		$log->logAction(ADM_ACTION, LOG_WARNING, "wiped all mailquotas");

		// Set the quota to 0 which means unlimited
		Database::query("UPDATE `" . TABLE_MAIL_USERS . "` SET `quota` = '0';");
		Database::query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `email_quota_used` = '0'");
		redirectTo($filename, array('s' => $s));

	} else {
		ask_yesno('admin_quotas_reallywipe', $filename, array('page' => $page));
	}

} elseif ($page == 'enforcequotas'
	&& $userinfo['change_serversettings'] == '1'
) {
	if (isset($_POST['send'])
		&& $_POST['send'] == 'send'
	) {
		// Fetch all accounts
		$result_stmt = Database::query("SELECT `quota`, `customerid` FROM `" . TABLE_MAIL_USERS . "`");

		if (Database::num_rows() > 0) {

			$upd_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET
				`email_quota_used` = `email_quota_used` + :diff
				WHERE `customerid` = :customerid
			");

			while ($array = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
				$difference = Settings::Get('system.mail_quota') - $array['quota'];
				Database::pexecute($upd_stmt, array('diff' => $difference, 'customerid' => $customerid));
			}
		}

		// Set the new quota
		$upd_stmt = Database::prepare("
			UPDATE `" . TABLE_MAIL_USERS . "` SET `quota` = :quota
		");
		Database::pexecute($upd_stmt, array('quota' => Settings::Get('system.mail_quota')));

		// Update the Customer, if the used quota is bigger than the allowed quota
		Database::query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `email_quota` = `email_quota_used` WHERE `email_quota` < `email_quota_used`");
		$log->logAction(ADM_ACTION, LOG_WARNING, 'enforcing mailquota to all customers: ' . Settings::Get('system.mail_quota') . ' MB');
		redirectTo($filename, array('s' => $s));

	} else {
		ask_yesno('admin_quotas_reallyenforce', $filename, array('page' => $page));
	}
} elseif ($page == 'integritycheck'
	&& $userinfo['change_serversettings'] == '1'
) {
	$integrity = new IntegrityCheck();
	if (isset($_POST['send'])
		&& $_POST['send'] == 'send'
	) {
		$integrity->fixAll();
	} elseif(isset($_GET['action'])
		 && $_GET['action'] == "fix") {
		ask_yesno('admin_integritycheck_reallyfix', $filename, array('page' => $page));
	}

	$integritycheck = '';
	foreach ($integrity->available as $id => $check) {
		$displayid = $id + 1;
		$result = $integrity->$check();
		$checkdesc = $lng['integrity_check'][$check];
		eval("\$integritycheck.=\"" . getTemplate("settings/integritycheck_row") . "\";");
	}
	eval("echo \"" . getTemplate("settings/integritycheck") . "\";");
}
elseif ($page == 'importexport' && $userinfo['change_serversettings'] == '1')
{
	// check for json-stuff
	if (! extension_loaded('json')) {
		standard_error('jsonextensionnotfound');
	}

	if (isset($_GET['action']) && $_GET['action'] == "export") {
		// export
		try {
			$json_result = Froxlor::getLocal($userinfo)->exportSettings();
			$json_export = json_decode($json_result, true)['data'];
		} catch(Exception $e) {
			dynamic_error($e->getMessage());
		}
		header('Content-disposition: attachment; filename=Froxlor_settings-'.$version.'-'.$dbversion.'_'.date('d.m.Y').'.json');
		header('Content-type: application/json');
		echo $json_export;
		exit;
	} elseif (isset($_GET['action']) && $_GET['action'] == "import") {
		// import
		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			// get uploaded file
			if (isset($_FILES["import_file"]["tmp_name"])) {
				$imp_content = file_get_contents($_FILES["import_file"]["tmp_name"]);
				try {
					Froxlor::getLocal($userinfo, array('json_str' => $imp_content))->importSettings();
				} catch(Exception $e) {
					dynamic_error($e->getMessage());
				}
				standard_success('settingsimported', '', array('filename' => 'admin_settings.php'));
			}
			dynamic_error("Upload failed");
		}
	} else {
		eval("echo \"" . getTemplate("settings/importexport/index") . "\";");
	}
}
elseif ($page == 'testmail')
{
		if (isset($_POST['send']) && $_POST['send'] == 'send')
		{
			$test_addr = isset($_POST['test_addr']) ? $_POST['test_addr'] : null;

			/**
			 * Initialize the mailingsystem
			 */
			$testmail = new PHPMailer(true);
			$testmail->CharSet = "UTF-8";

			if (Settings::Get('system.mail_use_smtp')) {
				$testmail->isSMTP();
				$testmail->Host = Settings::Get('system.mail_smtp_host');
				$testmail->SMTPAuth = Settings::Get('system.mail_smtp_auth') == '1' ? true : false;
				$testmail->Username = Settings::Get('system.mail_smtp_user');
				$testmail->Password = Settings::Get('system.mail_smtp_passwd');
				if (Settings::Get('system.mail_smtp_usetls')) {
					$testmail->SMTPSecure = 'tls';
				} else {
					$testmail->SMTPAutoTLS = false;
				}
				$testmail->Port = Settings::Get('system.mail_smtp_port');
			}

			$_mailerror = false;
			if (PHPMailer::ValidateAddress(Settings::Get('panel.adminmail')) !== false) {
				// set return-to address and custom sender-name, see #76
				$testmail->SetFrom(Settings::Get('panel.adminmail'), Settings::Get('panel.adminmail_defname'));
				if (Settings::Get('panel.adminmail_return') != '') {
					$testmail->AddReplyTo(Settings::Get('panel.adminmail_return'), Settings::Get('panel.adminmail_defname'));
				}

				try {
					$testmail->Subject = "Froxlor Test-Mail";
					$mail_body = "Yay, this worked :)";
					$testmail->AltBody = $mail_body;
					$testmail->MsgHTML(str_replace("\n", "<br />", $mail_body));
					$testmail->AddAddress($test_addr);
					$testmail->Send();
				} catch(phpmailerException $e) {
					$mailerr_msg = $e->errorMessage();
					$_mailerror = true;
				} catch (Exception $e) {
					$mailerr_msg = $e->getMessage();
					$_mailerror = true;
				}

				if (!$_mailerror) {
					// success
					$mail->ClearAddresses();
					standard_success('testmailsent', '', array('filename' => 'admin_settings.php', 'page' => 'testmail'));
				}
			} else {
				// invalid sender e-mail
				$mailerr_msg = "Invalid sender e-mail address: ".Settings::Get('panel.adminmail');
				$_mailerror = true;
			}
		}

		$mail_smtp_user = Settings::Get('system.mail_smtp_user');
		$mail_smtp_host = Settings::Get('system.mail_smtp_host');
		$mail_smtp_port = Settings::Get('system.mail_smtp_port');

		eval("echo \"" . getTemplate("settings/testmail") . "\";");
}
