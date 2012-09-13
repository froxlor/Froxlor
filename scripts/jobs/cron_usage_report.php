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
 * @package    Cron
 *
 */

fwrite($debugHandler, 'Web- and Traffic-usage reporting started...' . "\n");
$yesterday = time() - (60 * 60 * 24);

/**
 * Initialize the mailingsystem
 */
$mail = new PHPMailer(true);

$mail->CharSet = "UTF-8";
$mail->SetFrom($settings['panel']['adminmail'], 'Froxlor Administrator');

// Warn the customers at xx% traffic-usage

$result = $db->query("SELECT `c`.`customerid`, `c`.`adminid`, `c`.`name`, `c`.`firstname`, `c`.`traffic`,
                             `c`.`email`, `c`.`def_language`, `a`.`name` AS `adminname`, `a`.`email` AS `adminmail`,
                           (SELECT SUM(`t`.`http` + `t`.`ftp_up` + `t`.`ftp_down` + `t`.`mail`)
                            FROM `" . TABLE_PANEL_TRAFFIC . "` `t`
                            WHERE `t`.`customerid` = `c`.`customerid` AND `t`.`year` = '" . (int)date("Y", $yesterday) . "'
                            AND `t`.`month` = '" . date("m", $yesterday) . "') as `traffic_used`
                      FROM `" . TABLE_PANEL_CUSTOMERS . "` AS `c`
                      LEFT JOIN `" . TABLE_PANEL_ADMINS . "` AS `a` ON `a`.`adminid` = `c`.`adminid`
                      WHERE `c`.`reportsent` <> '1'");

while($row = $db->fetch_array($result))
{
	if(isset($row['traffic'])
	   && $row['traffic'] > 0
	   && $row['traffic_used'] != NULL
	   && (($row['traffic_used'] * 100) / $row['traffic']) >= (int)$settings['system']['report_trafficmax'])
	{
		$replace_arr = array(
			'NAME' => $row['name'],
			'TRAFFIC' => round(($row['traffic'] / 1024), 2), /* traffic is stored in KB, template uses MB */
			'TRAFFICUSED' => round(($row['traffic_used'] / 1024), 2), /* traffic is stored in KB, template uses MB */
			'USAGE_PERCENT' => round(($row['traffic_used'] * 100) / $row['traffic'], 2),
			'MAX_PERCENT' => $settings['system']['report_trafficmax']
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
                                AND `varname`='trafficmaxpercent_subject'");
		$mail_subject = html_entity_decode(replace_variables((($result2['value'] != '') ? $result2['value'] : $lng['mails']['trafficmaxpercent']['subject']), $replace_arr));
		$result2 = $db->query_first("SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
                                WHERE `adminid`='" . (int)$row['adminid'] . "'
                                AND `language`='" . $db->escape($row['def_language']) . "'
                                AND `templategroup`='mails'
                                AND `varname`='trafficmaxpercent_mailbody'");
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

		if($_mailerror)
		{
			$cronlog->logAction(CRON_ACTION, LOG_ERR, 'Error sending mail: ' . $mailerr_msg);
			echo 'Error sending mail: ' . $mailerr_msg . "\n";
		}

		$mail->ClearAddresses();
		$db->query('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` SET `reportsent`=\'1\'
                WHERE `customerid`=\'' . (int)$row['customerid'] . '\'');
	}
}

// Warn the admins at xx% traffic-usage

$result = $db->query("SELECT `a`.*,
                       (SELECT SUM(`t`.`http` + `t`.`ftp_up` + `t`.`ftp_down` + `t`.`mail`)
                        FROM `" . TABLE_PANEL_TRAFFIC_ADMINS . "` `t`
                        WHERE `t`.`adminid` = `a`.`adminid` AND `t`.`year` = '" . (int)date("Y", $yesterday) . "'
                        AND `t`.`month` = '" . date("m", $yesterday) . "') as `traffic_used_total`
                      FROM `" . TABLE_PANEL_ADMINS . "` `a` WHERE `a`.`reportsent` = '0'");

while($row = $db->fetch_array($result))
{
	if(isset($row['traffic'])
	   && $row['traffic'] > 0
	   && (($row['traffic_used_total'] * 100) / $row['traffic']) >= (int)$settings['system']['report_trafficmax'])
	{
		$replace_arr = array(
			'NAME' => $row['name'],
			'TRAFFIC' => round(($row['traffic'] / 1024), 2), /* traffic is stored in KB, template uses MB */
			'TRAFFICUSED' => round(($row['traffic_used_total'] / 1024), 2), /* traffic is stored in KB, template uses MB */
			'USAGE_PERCENT' => round(($row['traffic_used_total'] * 100) / $row['traffic'], 2),
			'MAX_PERCENT' => $settings['system']['report_trafficmax']
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
                                AND `varname`='trafficmaxpercent_subject'");
		$mail_subject = html_entity_decode(replace_variables((($result2['value'] != '') ? $result2['value'] : $lng['mails']['trafficmaxpercent']['subject']), $replace_arr));
		$result2 = $db->query_first("SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
                                WHERE `adminid`='" . (int)$row['adminid'] . "'
                                AND `language`='" . $db->escape($row['def_language']) . "'
                                AND `templategroup`='mails'
                                AND `varname`='trafficmaxpercent_mailbody'");
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
		$db->query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `reportsent`='1'
                WHERE `adminid`='" . (int)$row['adminid'] . "'");
	}

	// Another month, let's build our report

	if(date('d') == '01')
	{
		$mail_subject = 'Trafficreport ' . date("m/y", $yesterday) . ' for ' . $row['name'];
		$mail_body = 'Trafficreport ' . date("m/y", $yesterday) . ' for ' . $row['name'] . "\n";
		$mail_body.= '---------------------------------------------' . "\n";
		$mail_body.= 'Loginname       Traffic used (Percent) | Traffic available' . "\n";
		$customers = $db->query("SELECT `c`.*,
                            (SELECT SUM(`t`.`http` + `t`.`ftp_up` + `t`.`ftp_down` + `t`.`mail`)
                            FROM `" . TABLE_PANEL_TRAFFIC . "` `t`
                            WHERE `t`.`customerid` = `c`.`customerid` AND `t`.`year` = '" . (int)date("Y", $yesterday) . "'
                            AND `t`.`month` = '" . date("m", $yesterday) . "') as `traffic_used_total`
                            FROM `" . TABLE_PANEL_CUSTOMERS . "` `c` WHERE `c`.`adminid` = '" . $row['adminid'] . "'");

		while($customer = $db->fetch_array($customers))
		{
			if ($customer['traffic'] > 0) {
				$mail_body.= sprintf('%-15s', $customer['loginname']) . ' ' . sprintf('%-12d', $customer['traffic_used_total']) . ' (' . sprintf('%00.3f%%', (($customer['traffic_used_total'] * 100) / $customer['traffic'])) . ')   ' . $customer['traffic'] . "\n";
			} else {
				$mail_body.= sprintf('%-15s', $customer['loginname']) . ' ' . sprintf('%-12d', $customer['traffic_used_total']) . ' (' . sprintf('%00.3f%%', $customer['traffic_used_total']) . ')   ' . $customer['traffic'] . "\n";
			}
		}

		$mail_body.= '---------------------------------------------' . "\n";
		$mail_body.= sprintf('%-15s', $row['loginname']) . ' ' . sprintf('%-12d', $row['traffic_used_total']) . ' (' . sprintf('%00.3f%%', (($row['traffic_used_total'] * 100) / $row['traffic'])) . ')   ' . $row['traffic'] . "\n";
		
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

// include diskspace-usage report, #466
include dirname(__FILE__).'/cron_usage.inc.diskspace.php';

// Another month, reset the reportstatus

if(date('d') == '01')
{
	$db->query('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` SET `reportsent` = \'0\';');
	$db->query('UPDATE `' . TABLE_PANEL_ADMINS . '` SET `reportsent` = \'0\';');
}
