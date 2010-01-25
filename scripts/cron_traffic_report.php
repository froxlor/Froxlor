<?php

/**
 * This file is part of the SysCP project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Aders <eleras@syscp.org>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    System
 * @version    $Id$
 */

/**
 * STARTING REDUNDANT CODE, WHICH IS SOME KINDA HEADER FOR EVERY CRON SCRIPT.
 * When using this "header" you have to change $lockFilename for your needs.
 * Don't forget to also copy the footer which closes database connections
 * and the lockfile!
 */

include (dirname(__FILE__) . '/../lib/cron_init.php');

/**
 * END REDUNDANT CODE (CRONSCRIPT "HEADER")
 */

fwrite($debugHandler, 'Trafficreport run started...' . "\n");
$yesterday = time() - (60 * 60 * 24);

/**
 * Initialize the mailingsystem
 */

require (dirname(__FILE__) . '/../lib/class.phpmailer.php');
$mail = new PHPMailer();
$mail->From = $settings['panel']['adminmail'];

// Warn the customers at 90% traffic-usage

$result = $db->query("SELECT `c`.`customerid`, `c`.`adminid`, `c`.`name`, `c`.`firstname`, `c`.`traffic`,
                             `c`.`email`, `c`.`def_language`, `a`.`name` AS `adminname`, `a`.`email` AS `adminmail`,
                           (SELECT SUM(`t`.`http` + `t`.`ftp_up` + `t`.`ftp_down` + `t`.`mail`)
                            FROM `" . TABLE_PANEL_TRAFFIC . "` `t`
                            WHERE `t`.`customerid` = `c`.`customerid` AND `t`.`year` = '" . (int)date("Y", $yesterday) . "'
                            AND `t`.`month` = '" . date("m", $yesterday) . "') as `traffic_used`
                      FROM `" . TABLE_PANEL_CUSTOMERS . "` AS `c`
                      LEFT JOIN `" . TABLE_PANEL_ADMINS . "` AS `a` ON `a`.`adminid` = `c`.`adminid`
                      WHERE `c`.`reportsent` = '0'");

while($row = $db->fetch_array($result))
{
	if(isset($row['traffic'])
	   && $row['traffic'] > 0
	   && $row['traffic_used'] != NULL
	   && (($row['traffic_used'] * 100) / $row['traffic']) >= 90)
	{
		$replace_arr = array(
			'NAME' => $row['name'],
			'TRAFFIC' => $row['traffic'],
			'TRAFFICUSED' => $row['traffic_used']
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
                                AND `varname`='trafficninetypercent_subject'");
		$mail_subject = html_entity_decode(replace_variables((($result2['value'] != '') ? $result2['value'] : $lng['mails']['trafficninetypercent']['subject']), $replace_arr));
		$result2 = $db->query_first("SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
                                WHERE `adminid`='" . (int)$row['adminid'] . "'
                                AND `language`='" . $db->escape($row['def_language']) . "'
                                AND `templategroup`='mails'
                                AND `varname`='trafficninetypercent_mailbody'");
		$mail_body = html_entity_decode(replace_variables((($result2['value'] != '') ? $result2['value'] : $lng['mails']['trafficninetypercent']['mailbody']), $replace_arr));
		$mail->From = $row['adminmail'];
		$mail->FromName = $row['adminname'];
		$mail->Subject = $mail_subject;
		$mail->Body = $mail_body;
		$mail->AddAddress($row['email'], $row['firstname'] . ' ' . $row['name']);

		if(!$mail->Send())
		{
			$cronlog->logAction(CRON_ACTION, LOG_ERR, "Error sending mail: " . $mail->ErrorInfo);
			standard_error('errorsendingmail', $row["email"]);
		}

		$mail->ClearAddresses();
		$db->query('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` SET `reportsent`=\'1\'
                WHERE `customerid`=\'' . (int)$row['customerid'] . '\'');
	}
}

// Warn the admins at 90% traffic-usage

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
	   && (($row['traffic_used_total'] * 100) / $row['traffic']) >= 90)
	{
		$replace_arr = array(
			'NAME' => $row['name'],
			'TRAFFIC' => $row['traffic'],
			'TRAFFICUSED' => $row['traffic_used_total']
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
                                AND `varname`='trafficninetypercent_subject'");
		$mail_subject = html_entity_decode(replace_variables((($result2['value'] != '') ? $result2['value'] : $lng['mails']['trafficninetypercent']['subject']), $replace_arr));
		$result2 = $db->query_first("SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
                                WHERE `adminid`='" . (int)$row['adminid'] . "'
                                AND `language`='" . $db->escape($row['def_language']) . "'
                                AND `templategroup`='mails'
                                AND `varname`='trafficninetypercent_mailbody'");
		$mail_body = html_entity_decode(replace_variables((($result2['value'] != '') ? $result2['value'] : $lng['mails']['trafficninetypercent']['mailbody']), $replace_arr));
		$mail->From = $row['email'];
		$mail->FromName = $row['firstname'] . " " . $row['name'];
		$mail->Subject = $mail_subject;
		$mail->Body = $mail_body;
		$mail->AddAddress($row['email'], $row['name']);

		if(!$mail->Send())
		{
			$cronlog->logAction(CRON_ACTION, LOG_ERR, "Error sending mail: " . $mail->ErrorInfo);
			standard_error('errorsendingmail', $row["email"]);
		}

		$mail->ClearAddresses();
		$db->query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `reportsent`='1'
                WHERE `customerid`='" . (int)$row['adminid'] . "'");
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
			$mail_body.= sprintf('%-15s', $customer['loginname']) . ' ' . sprintf('%-12d', $customer['traffic_used_total']) . ' (' . sprintf('%00.3f%%', (($customer['traffic_used_total'] * 100) / $customer['traffic'])) . ')   ' . $customer['traffic'] . "\n";
		}

		$mail_body.= '---------------------------------------------' . "\n";
		$mail_body.= sprintf('%-15s', $row['loginname']) . ' ' . sprintf('%-12d', $row['traffic_used_total']) . ' (' . sprintf('%00.3f%%', (($row['traffic_used_total'] * 100) / $row['traffic'])) . ')   ' . $row['traffic'] . "\n";
		$mail->From = $row['email'];
		$mail->FromName = $row['name'];
		$mail->Subject = $mail_subject;
		$mail->Body = $mail_body;
		$mail->AddAddress($row['email'], $row['name']);

		if(!$mail->Send())
		{
			$cronlog->logAction(CRON_ACTION, LOG_ERR, "Error sending mail: " . $mail->ErrorInfo);
			standard_error('errorsendingmail', $row["email"]);
		}

		$mail->ClearAddresses();
	}
}

// Another month, reset the reportstatus

if(date('d') == '01')
{
	$db->query('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` SET `reportsent` = \'0\';');
	$db->query('UPDATE `' . TABLE_PANEL_ADMINS . '` SET `reportsent` = \'0\';');
}

$db->query('UPDATE `' . TABLE_PANEL_SETTINGS . '` SET `value` = UNIX_TIMESTAMP()
            WHERE `settinggroup` = \'system\' AND `varname` = \'last_traffic_report_run\' ');

/**
 * STARTING CRONSCRIPT FOOTER
 */

include ($pathtophpfiles . '/lib/cron_shutdown.php');

/**
 * END CRONSCRIPT FOOTER
 */

?>
