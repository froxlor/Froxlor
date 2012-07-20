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

/**
 * Include our init.php, which manages Sessions, Language etc.
 */

require ("./lib/init.php");

if(isset($_POST['id']))
{
	$id = intval($_POST['id']);
}
elseif(isset($_GET['id']))
{
	$id = intval($_GET['id']);
}

if($page == 'overview')
{
	$log->logAction(USR_ACTION, LOG_NOTICE, "viewed customer_ftp");
	eval("echo \"" . getTemplate("ftp/ftp") . "\";");
}
elseif($page == 'accounts')
{
	if($action == '')
	{
		$log->logAction(USR_ACTION, LOG_NOTICE, "viewed customer_ftp::accounts");
		$fields = array(
			'username' => $lng['login']['username'],
			'homedir' => $lng['panel']['path']
		);
		$paging = new paging($userinfo, $db, TABLE_FTP_USERS, $fields, $settings['panel']['paging'], $settings['panel']['natsorting']);
		$result = $db->query("SELECT `id`, `username`, `homedir` FROM `" . TABLE_FTP_USERS . "` WHERE `customerid`='" . $userinfo['customerid'] . "'  AND `username` NOT LIKE '%_backup'" . $paging->getSqlWhere(true) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit());
		$paging->setEntries($db->num_rows($result));
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$i = 0;
		$count = 0;
		$accounts = '';

		while($row = $db->fetch_array($result))
		{
			if($paging->checkDisplay($i))
			{
				if(strpos($row['homedir'], $userinfo['documentroot']) === 0)
				{
					$row['documentroot'] = substr($row['homedir'], strlen($userinfo['documentroot']));
				}
				else
				{
					$row['documentroot'] = $row['homedir'];
				}

				$row['documentroot'] = makeCorrectDir($row['documentroot']);
				
				$row = htmlentities_array($row);
				eval("\$accounts.=\"" . getTemplate("ftp/accounts_account") . "\";");
				$count++;
			}

			$i++;
		}

		$ftps_count = $db->num_rows($result);
		eval("echo \"" . getTemplate("ftp/accounts") . "\";");
	}
	elseif($action == 'delete'
	       && $id != 0)
	{
		$result = $db->query_first("SELECT `id`, `username`, `homedir`, `up_count`, `up_bytes`, `down_count`, `down_bytes` FROM `" . TABLE_FTP_USERS . "` WHERE `customerid`='" . (int)$userinfo['customerid'] . "' AND `id`='" . (int)$id . "'");

		if(isset($result['username'])
		   && $result['username'] != $userinfo['loginname'])
		{
			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				$db->query("UPDATE `" . TABLE_FTP_USERS . "` SET `up_count`=`up_count`+'" . (int)$result['up_count'] . "', `up_bytes`=`up_bytes`+'" . (int)$result['up_bytes'] . "', `down_count`=`down_count`+'" . (int)$result['down_count'] . "', `down_bytes`=`down_bytes`+'" . (int)$result['down_bytes'] . "' WHERE `username`='" . $db->escape($userinfo['loginname']) . "'");
				$result = $db->query_first("SELECT `username`, `homedir` FROM `" . TABLE_FTP_USERS . "` WHERE `customerid`='" . (int)$userinfo['customerid'] . "' AND `id`='" . (int)$id . "'");
				$db->query("DELETE FROM `" . TABLE_FTP_QUOTATALLIES . "` WHERE `name` = '" . $db->escape($result['username']) . "'");
				$db->query("DELETE FROM `" . TABLE_FTP_USERS . "` WHERE `customerid`='" . (int)$userinfo['customerid'] . "' AND `id`='" . (int)$id . "'");
				$log->logAction(USR_ACTION, LOG_INFO, "deleted ftp-account '" . $result['username'] . "'");
				$db->query("UPDATE `" . TABLE_FTP_GROUPS . "` SET `members`=REPLACE(`members`,'," . $db->escape($result['username']) . "','') WHERE `customerid`='" . (int)$userinfo['customerid'] . "'");

				if($userinfo['ftps_used'] == '1')
				{
					$resetaccnumber = " , `ftp_lastaccountnumber`='0'";
				}
				else
				{
					$resetaccnumber = '';
				}

				// refs #293
				if(isset($_POST['delete_userfiles'])
				  && (int)$_POST['delete_userfiles'] == 1)
				{
					inserttask('8', $userinfo['loginname'], $result['homedir']);
				}

				$result = $db->query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `ftps_used`=`ftps_used`-1 $resetaccnumber WHERE `customerid`='" . (int)$userinfo['customerid'] . "'");
				redirectTo($filename, Array('page' => $page, 's' => $s));
			}
			else
			{
				ask_yesno_withcheckbox('ftp_reallydelete', 'admin_customer_alsoremoveftphomedir', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $result['username']);
			}
		}
		else
		{
			standard_error('ftp_cantdeletemainaccount');
		}
	}
	elseif($action == 'add')
	{
		if($userinfo['ftps_used'] < $userinfo['ftps']
		   || $userinfo['ftps'] == '-1')
		{
			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				$path = validate($_POST['path'], 'path');
				$password = validate($_POST['ftp_password'], 'password');
				$password = validatePassword($password);

				$sendinfomail = isset($_POST['sendinfomail']) ? 1 : 0;
				if($sendinfomail != 1)
				{
					$sendinfomail = 0;
				}

				if($settings['customer']['ftpatdomain'] == '1')
				{
					$ftpusername = validate($_POST['ftp_username'], 'username', '/^[a-zA-Z0-9][a-zA-Z0-9\-_]+\$?$/');
					if($ftpusername == '')
					{
						standard_error(array('stringisempty', 'username'));
					}
					$ftpdomain = $idna_convert->encode(validate($_POST['ftp_domain'], 'domain'));
					$ftpdomain_check = $db->query_first("SELECT `id`, `domain`, `customerid` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `domain`='" . $db->escape($ftpdomain) . "' AND `customerid`='" . (int)$userinfo['customerid'] . "'");
					if($ftpdomain_check['domain'] != $ftpdomain)
					{
						standard_error('maindomainnonexist', $domain);
					}
					$username = $ftpusername . "@" . $ftpdomain;
				}
				else
				{
					$username = $userinfo['loginname'] . $settings['customer']['ftpprefix'] . (intval($userinfo['ftp_lastaccountnumber']) + 1);
				}
				
				$username_check = $db->query_first('SELECT * FROM `' . TABLE_FTP_USERS .'` WHERE `username` = \'' . $db->escape($username) . '\'');
				
				if(!empty($username_check) && $username_check['username'] = $username)
				{
					standard_error('usernamealreadyexists', $username);
				}
				elseif($password == '')
				{
					standard_error(array('stringisempty', 'mypassword'));
				}
				elseif($path == '')
				{
					standard_error('patherror');
				}
				else
				{
					$path = makeCorrectDir($userinfo['documentroot'] . '/' . $path);

					$cryptPassword = makeCryptPassword($db->escape($password),1);					
					$db->query("INSERT INTO `" . TABLE_FTP_USERS . "` (`customerid`, `username`, `password`, `homedir`, `login_enabled`, `uid`, `gid`) VALUES ('" . (int)$userinfo['customerid'] . "', '" . $db->escape($username) . "', '" . $db->escape($cryptPassword) . "', '" . $db->escape($path) . "', 'y', '" . (int)$userinfo['guid'] . "', '" . (int)$userinfo['guid'] . "')");
					$result = $db->query("SELECT `bytes_in_used` FROM `" . TABLE_FTP_QUOTATALLIES . "` WHERE `name` = '" . $userinfo['loginname'] . "'");
					while($row = $db->fetch_array($result))
					{
						$db->query("INSERT INTO `" . TABLE_FTP_QUOTATALLIES . "` (`name`, `quota_type`, `bytes_in_used`, `bytes_out_used`, `bytes_xfer_used`, `files_in_used`, `files_out_used`, `files_xfer_used`) VALUES ('" . $db->escape($username) . "', 'user', '" . $db->escape($row['bytes_in_used']) . "', '0', '0', '0', '0', '0')");
					}
					$db->query("UPDATE `" . TABLE_FTP_GROUPS . "` SET `members`=CONCAT_WS(',',`members`,'" . $db->escape($username) . "') WHERE `customerid`='" . $userinfo['customerid'] . "' AND `gid`='" . (int)$userinfo['guid'] . "'");
					$db->query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `ftps_used`=`ftps_used`+1, `ftp_lastaccountnumber`=`ftp_lastaccountnumber`+1 WHERE `customerid`='" . (int)$userinfo['customerid'] . "'");

					$log->logAction(USR_ACTION, LOG_INFO, "added ftp-account '" . $username . " (" . $path . ")'");
					inserttask(5);

					if($sendinfomail == 1)
					{
						$replace_arr = array(
							'CUST_NAME' => getCorrectUserSalutation($userinfo),
							'USR_NAME' => $username,
							'USR_PASS' => $password,
							'USR_PATH' => makeCorrectDir(substr($path, strlen($userinfo['documentroot'])))
						);
						
						$def_language = $userinfo['def_language'];
						$result = $db->query_first('SELECT `value` FROM `' . TABLE_PANEL_TEMPLATES . '` WHERE `adminid`=\'' . (int)$userinfo['adminid'] . '\' AND `language`=\'' . $db->escape($def_language) . '\' AND `templategroup`=\'mails\' AND `varname`=\'new_ftpaccount_by_customer_subject\'');
						$mail_subject = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $lng['customer']['ftp_add']['infomail_subject']), $replace_arr));
						$result = $db->query_first('SELECT `value` FROM `' . TABLE_PANEL_TEMPLATES . '` WHERE `adminid`=\'' . (int)$userinfo['adminid'] . '\' AND `language`=\'' . $db->escape($def_language) . '\' AND `templategroup`=\'mails\' AND `varname`=\'new_ftpaccount_by_customer_mailbody\'');
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

					redirectTo($filename, Array('page' => $page, 's' => $s));
				}
			}
			else
			{
				$pathSelect = makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid'], $settings['panel']['pathedit'], '/');

				if($settings['customer']['ftpatdomain'] == '1')
				{
					$domainlist = array();
					$domains = '';

					$result_domains = $db->query("SELECT `domain` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `customerid`='" . (int)$userinfo['customerid'] . "'");

					while($row_domain = $db->fetch_array($result_domains))
					{
						$domainlist[] =  $row_domain['domain'];
					}

					sort($domainlist);

					if(isset($domainlist[0]) && $domainlist[0] != '')
					{
						foreach($domainlist as $dom)
						{
							$domains .= makeoption($idna_convert->decode($dom), $dom);
						}
					}
				}

				//$sendinfomail = makeyesno('sendinfomail', '1', '0', '0');

				$ftp_add_data = include_once dirname(__FILE__).'/lib/formfields/customer/ftp/formfield.ftp_add.php';
				$ftp_add_form = htmlform::genHTMLForm($ftp_add_data);

				$title = $ftp_add_data['ftp_add']['title'];
				$image = $ftp_add_data['ftp_add']['image'];

				eval("echo \"" . getTemplate("ftp/accounts_add") . "\";");
			}
		}
	}
	elseif($action == 'edit'
	       && $id != 0)
	{
		$result = $db->query_first("SELECT `id`, `username`, `homedir`, `uid`, `gid` FROM `" . TABLE_FTP_USERS . "` WHERE `customerid`='" . (int)$userinfo['customerid'] . "' AND `id`='" . (int)$id . "'");

		if(isset($result['username'])
		   && $result['username'] != '')
		{
			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				$path = validate($_POST['path'], 'path');
				
				$_setnewpass = false;
				if(isset($_POST['ftp_password']) && $_POST['ftp_password'] != '')
				{
					$password = validate($_POST['ftp_password'], 'password');
					$password = validatePassword($password);
					$_setnewpass = true;
				}

				if($_setnewpass)
				{
					if($password == '')
					{
						standard_error(array('stringisempty', 'mypassword'));
						exit;
					}
					else
					{
						$log->logAction(USR_ACTION, LOG_INFO, "updated ftp-account password for '" . $result['username'] . "'");
						$cryptPassword = makeCryptPassword($db->escape($password),1);
						$db->query("UPDATE `" . TABLE_FTP_USERS . "` SET `password`='" . $db->escape($cryptPassword) . "' WHERE `customerid`='" . (int)$userinfo['customerid'] . "' AND `id`='" . (int)$id . "'");
						
						// also update customers backup user password if password of main ftp user is changed
						if(!preg_match('/' . $settings['customer']['ftpprefix'] . '/', $result['username'])){
						    $db->query("UPDATE `" . TABLE_FTP_USERS . "` SET `password`='" . $db->escape($cryptPassword) . "' WHERE `customerid`='" . (int)$userinfo['customerid'] . "' AND `username`='" . $result['username'] . "_backup'");
						}
					}
				}
				
				if($path != '')
				{
					$path = makeCorrectDir($userinfo['documentroot'] . '/' . $path);
					
					if($path != $result['homedir'])
					{
						if(!file_exists($path))
						{
							mkDirWithCorrectOwnership($userinfo['documentroot'], $path, $result['uid'], $result['gid']);
							inserttask(5); /* Let the cronjob do the rest */
						}

						$log->logAction(USR_ACTION, LOG_INFO, "updated ftp-account homdir for '" . $result['username'] . "'");
						$db->query("UPDATE `" . TABLE_FTP_USERS . "` SET `homedir`= '" . $db->escape($path) . "' WHERE `customerid`='" . (int)$userinfo['customerid'] . "' AND `id`='" . (int)$id . "'");						
					}
				}

				redirectTo($filename, Array('page' => $page, 's' => $s));
			}
			else
			{
				if(strpos($result['homedir'], $userinfo['documentroot']) === 0)
				{
					$homedir = substr($result['homedir'], strlen($userinfo['documentroot']));
				}
				else
				{
					$homedir = $result['homedir'];
				}
				$homedir = makeCorrectDir($homedir);

				$pathSelect = makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid'], $settings['panel']['pathedit'], $homedir);

				if($settings['customer']['ftpatdomain'] == '1')
				{
					$domains = '';

					$result_domains = $db->query("SELECT `domain` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `customerid`='" . (int)$userinfo['customerid'] . "'");

					while($row_domain = $db->fetch_array($result_domains))
					{
						$domains.= makeoption($idna_convert->decode($row_domain['domain']), $row_domain['domain']);
					}
				}

				$ftp_edit_data = include_once dirname(__FILE__).'/lib/formfields/customer/ftp/formfield.ftp_edit.php';
				$ftp_edit_form = htmlform::genHTMLForm($ftp_edit_data);

				$title = $ftp_edit_data['ftp_edit']['title'];
				$image = $ftp_edit_data['ftp_edit']['image'];

				eval("echo \"" . getTemplate("ftp/accounts_edit") . "\";");
			}
		}
	}
}

?>
