<?php if (!defined('MASTER_CRONJOB')) die('You cannot access this file directly!');

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
 * @package    Cron
 *
 */

/**
 * report about diskusage for customers
 */
$result_stmt = Database::query("
	SELECT `c`.`customerid`, `c`.`adminid`, `c`.`name`, `c`.`firstname`,
	`c`.`company`, `c`.`diskspace`, `c`.`diskspace_used`, `c`.`email`, `c`.`def_language`,
	`a`.`name` AS `adminname`, `a`.`email` AS `adminmail`
	FROM `" . TABLE_PANEL_CUSTOMERS . "` AS `c`
    LEFT JOIN `" . TABLE_PANEL_ADMINS . "` AS `a`
    ON `a`.`adminid` = `c`.`adminid`
    WHERE `c`.`diskspace` > '0' AND `c`.`reportsent` <> '2'
");

while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {

	if (isset($row['diskspace'])
		&& $row['diskspace_used'] != null
		&& $row['diskspace_used'] > 0
		&& (($row['diskspace_used'] * 100) / $row['diskspace']) >= (int)Settings::Get('system.report_webmax')
	) {

		$rep_userinfo = array(
			'name' => $row['name'],
			'firstname' => $row['firstname'],
			'company' => $row['company']
		);
		$replace_arr = array(
			'SALUTATION' => getCorrectUserSalutation($rep_userinfo),
			'NAME' => $row['name'], // < keep this for compatibility
			'DISKAVAILABLE' => round(($row['diskspace'] / 1024), 2), /* traffic is stored in KB, template uses MB */
			'DISKUSED' => round($row['diskspace_used'] / 1024, 2), /* traffic is stored in KB, template uses MB */
			'USAGE_PERCENT' => round(($row['diskspace_used'] * 100) / $row['diskspace'], 2),
			'MAX_PERCENT' => Settings::Get('system.report_webmax')
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
			'varname' => 'diskmaxpercent_subject'
		);
		$result2 = Database::pexecute_first($result2_stmt, $result2_data);
		$mail_subject = html_entity_decode(replace_variables((($result2['value'] != '') ? $result2['value'] : $lng['mails']['webmaxpercent']['subject']), $replace_arr));

		$result2_data['varname'] = 'diskmaxpercent_mailbody';
		$result2 = Database::pexecute_first($result2_stmt, $result2_data);
		$mail_body = html_entity_decode(replace_variables((($result2['value'] != '') ? $result2['value'] : $lng['mails']['webmaxpercent']['mailbody']), $replace_arr));

		$_mailerror = false;
		try {
			$mail->SetFrom($row['adminmail'], $row['adminname']);
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
			UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `reportsent` = '2'
			WHERE `customerid` = :customerid
		");
		Database::pexecute($upd_stmt, array('customerid' => $row['customerid']));
	}
}

/**
 * report about diskusage for admins/reseller
 */
$result_stmt = Database::query("
	SELECT `a`.* FROM `" . TABLE_PANEL_ADMINS . "` `a` WHERE `a`.`reportsent` <> '2'
");

while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {

	if (isset($row['diskspace'])
		&& $row['diskspace_used'] != null
		&& $row['diskspace_used'] > 0
		&& (($row['diskspace_used'] * 100) / $row['diskspace']) >= (int)Settings::Get('system.report_webmax')
	) {

		$replace_arr = array(
			'NAME' => $row['name'],
			'DISKAVAILABLE' => ($row['diskspace'] / 1024), /* traffic is stored in KB, template uses MB */
			'DISKUSED' => round($row['diskspace_used'] / 1024, 2), /* traffic is stored in KB, template uses MB */
			'USAGE_PERCENT' => ($row['diskspace_used'] * 100) / $row['diskspace'],
			'MAX_PERCENT' => Settings::Get('system.report_webmax')
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
			'varname' => 'diskmaxpercent_subject'
		);
		$result2 = Database::pexecute_first($result2_stmt, $result2_data);
		$mail_subject = html_entity_decode(replace_variables((($result2['value'] != '') ? $result2['value'] : $lng['mails']['webmaxpercent']['subject']), $replace_arr));

		$result2_data['varname'] = 'diskmaxpercent_mailbody';
		$result2 = Database::pexecute_first($result2_stmt, $result2_data);
		$mail_body = html_entity_decode(replace_variables((($result2['value'] != '') ? $result2['value'] : $lng['mails']['webmaxpercent']['mailbody']), $replace_arr));

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
			UPDATE `" . TABLE_PANEL_ADMINS . "` SET `reportsent` = '2'
			WHERE `adminid` = :adminid
		");
		Database::pexecute($upd_stmt, array('adminid' => $row['adminid']));
	}
}
