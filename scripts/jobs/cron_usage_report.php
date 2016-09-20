<?php if (!defined('MASTER_CRONJOB')) die('You cannot access this file directly!');

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
 * @package    Cron
 *
 */

$cronlog->logAction(CRON_ACTION, LOG_INFO, 'Web- and Traffic-usage reporting started...');
$yesterday = time() - (60 * 60 * 24);

/**
 * Initialize the mailingsystem
 */
$mail = new PHPMailer(true);
$mail->CharSet = "UTF-8";

if (Settings::Get('system.mail_use_smtp')) {
	$mail->isSMTP();
	$mail->Host = Settings::Get('system.mail_smtp_host');
	$mail->SMTPAuth = Settings::Get('system.mail_smtp_auth') == '1' ? true : false;
	$mail->Username = Settings::Get('system.mail_smtp_user');
	$mail->Password = Settings::Get('system.mail_smtp_passwd');
	if (Settings::Get('system.mail_smtp_usetls')) {
		$mail->SMTPSecure = 'tls';
	}
	$mail->Port = Settings::Get('system.mail_smtp_port');
}

if (PHPMailer::ValidateAddress(Settings::Get('panel.adminmail')) !== false) {
	// set return-to address and custom sender-name, see #76
	$mail->SetFrom(Settings::Get('panel.adminmail'), Settings::Get('panel.adminmail_defname'));
	if (Settings::Get('panel.adminmail_return') != '') {
		$mail->AddReplyTo(Settings::Get('panel.adminmail_return'), Settings::Get('panel.adminmail_defname'));
	}
}

if ((int)Settings::Get('system.report_trafficmax') > 0)
{
	// Warn the customers at xx% traffic-usage
	$result_stmt = Database::prepare("
		SELECT `c`.`customerid`, `c`.`adminid`, `c`.`name`, `c`.`firstname`,
		`c`.`company`, `c`.`traffic`, `c`.`email`, `c`.`def_language`,
		`a`.`name` AS `adminname`, `a`.`email` AS `adminmail`,
		(SELECT SUM(`t`.`http` + `t`.`ftp_up` + `t`.`ftp_down` + `t`.`mail`)
		FROM `" . TABLE_PANEL_TRAFFIC . "` `t`
		WHERE `t`.`customerid` = `c`.`customerid` AND `t`.`year` = :year AND `t`.`month` = :month
		) as `traffic_used`
		FROM `" . TABLE_PANEL_CUSTOMERS . "` AS `c`
		LEFT JOIN `" . TABLE_PANEL_ADMINS . "` AS `a`
		ON `a`.`adminid` = `c`.`adminid` WHERE `c`.`reportsent` <> '1'
	");

	$result_data = array(
		'year' => date("Y", $yesterday),
		'month' => date("m", $yesterday)
	);
	Database::pexecute($result_stmt, $result_data);

	while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {

		if (isset($row['traffic'])
			&& $row['traffic'] > 0
			&& $row['traffic_used'] != null
			&& (($row['traffic_used'] * 100) / $row['traffic']) >= (int)Settings::Get('system.report_trafficmax')
		) {
			$rep_userinfo = array(
				'name' => $row['name'],
				'firstname' => $row['firstname'],
				'company' => $row['company']
			);
			$replace_arr = array(
				'SALUTATION' => getCorrectUserSalutation($rep_userinfo),
				'NAME' => $row['name'], // < keep this for compatibility
				'TRAFFIC' => round(($row['traffic'] / 1024), 2), /* traffic is stored in KB, template uses MB */
				'TRAFFICUSED' => round(($row['traffic_used'] / 1024), 2), /* traffic is stored in KB, template uses MB */
				'USAGE_PERCENT' => round(($row['traffic_used'] * 100) / $row['traffic'], 2),
				'MAX_PERCENT' => Settings::Get('system.report_trafficmax')
			);

			$lngfile_stmt = Database::prepare("
				SELECT `file` FROM `" . TABLE_PANEL_LANGUAGE . "`
				WHERE `language` = :deflang
			");
			$lngfile = Database::pexecute_first($lngfile_stmt, array('deflang' => $row['def_language']));

			if ($lngfile !== null) {
				$langfile = $lngfile['file'];
			} else {
				$lngfile = Database::pexecute_first($lngfile_stmt, array('deflang' => Settings::Get('panel.standardlanguage')));
				$langfile = $lngfile['file'];
			}

			// include english language file (fallback)
			include_once makeCorrectFile(FROXLOR_INSTALL_DIR . '/lng/english.lng.php');
			// include admin/customer language file
			include_once makeCorrectFile(FROXLOR_INSTALL_DIR . '/' . $langfile);

			// Get mail templates from database; the ones from 'admin' are fetched for fallback
			$result2_stmt = Database::prepare("
				SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
				WHERE `adminid` = :adminid
				AND `language` = :lang
				AND `templategroup` = 'mails' AND `varname` = :varname
			");
			$result2_data = array(
				'adminid' => $row['adminid'],
				'lang' => $row['def_language'],
				'varname' => 'trafficmaxpercent_subject'
			);
			$result2 = Database::pexecute_first($result2_stmt, $result2_data);
			$mail_subject = html_entity_decode(replace_variables((($result2['value'] != '') ? $result2['value'] : $lng['mails']['trafficmaxpercent']['subject']), $replace_arr));

			$result2_data['varname'] = 'trafficmaxpercent_mailbody';
			$result2 = Database::pexecute_first($result2_stmt, $result2_data);
			$mail_body = html_entity_decode(replace_variables((($result2['value'] != '') ? $result2['value'] : $lng['mails']['trafficmaxpercent']['mailbody']), $replace_arr));

			$_mailerror = false;
			try {
				$mail->SetFrom($row['adminmail'], $row['adminname']);
				$mail->Subject = $mail_subject;
				$mail->AltBody = $mail_body;
				$mail->MsgHTML(nl2br($mail_body));
				$mail->AddAddress($row['email'], $row['firstname'] . ' ' . $row['name']);
				$mail->Send();
			} catch(phpmailerException $e) {
				$mailerr_msg = $e->errorMessage();
				$_mailerror = true;
			} catch (Exception $e) {
				$mailerr_msg = $e->getMessage();
				$_mailerror = true;
			}

			if ($_mailerror) {
				$cronlog->logAction(CRON_ACTION, LOG_ERR, 'Error sending mail: ' . $mailerr_msg);
				echo 'Error sending mail: ' . $mailerr_msg . "\n";
			}

			$mail->ClearAddresses();
			$upd_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `reportsent` = '1'
				WHERE `customerid` = :customerid
			");
			Database::pexecute($upd_stmt, array('customerid' => $row['customerid']));
		}
	}

	// Warn the admins at xx% traffic-usage
	$result_stmt = Database::prepare("
		SELECT `a`.*,
		(SELECT SUM(`t`.`http` + `t`.`ftp_up` + `t`.`ftp_down` + `t`.`mail`)
		FROM `" . TABLE_PANEL_TRAFFIC_ADMINS . "` `t`
		WHERE `t`.`adminid` = `a`.`adminid` AND `t`.`year` = :year AND `t`.`month` = :month
		) as `traffic_used_total`
		FROM `" . TABLE_PANEL_ADMINS . "` `a` WHERE `a`.`reportsent` = '0'
	");

	$result_data = array(
		'year' => date("Y", $yesterday),
		'month' => date("m", $yesterday)
	);
	Database::pexecute($result_stmt, $result_data);

	while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {

		if (isset($row['traffic'])
			&& $row['traffic'] > 0
			&& (($row['traffic_used_total'] * 100) / $row['traffic']) >= (int)Settings::Get('system.report_trafficmax')
		) {

			$replace_arr = array(
				'NAME' => $row['name'],
				'TRAFFIC' => round(($row['traffic'] / 1024), 2), /* traffic is stored in KB, template uses MB */
				'TRAFFICUSED' => round(($row['traffic_used_total'] / 1024), 2), /* traffic is stored in KB, template uses MB */
				'USAGE_PERCENT' => round(($row['traffic_used_total'] * 100) / $row['traffic'], 2),
				'MAX_PERCENT' => Settings::Get('system.report_trafficmax')
			);

			$lngfile_stmt = Database::prepare("
				SELECT `file` FROM `" . TABLE_PANEL_LANGUAGE . "`
				WHERE `language` = :deflang
			");
			$lngfile = Database::pexecute_first($lngfile_stmt, array('deflang' => $row['def_language']));

			if ($lngfile !== null) {
				$langfile = $lngfile['file'];
			} else {
				$lngfile = Database::pexecute_first($lngfile_stmt, array('deflang' => Settings::Get('panel.standardlanguage')));
				$langfile = $lngfile['file'];
			}

			// include english language file (fallback)
			include_once makeCorrectFile(FROXLOR_INSTALL_DIR . '/lng/english.lng.php');
			// include admin/customer language file
			include_once makeCorrectFile(FROXLOR_INSTALL_DIR . '/' . $langfile);

			// Get mail templates from database; the ones from 'admin' are fetched for fallback
			$result2_stmt = Database::prepare("
				SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
				WHERE `adminid` = :adminid
				AND `language` = :lang
				AND `templategroup` = 'mails' AND `varname` = :varname
			");
			$resul2_data = array(
				'adminid' => $row['adminid'],
				'lang' => $row['def_language'],
				'varname' => 'trafficmaxpercent_subject'
			);
			$result2 = Database::pexecute_first($result2_stmt, $result2_data);
			$mail_subject = html_entity_decode(replace_variables((($result2['value'] != '') ? $result2['value'] : $lng['mails']['trafficmaxpercent']['subject']), $replace_arr));

			$resul2_data['varname'] = 'trafficmaxpercent_mailbody';
			$result2 = Database::pexecute_first($result2_stmt, $result2_data);
			$mail_body = html_entity_decode(replace_variables((($result2['value'] != '') ? $result2['value'] : $lng['mails']['trafficmaxpercent']['mailbody']), $replace_arr));

			$_mailerror = false;
			try {
				$mail->SetFrom($row['email'], $row['name']);
				$mail->Subject = $mail_subject;
				$mail->AltBody = $mail_body;
				$mail->MsgHTML(nl2br($mail_body));
				$mail->AddAddress($row['email'], $row['name']);
				$mail->Send();
			} catch(phpmailerException $e) {
				$mailerr_msg = $e->errorMessage();
				$_mailerror = true;
			} catch (Exception $e) {
				$mailerr_msg = $e->getMessage();
				$_mailerror = true;
			}

			if ($_mailerror) {
				$cronlog->logAction(CRON_ACTION, LOG_ERR, "Error sending mail: " . $mailerr_msg);
				echo "Error sending mail: " . $mailerr_msg . "\n";
			}

			$mail->ClearAddresses();
			$upd_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_ADMINS . "` SET `reportsent` = '1'
				WHERE `adminid` = :adminid
			");
			Database::pexecute($upd_stmt, array('adminid' => $row['adminid']));
		}

		// Another month, let's build our report
		if (date('d') == '01') {

			$mail_subject = 'Trafficreport ' . date("m/y", $yesterday) . ' for ' . $row['name'];
			$mail_body = 'Trafficreport ' . date("m/y", $yesterday) . ' for ' . $row['name'] . "\n";
			$mail_body.= '---------------------------------------------------------------' . "\n";
			$mail_body.= 'Loginname       Traffic used  (Percent) | Traffic available' . "\n";
			$customers_stmt = Database::prepare("
				SELECT `c`.*,
				(SELECT SUM(`t`.`http` + `t`.`ftp_up` + `t`.`ftp_down` + `t`.`mail`)
				FROM `" . TABLE_PANEL_TRAFFIC . "` `t`
				WHERE `t`.`customerid` = `c`.`customerid` AND `t`.`year` = :year AND `t`.`month` = :month
				) as `traffic_used_total`
				FROM `" . TABLE_PANEL_CUSTOMERS . "` `c` WHERE `c`.`adminid` = :adminid
			");
			$customers_data = array(
				'year' => date("Y", $yesterday),
				'month' => date("m", $yesterday),
				'adminid' => $row['adminid']
			);
			Database::pexecute($customers_stmt, $customers_data);

			while ($customer = $customers_stmt->fetch(PDO::FETCH_ASSOC)) {
				$t = $customer['traffic_used_total']/1048576;
				if ($customer['traffic'] > 0) {
					$p = (($customer['traffic_used_total'] * 100) / $customer['traffic'] );
					$tg = $customer['traffic']/1048576;
					$str = sprintf('%00.1f GB  ( %00.1f %% )', $t, $p);
					$mail_body.= sprintf('%-15s', $customer['loginname']) . ' ' . sprintf('%-25s', $str) . ' ' . sprintf('%00.1f GB', $tg) . "\n";
				} else if ($customer['traffic'] == 0) {
					$str = sprintf('%00.1f GB  (   -   )', $t);
					$mail_body.= sprintf('%-15s', $customer['loginname']) . ' ' . sprintf('%-25s', $str) . ' ' . '0' . "\n";
				} else {
					$str = sprintf('%00.1f GB  (   -   )', $t);
					$mail_body.= sprintf('%-15s', $customer['loginname']) . ' ' . sprintf('%-25s', $str) . ' ' . 'unlimited' . "\n";
				}
			}

			$mail_body.= '---------------------------------------------------------------' . "\n";

			$t = $row['traffic_used_total']/1048576;
			if ($row['traffic'] > 0) {
				$p = (($row['traffic_used_total'] * 100) / $row['traffic']);
				$tg = $row['traffic']/1048576;
				$str = sprintf('%00.1f GB  ( %00.1f %% )', $t, $p);
				$mail_body.= sprintf('%-15s', $row['loginname']) . ' ' . sprintf('%-25s', $str) . ' ' . sprintf('%00.1f GB', $tg) . "\n";
			} else if ($row['traffic'] == 0) {
				$str = sprintf('%00.1f GB  (   -   )', $t);
				$mail_body.= sprintf('%-15s', $row['loginname']) . ' ' . sprintf('%-25s', $str) . ' ' . '0' . "\n";
			} else {
				$str = sprintf('%00.1f GB  (   -   )', $t);
				$mail_body.= sprintf('%-15s', $row['loginname']) . ' ' . sprintf('%-25s', $str) . ' ' . 'unlimited' . "\n";
			}

			$_mailerror = false;
			try {
				$mail->SetFrom($row['email'], $row['name']);
				$mail->Subject = $mail_subject;
				$mail->Body = $mail_body;
				$mail->AddAddress($row['email'], $row['name']);
				$mail->Send();
			} catch(phpmailerException $e) {
				$mailerr_msg = $e->errorMessage();
				$_mailerror = true;
			} catch (Exception $e) {
				$mailerr_msg = $e->getMessage();
				$_mailerror = true;
			}

			if ($_mailerror) {
				$cronlog->logAction(CRON_ACTION, LOG_ERR, 'Error sending mail: ' . $mailerr_msg);
				echo 'Error sending mail: ' . $mailerr_msg . "\n";
			}

			$mail->ClearAddresses();
		}
	}
} // trafficmax > 0

// include diskspace-usage report, #466
include dirname(__FILE__).'/cron_usage.inc.diskspace.php';

// Another month, reset the reportstatus
if (date('d') == '01') {
	Database::query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `reportsent` = '0';");
	Database::query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `reportsent` = '0';");
}
