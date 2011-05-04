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
 * @package    Cron
 *
 */

/**
 * report about diskusage for customers
 */
$result = $db->query("SELECT
	`c`.`customerid`, `c`.`adminid`, `c`.`name`, `c`.`firstname`, `c`.`diskspace`, 
	`c`.`diskspace_used`, `c`.`email`, `c`.`def_language`, 
	`a`.`name` AS `adminname`, `a`.`email` AS `adminmail`
	FROM `" . TABLE_PANEL_CUSTOMERS . "` AS `c`
    LEFT JOIN `" . TABLE_PANEL_ADMINS . "` AS `a` 
    ON `a`.`adminid` = `c`.`adminid`
    WHERE `c`.`diskspace` > '0' AND `c`.`reportsent` <> '2'");

while($row = $db->fetch_array($result))
{
	if(isset($row['diskspace'])
		&& $row['diskspace_used'] != NULL
		&& $row['diskspace_used'] > 0
		&& (($row['diskspace_used'] * 100) / $row['diskspace']) >= (int)$settings['system']['report_webmax']
	) {

		$replace_arr = array(
			'NAME' => $row['name'],
			'DISKAVAILABLE' => round(($row['diskspace'] / 1024), 2), /* traffic is stored in KB, template uses MB */
			'DISKUSED' => round($row['diskspace_used'] / 1024, 2), /* traffic is stored in KB, template uses MB */
			'USAGE_PERCENT' => round(($row['diskspace_used'] * 100) / $row['diskspace'], 2),
			'MAX_PERCENT' => $settings['system']['report_webmax']
		);

		$lngfile = $db->query_first("SELECT `file` FROM `" . TABLE_PANEL_LANGUAGE . "`
									WHERE `language` ='" . $row['def_language'] . "'");

		if($lngfile !== NULL)
		{
			$langfile = $lngfile['file'];
		}
		else
		{
			$lngfile = $db->query_first("SELECT `file` FROM `" . TABLE_PANEL_LANGUAGE . "`
										WHERE `language` ='" . $settings['panel']['standardlanguage'] . "'");
			$langfile = $lngfile['file'];
		}

		include_once makeCorrectFile($pathtophpfiles . '/' . $langfile);

		// Get mail templates from database; the ones from 'admin' are fetched for fallback
		$result2 = $db->query_first("SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
	                                WHERE `adminid`='" . (int)$row['adminid'] . "'
	                                AND `language`='" . $db->escape($row['def_language']) . "'
	                                AND `templategroup`='mails'
	                                AND `varname`='diskmaxpercent_subject'");
		$mail_subject = html_entity_decode(replace_variables((($result2['value'] != '') ? $result2['value'] : $lng['mails']['webmaxpercent']['subject']), $replace_arr));

		$result2 = $db->query_first("SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
	                                WHERE `adminid`='" . (int)$row['adminid'] . "'
	                                AND `language`='" . $db->escape($row['def_language']) . "'
	                                AND `templategroup`='mails'
	                                AND `varname`='diskmaxpercent_mailbody'");
		$mail_body = html_entity_decode(replace_variables((($result2['value'] != '') ? $result2['value'] : $lng['mails']['webmaxpercent']['mailbody']), $replace_arr));

		$_mailerror = false;
		try {
			$mail->SetFrom($row['email'], $row['firstname'] . " " . $row['name']);
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
		$db->query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `reportsent`='2'
	                WHERE `customerid`='" . (int)$row['customerid'] . "'");
	}
}

/**
 * report about diskusage for admins/reseller
 */
$result = $db->query("SELECT `a`.* FROM `" . TABLE_PANEL_ADMINS . "` `a` WHERE `a`.`reportsent` <> '2'");

while($row = $db->fetch_array($result))
{
	if(isset($row['diskspace'])
		&& $row['diskspace_used'] != NULL
		&& $row['diskspace_used'] > 0
		&& (($row['diskspace_used'] * 100) / $row['diskspace']) >= (int)$settings['system']['report_webmax']
	) {

		$replace_arr = array(
			'NAME' => $row['name'],
			'DISKAVAILABLE' => ($row['diskspace'] / 1024), /* traffic is stored in KB, template uses MB */
			'DISKUSED' => round($row['diskspace_used'] / 1024, 2), /* traffic is stored in KB, template uses MB */
			'USAGE_PERCENT' => ($row['diskspace_used'] * 100) / $row['diskspace'],
			'MAX_PERCENT' => $settings['system']['report_webmax']
		);

		$lngfile = $db->query_first("SELECT `file` FROM `" . TABLE_PANEL_LANGUAGE . "`
									WHERE `language` ='" . $row['def_language'] . "'");

		if($lngfile !== NULL)
		{
			$langfile = $lngfile['file'];
		}
		else
		{
			$lngfile = $db->query_first("SELECT `file` FROM `" . TABLE_PANEL_LANGUAGE . "`
										WHERE `language` ='" . $settings['panel']['standardlanguage'] . "'");
			$langfile = $lngfile['file'];
		}

		include_once makeCorrectFile($pathtophpfiles . '/' . $langfile);

		// Get mail templates from database; the ones from 'admin' are fetched for fallback
		$result2 = $db->query_first("SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
	                                WHERE `adminid`='" . (int)$row['adminid'] . "'
	                                AND `language`='" . $db->escape($row['def_language']) . "'
	                                AND `templategroup`='mails'
	                                AND `varname`='diskmaxpercent_subject'");
		$mail_subject = html_entity_decode(replace_variables((($result2['value'] != '') ? $result2['value'] : $lng['mails']['webmaxpercent']['subject']), $replace_arr));

		$result2 = $db->query_first("SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
	                                WHERE `adminid`='" . (int)$row['adminid'] . "'
	                                AND `language`='" . $db->escape($row['def_language']) . "'
	                                AND `templategroup`='mails'
	                                AND `varname`='diskmaxpercent_mailbody'");
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
		$db->query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `reportsent`='2'
	                WHERE `adminid`='" . (int)$row['adminid'] . "'");
	}
}
