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

$need_db_sql_data = true;
$need_root_db_sql_data = true;
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
	$log->logAction(USR_ACTION, LOG_NOTICE, "viewed customer_mysql");
	$lng['mysql']['description'] = str_replace('<SQL_HOST>', $sql['host'], $lng['mysql']['description']);
	eval("echo \"" . getTemplate("mysql/mysql") . "\";");
}
elseif($page == 'mysqls')
{
	if($action == '')
	{
		$log->logAction(USR_ACTION, LOG_NOTICE, "viewed customer_mysql::mysqls");
		$fields = array(
			'databasename' => $lng['mysql']['databasename'],
			'description' => $lng['mysql']['databasedescription']
		);
		$paging = new paging($userinfo, $db, TABLE_PANEL_DATABASES, $fields, $settings['panel']['paging'], $settings['panel']['natsorting']);
		$result = $db->query("SELECT * FROM `" . TABLE_PANEL_DATABASES . "` WHERE `customerid`='" . (int)$userinfo['customerid'] . "' " . $paging->getSqlWhere(true) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit());
		$paging->setEntries($db->num_rows($result));
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$i = 0;
		$count = 0;
		$mysqls = '';

		// Begin root-session
		$db_root = new db($sql_root[0]['host'], $sql_root[0]['user'], $sql_root[0]['password'], '');
		while($row = $db->fetch_array($result))
		{
			if($paging->checkDisplay($i))
			{
				$row = htmlentities_array($row);
				$mbdata = $db_root->query_first("SELECT SUM( data_length + index_length) / 1024 / 1024 'MB' FROM information_schema.TABLES WHERE table_schema = '" . $db_root->escape($row['databasename']) . "' GROUP BY table_schema ;");
				$row['size'] = number_format($mbdata['MB'], 3, '.', '');
				eval("\$mysqls.=\"" . getTemplate("mysql/mysqls_database") . "\";");
				$count++;
			}

			$i++;
		}
		$db_root->close();
		// End root-session

		$mysqls_count = $db->num_rows($result);
		eval("echo \"" . getTemplate("mysql/mysqls") . "\";");
	}
	elseif($action == 'delete'
	       && $id != 0)
	{
		$result = $db->query_first('SELECT `id`, `databasename`, `description`, `dbserver` FROM `' . TABLE_PANEL_DATABASES . '` WHERE `customerid`="' . (int)$userinfo['customerid'] . '" AND `id`="' . (int)$id . '"');

		if(isset($result['databasename'])
		   && $result['databasename'] != '')
		{
			if(!isset($sql_root[$result['dbserver']]) || !is_array($sql_root[$result['dbserver']]))
			{
				$result['dbserver'] = 0;
			}

			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				// Begin root-session

				$db_root = new db($sql_root[$result['dbserver']]['host'], $sql_root[$result['dbserver']]['user'], $sql_root[$result['dbserver']]['password'], '');
				$log->logAction(USR_ACTION, LOG_INFO, "deleted database '" . $result['databasename'] . "'");
				if(mysql_get_server_info() < '5.0.2') { 
					// Revoke privileges (only required for MySQL 4.1.2 - 5.0.1)
					$db_root->query('REVOKE ALL PRIVILEGES, GRANT OPTION FROM \'' . $db_root->escape($result['databasename']) .'\'',false,true);
				}

				$host_res = $db_root->query("SELECT `Host` FROM `mysql`.`user` WHERE `User`='" . $db_root->escape($result['databasename']) . "'");
				while($host = $db_root->fetch_array($host_res)) 
				{
					// as of MySQL 5.0.2 this also revokes privileges. (requires MySQL 4.1.2+)
					$db_root->query('DROP USER \'' . $db_root->escape($result['databasename']). '\'@\'' . $db_root->escape($host['Host']) . '\'', false, true);
				}

				$db_root->query('DROP DATABASE IF EXISTS `' . $db_root->escape($result['databasename']) . '`');
				$db_root->query('FLUSH PRIVILEGES');
				$db_root->close();

				// End root-session

				$db->query('DELETE FROM `' . TABLE_PANEL_DATABASES . '` WHERE `customerid`="' . (int)$userinfo['customerid'] . '" AND `id`="' . (int)$id . '"');

				if($userinfo['mysqls_used'] == '1')
				{
					$resetaccnumber = " , `mysql_lastaccountnumber`='0' ";
				}
				else
				{
					$resetaccnumber = '';
				}

				$result = $db->query('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` SET `mysqls_used`=`mysqls_used`-1 ' . $resetaccnumber . 'WHERE `customerid`="' . (int)$userinfo['customerid'] . '"');
				redirectTo($filename, Array('page' => $page, 's' => $s));
			}
			else
			{
				$dbnamedesc = $result['databasename'];
				if(isset($result['description']) && $result['description'] != '') {
					$dbnamedesc.= ' ('.$result['description'].')';
				}
				ask_yesno('mysql_reallydelete', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $dbnamedesc);
			}
		}
	}
	elseif($action == 'add')
	{
		if($userinfo['mysqls_used'] < $userinfo['mysqls']
		   || $userinfo['mysqls'] == '-1')
		{
			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				$password = validate($_POST['mysql_password'], 'password');
				$password = validatePassword($password);

				$sendinfomail = isset($_POST['sendinfomail']) ? 1 : 0;
				if($sendinfomail != 1)
				{
					$sendinfomail = 0;
				}

				if($password == '')
				{
					standard_error(array('stringisempty', 'mypassword'));
				}
				else
				{
					$username = $userinfo['loginname'] . $settings['customer']['mysqlprefix'] . (intval($userinfo['mysql_lastaccountnumber']) + 1);

					if(count($sql_root) > 1)
					{
						$dbserver = validate($_POST['mysql_server'], html_entity_decode($lng['mysql']['mysql_server']), '', '', 0);

						if(!isset($sql_root[$dbserver]) || !is_array($sql_root[$dbserver]))
						{
							$dbserver = 0;
						}
					}
					else
					{
						$dbserver = 0;
					}
					
					// validate description before actual adding the database, #1052
					$databasedescription = validate(trim($_POST['description']), 'description');

					// Begin root-session
					$db_root = new db($sql_root[$dbserver]['host'], $sql_root[$dbserver]['user'], $sql_root[$dbserver]['password'], '');
					$db_root->query('CREATE DATABASE `' . $db_root->escape($username) . '`');
					$log->logAction(USR_ACTION, LOG_INFO, "created database '" . $username . "'");
					foreach(array_map('trim', explode(',', $settings['system']['mysql_access_host'])) as $mysql_access_host)
					{
						$db_root->query('GRANT ALL PRIVILEGES ON `' . str_replace('_', '\_', $db_root->escape($username)) . '`.* TO `' . $db_root->escape($username) . '`@`' . $db_root->escape($mysql_access_host) . '` IDENTIFIED BY \'password\'');
						$db_root->query('SET PASSWORD FOR `' . $db_root->escape($username) . '`@`' . $db_root->escape($mysql_access_host) . '` = PASSWORD(\'' . $db_root->escape($password) . '\')');
						$log->logAction(USR_ACTION, LOG_NOTICE, "grant all privileges for '" . $username . "'@'" . $mysql_access_host . "'");
					}

					$db_root->query('FLUSH PRIVILEGES');
					$db_root->close();

					// End root-session
					// Statement modifyed for Database description -- PH 2004-11-29
					$result = $db->query('INSERT INTO `' . TABLE_PANEL_DATABASES . '` (`customerid`, `databasename`, `description`, `dbserver`) VALUES ("' . (int)$userinfo['customerid'] . '", "' . $db->escape($username) . '", "' . $db->escape($databasedescription) . '", "' . $db->escape($dbserver) . '")');
					$result = $db->query('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` SET `mysqls_used`=`mysqls_used`+1, `mysql_lastaccountnumber`=`mysql_lastaccountnumber`+1 WHERE `customerid`="' . (int)$userinfo['customerid'] . '"');

					if($sendinfomail == 1)
					{
						$pma = $lng['admin']['notgiven'];
						if($settings['panel']['phpmyadmin_url'] != '')
						{
							$pma = $settings['panel']['phpmyadmin_url'];
						}

						$replace_arr = array(
							'CUST_NAME' => getCorrectUserSalutation($userinfo),
							'DB_NAME' => $username,
							'DB_PASS' => $password,
							'DB_DESC' => $databasedescription,
							'DB_SRV' => $sql_root[$dbserver]['host'],
							'PMA_URI' => $pma 
						);
						
						$def_language = $userinfo['def_language'];
						$result = $db->query_first('SELECT `value` FROM `' . TABLE_PANEL_TEMPLATES . '` WHERE `adminid`=\'' . (int)$userinfo['adminid'] . '\' AND `language`=\'' . $db->escape($def_language) . '\' AND `templategroup`=\'mails\' AND `varname`=\'new_database_by_customer_subject\'');
						$mail_subject = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $lng['customer']['mysql_add']['infomail_subject']), $replace_arr));
						$result = $db->query_first('SELECT `value` FROM `' . TABLE_PANEL_TEMPLATES . '` WHERE `adminid`=\'' . (int)$userinfo['adminid'] . '\' AND `language`=\'' . $db->escape($def_language) . '\' AND `templategroup`=\'mails\' AND `varname`=\'new_database_by_customer_mailbody\'');
						$mail_body = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $lng['customer']['mysql_add']['infomail_body']['main']), $replace_arr));

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
				$mysql_servers = '';

				foreach($sql_root as $mysql_server => $mysql_server_details)
				{
					$mysql_servers .= makeoption($mysql_server_details['caption'], $mysql_server);
				}

				//$sendinfomail = makeyesno('sendinfomail', '1', '0', '0');

				$mysql_add_data = include_once dirname(__FILE__).'/lib/formfields/customer/mysql/formfield.mysql_add.php';
				$mysql_add_form = htmlform::genHTMLForm($mysql_add_data);

				$title = $mysql_add_data['mysql_add']['title'];
				$image = $mysql_add_data['mysql_add']['image'];

				eval("echo \"" . getTemplate("mysql/mysqls_add") . "\";");
			}
		}
	}
	elseif($action == 'edit'
	       && $id != 0)
	{
		$result = $db->query_first('SELECT `id`, `databasename`, `description`, `dbserver` FROM `' . TABLE_PANEL_DATABASES . '` WHERE `customerid`="' . $userinfo['customerid'] . '" AND `id`="' . $id . '"');

		if(isset($result['databasename'])
		   && $result['databasename'] != '')
		{
			if(!isset($sql_root[$result['dbserver']]) || !is_array($sql_root[$result['dbserver']]))
			{
				$result['dbserver'] = 0;
			}

			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				// Only change Password if it is set, do nothing if it is empty! -- PH 2004-11-29
				$password = validate($_POST['mysql_password'], 'password');

				if($password != '')
				{
					// validate password
					$password = validatePassword($password);

					// Begin root-session
					$db_root = new db($sql_root[$result['dbserver']]['host'], $sql_root[$result['dbserver']]['user'], $sql_root[$result['dbserver']]['password'], '');
					foreach(array_map('trim', explode(',', $settings['system']['mysql_access_host'])) as $mysql_access_host)
					{
						$db_root->query('SET PASSWORD FOR `' . $db_root->escape($result['databasename']) . '`@`' . $db_root->escape($mysql_access_host) . '` = PASSWORD(\'' . $db_root->escape($password) . '\')');
					}

					$db_root->query('FLUSH PRIVILEGES');
					$db_root->close();

					// End root-session
				}

				// Update the Database description -- PH 2004-11-29
				$log->logAction(USR_ACTION, LOG_INFO, "edited database '" . $result['databasename'] . "'");
				$databasedescription = validate($_POST['description'], 'description');
				$result = $db->query('UPDATE `' . TABLE_PANEL_DATABASES . '` SET `description`="' . $db->escape($databasedescription) . '" WHERE `customerid`="' . (int)$userinfo['customerid'] . '" AND `id`="' . (int)$id . '"');
				redirectTo($filename, Array('page' => $page, 's' => $s));
			}
			else
			{
				$mysql_edit_data = include_once dirname(__FILE__).'/lib/formfields/customer/mysql/formfield.mysql_edit.php';
				$mysql_edit_form = htmlform::genHTMLForm($mysql_edit_data);

				$title = $mysql_edit_data['mysql_edit']['title'];
				$image = $mysql_edit_data['mysql_edit']['image'];

				eval("echo \"" . getTemplate("mysql/mysqls_edit") . "\";");
			}
		}
	}
}

?>
